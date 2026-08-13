<?php
/**
 * Dental Ouest — Fallback.
 *
 * @package dental-ouest
 */
get_header();
?>
<section class="page-hero">
	<div class="container">
		<p class="crumb">🦷 <b><?php esc_html_e( 'Actualités', 'dental-ouest' ); ?></b></p>
		<h1><?php esc_html_e( 'Derniers ', 'dental-ouest' ); ?><span class="grad">articles</span></h1>
	</div>
</section>
<section class="section">
	<div class="container">
		<div class="why-grid" style="grid-template-columns:1fr;">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article style="border:1px solid #EAF0F7;border-radius:20px;padding:30px;box-shadow:var(--shadow-card);margin-bottom:22px;">
					<h2 style="font-size:1.25rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div style="color:var(--ink);font-size:.9rem;line-height:1.8;margin-top:10px;"><?php the_excerpt(); ?></div>
				</article>
				<?php
			}
			?>
		</div>
	</div>
</section>
<?php get_footer(); ?>