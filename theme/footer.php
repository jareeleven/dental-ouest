<?php
/**
 * Dental Ouest — Footer.
 *
 * @package dental-ouest
 */
?>
</main><!-- /#main -->

<div class="quick-view" id="quickView" role="dialog" aria-label="Fiche produit">
	<button class="qv-close" id="qvClose" aria-label="<?php esc_attr_e( 'Fermer', 'dental-ouest' ); ?>">✕</button>
	<div class="qv-media"><img id="qvImg" src="" alt=""></div>
	<div class="qv-body">
		<span class="qv-tag" id="qvTag"></span>
		<h3 id="qvTitle"></h3>
		<p id="qvDesc"></p>
		<h4 style="font-family:var(--font-head);font-size:.8rem;font-weight:800;color:var(--green);letter-spacing:1.5px;text-transform:uppercase;margin-top:22px;"><?php echo esc_html( do_mod( 'do_specs_label', 'Spécifications techniques' ) ); ?></h4>
		<ul class="qv-specs" id="qvSpecs"></ul>
		<div class="qv-foot">
			<span class="pc-price" id="qvStatus"></span>
			<a class="btn btn-sm btn-green" id="qvBtn" href="#"></a>
		</div>
	</div>
</div>

<a class="fab-whatsapp" target="_blank" rel="noreferrer"
	href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^\d]/', '', do_mod( 'do_wa_num', '+213550572388' ) ) ); ?>?text=<?php echo rawurlencode( do_mod( 'do_wa_msg', 'Bonjour Dental Ouest, je souhaite avoir des informations.' ) ); ?>"
	aria-label="WhatsApp">💬</a>
<button class="fab-top" id="fabTop" aria-label="<?php esc_attr_e( 'Haut de page', 'dental-ouest' ); ?>">↑</button>

<footer class="footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<span class="logo-mark">🦷</span>
						<span class="logo-text"><?php echo esc_html( do_mod( 'do_logo_text', 'Dental Ouest' ) ); ?>
							<small><?php echo esc_html( do_mod( 'do_logo_small', 'Équipement dentaire' ) ); ?></small>
						</span>
					<?php endif; ?>
				</a>
				<p><?php echo esc_html( do_mod( 'do_ft_desc', 'Depuis 1982, Dental Ouest équipe les professionnels dentaires d' . '\'' . 'Algérie : fourniture, installation et service après-vente de haut niveau, dans les 58 wilayas.' ) ); ?></p>
				<div class="footer-socials">
					<?php if ( $s = do_mod( 'do_fb' ) ) : ?><a href="<?php echo esc_url( $s ); ?>" target="_blank" rel="noreferrer" aria-label="Facebook">f</a><?php endif; ?>
					<?php if ( $s = do_mod( 'do_ig' ) ) : ?><a href="<?php echo esc_url( $s ); ?>" target="_blank" rel="noreferrer" aria-label="Instagram">◉</a><?php endif; ?>
					<?php if ( $s = do_mod( 'do_li' ) ) : ?><a href="<?php echo esc_url( $s ); ?>" target="_blank" rel="noreferrer" aria-label="LinkedIn">in</a><?php endif; ?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Navigation', 'dental-ouest' ); ?></h4>
				<div class="footer-links">
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) );
				} else {
					dental_ouest_fallback_menu();
				}
				?>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Nos services', 'dental-ouest' ); ?></h4>
				<div class="footer-links">
					<a href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Équipements de cabinet', 'dental-ouest' ); ?></a>
					<a href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Consommables & matériaux', 'dental-ouest' ); ?></a>
					<a href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Radiologie numérique', 'dental-ouest' ); ?></a>
					<a href="<?php echo esc_url( dental_ouest_page_url( 'produits' ) ); ?>"><?php esc_html_e( 'Hygiène & stérilisation', 'dental-ouest' ); ?></a>
					<a href="<?php echo esc_url( dental_ouest_page_url( 'sav' ) ); ?>"><?php esc_html_e( 'Installation clé en main', 'dental-ouest' ); ?></a>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Contact', 'dental-ouest' ); ?></h4>
				<div class="footer-contact">
					<div class="fc-item"><span class="ico">📍</span><span><?php echo esc_html( do_mod( 'do_addr', '41, Rue Cherif Ali Cherfi — Oran, Algérie' ) ); ?></span></div>
					<div class="fc-item"><span class="ico">📞</span><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', do_mod( 'do_phone', '+213 550 572 388' ) ) ); ?>"><?php echo esc_html( do_mod( 'do_phone', '+213 550 572 388' ) ); ?></a></div>
					<div class="fc-item"><span class="ico">✉️</span><a href="mailto:<?php echo esc_attr( do_mod( 'do_mail', 'commercial@dentalouest.net' ) ); ?>"><?php echo esc_html( do_mod( 'do_mail', 'commercial@dentalouest.net' ) ); ?></a></div>
					<div class="fc-item"><span class="ico">🕐</span><span><?php echo esc_html( do_mod( 'do_hours', 'Dimanche — Jeudi · 08h00 — 17h00' ) ); ?></span></div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <b>Dental Ouest</b> — <?php echo esc_html( do_mod( 'do_ft_rights', 'Tous droits réservés.' ) ); ?></span>
			<span><?php echo esc_html( do_mod( 'do_ft_made', 'DENTAL OUEST — Oran · Alger · Constantine' ) ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>