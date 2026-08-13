<?php
/**
 * Dental Ouest — Fiche produit.
 *
 * @package dental-ouest
 */
get_header();
?>
<section class="page-hero">
	<svg class="tooth a" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<svg class="tooth b" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<div class="container">
		<p class="crumb">🦷 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">Accueil</a><span class="sep">·</span><a href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>" style="color:inherit;"><?php esc_html_e( 'Produits', 'dental-ouest' ); ?></a><span class="sep">·</span><b><?php the_title(); ?></b></p>
		<h1><span class="grad"><?php the_title(); ?></span></h1>
		<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="why-grid" style="align-items:start;">
			<div class="why-visual reveal">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'aspect-ratio:4/3;' ) ); ?>
				<?php endif; ?>
			</div>
			<div class="reveal d1">
				<span class="eyebrow">🛍️ <?php echo esc_html( wp_strip_all_tags( get_the_terms( get_the_ID(), 'categorie_produit' ) ? implode( ', ', wp_list_pluck( get_the_terms( get_the_ID(), 'categorie_produit' ), 'name' ) ) : __( 'Produit', 'dental-ouest' ) ) ); ?></span>
				<h2 class="section-title"><?php the_title(); ?></h2>
				<p class="section-sub"><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p>

				<?php $specs = get_post_meta( get_the_ID(), '_do_specs', true ); ?>
				<?php if ( $specs ) : ?>
					<h4 style="font-family:var(--font-head);font-size:.8rem;font-weight:800;color:var(--green);letter-spacing:1.6px;text-transform:uppercase;margin:28px 0 6px;"><?php echo esc_html( do_mod( 'do_specs_label', 'Spécifications techniques' ) ); ?></h4>
					<ul class="qv-specs" style="list-style:none;">
						<?php foreach ( preg_split( '/\r?\n/', trim( $specs ) ) as $sp ) : ?>
							<?php $sp = trim( $sp ); if ( '' === $sp ) { continue; } ?>
							<li style="position:relative;padding:8px 0 8px 28px;font-size:.92rem;color:var(--ink);border-bottom:1px dashed #E4EBF4;line-height:1.6;list-style:none;">
								<span style="position:absolute;inset-inline-start:2px;color:var(--green);font-weight:800;">✓</span><?php echo esc_html( $sp ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="hero-actions" style="justify-content:flex-start;margin-top:30px;">
					<a class="btn btn-green" href="<?php echo esc_url( dental_ouest_page_url( 'contact' ) ); ?>"><?php echo esc_html( 'en_stock' === get_post_meta( get_the_ID(), '_do_dispo', true ) ? do_mod( 'do_stock', 'En stock' ) : do_mod( 'do_devis', 'Sur devis' ) ); ?> · <?php echo esc_html( do_mod( 'do_quote_btn', 'Demander un devis' ) ); ?> →</a>
					<a class="btn btn-navy" href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Retour au catalogue', 'dental-ouest' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section section-navy" style="padding-top:0;">
	<div class="blueprint"></div>
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">✨ <?php esc_html_e( 'Dans la même gamme', 'dental-ouest' ); ?></span>
			<h2 class="section-title" style="color:#fff;"><?php esc_html_e( 'D' . '\'' . 'autres équipements', 'dental-ouest' ); ?></h2>
		</div>
		<?php dental_ouest_products_grid( 6 ); ?>
	</div>
</section>
<?php get_footer(); ?>