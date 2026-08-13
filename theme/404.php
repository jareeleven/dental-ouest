<?php
/**
 * Dental Ouest — 404.
 *
 * @package dental-ouest
 */
get_header();
?>
<section class="page-hero">
	<div class="container">
		<p class="crumb">🦷 <span class="sep">·</span><b>404</b></p>
		<h1>Oups — page <span class="grad">introuvable</span></h1>
		<p>La page que vous cherchez n'existe pas ou a été déplacée.</p>
	</div>
</section>
<section class="section">
	<div class="container" style="text-align:center;">
		<a class="btn btn-green" href="<?php echo esc_url( home_url( '/' ) ); ?>">← <?php esc_html_e( 'Retour à l' . '\'' . 'accueil', 'dental-ouest' ); ?></a>
		<a class="btn btn-navy" style="margin-inline-start:12px;" href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Voir les produits', 'dental-ouest' ); ?></a>
	</div>
</section>
<?php get_footer(); ?>