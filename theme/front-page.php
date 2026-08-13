<?php
/**
 * Dental Ouest — Page d'accueil.
 *
 * @package dental-ouest
 */
get_header();

$contact = dental_ouest_page_url( 'contact', home_url( '/' ) );
$produit = dental_ouest_page_url( 'produits', home_url( '/' ) );
$about   = dental_ouest_page_url( 'apropos', home_url( '/' ) );
$sav     = dental_ouest_page_url( 'sav', home_url( '/' ) );
?>

<section class="hero">
	<div class="hero-art">
		<svg class="hero-tooth t1" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
		<svg class="hero-tooth t2" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
		<svg class="hero-tooth t3" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C8 2 6 5 6 8c0 3 1.5 4 2 7 .4 2.5 1.5 7 4 7s3.6-4.5 4-7c.5-3 2-4 2-7 0-3-2-6-6-6z"/></svg>
	</div>
	<div class="hero-glow-1"></div>
	<div class="hero-glow-2"></div>
	<div class="container hero-inner">
		<span class="hero-badge"><span class="dot"></span><?php echo wp_kses_post( do_mod( 'do_hero_badge', 'Depuis 1982 · Oran, Algérie' ) ); ?></span>
		<h1 class="hero-title"><?php echo wp_kses_post( do_mod( 'do_hero_title', 'L' . '\'' . 'excellence dentaire au service de votre <span class="grad">cabinet</span>' ) ); ?></h1>
		<p class="hero-sub"><?php echo esc_html( do_mod( 'do_hero_sub', 'Importation, distribution et installation d' . '\'' . 'équipements et de consommables dentaires de qualité internationale. Votre partenaire de confiance pour équiper votre cabinet partout en Algérie — du conseil à la maintenance.' ) ); ?></p>
		<div class="hero-actions">
			<?php $u = do_mod( 'do_hero_cta1_url', $contact ); ?>
			<a class="btn btn-green" href="<?php echo esc_url( $u ); ?>"><?php echo esc_html( do_mod( 'do_hero_cta1', 'Demander un devis' ) ); ?> →</a>
			<?php $u2 = do_mod( 'do_hero_cta2_url', $produit ); ?>
			<a class="btn btn-ghost" href="<?php echo esc_url( $u2 ); ?>"><?php echo esc_html( do_mod( 'do_hero_cta2', 'Découvrir nos produits' ) ); ?></a>
		</div>
		<div class="hero-stats" id="statRow">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php $n = do_mod( 'do_stat' . $i . '_n', '' ); if ( '' === $n ) { continue; } ?>
				<div class="stat-card<?php echo 4 === $i ? ' gold' : ''; ?>">
					<div class="stat-num" data-count="<?php echo (int) $n; ?>">0</div>
					<div class="stat-label"><?php echo esc_html( do_mod( 'do_stat' . $i . '_label', '' ) ); ?></div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<div class="trust-strip" aria-hidden="true">
	<div class="trust-track" id="marquee">
		<?php
		$lines = array_filter( array_map( 'trim', explode( "\n", do_mod( 'do_marquee', "Qualité internationale certifiée ISO\nLivraison dans les 58 wilayas\nDepuis 1982 en Algérie\nTechniciens installateurs certifiés\nSAV réactif 6 jours sur 7\nPlus de 5 000 clients satisfaits" ) ) ) );
		$lines = array_merge( $lines, $lines );
		foreach ( $lines as $l ) { echo '<span>' . esc_html( $l ) . '</span>'; }
		?>
	</div>
</div>

<section class="section section-navy">
	<div class="blueprint"></div>
	<div class="glow glow-g" style="top:-160px;inset-inline-start:-120px;"></div>
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">🦷 <?php esc_html_e( 'Nos domaines', 'dental-ouest' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Un partenaire ', 'dental-ouest' ); ?><span class="grad"><?php esc_html_e( 'complet', 'dental-ouest' ); ?></span><?php esc_html_e( ' pour votre pratique', 'dental-ouest' ); ?></h2>
			<p class="section-sub"><?php esc_html_e( 'De l' . '\'' . 'équipement au service après-vente, nous accompagnons chaque praticien à chaque étape.', 'dental-ouest' ); ?></p>
			<div class="decor"><span></span><span></span><span></span></div>
		</div>
		<div class="services-grid">
			<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
				<article class="service-card reveal<?php echo esc_attr( ' d' . ( ( $i - 1 ) % 3 + 1 ) ); ?>">
					<div class="service-icon"><?php echo esc_html( do_mod( 'do_serv' . $i . '_ic', '' ) ); ?></div>
					<h3><?php echo esc_html( do_mod( 'do_serv' . $i . '_t', '' ) ); ?></h3>
					<p><?php echo esc_html( do_mod( 'do_serv' . $i . '_d', '' ) ); ?></p>
				</article>
			<?php endfor; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="why-grid">
			<div class="why-visual reveal">
				<?php
				$img = do_mod( 'do_why_img', get_template_directory_uri() . '/assets/img/cabinet.png' );
				?>
				<img src="<?php echo esc_url( $img ); ?>" alt="Dental Ouest" loading="lazy">
				<div class="why-badge">
					<span class="medal">🏅</span>
					<span><b><?php echo esc_html( do_mod( 'do_why_badge_b', 'Certifié ISO 9001' ) ); ?></b>
						<small><?php echo esc_html( do_mod( 'do_why_badge_s', 'Plus de 40 ans d' . '\'' . 'expérience' ) ); ?></small></span>
				</div>
			</div>
			<div>
				<div class="section-head" style="text-align:start;margin:0 0 20px;">
					<span class="eyebrow">✓ <?php esc_html_e( 'Pourquoi nous choisir ?', 'dental-ouest' ); ?></span>
					<h2 class="section-title"><?php esc_html_e( 'Le choix ', 'dental-ouest' ); ?><span class="grad"><?php esc_html_e( 'Nº1', 'dental-ouest' ); ?></span><?php esc_html_e( ' des professionnels', 'dental-ouest' ); ?></h2>
				</div>
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<div class="feature reveal d<?php echo (int) $i; ?>">
						<div class="feature-icon"><?php echo esc_html( do_mod( 'do_why' . $i . '_ic', '' ) ); ?></div>
						<div>
							<h3><?php echo esc_html( do_mod( 'do_why' . $i . '_t', '' ) ); ?></h3>
							<p><?php echo esc_html( do_mod( 'do_why' . $i . '_d', '' ) ); ?></p>
						</div>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</section>

<section class="section section-navy">
	<div class="blueprint"></div>
	<div class="glow glow-gold" style="top:-140px;inset-inline-end:-120px;"></div>
	<div class="container">
		<div class="quote-card reveal">
			<div class="quote-mark">“</div>
			<p class="quote-text"><?php echo esc_html( do_mod( 'do_quote_t', '« Notre engagement va au-delà de la vente : chaque fauteuil installé est une confiance qu' . '\'' . 'il faut mériter chaque jour. »' ) ); ?></p>
			<div class="quote-author">
				<span class="quote-ava">AH</span>
				<span><b><?php echo esc_html( do_mod( 'do_quote_a', 'Ali HAKKA' ) ); ?></b>
					<small><?php echo esc_html( do_mod( 'do_quote_r', 'Gérant · Dental Ouest' ) ); ?></small></span>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head">
			<span class="eyebrow">🛍️ <?php esc_html_e( 'Notre catalogue', 'dental-ouest' ); ?></span>
			<h2 class="section-title"><?php echo wp_kses_post( do_mod( 'do_prod_t', 'Des produits <span class="grad">d' . '\'' . 'exception</span>' ) ); ?></h2>
			<p class="section-sub"><?php echo esc_html( do_mod( 'do_prod_sub', 'Équipements et matériaux des grandes marques internationales, livrés partout en Algérie.' ) ); ?></p>
			<div class="decor"><span></span><span></span><span></span></div>
		</div>
		<?php dental_ouest_products_grid( 6 ); ?>
		<div style="text-align:center;margin-top:44px;">
			<a class="btn btn-navy" href="<?php echo esc_url( $produit ); ?>"><?php esc_html_e( 'Voir tout le catalogue', 'dental-ouest' ); ?> →</a>
		</div>
	</div>
</section>

<section class="section" style="padding-top:0;">
	<div class="container">
		<div class="cta-banner reveal">
			<div class="glow"></div>
			<h2><?php echo esc_html( do_mod( 'do_cta_t', 'Prêt à équiper votre cabinet ?' ) ); ?></h2>
			<p><?php echo esc_html( do_mod( 'do_cta_s', 'Devis détaillé, sans engagement, sous 24 h. Nos équipes vous accompagnent de A à Z.' ) ); ?></p>
			<div class="cta-actions">
				<a class="btn btn-gold" href="<?php echo esc_url( $contact ); ?>"><?php echo esc_html( do_mod( 'do_cta_b', 'Demander un devis gratuit' ) ); ?> →</a>
				<a class="btn btn-ghost" href="<?php echo esc_url( $sav ); ?>"><?php esc_html_e( 'Besoin du SAV ?', 'dental-ouest' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>