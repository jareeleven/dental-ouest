<?php
/**
 * Dental Ouest — Header.
 *
 * @package dental-ouest
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Aller au contenu', 'dental-ouest' ); ?></a>

<div id="doProgress"></div>

<div id="doLoader">
	<div class="loader-mark">
		<div class="loader-ring"></div>
		<div class="loader-core">🦷</div>
	</div>
	<div class="loader-word">DENTAL<b>OUEST</b></div>
	<div class="loader-bar"><div class="loader-fill" id="loaderFill"></div></div>
</div>

<header id="doHeader">
	<div class="container header-inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Dental Ouest">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="logo-mark">🦷</span>
				<span class="logo-text"><?php echo esc_html( do_mod( 'do_logo_text', 'Dental Ouest' ) ); ?>
					<small><?php echo esc_html( do_mod( 'do_logo_small', 'Équipement dentaire' ) ); ?></small>
				</span>
			<?php endif; ?>
		</a>

		<nav class="nav" aria-label="<?php esc_attr_e( 'Navigation principale', 'dental-ouest' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 2 ) );
			} else {
				dental_ouest_fallback_menu();
			}
			?>
		</nav>

		<div class="header-cta">
			<a class="phone-pill" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', do_mod( 'do_phone', '+213 550 572 388' ) ) ); ?>">📞 <?php echo esc_html( do_mod( 'do_phone', '+213 550 572 388' ) ); ?></a>
			<button class="burger" id="burger" aria-label="<?php esc_attr_e( 'Menu', 'dental-ouest' ); ?>" aria-expanded="false"><span></span><span></span><span></span></button>
		</div>
	</div>

	<div class="mobile-menu" id="mobileMenu">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 2 ) );
		} else {
			dental_ouest_fallback_menu();
		}
		?>
		<a class="mm-call" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', do_mod( 'do_phone', '+213 550 572 388' ) ) ); ?>">📞 <?php echo esc_html( do_mod( 'do_phone', '+213 550 572 388' ) ); ?></a>
	</div>
</header>

<main id="main">