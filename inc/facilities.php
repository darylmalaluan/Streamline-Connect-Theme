<?php
/**
 * Facilities page fields and the copy from the WIP Facilities frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_facilities_page', 25 );
add_action( 'acf/init', 'slc_seed_facilities_images', 40 );

/**
 * The Facilities page, under Products.
 *
 * @return WP_Post|null
 */
function slc_facilities_page_post() {
	$page = get_page_by_path( 'products/facilities' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'facilities' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is the Facilities page.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_facilities_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-facilities.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'facilities' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Facilities template so its fields appear in the editor.
 */
function slc_prepare_facilities_page() {
	$page = slc_facilities_page_post();
	if ( ! $page instanceof WP_Post || 'page-facilities.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-facilities.php' );
}

/**
 * Facilities fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_facilities_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'facilities',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Facility hero' );
	$add( 'image', 'facility_hero_image', 'Photograph', '', 'basic', 'Zero Emission Rooms behind the headline.' );
	$add( 'text', 'facility_hero_alt', 'Photograph description', 'A row of white Zero Emission Rooms with air conditioners.' );
	$add( 'text', 'facility_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'facility_breadcrumb_parent', 'Breadcrumb parent', 'Products' );
	$add( 'text', 'facility_breadcrumb_current', 'Breadcrumb current', 'Facilities' );
	$add( 'wysiwyg', 'facility_heading', 'Heading', 'Modular offices and<br>amenities for remote sites', 'inline' );
	$add( 'wysiwyg', 'facility_standfirst', 'Standfirst', 'The first people to use Streamline’s Zero Emission Rooms were our own crews. We needed offices and amenities that could operate without permanent mains power or a separate diesel generator. So we developed our own.' );
	$add( 'text', 'facility_jump_label', 'Jump panel label', 'Explore facilities' );
	foreach ( slc_facilities_jump_defaults() as $index => $jump ) {
		$add( 'text', 'facility_jump_' . ( $index + 1 ), 'Jump link ' . ( $index + 1 ), $jump['label'] );
	}
	$add( 'text', 'facility_hero_button', 'Hero button', 'Discuss your facilities project' );

	$add( 'tab', '', 'Facility overview' );
	$add( 'wysiwyg', 'facility_overview', 'Overview', 'Those facilities now serve other project teams too. Our Zero Emission Rooms (ZER) incorporate solar generation, battery storage and intelligent power management into site offices, crib rooms, respite spaces and ablution facilities.

Without a separate diesel generator, crews have a quieter environment for work and breaks, while site teams avoid the associated refuelling and routine engine servicing. Standard ZER configurations are available for hire or purchase, with customised options for different requirements.' );
	$add( 'image', 'facility_logo', 'Zero Emission Rooms logo', '', 'basic', 'Shown beside the overview.' );
	$add( 'text', 'facility_logo_alt', 'Logo description', 'Zero Emission Rooms' );

	$add( 'tab', '', 'Facility cards' );
	$add( 'wysiwyg', 'facility_explore_heading', 'Heading', 'Explore our facilities', 'inline' );
	$add( 'wysiwyg', 'facility_explore_intro', 'Intro', 'Browse the full range by application, power type and size, including our Zero Emission Rooms. From a single site office to amenities for a larger compound, you can choose facilities according to their intended use, occupancy and available services. For sites with suitable mains power, Streamline also manufactures grid-connected facilities. Layouts and fittings are tailored to their intended purpose, with associated electrical installations available through our teams.' );
	foreach ( slc_facilities_card_defaults() as $index => $card ) {
		$n = $index + 1;
		$add( 'image', "facility_card_{$n}_image", $card['title'] . ' photograph' );
		$add( 'text', "facility_card_{$n}_alt", $card['title'] . ' photograph description', $card['alt'] );
		$add( 'wysiwyg', "facility_card_{$n}_title", $card['title'] . ' title', $card['title'], 'inline' );
		$add( 'wysiwyg', "facility_card_{$n}_text", $card['title'] . ' text', $card['text'] );
		$add( 'text', "facility_card_{$n}_link", $card['title'] . ' link label', $card['link'] );
		$add( 'text', "facility_card_{$n}_url", $card['title'] . ' link', $card['url'], 'basic', 'Path or full URL.' );
	}
	$add( 'text', 'facility_explore_bar', 'Section button', 'Discuss your project' );

	$add( 'tab', '', 'Facility project' );
	$add( 'wysiwyg', 'facility_projects_heading', 'Heading', 'Related projects', 'inline' );
	$add( 'wysiwyg', 'facility_projects_intro', 'Intro', 'Streamline’s Zero Emission offices, crib rooms and ablution blocks supported crews installing a major wireless network at a Pilbara mine site. Powered by integrated solar and battery systems, they provided the project team with offices and amenities without separate diesel generators.' );
	$add( 'image', 'facility_project_image', 'Photograph' );
	$add( 'text', 'facility_project_alt', 'Photograph description', 'Zero Emission Rooms lined along a red-dirt track at sunset.' );
	$add( 'text', 'facility_project_title', 'Title', 'Rio Tinto rail operations' );
	$add( 'wysiwyg', 'facility_project_summary', 'Summary', 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.' );
	$add( 'text', 'facility_project_chip_1', 'Chip 1', 'Facilities' );
	$add( 'text', 'facility_project_chip_2', 'Chip 2', 'Power' );
	$add( 'text', 'facility_project_sector', 'Sector', 'Mining and resources' );
	$add( 'text', 'facility_project_client', 'Client', 'Mining operator' );
	$add( 'text', 'facility_project_location', 'Location', 'Pilbara, WA' );
	$add( 'text', 'facility_projects_bar', 'Section button', 'Explore projects' );
	$add( 'text', 'facility_projects_url', 'Section button link', '/projects/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Facility built' );
	$add( 'image', 'facility_built_image', 'Photograph', '', 'basic', 'Factory photograph behind the statement.' );
	$add( 'text', 'facility_built_alt', 'Photograph description', 'Manufacturing bay for modular facilities.' );
	$add( 'wysiwyg', 'facility_built_heading', 'Heading', 'Built here.<br>Delivered with confidence.', 'inline' );
	$add( 'wysiwyg', 'facility_built_body', 'Body', 'We manufacture and fit out our facilities at Embleton, Western Australia. We incorporate the specified interiors and electrical systems before dispatch, with the remaining site requirements established for installation.' );
	$add( 'text', 'facility_built_link', 'Link label', 'Explore our modular infrastructure capability' );
	$add( 'text', 'facility_built_url', 'Link', '/capabilities/modular-infrastructure/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Facility enquiry' );
	$add( 'wysiwyg', 'facility_enquiry_heading', 'Heading', 'Discuss your<br>facilities project', 'inline' );
	$add( 'wysiwyg', 'facility_enquiry_body', 'Body', 'Tell us which facilities your team needs, how many people they’ll serve and where they’ll be used. We’ll discuss suitable configurations, power options and any supporting infrastructure required.' );
	$add( 'text', 'facility_enquiry_label', 'Button', 'Discuss your project' );

	return $items;
}

/**
 * Hero jump links.
 *
 * @return array<int, array<string, string>>
 */
function slc_facilities_jump_defaults() {
	return array(
		array(
			'label' => __( 'Explore our facilities', 'streamlineconnect' ),
			'url'   => '#explore_our_facilities',
		),
		array(
			'label' => __( 'Related projects', 'streamlineconnect' ),
			'url'   => '#related_projects',
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
function slc_facilities_jumps() {
	$rows = slc_facilities_jump_defaults();
	foreach ( $rows as $index => &$row ) {
		$row['label'] = slc_plain( 'facility_jump_' . ( $index + 1 ), $row['label'] );
	}
	unset( $row );

	return $rows;
}

/**
 * The four facility cards.
 *
 * @return array<int, array<string, string>>
 */
function slc_facilities_card_defaults() {
	return array(
		array(
			'title'  => __( 'Site offices', 'streamlineconnect' ),
			'anchor' => 'site_offices',
			'text'   => __( 'A dedicated space for supervisors, project administration, and team briefings, with layouts suited to the people and equipment that use it.', 'streamlineconnect' ),
			'link'   => __( 'Explore site offices', 'streamlineconnect' ),
			'url'    => '#site_offices',
			'file'   => 'images/facilities/offices.png',
			'alt'    => __( 'A modular site office with rows of desks and monitors.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Crib rooms', 'streamlineconnect' ),
			'anchor' => 'crib_rooms',
			'text'   => __( 'Space for meals and breaks, with layouts and fittings suited to the number of people using the room.', 'streamlineconnect' ),
			'link'   => __( 'Explore crib rooms', 'streamlineconnect' ),
			'url'    => '#crib_rooms',
			'file'   => 'images/facilities/crib.png',
			'alt'    => __( 'A crib room with tables and chairs.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Respite rooms', 'streamlineconnect' ),
			'anchor' => 'respite_rooms',
			'text'   => __( 'Comfortable spaces for rest and recovery away from outside activity, especially during long shifts at remote sites.', 'streamlineconnect' ),
			'link'   => __( 'Explore respite rooms', 'streamlineconnect' ),
			'url'    => '#respite_rooms',
			'file'   => 'images/facilities/respite.png',
			'alt'    => __( 'An open respite room with a pale floor.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Ablution facilities', 'streamlineconnect' ),
			'anchor' => 'ablution_facilities',
			'text'   => __( 'Toilets and wash facilities, with water supply, wastewater arrangements and servicing access considered alongside the room itself.', 'streamlineconnect' ),
			'link'   => __( 'Explore ablution facilities', 'streamlineconnect' ),
			'url'    => '#ablution_facilities',
			'file'   => 'images/facilities/ablution.png',
			'alt'    => __( 'The interior of an ablution block.', 'streamlineconnect' ),
		),
	);
}

/**
 * Facility cards with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_facilities_cards() {
	$rows = slc_facilities_card_defaults();
	foreach ( $rows as $index => &$row ) {
		$n            = $index + 1;
		$row['image'] = "facility_card_{$n}_image";
		$row['alt']   = slc_plain( "facility_card_{$n}_alt", $row['alt'] );
		$row['title'] = slc_inline( "facility_card_{$n}_title", $row['title'] );
		$row['text']  = slc_rich( "facility_card_{$n}_text", $row['text'] );
		$row['link']  = slc_plain( "facility_card_{$n}_link", $row['link'] );
		$row['url']   = slc_href( "facility_card_{$n}_url", $row['url'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Facilities image fields when those fields are empty.
 */
function slc_seed_facilities_images() {
	if ( '1' === get_option( 'slc_facilities_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_facilities_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'facility_hero_image'    => array( 'images/facilities/hero.jpg', 'Facilities hero, Zero Emission Rooms' ),
		'facility_logo'          => array( 'images/facilities/zer-logo.svg', 'Zero Emission Rooms logo' ),
		'facility_card_1_image'  => array( 'images/facilities/offices.png', 'Facilities, site office' ),
		'facility_card_2_image'  => array( 'images/facilities/crib.png', 'Facilities, crib room' ),
		'facility_card_3_image'  => array( 'images/facilities/respite.png', 'Facilities, respite room' ),
		'facility_card_4_image'  => array( 'images/facilities/ablution.png', 'Facilities, ablution block' ),
		'facility_project_image' => array( 'images/facilities/project.jpg', 'Facilities, Pilbara Zero Emission Rooms' ),
		'facility_built_image'   => array( 'images/facilities/built.jpg', 'Facilities, Embleton manufacturing' ),
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
		update_option( 'slc_facilities_images_seeded', '1', false );
	}
}
