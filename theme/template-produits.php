<?php
/**
 * Template Name: Catalogue des produits
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
		<p class="crumb">🦷 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">Accueil</a><span class="sep">·</span><b><?php esc_html_e( 'Nos Produits', 'dental-ouest' ); ?></b></p>
		<h1><?php esc_html_e( 'Notre ', 'dental-ouest' ); ?><span class="grad"><?php esc_html_e( 'catalogue', 'dental-ouest' ); ?></span></h1>
		<p><?php esc_html_e( 'Équipements, consommables et radiologie : toutes les grandes marques, livrées partout en Algérie. Passez la souris sur une carte pour voir ses spécifications techniques.', 'dental-ouest' ); ?></p>
		<div class="decor"><span></span><span></span><span></span></div>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php
		while ( have_posts() ) {
			the_post();
			the_content();
		}
		dental_ouest_products_grid( 0, true );
		?>
		<div style="text-align:center;margin-top:46px;">
			<a class="btn btn-green" href="<?php echo esc_url( $contact ); ?>"><?php esc_html_e( 'Un produit manque ? Demandez-nous', 'dental-ouest' ); ?> →</a>
		</div>
	</div>
</section>
<?php get_footer(); ?>