<?php
/**
 * Dental Ouest — functions & setup.
 *
 * @package dental-ouest
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'DO_VERSION', '1.3.0' );

/* ── Lecture d'un réglage du Personnalisateur (avec valeur par défaut) ── */
function do_mod( $key, $default = '' ) {
	$v = get_theme_mod( $key, $default );
	return ( '' === $v ) ? $default : $v;
}

/* ── Setup du thème ── */
function dental_ouest_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 90,
		'width'       => 320,
		'flex-width'  => true,
		'flex-height' => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'dental-ouest' ),
		'footer'  => __( 'Menu pied de page', 'dental-ouest' ),
	) );
}
add_action( 'after_setup_theme', 'dental_ouest_setup' );

/* ── Assets ── */
function dental_ouest_assets() {
	wp_enqueue_style(
		'dental-ouest-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600;700&display=swap',
		array(), null
	);
	wp_enqueue_style( 'dental-ouest', get_stylesheet_uri(), array( 'dental-ouest-fonts' ), DO_VERSION );
	wp_enqueue_script( 'dental-ouest', get_template_directory_uri() . '/assets/js/theme.js', array(), DO_VERSION, true );

	$colors = array(
		'--navy'   => do_mod( 'do_navy', '#0D2455' ),
		'--navy-2' => do_mod( 'do_navy2', '#0A3D7A' ),
		'--green'  => do_mod( 'do_green', '#2DB87A' ),
		'--gold'   => do_mod( 'do_gold', '#C8A84B' ),
	);
	$css = ':root{' . implode( '', array_map(
		function ( $k, $v ) { return $k . ':' . $v . ';'; },
		array_keys( $colors ), array_values( $colors )
	) ) . '}';
	wp_add_inline_style( 'dental-ouest', $css );
}
add_action( 'wp_enqueue_scripts', 'dental_ouest_assets' );

/* ── Type de contenu : produit ── */
function dental_ouest_register_cpt() {
	register_post_type( 'produit', array(
		'labels'      => array(
			'name'          => __( 'Produits', 'dental-ouest' ),
			'singular_name' => __( 'Produit', 'dental-ouest' ),
			'add_new_item'  => __( 'Ajouter un produit', 'dental-ouest' ),
			'edit_item'     => __( 'Modifier le produit', 'dental-ouest' ),
			'featured_image' => __( 'Photo du produit', 'dental-ouest' ),
			'set_featured_image' => __( 'Définir la photo du produit', 'dental-ouest' ),
		),
		'public'      => true,
		'has_archive' => false,
		'menu_icon'   => 'dashicons-stethoscope',
		'menu_position' => 5,
		'rewrite'     => array( 'slug' => 'produit' ),
		'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	) );

	register_taxonomy( 'categorie_produit', 'produit', array(
		'labels'            => array(
			'name'          => __( 'Catégories de produits', 'dental-ouest' ),
			'singular_name' => __( 'Catégorie', 'dental-ouest' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'categorie-produit' ),
	) );

	register_post_type( 'technicien', array(
		'labels'      => array(
			'name'          => __( 'Techniciens SAV', 'dental-ouest' ),
			'singular_name' => __( 'Technicien', 'dental-ouest' ),
			'add_new_item'  => __( 'Ajouter un technicien', 'dental-ouest' ),
			'edit_item'     => __( 'Modifier le technicien', 'dental-ouest' ),
			'featured_image' => __( 'Photo du technicien', 'dental-ouest' ),
			'set_featured_image' => __( 'Définir la photo du technicien', 'dental-ouest' ),
		),
		'public'      => true,
		'has_archive' => false,
		'menu_icon'   => 'dashicons-hammer',
		'menu_position' => 6,
		'show_in_rest' => true,
		'rewrite'     => array( 'slug' => 'technicien' ),
		'supports'    => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
	) );
}
add_action( 'init', 'dental_ouest_register_cpt' );

/* ── Champs produit : disponibilité + spécifications ── */
function dental_ouest_product_metabox() {
	add_meta_box( 'do-product-fields', __( 'Fiche produit', 'dental-ouest' ),
		'dental_ouest_product_metabox_render', 'produit', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'dental_ouest_product_metabox' );

function dental_ouest_product_metabox_render( $post ) {
	wp_nonce_field( 'do_product_save', 'do_product_nonce' );
	$dispo   = get_post_meta( $post->ID, '_do_dispo', true );
	$dispo   = $dispo ? $dispo : 'sur_devis';
	$specs   = get_post_meta( $post->ID, '_do_specs', true );
	?>
	<p><strong><?php esc_html_e( 'Disponibilité', 'dental-ouest' ); ?></strong></p>
	<p>
		<label style="display:block;margin-bottom:6px;">
			<input type="radio" name="do_dispo" value="en_stock" <?php checked( $dispo, 'en_stock' ); ?> />
			<?php esc_html_e( 'En stock', 'dental-ouest' ); ?>
		</label>
		<label style="display:block;">
			<input type="radio" name="do_dispo" value="sur_devis" <?php checked( $dispo, 'sur_devis' ); ?> />
			<?php esc_html_e( 'Sur devis', 'dental-ouest' ); ?>
		</label>
	</p>
	<p><strong><?php esc_html_e( 'Spécifications techniques', 'dental-ouest' ); ?></strong></p>
	<p style="font-size:12px;color:#666;"><?php esc_html_e( 'Une spécification par ligne (la liste apparaît au survol de la carte), sans saisir « ✓ » :', 'dental-ouest' ); ?></p>
	<textarea name="do_specs" rows="8" style="width:100%;"><?php echo esc_textarea( $specs ); ?></textarea>
	<?php
}

function dental_ouest_product_metabox_save( $post_id ) {
	if ( ! isset( $_POST['do_product_nonce'] ) || ! wp_verify_nonce( $_POST['do_product_nonce'], 'do_product_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$dispo = isset( $_POST['do_dispo'] ) && 'en_stock' === $_POST['do_dispo'] ? 'en_stock' : 'sur_devis';
	update_post_meta( $post_id, '_do_dispo', $dispo );

	$specs = isset( $_POST['do_specs'] ) ? sanitize_textarea_field( wp_unslash( $_POST['do_specs'] ) ) : '';
	update_post_meta( $post_id, '_do_specs', $specs );
}
add_action( 'save_post_produit', 'dental_ouest_product_metabox_save' );

/* ── Coordonnées du technicien (téléphone + e-mail de réception) ── */
function dental_ouest_tech_metabox() {
	add_meta_box( 'do-tech-fields', __( 'Coordonnées', 'dental-ouest' ),
		'dental_ouest_tech_metabox_render', 'technicien', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'dental_ouest_tech_metabox' );

function dental_ouest_tech_metabox_render( $post ) {
	wp_nonce_field( 'do_tech_save', 'do_tech_nonce' );
	$tel  = get_post_meta( $post->ID, '_do_tech_tel', true );
	$mail = get_post_meta( $post->ID, '_do_tech_mail', true );
	?>
	<p style="margin-bottom:12px;">
		<label for="do_tech_tel" style="font-weight:600;display:block;margin-bottom:4px;"><?php esc_html_e( 'Téléphone (affiché sur le site)', 'dental-ouest' ); ?></label>
		<input type="tel" id="do_tech_tel" name="do_tech_tel" value="<?php echo esc_attr( $tel ); ?>" style="width:100%;" placeholder="+213 555 00 00 00">
	</p>
	<p>
		<label for="do_tech_mail" style="font-weight:600;display:block;margin-bottom:4px;"><?php esc_html_e( 'E-mail de réception des demandes', 'dental-ouest' ); ?></label>
		<input type="email" id="do_tech_mail" name="do_tech_mail" value="<?php echo esc_attr( $mail ); ?>" style="width:100%;" placeholder="technicien@dentalouest.net">
	</p>
	<p style="font-size:12px;color:#666;">
		<?php esc_html_e( 'La spécialité se renseigne dans « Extrait » (à droite de l' . '\'' . 'éditeur) — ex : « Électronique & modules ».', 'dental-ouest' ); ?>
	</p>
	<?php
}

function dental_ouest_tech_metabox_save( $post_id ) {
	if ( ! isset( $_POST['do_tech_nonce'] ) || ! wp_verify_nonce( $_POST['do_tech_nonce'], 'do_tech_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$tel  = isset( $_POST['do_tech_tel'] ) ? sanitize_text_field( wp_unslash( $_POST['do_tech_tel'] ) ) : '';
	$mail = isset( $_POST['do_tech_mail'] ) ? sanitize_email( wp_unslash( $_POST['do_tech_mail'] ) ) : '';
	update_post_meta( $post_id, '_do_tech_tel', $tel );
	update_post_meta( $post_id, '_do_tech_mail', $mail );
}
add_action( 'save_post_technicien', 'dental_ouest_tech_metabox_save' );

/* ── Personnalisateur ── */
function dental_ouest_customize( $wp_customize ) {

	/* Aide : textes édités ligne par ligne. */
	$wp_customize->get_setting( 'blogname' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$section = function ( $id, $title, $prio, $desc = '' ) use ( $wp_customize ) {
		$wp_customize->add_section( $id, array(
			'title'       => $title,
			'priority'    => $prio,
			'description' => $desc,
		) );
	};

	$colour = function ( $id, $label, $default ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_hex_color' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => $label,
			'section' => 'do_colors',
		) ) );
	};

	$text = function ( $id, $label, $section_id, $default = '', $type = 'text', $transport = 'refresh' ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control( $id, array(
			'label'       => $label,
			'section'     => $section_id,
			'type'        => $type,
			'input_attrs' => array( 'placeholder' => esc_attr( $default ) ),
		) );
	};

	$url = function ( $id, $label, $section_id, $default = '' ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => $section_id, 'type' => 'url' ) );
	};

	$mail = function ( $id, $label, $section_id, $default = '' ) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_email' ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => $section_id, 'type' => 'email' ) );
	};

	/* ── Couleurs ── */
	$section( 'do_colors', __( 'Couleurs du site', 'dental-ouest' ), 20 );
	$colour( 'do_navy',  __( 'Bleu marine (fond)', 'dental-ouest' ), '#0D2455' );
	$colour( 'do_navy2', __( 'Bleu secondaire', 'dental-ouest' ), '#0A3D7A' );
	$colour( 'do_green', __( 'Vert émeraude', 'dental-ouest' ), '#2DB87A' );
	$colour( 'do_gold',  __( 'Or (accents)', 'dental-ouest' ), '#C8A84B' );

	/* ── Accueil ── */
	$section( 'do_home', __( 'Page d' . '\'' . 'accueil', 'dental-ouest' ), 30,
		__( 'Titres et textes du héros, bandeau défilant, statistiques et services. Vous pouvez utiliser <span class="grad">…</span> pour colorer un mot.', 'dental-ouest' ) );

	$text( 'do_hero_badge', __( 'Badge au-dessus du titre', 'dental-ouest' ), 'do_home', 'Depuis 1982 · Oran, Algérie' );
	$text( 'do_hero_title', __( 'Titre du héros', 'dental-ouest' ), 'do_home', 'L\'excellence dentaire au service de votre <span class="grad">cabinet</span>', 'textarea' );
	$text( 'do_hero_sub', __( 'Sous-titre', 'dental-ouest' ), 'do_home', 'Importation, distribution et installation d\'équipements et de consommables dentaires de qualité internationale. Votre partenaire de confiance pour équiper votre cabinet partout en Algérie — du conseil à la maintenance.', 'textarea' );
	$text( 'do_hero_cta1', __( 'Bouton 1 (devis)', 'dental-ouest' ), 'do_home', 'Demander un devis' );
	$url( 'do_hero_cta1_url', __( 'Lien du bouton 1 (page)', 'dental-ouest' ), 'do_home', '' );
	$text( 'do_hero_cta2', __( 'Bouton 2 (produits)', 'dental-ouest' ), 'do_home', 'Découvrir nos produits' );
	$url( 'do_hero_cta2_url', __( 'Lien du bouton 2 (page)', 'dental-ouest' ), 'do_home', '' );
	$text( 'do_marquee', __( 'Bandeau défilant (une phrase par ligne)', 'dental-ouest' ), 'do_home', "Qualité internationale certifiée ISO\nLivraison dans les 58 wilayas\nDepuis 1982 en Algérie\nTechniciens installateurs certifiés\nSAV réactif 6 jours sur 7\nPlus de 5 000 clients satisfaits", 'textarea' );

	$stats = array(
		'do_stat1' => array( '40',  __( 'Années d' . '\'' . 'expérience', 'dental-ouest' ) ),
		'do_stat2' => array( '3',   __( 'Agences en Algérie', 'dental-ouest' ) ),
		'do_stat3' => array( '5000', __( 'Clients satisfaits', 'dental-ouest' ) ),
		'do_stat4' => array( '500',  __( 'Produits disponibles', 'dental-ouest' ) ),
	);
	foreach ( $stats as $s => $d ) {
		$text( $s . '_n',     sprintf( __( 'Statistique %1$d — valeur', 'dental-ouest' ), substr( $s, -1 ) ), 'do_home', $d[0] );
		$text( $s . '_label', sprintf( __( 'Statistique %1$d — libellé', 'dental-ouest' ), substr( $s, -1 ) ), 'do_home', $d[1] );
	}

	$services = array(
		1 => array( '🦷', __( 'Équipements de cabinet', 'dental-ouest' ), __( 'Fauteuils, units dentaires, lampes, compresseurs : tout l' . '\'' . 'équipement essentiel pour votre cabinet.', 'dental-ouest' ) ),
		2 => array( '🧰', __( 'Installation clé en main', 'dental-ouest' ), __( 'Nos équipes installent, raccordent et configurent votre cabinet intégralement.', 'dental-ouest' ) ),
		3 => array( '💊', __( 'Consommables & matériaux', 'dental-ouest' ), __( 'Composites, anesthésiques, empreintes : les grandes marques toujours en stock.', 'dental-ouest' ) ),
		4 => array( '📡', __( 'Radiologie numérique', 'dental-ouest' ), __( 'Capteurs intra-oraux, panoramiques et imagerie haute résolution.', 'dental-ouest' ) ),
		5 => array( '🧼', __( 'Hygiène & stérilisation', 'dental-ouest' ), __( 'Autoclaves certifiés, désinfectants et solutions conformes aux normes internationales.', 'dental-ouest' ) ),
		6 => array( '🔧', __( 'SAV & maintenance', 'dental-ouest' ), __( 'Techniciens spécialisés à votre écoute pour un entretien rapide et fiable.', 'dental-ouest' ) ),
	);
	foreach ( $services as $i => $s ) {
		$text( 'do_serv' . $i . '_ic', sprintf( __( 'Service %1$d — icône (emojis)', 'dental-ouest' ), $i ), 'do_home', $s[0] );
		$text( 'do_serv' . $i . '_t',  sprintf( __( 'Service %1$d — titre', 'dental-ouest' ), $i ), 'do_home', $s[1] );
		$text( 'do_serv' . $i . '_d',  sprintf( __( 'Service %1$d — description', 'dental-ouest' ), $i ), 'do_home', $s[2], 'textarea' );
	}

	/* ── Pourquoi nous / citation ── */
	$section( 'do_why', __( '« Pourquoi nous » (accueil)', 'dental-ouest' ), 31 );
	$text( 'do_why_img', __( 'Image (mettez l' . '\'' . 'adresse dans Médias → copier l' . '\'' . 'URL)', 'dental-ouest' ), 'do_why', '', 'url' );
	$text( 'do_why_badge_b', __( 'Badge — titre', 'dental-ouest' ), 'do_why', 'Certifié ISO 9001' );
	$text( 'do_why_badge_s', __( 'Badge — sous-titre', 'dental-ouest' ), 'do_why', 'Plus de 40 ans d' . '\'' . 'expérience' );
	$why = array(
		1 => array( '🏛️', __( 'Une histoire familiale', 'dental-ouest' ), __( 'Fondée par la famille HAKKA à Oran : trois générations au service des praticiens algériens depuis 1982.', 'dental-ouest' ) ),
		2 => array( '⚡', __( 'Installation clé en main', 'dental-ouest' ), __( 'Livraison, installation, réseaux d' . '\'' . 'air, d' . '\'' . 'eau et d' . '\'' . 'électricité, mise en service : tout est pris en charge.', 'dental-ouest' ) ),
		3 => array( '🛡️', __( 'Garantie & suivi', 'dental-ouest' ), __( 'Garantie constructeur, contrats de maintenance et techniciens disponibles 6 jours sur 7.', 'dental-ouest' ) ),
		4 => array( '💎', __( 'Devis transparents', 'dental-ouest' ), __( 'Devis détaillés, prix justes, sans frais cachés, pour toutes les wilayas.', 'dental-ouest' ) ),
	);
	foreach ( $why as $i => $f ) {
		$text( 'do_why' . $i . '_ic', sprintf( __( 'Atout %1$d — icône', 'dental-ouest' ), $i ), 'do_why', $f[0] );
		$text( 'do_why' . $i . '_t',  sprintf( __( 'Atout %1$d — titre', 'dental-ouest' ), $i ), 'do_why', $f[1] );
		$text( 'do_why' . $i . '_d',  sprintf( __( 'Atout %1$d — texte', 'dental-ouest' ), $i ), 'do_why', $f[2], 'textarea' );
	}
	$text( 'do_quote_t', __( 'Citation — texte', 'dental-ouest' ), 'do_why', __( '« Notre engagement va au-delà de la vente : chaque fauteuil installé est une confiance qu' . '\'' . 'il faut mériter chaque jour. »', 'dental-ouest' ), 'textarea' );
	$text( 'do_quote_a', __( 'Citation — auteur', 'dental-ouest' ), 'do_why', 'Ali HAKKA' );
	$text( 'do_quote_r', __( 'Citation — fonction', 'dental-ouest' ), 'do_why', 'Gérant · Dental Ouest' );

	/* ── Bandeau final (CTA) ── */
	$section( 'do_cta', __( 'Bandeau « Prêt à équiper ? »', 'dental-ouest' ), 32 );
	$text( 'do_cta_t', __( 'Titre', 'dental-ouest' ), 'do_cta', __( 'Prêt à équiper votre cabinet ?', 'dental-ouest' ) );
	$text( 'do_cta_s', __( 'Sous-titre', 'dental-ouest' ), 'do_cta', __( 'Devis détaillé, sans engagement, sous 24 h. Nos équipes vous accompagnent de A à Z.', 'dental-ouest' ), 'textarea' );
	$text( 'do_cta_b', __( 'Bouton', 'dental-ouest' ), 'do_cta', __( 'Demander un devis gratuit', 'dental-ouest' ) );

	/* ── Produits ── */
	$section( 'do_prod', __( 'Catalogue produits', 'dental-ouest' ), 33 );
	$text( 'do_prod_t', __( 'Titre de la section', 'dental-ouest' ), 'do_prod', 'Des produits <span class="grad">d' . '\'' . 'exception</span>' );
	$text( 'do_prod_sub', __( 'Sous-titre', 'dental-ouest' ), 'do_prod', 'Équipements et matériaux des grandes marques internationales, livrés partout en Algérie.', 'textarea' );
	$text( 'do_prod_all', __( 'Filtre « Tous »', 'dental-ouest' ), 'do_prod', 'Tous' );
	$text( 'do_stock', __( 'Étiquette « En stock »', 'dental-ouest' ), 'do_prod', 'En stock' );
	$text( 'do_devis', __( 'Étiquette « Sur devis »', 'dental-ouest' ), 'do_prod', 'Sur devis' );
	$text( 'do_quote_btn', __( 'Bouton « Demander un devis »', 'dental-ouest' ), 'do_prod', 'Demander un devis' );
	$text( 'do_specs_label', __( 'Titre « Spécifications » (fiche survol)', 'dental-ouest' ), 'do_prod', 'Spécifications techniques' );

	/* ── Contact & réseaux ── */
	$section( 'do_contact', __( 'Coordonnées & réseaux', 'dental-ouest' ), 34 );
	$text( 'do_phone', __( 'Téléphone / WhatsApp', 'dental-ouest' ), 'do_contact', '+213 550 572 388' );
	$text( 'do_wa_num', __( 'Numéro WhatsApp (format international, sans espaces)', 'dental-ouest' ), 'do_contact', '+213550572388' );
	$text( 'do_wa_msg', __( 'Message WhatsApp par défaut', 'dental-ouest' ), 'do_contact', 'Bonjour Dental Ouest, je souhaite avoir des informations.' );
	$text( 'do_mail', __( 'E-mail commercial', 'dental-ouest' ), 'do_contact', 'commercial@dentalouest.net' );
	$text( 'do_mail_sav', __( 'E-mail SAV (réception des formulaires)', 'dental-ouest' ), 'do_contact', '' );
	$mail( 'do_mail_direction', __( 'E-mail direction (reçoit une copie de chaque message du site)', 'dental-ouest' ), 'do_contact', '' );
	$text( 'do_addr', __( 'Adresse siège', 'dental-ouest' ), 'do_contact', '41, Rue Cherif Ali Cherfi — Oran, Algérie' );
	$text( 'do_hours', __( 'Horaires', 'dental-ouest' ), 'do_contact', 'Dimanche — Jeudi · 08h00 — 17h00' );
	$url( 'do_map_url', __( 'URL de la carte (iframe Google Maps)', 'dental-ouest' ), 'do_contact', 'https://www.google.com/maps?q=41+Rue+de+la+Libert%C3%A9+Oran+Alg%C3%A9rie&output=embed' );
	$text( 'do_fb', __( 'Facebook (URL)', 'dental-ouest' ), 'do_contact', '' );
	$text( 'do_ig', __( 'Instagram (URL)', 'dental-ouest' ), 'do_contact', '' );
	$text( 'do_li', __( 'LinkedIn (URL)', 'dental-ouest' ), 'do_contact', '' );

	/* ── À propos ── */
	$section( 'do_about', __( 'Page « À propos »', 'dental-ouest' ), 35 );
	$text( 'do_ab_kicker', __( 'Sur-titre', 'dental-ouest' ), 'do_about', 'Notre histoire' );
	$text( 'do_ab_title', __( 'Titre', 'dental-ouest' ), 'do_about', 'Trois générations <span class="grad">au service</span> de la dentisterie' );
	$text( 'do_ab_sub', __( 'Introduction', 'dental-ouest' ), 'do_about', 'De l' . '\'' . 'atelier de prothèse à l' . '\'' . 'intégration clé en main : un héritage familial tourné vers l' . '\'' . 'excellence.', 'textarea' );
	$timeline = array(
		1 => array( '1982',     __( 'Les débuts', 'dental-ouest' ), __( 'M. HAKKA, prothésiste reconnu, commence à fournir ses confrères en produits dentaires depuis son laboratoire à Oran.', 'dental-ouest' ) ),
		2 => array( '1993',     __( 'La création', 'dental-ouest' ), __( 'Ali HAKKA, fils du fondateur, crée les ETS HAKKA et professionnalise la distribution dans l' . '\'' . 'Ouest algérien.', 'dental-ouest' ) ),
		3 => array( '2002',     __( 'La marque Dental Ouest', 'dental-ouest' ), __( 'Lancement officiel de la marque Dental Ouest : équipements, consommables et installation complète de cabinets.', 'dental-ouest' ) ),
		4 => array( 'Aujourd' . '\'' . 'hui', __( 'Le Nº1 de l' . '\'' . 'Ouest', 'dental-ouest' ), __( 'Plus de 40 ans d' . '\'' . 'expérience, 3 agences et plus de 5 000 professionnels équipés à travers toute l' . '\'' . 'Algérie.', 'dental-ouest' ) ),
	);
	foreach ( $timeline as $i => $t ) {
		$text( 'do_tl' . $i . '_yr', sprintf( __( 'Étape %1$d — année', 'dental-ouest' ), $i ), 'do_about', $t[0] );
		$text( 'do_tl' . $i . '_t',  sprintf( __( 'Étape %1$d — titre', 'dental-ouest' ), $i ), 'do_about', $t[1] );
		$text( 'do_tl' . $i . '_d',  sprintf( __( 'Étape %1$d — texte', 'dental-ouest' ), $i ), 'do_about', $t[2], 'textarea' );
	}
	$text( 'do_ab_values_t', __( 'Titre « Nos valeurs »', 'dental-ouest' ), 'do_about', 'Nos valeurs' );
	$values = array(
		1 => array( '🤝', __( 'Confiance', 'dental-ouest' ), __( 'Des relations de long terme fondées sur la transparence et l' . '\'' . 'écoute.', 'dental-ouest' ) ),
		2 => array( '🏆', __( 'Excellence', 'dental-ouest' ), __( 'Une exigence de qualité à chaque étape du processus.', 'dental-ouest' ) ),
		3 => array( '⚙️', __( 'Fiabilité', 'dental-ouest' ), __( 'Un suivi complet : installation, garantie et maintenance.', 'dental-ouest' ) ),
		4 => array( '🇩🇿', __( 'Engagement', 'dental-ouest' ), __( 'Au service de la dentisterie algérienne depuis 1982.', 'dental-ouest' ) ),
	);
	foreach ( $values as $i => $v ) {
		$text( 'do_val' . $i . '_ic', sprintf( __( 'Valeur %1$d — icône', 'dental-ouest' ), $i ), 'do_about', $v[0] );
		$text( 'do_val' . $i . '_t',  sprintf( __( 'Valeur %1$d — titre', 'dental-ouest' ), $i ), 'do_about', $v[1] );
		$text( 'do_val' . $i . '_d',  sprintf( __( 'Valeur %1$d — texte', 'dental-ouest' ), $i ), 'do_about', $v[2] );
	}
	$text( 'do_ab_iso_t', __( 'Engagement qualité — titre', 'dental-ouest' ), 'do_about', 'Notre engagement qualité' );
	$text( 'do_ab_iso_d', __( 'Engagement qualité — texte', 'dental-ouest' ), 'do_about', 'Nos processus sont organisés selon les principes des systèmes de management certifiés : équipements contrôlés, traçabilité complète et personnel formé en continu.', 'textarea' );
	$text( 'do_ab_iso_b', __( 'Engagement qualité — badge', 'dental-ouest' ), 'do_about', 'Certifié ISO' );

	/* ── SAV ── */
	$section( 'do_sav', __( 'Page SAV', 'dental-ouest' ), 36 );
	$text( 'do_sav_kicker', __( 'Sur-titre', 'dental-ouest' ), 'do_sav', 'Service Après-Vente' );
	$text( 'do_sav_title', __( 'Titre', 'dental-ouest' ), 'do_sav', 'Votre équipement <span class="grad">mérite de l' . '\'' . 'attention</span>' );
	$text( 'do_sav_sub', __( 'Introduction', 'dental-ouest' ), 'do_sav', 'Un SAV dédié, des techniciens spécialisés : votre cabinet reste opérationnel en toutes circonstances.', 'textarea' );
	$steps = array(
		1 => array( __( 'Contactez-nous', 'dental-ouest' ), __( 'Par téléphone, e-mail ou le formulaire ci-dessous — réponse sous 24 h.', 'dental-ouest' ) ),
		2 => array( __( 'Diagnostic', 'dental-ouest' ), __( 'Notre technicien analyse le problème à distance ou sur site.', 'dental-ouest' ) ),
		3 => array( __( 'Intervention', 'dental-ouest' ), __( 'Réparation, pièce de rechange ou prise en charge garantie.', 'dental-ouest' ) ),
		4 => array( __( 'Suivi', 'dental-ouest' ), __( 'Contrôle qualité et vérification du bon fonctionnement après intervention.', 'dental-ouest' ) ),
	);
	foreach ( $steps as $i => $s ) {
		$text( 'do_step' . $i . '_t', sprintf( __( 'Étape %1$d — titre', 'dental-ouest' ), $i ), 'do_sav', $s[0] );
		$text( 'do_step' . $i . '_d', sprintf( __( 'Étape %1$d — texte', 'dental-ouest' ), $i ), 'do_sav', $s[1] );
	}
	$text( 'do_tech_head_t', __( 'Techniciens — titre de la section', 'dental-ouest' ), 'do_sav', 'Des experts sur intervention' );
	$text( 'do_tech_head_d', __( 'Techniciens — sous-titre', 'dental-ouest' ), 'do_sav', 'Un SAV dédié, des techniciens spécialisés : votre cabinet reste opérationnel en toutes circonstances.' );
	$text( 'do_tech_form_label', __( 'Formulaire SAV — libellé du choix du technicien', 'dental-ouest' ), 'do_sav', 'Choisir le technicien' );
	$faqs = array(
		1 => array( __( 'Quelles sont vos garanties ?', 'dental-ouest' ), __( 'Tous nos équipements bénéficient de la garantie constructeur. Nous proposons également des contrats de maintenance annuels.', 'dental-ouest' ) ),
		2 => array( __( 'Intervenez-vous dans tout le pays ?', 'dental-ouest' ), __( 'Oui, nos techniciens se déplacent dans les 58 wilayas depuis nos agences d' . '\'' . 'Oran, d' . '\'' . 'Alger et de Constantine.', 'dental-ouest' ) ),
		3 => array( __( 'Que faire en cas de panne ?', 'dental-ouest' ), __( 'Contactez le SAV : un technicien vous répond, établit le diagnostic et intervient sous 48 h après accord.', 'dental-ouest' ) ),
		4 => array( __( 'Vendez-vous des pièces détachées ?', 'dental-ouest' ), __( 'Oui, nous maintenons un stock de pièces d' . '\'' . 'origine pour les principaux fabricants.', 'dental-ouest' ) ),
	);
	foreach ( $faqs as $i => $f ) {
		$text( 'do_faq' . $i . '_q', sprintf( __( 'Question %1$d', 'dental-ouest' ), $i ), 'do_sav', $f[0] );
		$text( 'do_faq' . $i . '_a', sprintf( __( 'Réponse %1$d', 'dental-ouest' ), $i ), 'do_sav', $f[1], 'textarea' );
	}

	/* ── Pied de page ── */
	$section( 'do_footer', __( 'Pied de page', 'dental-ouest' ), 37 );
	$text( 'do_ft_desc', __( 'Description', 'dental-ouest' ), 'do_footer', 'Depuis 1982, Dental Ouest équipe les professionnels dentaires d' . '\'' . 'Algérie : fourniture, installation et service après-vente de haut niveau, dans les 58 wilayas.', 'textarea' );
	$text( 'do_ft_rights', __( 'Mention de droits', 'dental-ouest' ), 'do_footer', 'Tous droits réservés.' );
	$text( 'do_ft_made', __( 'Ligne villes', 'dental-ouest' ), 'do_footer', 'DENTAL OUEST — Oran · Alger · Constantine' );

	/* Logo personnalisé */
	$wp_customize->add_section( 'do_identity', array( 'title' => __( 'Logo & identité', 'dental-ouest' ), 'priority' => 19 ) );
	$wp_customize->add_setting( 'do_logo_text', array( 'default' => 'Dental Ouest', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'do_logo_text', array( 'label' => __( 'Texte du logo (utilisé si aucun logo image)', 'dental-ouest' ), 'section' => 'do_identity', 'type' => 'text' ) );
	$wp_customize->add_setting( 'do_logo_small', array( 'default' => 'Équipement dentaire', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control( 'do_logo_small', array( 'label' => __( 'Sous-texte du logo', 'dental-ouest' ), 'section' => 'do_identity', 'type' => 'text' ) );
}
add_action( 'customize_register', 'dental_ouest_customize' );

/* ── Navigation de secours ── */
function dental_ouest_fallback_menu() {
	$items = array(
		array( 'home',      __( 'Accueil', 'dental-ouest' ),             home_url( '/' ) ),
		array( 'produits',  __( 'Nos Produits', 'dental-ouest' ),         home_url( '/produits/' ) ),
		array( 'apropos',   __( 'À propos', 'dental-ouest' ),             home_url( '/apropos/' ) ),
		array( 'sav',       __( 'SAV & Assistance', 'dental-ouest' ),     home_url( '/sav/' ) ),
		array( 'contact',   __( 'Contact', 'dental-ouest' ),              home_url( '/contact/' ) ),
	);
	foreach ( $items as $it ) {
		$cls = is_page( $it[0] ) ? 'active' : '';
		echo '<a href="' . esc_url( $it[2] ) . '" class="' . esc_attr( $cls ) . '">' . esc_html( $it[1] ) . '</a>';
	}
}

/* ── Grille produits (partagée accueil + catalogue) ── */
function dental_ouest_products_grid( $limit = 0, $with_filter = false ) {
	$q = new WP_Query( array(
		'post_type'      => 'produit',
		'posts_per_page' => $limit ? $limit : -1,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	) );
	if ( ! $q->have_posts() ) { return; }

	$cats = get_terms( array( 'taxonomy' => 'categorie_produit', 'hide_empty' => true ) );

	if ( $with_filter && ! is_wp_error( $cats ) && $cats ) {
		echo '<div class="filter-bar" id="filterBar">';
		echo '<button class="filter-btn active" data-cat="all">' . esc_html( do_mod( 'do_prod_all', 'Tous' ) ) . '</button>';
		foreach ( $cats as $c ) {
			echo '<button class="filter-btn" data-cat="' . esc_attr( $c->slug ) . '">' . esc_html( $c->name ) . '</button>';
		}
		echo '</div>';
	}

	$stock_t = do_mod( 'do_stock', 'En stock' );
	$devis_t = do_mod( 'do_devis', 'Sur devis' );

	echo '<div class="products-grid" id="productsGrid">';
	while ( $q->have_posts() ) {
		$q->the_post();
		$pid    = get_the_ID();
		$dispo  = get_post_meta( $pid, '_do_dispo', true );
		$dispo  = $dispo ? $dispo : 'sur_devis';
		$specs  = get_post_meta( $pid, '_do_specs', true );
		$specs  = preg_split( '/\r?\n/', trim( $specs ) );
		$specs  = array_filter( array_map( 'trim', $specs ) );
		$cats   = wp_get_post_terms( $pid, 'categorie_produit', array( 'fields' => 'slugs' ) );
		$cat_n  = wp_get_post_terms( $pid, 'categorie_produit', array( 'fields' => 'names' ) );
		$cat    = $cats ? $cats[0] : 'autre';
		$tagn   = $cat_n ? $cat_n[0] : '';
		$url    = get_permalink( $pid );
		$img    = get_the_post_thumbnail_url( $pid, 'large' );
		$img    = $img ? $img : get_template_directory_uri() . '/assets/img/cabinet.png';
		$media  = $img . '|' . get_the_title();
		?>
		<article class="product-card reveal" data-cat="<?php echo esc_attr( $cat ); ?>"
			data-name="<?php echo esc_attr( get_the_title() ); ?>"
			data-desc="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ) ); ?>"
			data-tag="<?php echo esc_attr( $tagn ); ?>"
			data-status="<?php echo esc_attr( 'en_stock' === $dispo ? $stock_t : $devis_t ); ?>"
			data-stock="<?php echo esc_attr( 'en_stock' === $dispo ? 1 : 0 ); ?>"
			data-btn="<?php echo esc_attr( do_mod( 'do_quote_btn', 'Demander un devis' ) ); ?>"
			data-specs="<?php echo esc_attr( implode( '||', $specs ) ); ?>"
			data-img="<?php echo esc_attr( $img ); ?>">
			<div class="pc-media">
				<img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
				<span class="pc-tag<?php echo 'en_stock' === $dispo ? ' green' : ''; ?>"><?php echo esc_html( $tagn ); ?></span>
				<span class="pc-status<?php echo 'en_stock' === $dispo ? ' stock' : ''; ?>"><?php echo esc_html( 'en_stock' === $dispo ? $stock_t : $devis_t ); ?></span>
			</div>
			<div class="pc-body">
				<h3><a href="<?php echo esc_url( $url ); ?>"><?php the_title(); ?></a></h3>
				<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ) ); ?></p>
				<div class="pc-foot">
					<a class="btn btn-sm btn-green" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Voir la fiche', 'dental-ouest' ); ?></a>
					<a class="pc-price" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( do_mod( 'do_quote_btn', 'Demander un devis' ) ); ?> →</a>
				</div>
			</div>
		</article>
		<?php
	}
	wp_reset_postdata();
	echo '</div>';
}

/* ── Formulaire → e-mail ──
   Routage configuré dans Apparence → Personnaliser → Coordonnées & réseaux :
   - Contact   : le message part à la DIRECTION + au COMMERCIAL (2 destinataires).
   - SAV       : le message part au TECHNICIEN choisi + à la DIRECTION (copie),
                 pour que la direction puisse relancer si le technicien n'a pas lu.
   Aucun plugin : tout est géré ici, dans functions.php. */
function dental_ouest_form_handler() {
	if ( empty( $_POST['do_form'] ) || '1' !== $_POST['do_form'] ) { return; }

	$name  = sanitize_text_field( wp_unslash( $_POST['do_name'] ?? '' ) );
	$subj  = sanitize_text_field( wp_unslash( $_POST['do_subject'] ?? '' ) );
	$msg   = sanitize_textarea_field( wp_unslash( $_POST['do_message'] ?? '' ) );
	$mail  = sanitize_email( wp_unslash( $_POST['do_email'] ?? '' ) );
	$phone = sanitize_text_field( wp_unslash( $_POST['do_phone'] ?? '' ) );
	$route = isset( $_POST['do_route'] ) && 'sav' === $_POST['do_route'] ? 'sav' : 'contact';

	$admin     = get_option( 'admin_email' );
	$direction = sanitize_email( do_mod( 'do_mail_direction', '' ) );
	if ( ! $direction ) { $direction = sanitize_email( do_mod( 'do_mail_sav', '' ) ); }
	if ( ! $direction ) { $direction = $admin; }

	$to        = array();
	$recipient = '';

	if ( 'sav' === $route ) {
		/* Le client choisit un technicien (menu « Techniciens SAV ») →
		   e-mail au technicien + copie à la direction. */
		$tech_id = isset( $_POST['do_tech'] ) ? intval( $_POST['do_tech'] ) : 0;
		if ( $tech_id && 'technicien' === get_post_type( $tech_id ) ) {
			$recipient = get_the_title( $tech_id );
			$tech_mail = sanitize_email( get_post_meta( $tech_id, '_do_tech_mail', true ) );
			$to[]      = $tech_mail ? $tech_mail : $direction;
		} else {
			$recipient = __( 'Technicien SAV', 'dental-ouest' );
			$to[]      = $direction;
		}
		$to[] = $direction; /* copie de sécurité à la direction */
	} else {
		/* Le client précise Direction ou Service commercial → les 2 reçoivent. */
		$recipient = isset( $_POST['do_recipient'] ) && 'direction' === $_POST['do_recipient']
			? __( 'Direction', 'dental-ouest' )
			: __( 'Service commercial', 'dental-ouest' );
		$commercial = sanitize_email( do_mod( 'do_mail', '' ) );
		$to[]       = $direction;
		$to[]       = $commercial ? $commercial : $direction;
	}

	$to = array_values( array_unique( array_filter( $to ) ) );
	if ( ! $to ) { $to = array( $admin ); }

	$body = sprintf(
		"%s : %s\n%s : %s\n%s : %s\n%s : %s\n%s : %s\n\n%s\n\n— %s",
		__( 'Nom', 'dental-ouest' ),          $name,
		__( 'Téléphone', 'dental-ouest' ),    $phone ? $phone : '—',
		__( 'E-mail', 'dental-ouest' ),       $mail,
		__( 'Destinataire', 'dental-ouest' ), $recipient,
		__( 'Sujet', 'dental-ouest' ),        $subj,
		$msg,
		home_url( '/' )
	);

	$headers = array();
	if ( $mail ) { $headers[] = 'Reply-To: ' . $name . ' <' . $mail . '>'; }
	wp_mail( $to, 'Dental Ouest — ' . $subj . ' — ' . $name, $body, $headers );

	wp_safe_redirect( add_query_arg( 'do_sent', '1', wp_get_referer() ? wp_get_referer() : home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_dental_form', 'dental_ouest_form_handler' );
add_action( 'admin_post_nopriv_dental_form', 'dental_ouest_form_handler' );

/* ── Liens utiles ── */
function dental_ouest_page_url( $slug, $fallback = '#' ) {
	$p = get_page_by_path( $slug );
	return $p ? get_permalink( $p ) : $fallback;
}

/* ── Installation de la démo (une seule fois) ── */
function dental_ouest_demo_install() {
	if ( get_option( '_do_demo_installed' ) ) { return; }

	$pages = array(
		'Accueil'  => 'front-page.php',
		'Produits' => 'template-produits.php',
		'À propos' => 'template-apropos.php',
		'SAV'      => 'template-sav.php',
		'Contact'  => 'template-contact.php',
	);

	foreach ( $pages as $title => $template ) {
		$p = get_page_by_path( sanitize_title( $title ) );
		if ( ! $p ) {
			$p = get_page_by_title( $title );
		}
		if ( ! $p ) {
			$pid = wp_insert_post( array(
				'post_title'   => $title,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			) );
		} else {
			$pid = $p->ID;
		}
		update_post_meta( $pid, '_wp_page_template', $template );
		if ( 'front-page.php' === $template ) {
			update_option( 'page_on_front', $pid );
			update_option( 'show_on_front', 'page' );
		}
	}

	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	/* Catégories. */
	$cats = array(
		'equipement'  => 'Équipements',
		'consommable' => 'Consommables',
		'hygiene'     => 'Hygiène',
		'radiologie'  => 'Radiologie',
		'chirurgie'   => 'Chirurgie',
	);
	$term_ids = array();
	foreach ( $cats as $slug => $name ) {
		$term = term_exists( $slug, 'categorie_produit' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'categorie_produit', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $term ) ) {
			$term_ids[ $slug ] = is_array( $term ) ? intval( $term['term_id'] ) : intval( $term );
		}
	}

	/* 12 produits de démonstration. */
	$products = array(
		array( 'Fauteuil Dentaire Électrique', 'fauteuil.png', 'equipement', 'en_stock', 'Fauteuil hydraulique électrique avec scialytique LED, crachoir céramique et unité intégrée.', array( 'Système hydraulique électrique', 'Scialytique LED réglable 3 intensités', 'Crachoir céramique + kit seringue 3 fonctions', 'Commandes au pied et sur le dossier', 'Dimensions : 190 × 85 × 70 cm', 'Alimentation : 220V — 50Hz' ) ),
		array( 'Unit Dentaire Complet', 'cabinet.png', 'equipement', 'sur_devis', 'Unit 5 instruments : turbine, contre-angle, détartreur piézo et seringue 3 fonctions.', array( 'Turbine haute vitesse + contre-angle', 'Détartreur piézoélectrique ultrasons', 'Seringue 3 fonctions', 'Bloc opératoire avec écran tactile', 'Compresseur silencieux inclus', 'Installation et mise en service incluses' ) ),
		array( 'Lampe LED Photopolymérisation', 'lampe.webp', 'equipement', 'en_stock', 'Lampe sans fil : 1 200 mW/cm², rechargeable, faisceau homogène et sans chaleur.', array( 'Intensité : 1 200 mW/cm²', 'Sans fil — batterie rechargeable', 'Timbre-minute intégré', 'Lumière homogène, sans chaleur', 'Longueur d' . '\'' . 'onde : 430 – 480 nm' ) ),
		array( 'Capteur Radiographique Numérique', 'radio.jpg', 'radiologie', 'sur_devis', 'Capteur intra-oral haute définition pour des radiographies instantanées à faible dose.', array( 'Technologie CMOS haute définition', 'Radiographie instantanée', 'Très faible dose de rayonnement', 'Compatible avec les principaux logiciels', 'Tailles 0, 1 et 2 disponibles', 'Câble USB + capteur inclus' ) ),
		array( 'Panoramique Dentaire', 'panoramique.webp', 'radiologie', 'sur_devis', 'Radio panoramique numérique 2D haute définition pour un diagnostic précis.', array( 'Capteur CCD — images 2D haute résolution', 'Logiciel d' . '\'' . 'imagerie inclus', 'Programmes panoramique, sinus et ATM', 'Faible dose — FOV ajustable', 'Installation et formation incluses' ) ),
		array( 'Instruments Chirurgicaux', 'instruments.jpg', 'chirurgie', 'en_stock', 'Davier, élévateurs, curettes : instrumentarium complet en acier inoxydable.', array( 'Acier inoxydable 18/8', 'Autoclavables jusqu' . '\'' . 'à 135 °C', 'Davier et élévateurs complets', 'Curettes et sondes parodontales', 'Écrin de rangement stérilisable' ) ),
		array( 'Implants & Biomatériaux', 'implant.jpg', 'chirurgie', 'sur_devis', 'Implants en titane, membranes et substituts osseux pour l' . '\'' . 'implantologie.', array( 'Implants titane grade 4', 'Connexion cone morse / hexagone interne', 'Membranes de régénération osseuse', 'Substituts osseux granulaires', 'Kit chirurgical disponible' ) ),
		array( 'Stérilisateur Autoclave', 'autoclave.jpg', 'hygiene', 'sur_devis', 'Autoclave de classe B : cycles rapides à 134 °C avec imprimante et validation.', array( 'Classe B — cycles B, N et S', 'Température : 134 °C', 'Volume : 18 – 23 L', 'Séchage haute performance', 'Imprimante et validation intégrées', 'Certifié CE' ) ),
		array( 'Désinfectants & Détergents', 'hygiene.webp', 'hygiene', 'en_stock', 'Désinfection des surfaces, instruments et empreintes conformes aux normes.', array( 'Nettoyant-désinfectant surfaces', 'Désinfectant instruments', 'Désinfectant empreintes', 'Bactéricide, virucide, fongicide', 'Prêt à l' . '\'' . 'emploi ou concentré' ) ),
		array( 'Anesthésiques & Seringues', 'seringue.jpg', 'consommable', 'en_stock', 'Carpules, seringues carpule et aiguilles stériles de gammes hospitalières.', array( 'Carpules 1,8 ml — articaïne / lidocaïne', 'Seringues carpule en métal inoxydable', 'Aiguilles 30G stériles', 'Gamme hospitalière certifiée', 'Conditionnement par 50' ) ),
		array( 'Matériaux de Reconstitution', 'matriaux.jpg', 'consommable', 'sur_devis', 'Composites, verres ionomères et ciments pour toutes les restaurations.', array( 'Composites micro-hybrides et nanohybrides', 'Ciments verre ionomère', 'Systèmes adhésifs complets', 'Teintes A1 – D4', 'Cartouches de 4 g', 'Conservation : 2 – 28 °C' ) ),
		array( 'Empreintes & Matériaux', 'alginate.jpg', 'consommable', 'en_stock', 'Alginates, silicones et plâtres haute précision pour toutes les techniques.', array( 'Alginates à prise rapide', 'Silicones addition putty + light', 'Plâtres type III et IV', 'Cueillères et godets de mélange', 'Compatibles désinfectants empreintes' ) ),
	);

	$img_root = get_template_directory() . '/assets/img/';
	global $wpdb;
	foreach ( $products as $i => $p ) {
		$slug     = sanitize_title( $p[0] );
		$existing = get_page_by_path( $slug, OBJECT, 'produit' );
		if ( ! $existing ) {
			$existing = get_page_by_title( $p[0], OBJECT, 'produit' );
		}
		if ( $existing ) {
			continue;
		}
		$pid = wp_insert_post( array(
			'post_title'   => $p[0],
			'post_name'    => $slug,
			'post_content' => $p[4],
			'post_excerpt' => $p[4],
			'post_status'  => 'publish',
			'post_type'    => 'produit',
			'menu_order'   => $i,
		) );
		/* wp_insert_post en contexte non-authentifié passe par kses : on
		   rétablit le titre exact (les « & » sont stockés en « &amp; »). */
		$wpdb->update(
			$wpdb->posts,
			array( 'post_title' => $p[0] ),
			array( 'ID' => $pid ),
			array( '%s' ),
			array( '%d' )
		);
		clean_post_cache( $pid );
		$t = isset( $term_ids[ $p[2] ] ) ? $term_ids[ $p[2] ] : 0;
		if ( $t ) { wp_set_object_terms( $pid, array( $t ), 'categorie_produit' ); }
		update_post_meta( $pid, '_do_dispo', $p[3] );
		update_post_meta( $pid, '_do_specs', implode( "\n", $p[5] ) );
		if ( file_exists( $img_root . $p[1] ) ) {
			$file = $img_root . $p[1];
			$id   = wp_insert_attachment( array(
				'post_mime_type' => wp_check_filetype( $p[1] )['type'],
				'post_title'     => $p[0],
				'post_status'    => 'inherit',
			), $file, $pid );
			if ( ! is_wp_error( $id ) ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
				wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
				set_post_thumbnail( $pid, $id );
			}
		}
	}

	/* Pré-remplissage des réglages du Personnalisateur avec les valeurs de
	   référence (uniquement si jamais édités) : le site est complet dès
	   l'installation, et l'utilisateur modifie ensuite tout depuis l'apparence. */
	$defaults = array(
		'do_logo_text'   => 'Dental Ouest',
		'do_logo_small'  => 'Équipement dentaire',
		'do_hero_badge'  => 'Depuis 1982 · Oran, Algérie',
		'do_hero_title'  => 'L' . '\'' . 'excellence dentaire au service de votre <span class="grad">cabinet</span>',
		'do_hero_sub'    => 'Importation, distribution et installation d' . '\'' . 'équipements et de consommables dentaires de qualité internationale. Votre partenaire de confiance pour équiper votre cabinet partout en Algérie — du conseil à la maintenance.',
		'do_hero_cta1'   => 'Demander un devis',
		'do_hero_cta2'   => 'Découvrir nos produits',
		'do_marquee'     => "Qualité internationale certifiée ISO\nLivraison dans les 58 wilayas\nDepuis 1982 en Algérie\nTechniciens installateurs certifiés\nSAV réactif 6 jours sur 7\nPlus de 5 000 clients satisfaits",
		'do_stat1_n'     => '40',   'do_stat1_label' => 'Années d' . '\'' . 'expérience',
		'do_stat2_n'     => '3',    'do_stat2_label' => 'Agences en Algérie',
		'do_stat3_n'     => '5000', 'do_stat3_label' => 'Clients satisfaits',
		'do_stat4_n'     => '500',  'do_stat4_label' => 'Produits disponibles',
		'do_serv1_ic'    => '🦷', 'do_serv1_t' => 'Équipements de cabinet',   'do_serv1_d' => 'Fauteuils, units dentaires, lampes, compresseurs : tout l' . '\'' . 'équipement essentiel pour votre cabinet.',
		'do_serv2_ic'    => '🧰', 'do_serv2_t' => 'Installation clé en main', 'do_serv2_d' => 'Nos équipes installent, raccordent et configurent votre cabinet intégralement.',
		'do_serv3_ic'    => '💊', 'do_serv3_t' => 'Consommables & matériaux', 'do_serv3_d' => 'Composites, anesthésiques, empreintes : les grandes marques toujours en stock.',
		'do_serv4_ic'    => '📡', 'do_serv4_t' => 'Radiologie numérique',    'do_serv4_d' => 'Capteurs intra-oraux, panoramiques et imagerie haute résolution.',
		'do_serv5_ic'    => '🧼', 'do_serv5_t' => 'Hygiène & stérilisation', 'do_serv5_d' => 'Autoclaves certifiés, désinfectants et solutions conformes aux normes internationales.',
		'do_serv6_ic'    => '🔧', 'do_serv6_t' => 'SAV & maintenance',       'do_serv6_d' => 'Techniciens spécialisés à votre écoute pour un entretien rapide et fiable.',
		'do_why_badge_b' => 'Certifié ISO 9001',
		'do_why_badge_s' => 'Plus de 40 ans d' . '\'' . 'expérience',
		'do_why1_ic' => '🏛️', 'do_why1_t' => 'Une histoire familiale', 'do_why1_d' => 'Fondée par la famille HAKKA à Oran : trois générations au service des praticiens algériens depuis 1982.',
		'do_why2_ic' => '⚡',   'do_why2_t' => 'Installation clé en main', 'do_why2_d' => 'Livraison, installation, réseaux d' . '\'' . 'air, d' . '\'' . 'eau et d' . '\'' . 'électricité, mise en service : tout est pris en charge.',
		'do_why3_ic' => '🛡️',  'do_why3_t' => 'Garantie & suivi', 'do_why3_d' => 'Garantie constructeur, contrats de maintenance et techniciens disponibles 6 jours sur 7.',
		'do_why4_ic' => '💎',   'do_why4_t' => 'Devis transparents', 'do_why4_d' => 'Devis détaillés, prix justes, sans frais cachés, pour toutes les wilayas.',
		'do_quote_t'  => '« Notre engagement va au-delà de la vente : chaque fauteuil installé est une confiance qu' . '\'' . 'il faut mériter chaque jour. »',
		'do_quote_a'  => 'Ali HAKKA',
		'do_quote_r'  => 'Gérant · Dental Ouest',
		'do_cta_t'    => 'Prêt à équiper votre cabinet ?',
		'do_cta_s'    => 'Devis détaillé, sans engagement, sous 24 h. Nos équipes vous accompagnent de A à Z.',
		'do_cta_b'    => 'Demander un devis gratuit',
		'do_prod_t'   => 'Des produits <span class="grad">d' . '\'' . 'exception</span>',
		'do_prod_sub' => 'Équipements et matériaux des grandes marques internationales, livrés partout en Algérie.',
		'do_prod_all' => 'Tous',
		'do_stock'    => 'En stock',
		'do_devis'    => 'Sur devis',
		'do_quote_btn' => 'Demander un devis',
		'do_specs_label' => 'Spécifications techniques',
		'do_phone'    => '+213 550 572 388',
		'do_wa_num'   => '+213550572388',
		'do_wa_msg'   => 'Bonjour Dental Ouest, je souhaite avoir des informations.',
		'do_mail'     => 'commercial@dentalouest.net',
		'do_addr'     => '41, Rue Cherif Ali Cherfi — Oran, Algérie',
		'do_hours'    => 'Dimanche — Jeudi · 08h00 — 17h00',
		'do_map_url'  => 'https://www.google.com/maps?q=Oran%2C+Alg%C3%A9rie&output=embed',
		'do_ab_kicker' => 'Notre histoire',
		'do_ab_title' => 'Trois générations <span class="grad">au service</span> de la dentisterie',
		'do_ab_sub'   => 'De l' . '\'' . 'atelier de prothèse à l' . '\'' . 'intégration clé en main : un héritage familial tourné vers l' . '\'' . 'excellence.',
		'do_tl1_yr' => '1982',        'do_tl1_t' => 'Les débuts',       'do_tl1_d' => 'M. HAKKA, prothésiste reconnu, commence à fournir ses confrères en produits dentaires depuis son laboratoire à Oran.',
		'do_tl2_yr' => '1993',        'do_tl2_t' => 'La création',       'do_tl2_d' => 'Ali HAKKA, fils du fondateur, crée les ETS HAKKA et professionnalise la distribution dans l' . '\'' . 'Ouest algérien.',
		'do_tl3_yr' => '2002',        'do_tl3_t' => 'La marque Dental Ouest', 'do_tl3_d' => 'Lancement officiel de la marque Dental Ouest : équipements, consommables et installation complète de cabinets.',
		'do_tl4_yr' => 'Aujourd' . '\'' . 'hui', 'do_tl4_t' => 'Le Nº1 de l' . '\'' . 'Ouest', 'do_tl4_d' => 'Plus de 40 ans d' . '\'' . 'expérience, 3 agences et plus de 5 000 professionnels équipés à travers toute l' . '\'' . 'Algérie.',
		'do_ab_values_t' => 'Nos valeurs',
		'do_val1_ic' => '🤝', 'do_val1_t' => 'Confiance',   'do_val1_d' => 'Des relations de long terme fondées sur la transparence et l' . '\'' . 'écoute.',
		'do_val2_ic' => '🏆', 'do_val2_t' => 'Excellence',  'do_val2_d' => 'Une exigence de qualité à chaque étape du processus.',
		'do_val3_ic' => '⚙️', 'do_val3_t' => 'Fiabilité',  'do_val3_d' => 'Un suivi complet : installation, garantie et maintenance.',
		'do_val4_ic' => '🇩🇿', 'do_val4_t' => 'Engagement', 'do_val4_d' => 'Au service de la dentisterie algérienne depuis 1982.',
		'do_ab_iso_t' => 'Notre engagement qualité',
		'do_ab_iso_d' => 'Nos processus sont organisés selon les principes des systèmes de management certifiés : équipements contrôlés, traçabilité complète et personnel formé en continu.',
		'do_ab_iso_b' => 'Certifié ISO',
		'do_sav_kicker' => 'Service Après-Vente',
		'do_sav_title'  => 'Votre équipement <span class="grad">mérite de l' . '\'' . 'attention</span>',
		'do_sav_sub'    => 'Un SAV dédié, des techniciens spécialisés : votre cabinet reste opérationnel en toutes circonstances.',
		'do_step1_t' => 'Contactez-nous', 'do_step1_d' => 'Par téléphone, e-mail ou le formulaire ci-dessous — réponse sous 24 h.',
		'do_step2_t' => 'Diagnostic',     'do_step2_d' => 'Notre technicien analyse le problème à distance ou sur site.',
		'do_step3_t' => 'Intervention',   'do_step3_d' => 'Réparation, pièce de rechange ou prise en charge garantie.',
		'do_step4_t' => 'Suivi',          'do_step4_d' => 'Contrôle qualité et vérification du bon fonctionnement après intervention.',
		'do_tech_head_t'    => 'Des experts sur intervention',
		'do_tech_head_d'    => 'Un SAV dédié, des techniciens spécialisés : votre cabinet reste opérationnel en toutes circonstances.',
		'do_tech_form_label' => 'Choisir le technicien',
		'do_faq1_q' => 'Quelles sont vos garanties ?',
		'do_faq1_a' => 'Tous nos équipements bénéficient de la garantie constructeur. Nous proposons également des contrats de maintenance annuels.',
		'do_faq2_q' => 'Intervenez-vous dans tout le pays ?',
		'do_faq2_a' => 'Oui, nos techniciens se déplacent dans les 58 wilayas depuis nos agences d' . '\'' . 'Oran, d' . '\'' . 'Alger et de Constantine.',
		'do_faq3_q' => 'Que faire en cas de panne ?',
		'do_faq3_a' => 'Contactez le SAV : un technicien vous répond, établit le diagnostic et intervient sous 48 h après accord.',
		'do_faq4_q' => 'Vendez-vous des pièces détachées ?',
		'do_faq4_a' => 'Oui, nous maintenons un stock de pièces d' . '\'' . 'origine pour les principaux fabricants.',
		'do_ft_desc'   => 'Depuis 1982, Dental Ouest équipe les professionnels dentaires d' . '\'' . 'Algérie : fourniture, installation et service après-vente de haut niveau, dans les 58 wilayas.',
		'do_ft_rights' => 'Tous droits réservés.',
		'do_ft_made'   => 'DENTAL OUEST — Oran · Alger · Constantine',
	);
	foreach ( $defaults as $k => $v ) {
		if ( get_theme_mod( $k, '##DO_EMPTY##' ) === '##DO_EMPTY##' ) {
			set_theme_mod( $k, $v );
		}
	}

	update_option( '_do_demo_installed', 1 );
}

/* ── Techniciens de démonstration (menu « Techniciens SAV ») ──
   Créés une seule fois : nom, spécialité, téléphone et e-mail de chaque
   technicien se modifient ensuite librement dans l'administration WordPress
   (menu « Techniciens SAV » → ajouter / modifier / supprimer / photo). */
function dental_ouest_demo_techs() {
	if ( get_option( '_do_demo_tech_installed' ) ) { return; }

	$techs = array(
		array( 'A. Mansouri',       'Électronique & modules',         '+213 555 00 01', 'tech.electronique@dentalouest.net' ),
		array( 'S. Benali',         'Hydraulique & fluides',          '+213 555 00 02', 'tech.hydraulique@dentalouest.net' ),
		array( 'R. Kaddour',        'Radiologie & imagerie',          '+213 555 00 03', 'tech.radiologie@dentalouest.net' ),
		array( 'M. Haddad',         'Installation & mise en service', '+213 555 00 04', 'tech.installation@dentalouest.net' ),
	);

	foreach ( $techs as $i => $t ) {
		$existing = get_page_by_title( $t[0], OBJECT, 'technicien' );
		if ( $existing ) { continue; }
		$pid = wp_insert_post( array(
			'post_title'   => $t[0],
			'post_content' => $t[1],
			'post_excerpt' => $t[1],
			'post_status'  => 'publish',
			'post_type'    => 'technicien',
			'menu_order'   => $i,
		) );
		if ( is_wp_error( $pid ) || ! $pid ) { continue; }
		update_post_meta( $pid, '_do_tech_tel', $t[2] );
		update_post_meta( $pid, '_do_tech_mail', $t[3] );
	}

	update_option( '_do_demo_tech_installed', 1 );
}

/* Installation « one-click » : pages + produits de démonstration créés
   automatiquement à l'activation du thème (exécuté une seule fois). */
add_action( 'after_switch_theme', 'dental_ouest_demo_install' );
add_action( 'after_switch_theme', 'dental_ouest_demo_techs' );
/* Filet de sécurité : si le thème est mis à jour (re-téléversé) alors qu'il
   est déjà actif, on crée quand même les techniciens de démonstration. */
add_action( 'after_setup_theme', 'dental_ouest_demo_techs' );