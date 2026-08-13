<?php
/**
 * Template Name: SAV & assistance
 *
 * @package dental-ouest
 */
get_header();
$contact = dental_ouest_page_url( 'contact', home_url( '/' ) );
?>
<section class="page-hero">
	<svg class="tooth a" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<svg class="tooth b" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<div class="container">
		<p class="crumb">🦷 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">Accueil</a><span class="sep">·</span><b><?php esc_html_e( 'SAV & Assistance', 'dental-ouest' ); ?></b></p>
		<h1><?php echo wp_kses_post( do_mod( 'do_sav_title', 'Votre équipement <span class="grad">mérite de l' . '\'' . 'attention</span>' ) ); ?></h1>
		<p><?php echo esc_html( do_mod( 'do_sav_sub', 'Un SAV dédié, des techniciens spécialisés : votre cabinet reste opérationnel en toutes circonstances.' ) ); ?></p>
		<div class="decor"><span></span><span></span><span></span></div>
	</div>
</section>

<section class="section section-navy">
	<div class="blueprint"></div>
	<div class="glow glow-gold" style="top:-140px;inset-inline-end:-120px;"></div>
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">🔧 <?php esc_html_e( 'Comment ça marche', 'dental-ouest' ); ?></span>
			<h2 class="section-title" style="color:#fff;"><?php esc_html_e( 'Un SAV en 4 étapes', 'dental-ouest' ); ?></h2>
			<div class="decor"><span></span><span></span><span></span></div>
		</div>
		<div class="steps-grid">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<div class="step-card reveal d<?php echo (int) $i; ?>">
					<div class="step-num"><?php echo (int) $i; ?></div>
					<h3><?php echo esc_html( do_mod( 'do_step' . $i . '_t', '' ) ); ?></h3>
					<p><?php echo esc_html( do_mod( 'do_step' . $i . '_d', '' ) ); ?></p>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section" style="padding-bottom:60px;">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">🛠️ <?php esc_html_e( 'Nos techniciens', 'dental-ouest' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( do_mod( 'do_tech_head_t', 'Des experts sur <span class="grad">intervention</span>' ) ); ?></h2>
			<p class="section-sub"><?php echo esc_html( do_mod( 'do_tech_head_d', 'Choisissez le technicien le plus adapté à votre panne.' ) ); ?></p>
			<div class="decor"><span></span><span></span><span></span></div>
		</div>
		<div class="tech-grid">
			<?php
			$techs = get_posts( array(
				'post_type'   => 'technicien',
				'numberposts' => -1,
				'orderby'     => 'menu_order date',
				'order'       => 'ASC',
			) );
			foreach ( $techs as $t ) :
				$tel  = get_post_meta( $t->ID, '_do_tech_tel', true );
				$mail = get_post_meta( $t->ID, '_do_tech_mail', true );
				$img  = get_the_post_thumbnail_url( $t->ID, 'thumbnail' );
				$spec = get_the_excerpt( $t );
				if ( ! $spec ) { $spec = wp_strip_all_tags( $t->post_content ); }
				?>
				<div class="tech-card reveal" style="background:#fff;border-color:#EAF0F7;">
					<div class="tech-ava">
						<?php if ( $img ) : ?>
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title( $t ) ); ?>">
						<?php else : ?>
							🛠️
						<?php endif; ?>
					</div>
					<div>
						<h3 style="color:var(--navy);"><?php echo esc_html( get_the_title( $t ) ); ?></h3>
						<p style="color:var(--ink);"><?php echo esc_html( $spec ); ?></p>
						<?php if ( $tel ) : ?>
							<p class="tech-coords"><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $tel ) ); ?>"><?php echo esc_html( $tel ); ?></a></p>
						<?php endif; ?>
						<?php if ( $mail ) : ?>
							<p class="tech-coords"><a href="mailto:<?php echo esc_attr( $mail ); ?>"><?php echo esc_html( $mail ); ?></a></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section" style="padding-top:0;">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">❓ <?php esc_html_e( 'Questions fréquentes', 'dental-ouest' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Besoin d' . '\'' . 'un éclaircissement ?', 'dental-ouest' ); ?></h2>
			<div class="decor"><span></span><span></span><span></span></div>
		</div>
		<div class="faq-wrap">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<details class="faq-item reveal">
					<summary>
						<span class="fq">Q<?php echo (int) $i; ?></span>
						<?php echo esc_html( do_mod( 'do_faq' . $i . '_q', '' ) ); ?>
						<span class="chev">+</span>
					</summary>
					<div class="faq-body"><?php echo esc_html( do_mod( 'do_faq' . $i . '_a', '' ) ); ?></div>
				</details>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section" style="padding-top:0;">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">📨 <?php esc_html_e( 'Demande d' . '\'' . 'intervention', 'dental-ouest' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Signalez une ', 'dental-ouest' ); ?><span class="grad"><?php esc_html_e( 'panne', 'dental-ouest' ); ?></span></h2>
			<p class="section-sub"><?php esc_html_e( 'Un technicien vous recontacte sous 24 h. Précisez le modèle de votre équipement et la nature du problème.', 'dental-ouest' ); ?></p>
		</div>
		<div class="form-shell">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="form-grid">
				<input type="hidden" name="action" value="dental_form">
				<input type="hidden" name="do_form" value="1">
				<input type="hidden" name="do_route" value="sav">
				<input type="hidden" name="do_subject" value="Demande d'intervention SAV">
				<div class="form-field">
					<label><?php esc_html_e( 'Nom complet', 'dental-ouest' ); ?> <span class="req">*</span></label>
					<input type="text" name="do_name" required>
				</div>
				<div class="form-field">
					<label><?php esc_html_e( 'Téléphone', 'dental-ouest' ); ?> <span class="req">*</span></label>
					<input type="tel" name="do_phone" required>
				</div>
				<div class="form-field full">
					<label><?php esc_html_e( 'Adresse e-mail', 'dental-ouest' ); ?> <span class="req">*</span></label>
					<input type="email" name="do_email" required>
				</div>
				<div class="form-field full">
					<label><?php echo esc_html( do_mod( 'do_tech_form_label', 'Choisir le technicien' ) ); ?> <span class="req">*</span></label>
					<select name="do_tech" required>
						<option value=""><?php esc_html_e( '— Sélectionner un technicien —', 'dental-ouest' ); ?></option>
						<?php foreach ( $techs as $t ) : ?>
							<option value="<?php echo (int) $t->ID; ?>"><?php echo esc_html( get_the_title( $t ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-field full">
					<label><?php esc_html_e( 'Votre message', 'dental-ouest' ); ?> <span class="req">*</span></label>
					<textarea name="do_message" required placeholder="<?php esc_attr_e( 'Ex : Fauteuil, autoclave…', 'dental-ouest' ); ?>"></textarea>
				</div>
				<div class="form-submit">
					<button class="btn btn-green" type="submit"><?php esc_html_e( 'Envoyer la demande', 'dental-ouest' ); ?> →</button>
				</div>
				<p class="form-hint"><?php esc_html_e( 'Urgence ? Appelez directement le SAV :', 'dental-ouest' ); ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', do_mod( 'do_phone', '+213 550 572 388' ) ) ); ?>" style="color:var(--green);font-weight:700;"> <?php echo esc_html( do_mod( 'do_phone', '+213 550 572 388' ) ); ?></a>
				</p>
			</form>
		</div>
	</div>
</section>

<section class="section" style="padding-top:0;">
	<div class="container">
		<div class="cta-banner reveal">
			<div class="glow"></div>
			<h2><?php esc_html_e( 'Plutôt un devis pour du matériel ?', 'dental-ouest' ); ?></h2>
			<p><?php esc_html_e( 'Parcourez notre catalogue : notre équipe commerciale vous répond sous 24 h.', 'dental-ouest' ); ?></p>
			<div class="cta-actions">
				<a class="btn btn-gold" href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Voir le catalogue', 'dental-ouest' ); ?> →</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Nous contacter', 'dental-ouest' ); ?></a>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>