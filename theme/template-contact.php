<?php
/**
 * Template Name: Contact
 *
 * @package dental-ouest
 */
get_header();
$sent     = isset( $_GET['do_sent'] ); // phpcs:ignore WordPress.Security.NonceVerification
$phone    = do_mod( 'do_phone', '+213 550 572 388' );
$mailc    = do_mod( 'do_mail', 'commercial@dentalouest.net' );
?>
<section class="page-hero">
	<svg class="tooth a" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<svg class="tooth b" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	<div class="container">
		<p class="crumb">🦷 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">Accueil</a><span class="sep">·</span><b><?php esc_html_e( 'Contact', 'dental-ouest' ); ?></b></p>
		<h1><?php esc_html_e( 'Parlons de votre ', 'dental-ouest' ); ?><span class="grad"><?php esc_html_e( 'projet', 'dental-ouest' ); ?></span></h1>
		<p><?php esc_html_e( 'Une question, un devis, un projet de cabinet : notre équipe vous répond rapidement.', 'dental-ouest' ); ?></p>
		<div class="decor"><span></span><span></span><span></span></div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="info-grid">
			<div class="info-card reveal">
				<div class="info-ico">☎️</div>
				<b><?php esc_html_e( 'Téléphone / WhatsApp', 'dental-ouest' ); ?></b>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
			</div>
			<div class="info-card reveal d1">
				<div class="info-ico">✉️</div>
				<b><?php esc_html_e( 'E-mails', 'dental-ouest' ); ?></b>
				<a href="mailto:<?php echo esc_attr( $mailc ); ?>"><?php echo esc_html( $mailc ); ?></a>
			</div>
			<div class="info-card reveal d2">
				<div class="info-ico">📍</div>
				<b><?php esc_html_e( 'Siège — Oran', 'dental-ouest' ); ?></b>
				<span><?php echo esc_html( do_mod( 'do_addr', '41, Rue Cherif Ali Cherfi — Oran' ) ); ?></span>
			</div>
			<div class="info-card reveal d3">
				<div class="info-ico">🕐</div>
				<b><?php esc_html_e( 'Horaires', 'dental-ouest' ); ?></b>
				<span><?php echo esc_html( do_mod( 'do_hours', 'Dim — Jeu · 08h00 — 17h00' ) ); ?></span>
			</div>
		</div>

		<div class="why-grid" style="grid-template-columns:1fr 1fr;gap:48px;align-items:start;">
			<div class="form-shell">
				<h3 style="margin-bottom:22px;"><?php esc_html_e( 'Envoyez-nous un message', 'dental-ouest' ); ?></h3>
				<?php if ( $sent ) : ?>
					<div class="alert ok show">✅ <?php esc_html_e( 'Merci ! Votre message a bien été pris en compte. Nous vous répondons sous 24 h.', 'dental-ouest' ); ?></div>
				<?php endif; ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="form-grid">
					<input type="hidden" name="action" value="dental_form">
					<input type="hidden" name="do_form" value="1">
					<input type="hidden" name="do_route" value="contact">
					<div class="form-field">
						<label><?php esc_html_e( 'Nom complet', 'dental-ouest' ); ?> <span class="req">*</span></label>
						<input type="text" name="do_name" required>
					</div>
					<div class="form-field">
						<label><?php esc_html_e( 'Téléphone', 'dental-ouest' ); ?></label>
						<input type="tel" name="do_phone">
					</div>
					<div class="form-field">
						<label><?php esc_html_e( 'Adresse e-mail', 'dental-ouest' ); ?> <span class="req">*</span></label>
						<input type="email" name="do_email" required>
					</div>
					<div class="form-field">
						<label><?php esc_html_e( 'À qui s' . '\'' . 'adresse votre demande ?', 'dental-ouest' ); ?></label>
						<select name="do_recipient">
							<option value="commercial"><?php esc_html_e( 'Service commercial', 'dental-ouest' ); ?></option>
							<option value="direction"><?php esc_html_e( 'Direction', 'dental-ouest' ); ?></option>
						</select>
					</div>
					<div class="form-field">
						<label><?php esc_html_e( 'Sujet', 'dental-ouest' ); ?></label>
						<select name="do_subject">
							<option><?php esc_html_e( 'Demande de devis', 'dental-ouest' ); ?></option>
							<option><?php esc_html_e( 'Demande d' . '\'' . 'information', 'dental-ouest' ); ?></option>
							<option><?php esc_html_e( 'SAV / Panne', 'dental-ouest' ); ?></option>
							<option><?php esc_html_e( 'Installation de cabinet', 'dental-ouest' ); ?></option>
							<option><?php esc_html_e( 'Autre demande', 'dental-ouest' ); ?></option>
						</select>
					</div>
					<div class="form-field full">
						<label><?php esc_html_e( 'Votre message', 'dental-ouest' ); ?> <span class="req">*</span></label>
						<textarea name="do_message" required></textarea>
					</div>
					<div class="form-submit">
						<button class="btn btn-green" type="submit"><?php esc_html_e( 'Envoyer le message', 'dental-ouest' ); ?> →</button>
					</div>
				</form>
			</div>

			<div>
				<div class="section-head" style="text-align:start;margin:0 0 24px;">
					<span class="eyebrow">🏢 <?php esc_html_e( 'Nos agences', 'dental-ouest' ); ?></span>
					<h2 class="section-title" style="font-size:1.6rem;"><?php esc_html_e( 'Présents dans ', 'dental-ouest' ); ?><span class="grad"><?php esc_html_e( '3 régions', 'dental-ouest' ); ?></span></h2>
				</div>
				<div class="agency-grid" style="grid-template-columns:1fr;margin-top:0;">
					<?php
					$ag = array(
						1 => array( 'Agence Ouest',  'Oran',        'Siège social, showroom et service après-vente.' ),
						2 => array( 'Agence Centre', 'Alger',       'Showroom et service commercial pour la région centre.' ),
						3 => array( 'Agence Est',    'Constantine', 'Point de livraison et installation pour l' . '\'' . 'Est du pays.' ),
					);
					foreach ( $ag as $i => $a ) : ?>
						<div class="agency-card reveal d<?php echo (int) $i; ?>">
							<span class="agency-pin">📍</span>
							<h3><?php echo esc_html( $a[0] ); ?><span style="color:var(--gold);font-weight:700;"> · <?php echo esc_html( $a[1] ); ?></span></h3>
							<p><?php echo esc_html( $a[2] ); ?></p>
							<a href="<?php echo esc_url( do_mod( 'do_map_url', 'https://www.google.com/maps?q=Oran&output=embed' ) ); ?>" target="_blank" rel="noreferrer"><?php esc_html_e( 'Itinéraire', 'dental-ouest' ); ?> →</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="map-wrap" style="margin-top:56px;">
			<iframe src="<?php echo esc_url( do_mod( 'do_map_url', 'https://www.google.com/maps?q=Oran%2C+Alg%C3%A9rie&output=embed' ) ); ?>"
				title="Dental Ouest — Oran" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	</div>
</section>
<?php get_footer(); ?>