<?php
/**
 * Modular Infrastructure page fields and the copy from the WIP frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_modular_page', 25 );
add_action( 'acf/init', 'slc_seed_modular_images', 40 );

/**
 * The Modular Infrastructure page, under Capabilities.
 *
 * @return WP_Post|null
 */
function slc_modular_page_post() {
	$page = get_page_by_path( 'capabilities/modular-infrastructure' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'modular-infrastructure' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is Modular Infrastructure.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_modular_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-modular.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'modular-infrastructure' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Modular Infrastructure template so its fields appear in the editor.
 */
function slc_prepare_modular_page() {
	$page = slc_modular_page_post();
	if ( ! $page instanceof WP_Post || 'page-modular.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-modular.php' );
}

/**
 * Modular Infrastructure fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_modular_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'modular',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Modular hero' );
	$add( 'image', 'modular_hero_image', 'Photograph', '', 'basic', 'Modular rooms behind the headline.' );
	$add( 'text', 'modular_hero_alt', 'Photograph description', 'A row of white modular rooms with air conditioners.' );
	$add( 'text', 'modular_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'modular_breadcrumb_parent', 'Breadcrumb parent', 'Capabilities' );
	$add( 'text', 'modular_breadcrumb_current', 'Breadcrumb current', 'Modular Infrastructure' );
	$add( 'wysiwyg', 'modular_heading', 'Heading', 'Modular Data Rooms with the groundwork covered', 'inline' );
	$add( 'wysiwyg', 'modular_standfirst', 'Standfirst', 'Communication Equipment Rooms (CERs) and Modular Data Centres (MDCs) house critical communications and IT equipment. Their power, cooling and protection systems must meet the equipment’s requirements, while foundations and site connections need to be ready when the room arrives.

Streamline brings these requirements into the project from the start. We manufacture both room types at Embleton, Western Australia, with our own civil, electrical and communications crews available to undertake the supporting site infrastructure. The people preparing the destination understand what the room needs, and the manufacturing team knows what awaits it on site.' );
	$add( 'text', 'modular_jump_label', 'Jump panel label', 'On this page' );
	foreach ( slc_modular_jump_defaults() as $index => $jump ) {
		$add( 'text', 'modular_jump_' . ( $index + 1 ), 'Jump link ' . ( $index + 1 ), $jump['label'] );
	}
	$add( 'text', 'modular_hero_button', 'Hero button', 'Discuss your Data Room project' );

	$add( 'tab', '', 'Modular rows' );
	foreach ( slc_modular_row_defaults() as $index => $row ) {
		$n = $index + 1;
		$add( 'image', "modular_row_{$n}_image", $row['title'] . ' photograph' );
		$add( 'text', "modular_row_{$n}_alt", $row['title'] . ' photograph description', $row['alt'] );
		$add( 'wysiwyg', "modular_row_{$n}_title", $row['title'] . ' title', $row['title'], 'inline' );
		$add( 'wysiwyg', "modular_row_{$n}_text", $row['title'] . ' text', $row['text'] );
		$add( 'text', "modular_row_{$n}_link", $row['title'] . ' link label', $row['link'] );
		$add( 'text', "modular_row_{$n}_url", $row['title'] . ' link', $row['url'], 'basic', 'Path or full URL. Use a hash for a place on this page.' );
	}

	$add( 'tab', '', 'Modular projects' );
	$add( 'wysiwyg', 'modular_projects_heading', 'Heading', 'Modular projects', 'inline' );
	$add( 'wysiwyg', 'modular_projects_intro', 'Intro', 'See how Streamline applies its modular manufacturing and construction capability on projects, from factory fit-out to installation and site connections.' );
	$add( 'image', 'modular_project_image', 'Photograph' );
	$add( 'text', 'modular_project_alt', 'Photograph description', 'Zero Emission Rooms lined along a red-dirt track at sunset.' );
	$add( 'text', 'modular_project_title', 'Title', 'Rio Tinto rail operations' );
	$add( 'wysiwyg', 'modular_project_summary', 'Summary', 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.' );
	$add( 'text', 'modular_project_chip_1', 'Chip 1', 'Facilities' );
	$add( 'text', 'modular_project_chip_2', 'Chip 2', 'Power' );
	$add( 'text', 'modular_project_sector', 'Sector', 'Mining and resources' );
	$add( 'text', 'modular_project_client', 'Client', 'Mining operator' );
	$add( 'text', 'modular_project_location', 'Location', 'Pilbara, WA' );
	$add( 'text', 'modular_projects_bar', 'Section button', 'Explore our projects' );
	$add( 'text', 'modular_projects_url', 'Section button link', '/projects/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Modular enquiry' );
	$add( 'wysiwyg', 'modular_enquiry_heading', 'Heading', 'Discuss your<br>Data Room project', 'inline' );
	$add( 'wysiwyg', 'modular_enquiry_body', 'Body', 'Tell us what infrastructure you’re planning, where the room will operate and what services are already available. We’ll work through the manufacturing requirements and any site works needed for installation.' );
	$add( 'text', 'modular_enquiry_label', 'Button', 'Discuss your project' );

	return $items;
}

/**
 * Hero jump links.
 *
 * @return array<int, array<string, string>>
 */
function slc_modular_jump_defaults() {
	return array(
		array(
			'label' => __( 'Factory manufacturing', 'streamlineconnect' ),
			'url'   => '#factory_manufacturing',
		),
		array(
			'label' => __( 'Site delivery', 'streamlineconnect' ),
			'url'   => '#site_delivery',
		),
		array(
			'label' => __( 'Explore our Data Rooms', 'streamlineconnect' ),
			'url'   => '#explore_our_data_rooms',
		),
		array(
			'label' => __( 'Modular projects', 'streamlineconnect' ),
			'url'   => '#modular_projects',
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
function slc_modular_jumps() {
	$rows = slc_modular_jump_defaults();
	foreach ( $rows as $index => &$row ) {
		$row['label'] = slc_plain( 'modular_jump_' . ( $index + 1 ), $row['label'] );
	}
	unset( $row );

	return $rows;
}

/**
 * The three service rows.
 *
 * @return array<int, array<string, string>>
 */
function slc_modular_row_defaults() {
	return array(
		array(
			'title'  => __( 'More completed before dispatch', 'streamlineconnect' ),
			'anchor' => 'factory_manufacturing',
			'text'   => __( 'Our container-based Communication Equipment Rooms and Modular Data Centres are fabricated and fitted out at Embleton, with electrical systems and specified equipment installed before delivery.

Factory inspections and Factory Acceptance Testing allow the specified systems to be checked while the room is still at the manufacturing facility. Any problems identified can be investigated by the people responsible for its assembly, before the equipment makes the journey to site. For remote projects, completing this work at Embleton reduces the specialist installation and assembly tasks remaining at the destination.', 'streamlineconnect' ),
			'link'   => __( 'Discuss your Data Room requirements', 'streamlineconnect' ),
			'url'    => '/contact/',
			'file'   => 'images/data-rooms/built.png',
			'alt'    => __( 'A welder working inside a modular room.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'One team for the room and the site', 'streamlineconnect' ),
			'anchor' => 'site_delivery',
			'text'   => __( 'Clients can engage Streamline for the manufactured room or for a combined package of room and site works. On combined projects, our civil crews undertake ground preparation, foundations, trenching and conduit installation, while our electrical and communications teams provide the associated power and network connections.

Requirements such as foundation positions, cable routes and connection points can be resolved directly between the teams responsible for the work. Site construction can also progress while the room is being manufactured, with delivery and installation scheduled around the readiness of the destination.', 'streamlineconnect' ),
			'link'   => __( 'See how we deliver', 'streamlineconnect' ),
			'url'    => '#how_we_deliver',
			'file'   => 'images/modular/site.png',
			'alt'    => __( 'Construction plant on a site at dusk.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Explore our Data Rooms', 'streamlineconnect' ),
			'anchor' => 'explore_our_data_rooms',
			'text'   => __( 'Communication Equipment Rooms support telecommunications and network equipment, while Modular Data Centres accommodate IT infrastructure. Both are configured around the equipment they house, with power, cooling, protection and servicing access planned for the application.', 'streamlineconnect' ),
			'link'   => __( 'Explore Data Rooms', 'streamlineconnect' ),
			'url'    => '/products/data-rooms/',
			'file'   => 'images/data-rooms/cer.png',
			'alt'    => __( 'A green communication equipment room on a prepared pad.', 'streamlineconnect' ),
		),
	);
}

/**
 * Service rows with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_modular_rows() {
	$rows = slc_modular_row_defaults();
	foreach ( $rows as $index => &$row ) {
		$n            = $index + 1;
		$row['image'] = "modular_row_{$n}_image";
		$row['alt']   = slc_plain( "modular_row_{$n}_alt", $row['alt'] );
		$row['title'] = slc_inline( "modular_row_{$n}_title", $row['title'] );
		$row['text']  = slc_rich( "modular_row_{$n}_text", $row['text'] );
		$row['link']  = slc_plain( "modular_row_{$n}_link", $row['link'] );
		$fallback     = 0 === strpos( $row['url'], '#' ) ? $row['url'] : slc_url( $row['url'] );
		$row['url']   = slc_href( "modular_row_{$n}_url", $fallback );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Modular Infrastructure image fields when those fields are empty.
 */
function slc_seed_modular_images() {
	if ( '1' === get_option( 'slc_modular_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_modular_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'modular_hero_image'    => array( 'images/facilities/hero.jpg', 'Modular Infrastructure hero, modular rooms' ),
		'modular_row_1_image'   => array( 'images/data-rooms/built.png', 'Modular Infrastructure, fabrication bay' ),
		'modular_row_2_image'   => array( 'images/modular/site.png', 'Modular Infrastructure, site at dusk' ),
		'modular_row_3_image'   => array( 'images/data-rooms/cer.png', 'Modular Infrastructure, equipment room' ),
		'modular_project_image' => array( 'images/facilities/project.jpg', 'Modular Infrastructure, Pilbara project' ),
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
		update_option( 'slc_modular_images_seeded', '1', false );
	}
}
