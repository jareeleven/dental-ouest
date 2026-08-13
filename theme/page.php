<?php
/**
 * Dental Ouest — Page classique.
 *
 * @package dental-ouest
 */
get_header();
?>
<section class="page-hero">
	<div class="container">
		<p class="crumb">🦷 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">Accueil</a><span class="sep">·</span><b><?php the_title(); ?></b></p>
		<h1><?php the_title(); ?></h1>
		<div class="decor"><span></span><span></span><span></span></div>
	</div>
</section>
<section class="section">
	<div class="container">
		<div style="max-width:820px;margin:0 auto;font-size:1rem;line-height:1.9;">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
			?>
		</div>
	</div>
</section>
<?php get_footer(); ?>