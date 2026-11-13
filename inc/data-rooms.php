<?php
/**
 * Data Rooms page fields and the copy from the WIP Data Rooms frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_data_rooms_page', 25 );
add_action( 'acf/init', 'slc_seed_data_rooms_images', 40 );

/**
 * The Data Rooms page, under Products.
 *
 * @return WP_Post|null
 */
function slc_data_rooms_page_post() {
	$page = get_page_by_path( 'products/data-rooms' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'data-rooms' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is the Data Rooms page.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_data_rooms_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-data-rooms.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'data-rooms' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Data Rooms template so its fields appear in the editor.
 */
function slc_prepare_data_rooms_page() {
	$page = slc_data_rooms_page_post();
	if ( ! $page instanceof WP_Post || 'page-data-rooms.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-data-rooms.php' );
}

/**
 * Data Rooms fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_data_rooms_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'dataroom',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Data room hero' );
	$add( 'image', 'dataroom_hero_image', 'Photograph', '', 'basic', 'Cable photograph behind the headline.' );
	$add( 'text', 'dataroom_hero_alt', 'Photograph description', 'Bundles of turquoise network cables.' );
	$add( 'text', 'dataroom_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'dataroom_breadcrumb_parent', 'Breadcrumb parent', 'Products' );
	$add( 'text', 'dataroom_breadcrumb_current', 'Breadcrumb current', 'Data Rooms' );
	$add( 'wysiwyg', 'dataroom_heading', 'Heading', 'Data Rooms with field experience behind the specification', 'inline' );
	$add( 'wysiwyg', 'dataroom_standfirst', 'Standfirst', 'Streamline spent years installing, upgrading and decommissioning communications facilities before clients asked us to manufacture them. We knew the equipment, connections and site services awaiting those rooms because our teams had dealt with them firsthand.

That experience informs the Communication Equipment Rooms (CERs) and Modular Data Centres (MDCs) we design and manufacture at Embleton, Western Australia. On combined projects, our civil, electrical and communications teams also undertake the supporting infrastructure, planning the factory fit-out and site connections together.' );
	$add( 'text', 'dataroom_jump_label', 'Jump panel label', 'On this page' );
	foreach ( slc_data_rooms_jump_defaults() as $index => $jump ) {
		$add( 'text', 'dataroom_jump_' . ( $index + 1 ), 'Jump link ' . ( $index + 1 ), $jump['label'] );
	}
	$add( 'text', 'dataroom_hero_button', 'Hero button', 'Discuss your Data Room project' );

	$add( 'tab', '', 'Data room products' );
	foreach ( slc_data_rooms_product_defaults() as $index => $product ) {
		$n = $index + 1;
		$add( 'image', "dataroom_product_{$n}_image", $product['title'] . ' photograph' );
		$add( 'text', "dataroom_product_{$n}_alt", $product['title'] . ' photograph description', $product['alt'] );
		$add( 'wysiwyg', "dataroom_product_{$n}_title", $product['title'] . ' title', $product['title'], 'inline' );
		$add( 'wysiwyg', "dataroom_product_{$n}_text", $product['title'] . ' text', $product['text'] );
		$add( 'text', "dataroom_product_{$n}_link", $product['title'] . ' link label', $product['link'] );
		$add( 'text', "dataroom_product_{$n}_url", $product['title'] . ' link', $product['url'], 'basic', 'Path or full URL.' );
	}

	$add( 'tab', '', 'Data room built' );
	$add( 'image', 'dataroom_built_image', 'Photograph', '', 'basic', 'Factory photograph behind the statement.' );
	$add( 'text', 'dataroom_built_alt', 'Photograph description', 'A welder working inside a modular room.' );
	$add( 'wysiwyg', 'dataroom_built_heading', 'Heading', 'Built here.<br>Delivered with confidence.', 'inline' );
	$add( 'wysiwyg', 'dataroom_built_body', 'Body', 'At our Embleton factory in Western Australia, you can inspect your Data Room and witness Factory Acceptance Testing. The people who assembled it are on hand to investigate and resolve issues before dispatch. Our site crews can prepare the foundations and connections while the factory team completes your room.' );
	$add( 'text', 'dataroom_built_link', 'Link label', 'Explore our modular manufacturing capability' );
	$add( 'text', 'dataroom_built_url', 'Link', '/capabilities/modular-infrastructure/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Data room project' );
	$add( 'wysiwyg', 'dataroom_projects_heading', 'Heading', 'Related projects', 'inline' );
	$add( 'wysiwyg', 'dataroom_projects_intro', 'Intro', 'Streamline’s Zero Emission offices, crib rooms and ablution blocks supported crews installing a major wireless network at a Pilbara mine site. Powered by integrated solar and battery systems, they provided the project team with offices and amenities without separate diesel generators.' );
	$add( 'image', 'dataroom_project_image', 'Photograph' );
	$add( 'text', 'dataroom_project_alt', 'Photograph description', 'Zero Emission Rooms lined along a red-dirt track at sunset.' );
	$add( 'text', 'dataroom_project_title', 'Title', 'Rio Tinto rail operations' );
	$add( 'wysiwyg', 'dataroom_project_summary', 'Summary', 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.' );
	$add( 'text', 'dataroom_project_chip_1', 'Chip 1', 'Facilities' );
	$add( 'text', 'dataroom_project_chip_2', 'Chip 2', 'Power' );
	$add( 'text', 'dataroom_project_sector', 'Sector', 'Mining and resources' );
	$add( 'text', 'dataroom_project_client', 'Client', 'Mining operator' );
	$add( 'text', 'dataroom_project_location', 'Location', 'Pilbara, WA' );
	$add( 'text', 'dataroom_projects_bar', 'Section button', 'Explore projects' );
	$add( 'text', 'dataroom_projects_url', 'Section button link', '/projects/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Data room enquiry' );
	$add( 'wysiwyg', 'dataroom_enquiry_heading', 'Heading', 'Discuss your<br>Data Room project', 'inline' );
	$add( 'wysiwyg', 'dataroom_enquiry_body', 'Body', 'Tell us what equipment needs housing, the intended location and which services are available. We’ll discuss the room’s configuration and the site connections you need.' );
	$add( 'text', 'dataroom_enquiry_label', 'Button', 'Discuss your project' );

	return $items;
}

/**
 * Hero jump links.
 *
 * @return array<int, array<string, string>>
 */
function slc_data_rooms_jump_defaults() {
	return array(
		array(
			'label' => __( 'Communication Equipment Rooms', 'streamlineconnect' ),
			'url'   => '#communication_equipment_rooms',
		),
		array(
			'label' => __( 'Modular Data Centres', 'streamlineconnect' ),
			'url'   => '#modular_data_centres',
		),
		array(
			'label' => __( 'How we deliver', 'streamlineconnect' ),
			'url'   => '#how_we_deliver',
		),
		array(
			'label' => __( 'Why Streamline', 'streamlineconnect' ),
			'url'   => '#why_streamline',
		),
	);
}

/**
 * Jump links with saved labels.
 *
 * @return array<int, array<string, string>>
 */
function slc_data_rooms_jumps() {
	$rows = slc_data_rooms_jump_defaults();
	foreach ( $rows as $index => &$row ) {
		$row['label'] = slc_plain( 'dataroom_jump_' . ( $index + 1 ), $row['label'] );
	}
	unset( $row );

	return $rows;
}

/**
 * The two product rows.
 *
 * @return array<int, array<string, string>>
 */
function slc_data_rooms_product_defaults() {
	return array(
		array(
			'title'  => __( 'Communication Equipment Rooms', 'streamlineconnect' ),
			'anchor' => 'communication_equipment_rooms',
			'text'   => __( 'Communication Equipment Rooms house network equipment for fibre, wireless and private LTE systems, including those used at mine sites and other operational facilities.

We plan cable entries and equipment positions around the connections outside your CER, leaving access for your crews to inspect and service the equipment.

Streamline also delivers foundations, conduits, fibre lead-ins and network installation, giving you one team for the room and its connections through commissioning.', 'streamlineconnect' ),
			'link'   => __( 'Explore Communication Equipment Rooms', 'streamlineconnect' ),
			'url'    => '#communication_equipment_rooms',
			'file'   => 'images/data-rooms/cer.png',
			'alt'    => __( 'A green communication equipment room on a prepared pad, with a crane beside it.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Modular Data Centres', 'streamlineconnect' ),
			'anchor' => 'modular_data_centres',
			'text'   => __( 'Our Modular Data Centres house IT equipment in factory-assembled facilities, with rack layout, power distribution, backup and cooling planned together.

We fit structured cabling around your equipment layout, while fire protection, security and environmental monitoring are specified for the facility’s operating requirements.', 'streamlineconnect' ),
			'link'   => __( 'Explore Modular Data Centres', 'streamlineconnect' ),
			'url'    => '#modular_data_centres',
			'file'   => 'images/data-rooms/mdc.png',
			'alt'    => __( 'A white modular data centre with access stairs and safety signage.', 'streamlineconnect' ),
		),
	);
}

/**
 * Product rows with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_data_rooms_products() {
	$rows = slc_data_rooms_product_defaults();
	foreach ( $rows as $index => &$row ) {
		$n            = $index + 1;
		$row['image'] = "dataroom_product_{$n}_image";
		$row['alt']   = slc_plain( "dataroom_product_{$n}_alt", $row['alt'] );
		$row['title'] = slc_inline( "dataroom_product_{$n}_title", $row['title'] );
		$row['text']  = slc_rich( "dataroom_product_{$n}_text", $row['text'] );
		$row['link']  = slc_plain( "dataroom_product_{$n}_link", $row['link'] );
		$row['url']   = slc_href( "dataroom_product_{$n}_url", $row['url'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Data Rooms image fields when those fields are empty.
 */
function slc_seed_data_rooms_images() {
	if ( '1' === get_option( 'slc_data_rooms_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_data_rooms_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'dataroom_hero_image'      => array( 'images/data-rooms/hero.jpg', 'Data Rooms hero, network cables' ),
		'dataroom_product_1_image' => array( 'images/data-rooms/cer.png', 'Data Rooms, communication equipment room' ),
		'dataroom_product_2_image' => array( 'images/data-rooms/mdc.png', 'Data Rooms, modular data centre' ),
		'dataroom_built_image'     => array( 'images/data-rooms/built.png', 'Data Rooms, welder in a modular room' ),
		'dataroom_project_image'   => array( 'images/facilities/project.jpg', 'Data Rooms, Pilbara Zero Emission Rooms' ),
	);

	$ready = true;
	foreach ( $assets as $field => $asset ) {
		$current = get_field( $field, $page->ID );
		if ( function_exists( 'slc_attachment_exists' ) && slc_attachment_exists( slc_attachment_id( $current ) ) ) {
			continue;
		}

		$id = slc_import_theme_asset( $asset[0], $asset[1] );
		if ( ! $id || ! update_field( $field, $id, $page->ID ) ) {
			$ready = false;
		}
	}

	if ( $ready ) {
		update_option( 'slc_data_rooms_images_seeded', '1', false );
	}
}
