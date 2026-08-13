<?php
/**
 * Template Name: À propos
 *
 * @package dental-ouest
 */
get_header();
$contact = dental_ouest_page_url( 'contact', home_url( '/' ) );
$produit = dental_ouest_page_url( 'produits', home_url( '/' ) );
?>
<section class="page-hero">
	<svg class="tooth a" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<svg class="tooth b" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<div class="container">
		<p class="crumb">🦷 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">Accueil</a><span class="sep">·</span><b><?php esc_html_e( 'À propos', 'dental-ouest' ); ?></b></p>
		<h1><?php echo wp_kses_post( do_mod( 'do_ab_title', 'Trois générations <span class="grad">au service</span> de la dentisterie' ) ); ?></h1>
		<p><?php echo esc_html( do_mod( 'do_ab_sub', 'De l' . '\'' . 'atelier de prothèse à l' . '\'' . 'intégration clé en main : un héritage familial tourné vers l' . '\'' . 'excellence.' ) ); ?></p>
		<div class="decor"><span></span><span></span><span></span></div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="timeline">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<div class="tl-item reveal">
					<span class="tl-dot"></span>
					<div class="tl-year"><?php echo esc_html( do_mod( 'do_tl' . $i . '_yr', '' ) ); ?></div>
					<div class="tl-card">
						<h3><?php echo esc_html( do_mod( 'do_tl' . $i . '_t', '' ) ); ?></h3>
						<p><?php echo esc_html( do_mod( 'do_tl' . $i . '_d', '' ) ); ?></p>
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section section-light">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">💎 <?php esc_html_e( 'Ce qui nous anime', 'dental-ouest' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( do_mod( 'do_ab_values_t', 'Nos valeurs' ) ); ?></h2>
			<div class="decor"><span></span><span></span><span></span></div>
		</div>
		<div class="values-grid">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<article class="value-card reveal d<?php echo (int) $i; ?>">
					<div class="value-icon"><?php echo esc_html( do_mod( 'do_val' . $i . '_ic', '' ) ); ?></div>
					<h3><?php echo esc_html( do_mod( 'do_val' . $i . '_t', '' ) ); ?></h3>
					<p><?php echo esc_html( do_mod( 'do_val' . $i . '_d', '' ) ); ?></p>
				</article>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section section-navy">
	<div class="blueprint"></div>
	<div class="glow glow-g" style="bottom:-160px;inset-inline-start:-120px;"></div>
	<div class="container">
		<div class="quote-card reveal">
			<div class="quote-mark">ISO</div>
			<p class="quote-text"><?php echo esc_html( do_mod( 'do_ab_iso_t', 'Notre engagement qualité' ) ); ?></p>
			<p style="color:rgba(255,255,255,.75);font-size:.95rem;line-height:1.8;max-width:640px;margin:0 auto 8px;"><?php echo esc_html( do_mod( 'do_ab_iso_d', 'Nos processus sont organisés selon les principes des systèmes de management certifiés : équipements contrôlés, traçabilité complète et personnel formé en continu.' ) ); ?></p>
			<div class="quote-author">
				<span class="quote-ava">🎖️</span>
				<span><b style="color:var(--gold);"><?php echo esc_html( do_mod( 'do_ab_iso_b', 'Certifié ISO' ) ); ?></b>
					<small><?php esc_html_e( 'Qualité & traçabilité', 'dental-ouest' ); ?></small></span>
			</div>
		</div>
	</div>
</section>

<section class="section" style="padding-top:0;">
	<div class="container">
		<div class="cta-banner reveal">
			<div class="glow"></div>
			<h2><?php esc_html_e( 'Une aventure familiale', 'dental-ouest' ); ?></h2>
			<p><?php esc_html_e( 'Depuis 1982, nous équipons les cabinets dentaires de toute l' . '\'' . 'Algérie. Découvrez notre catalogue ou contactez-nous.', 'dental-ouest' ); ?></p>
			<div class="cta-actions">
				<a class="btn btn-gold" href="<?php echo esc_url( $produit ); ?>"><?php esc_html_e( 'Voir les produits', 'dental-ouest' ); ?> →</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Nous contacter', 'dental-ouest' ); ?></a>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>