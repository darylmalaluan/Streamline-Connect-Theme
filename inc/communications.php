<?php
/**
 * Communications and Infrastructure page fields and the WIP frame copy.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_communications_page', 25 );
add_action( 'acf/init', 'slc_seed_communications_images', 40 );

/**
 * The Communications page, under Capabilities.
 *
 * @return WP_Post|null
 */
function slc_communications_page_post() {
	$page = get_page_by_path( 'capabilities/communications-infrastructure' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'communications-infrastructure' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is Communications and Infrastructure.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_communications_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-communications.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'communications-infrastructure' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Communications template so its fields appear in the editor.
 */
function slc_prepare_communications_page() {
	$page = slc_communications_page_post();
	if ( ! $page instanceof WP_Post || 'page-communications.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-communications.php' );
}

/**
 * Communications fields, in page order. How we deliver and Why Streamline stay the shared home sections.
 *
 * @return array<int, array<string, string>>
 */
function slc_communications_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'communications',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Comms hero' );
	$add( 'image', 'comms_hero_image', 'Photograph', '', 'basic', 'Site photograph behind the headline.' );
	$add( 'text', 'comms_hero_alt', 'Photograph description', 'Communications tower and crane on an industrial site.' );
	$add( 'text', 'comms_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'comms_breadcrumb_parent', 'Breadcrumb parent', 'Capabilities' );
	$add( 'text', 'comms_breadcrumb_current', 'Breadcrumb current', 'Communications' );
	$add( 'wysiwyg', 'comms_heading', 'Heading', 'One team for the<br>site and the network', 'inline' );
	$add( 'wysiwyg', 'comms_standfirst', 'Standfirst', 'Streamline has invested in the crews, specialist plant and technicians that put communications networks into service. We construct fibre routes and wireless sites, install equipment, and test and commission.' );
	$add( 'text', 'comms_jump_label', 'Jump panel label', 'On this page' );
	foreach ( slc_communications_jump_defaults() as $index => $jump ) {
		$add( 'text', 'comms_jump_' . ( $index + 1 ), 'Jump link ' . ( $index + 1 ), $jump['label'] );
	}

	$add( 'tab', '', 'Comms services' );
	$add( 'wysiwyg', 'comms_services_heading', 'Heading', 'Communications<br>infrastructure solutions', 'inline' );
	$add( 'wysiwyg', 'comms_services_intro', 'Intro', 'Across mine sites, rail corridors, utility networks and industrial facilities, dependable communications support operational continuity, worker safety and remote operations. Your groundworks are planned with the technicians who will install and commission the network, so cable routes, foundations and site connections are prepared for the equipment arriving on site.' );
	foreach ( slc_communications_service_defaults() as $index => $service ) {
		$n = $index + 1;
		$add( 'image', "comms_service_{$n}_image", $service['title'] . ' photograph' );
		$add( 'text', "comms_service_{$n}_alt", $service['title'] . ' photograph description', $service['alt'] );
		$add( 'wysiwyg', "comms_service_{$n}_title", $service['title'] . ' title', $service['title'], 'inline' );
		$add( 'wysiwyg', "comms_service_{$n}_text", $service['title'] . ' text', $service['text'] );
		$add( 'text', "comms_service_{$n}_link", $service['title'] . ' link label', $service['link'] );
	}
	$add( 'text', 'comms_services_bar', 'Section button', 'Discuss your project' );

	$add( 'tab', '', 'Comms remote' );
	$add( 'image', 'comms_remote_image', 'Photograph', '', 'basic', 'Excavator working rocky ground.' );
	$add( 'text', 'comms_remote_alt', 'Photograph description', 'Excavator with a rock breaker working on a remote site.' );
	$add( 'wysiwyg', 'comms_remote_heading', 'Heading', 'Built for remote<br>and operational<br>environments', 'inline' );
	$add( 'wysiwyg', 'comms_remote_body', 'Body', 'On mine sites and rail corridors, our crews account for difficult ground, restricted access and existing services when selecting plant and construction methods. Where site conditions require a change, clients deal directly with the people directing the work about its effect on access, equipment and programme.

When requirements change, clients can speak directly with experienced people who understand the site and can explain what needs to happen next.' );
	$add( 'text', 'comms_remote_link', 'Link label', 'Explore our capability' );
	$add( 'text', 'comms_remote_url', 'Link', '/capabilities/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Comms enquiry' );
	$add( 'wysiwyg', 'comms_enquiry_heading', 'Heading', 'Discuss your communications project', 'inline' );
	$add( 'wysiwyg', 'comms_enquiry_body', 'Body', 'Tell us about the network you’re planning, the site and the programme you’re working on. We’ll establish Streamline’s scope and the steps needed to get the work underway.' );
	$add( 'text', 'comms_enquiry_label', 'Button', 'Discuss your project' );

	return $items;
}

/**
 * Hero jump links, in the order drawn.
 *
 * @return array<int, array<string, string>>
 */
function slc_communications_jump_defaults() {
	return array(
		array(
			'label' => __( 'Fibre networks', 'streamlineconnect' ),
			'url'   => '#fibre_networks',
		),
		array(
			'label' => __( 'Wireless infrastructure', 'streamlineconnect' ),
			'url'   => '#wireless_infrastructure',
		),
		array(
			'label' => __( 'Critical communications', 'streamlineconnect' ),
			'url'   => '#critical_communications',
		),
		array(
			'label' => __( 'Communications facilities', 'streamlineconnect' ),
			'url'   => '#communications_facilities',
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
function slc_communications_jumps() {
	$rows = slc_communications_jump_defaults();
	foreach ( $rows as $index => &$row ) {
		$row['label'] = slc_plain( 'comms_jump_' . ( $index + 1 ), $row['label'] );
	}
	unset( $row );

	return $rows;
}

/**
 * The four service rows.
 *
 * @return array<int, array<string, string>>
 */
function slc_communications_service_defaults() {
	return array(
		array(
			'title'  => __( 'Fibre networks', 'streamlineconnect' ),
			'anchor' => 'fibre_networks',
			'text'   => __( 'Long-haul fibre installation has been central to Streamline’s business for years. Our cable ploughs, rock saws and directional drills give crews practical options as terrain and route conditions change. On remote routes, access to different work areas and the logistics of moving plant also influence the construction approach.

We install the fibre and provide OTDR and power meter testing through commissioning. Our work covers backbone routes, local access networks, expansions, upgrades and remediation, including networks serving mining, utility and industrial operations.', 'streamlineconnect' ),
			'link'   => __( 'Discuss your fibre network project', 'streamlineconnect' ),
			'file'   => 'images/communications/fibre.png',
			'alt'    => __( 'Tracked machine laying cable from a large reel on red earth.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Wireless infrastructure', 'streamlineconnect' ),
			'anchor' => 'wireless_infrastructure',
			'text'   => __( 'We deliver site preparation, foundations, access tracks, fibre lead-ins and AC power, along with rigging and technical installation.

Our technicians commission private LTE, microwave, radio and other wireless systems, and provide fault finding, optimisation and network upgrades for industrial and operational networks. On remote deployments, our civil and technical teams plan site access alongside foundations, fibre lead-ins and power connections, accounting for how technicians will reach equipment for inspection and servicing.', 'streamlineconnect' ),
			'link'   => __( 'Discuss your wireless project', 'streamlineconnect' ),
			'file'   => 'images/communications/wireless.png',
			'alt'    => __( 'Two people in high-visibility clothing working at a mast with antennas.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Critical communications', 'streamlineconnect' ),
			'anchor' => 'critical_communications',
			'text'   => __( 'An interruption can affect work across a mine, rail corridor or utility site, including contact with crews in remote areas.

Our teams have installed communications infrastructure on live mine sites and rail corridors, working around existing services and restricted access. We deliver mine and rail communications, public safety systems and operational network upgrades, with access planned for the technicians who will inspect and maintain the equipment after handover.', 'streamlineconnect' ),
			'link'   => __( 'Discuss your critical communications project', 'streamlineconnect' ),
			'file'   => 'images/communications/critical.png',
			'alt'    => __( 'A service vehicle on a mine site at sunrise, with a tower behind it.', 'streamlineconnect' ),
		),
		array(
			'title'  => __( 'Communications facilities', 'streamlineconnect' ),
			'anchor' => 'communications_facilities',
			'text'   => __( 'We also manufacture the rooms that house communications and network equipment. At Embleton, we fabricate and fit out Communication Equipment Rooms and Modular Data Centres, including their power, cooling, security and monitoring systems.

We also design and manufacture equipment shelters and remote communications facilities. On combined projects, our civil and communications teams deliver the supporting site works and network connections.', 'streamlineconnect' ),
			'link'   => __( 'Discuss your communications facility project', 'streamlineconnect' ),
			'file'   => 'images/communications/facilities.png',
			'alt'    => __( 'A green modular equipment room on a concrete pad.', 'streamlineconnect' ),
		),
	);
}

/**
 * Service rows with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_communications_services() {
	$rows = slc_communications_service_defaults();
	foreach ( $rows as $index => &$row ) {
		$n            = $index + 1;
		$row['image'] = "comms_service_{$n}_image";
		$row['alt']   = slc_plain( "comms_service_{$n}_alt", $row['alt'] );
		$row['title'] = slc_inline( "comms_service_{$n}_title", $row['title'] );
		$row['text']  = slc_rich( "comms_service_{$n}_text", $row['text'] );
		$row['link']  = slc_plain( "comms_service_{$n}_link", $row['link'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Communications image fields when those fields are empty.
 */
function slc_seed_communications_images() {
	if ( '1' === get_option( 'slc_communications_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_communications_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'comms_hero_image'        => array( 'images/communications/hero.jpg', 'Communications hero, tower and crane' ),
		'comms_service_1_image'   => array( 'images/communications/fibre.png', 'Communications, fibre installation' ),
		'comms_service_2_image'   => array( 'images/communications/wireless.png', 'Communications, wireless mast' ),
		'comms_service_3_image'   => array( 'images/communications/critical.png', 'Communications, mine site at sunrise' ),
		'comms_service_4_image'   => array( 'images/communications/facilities.png', 'Communications, equipment room' ),
		'comms_remote_image'      => array( 'images/communications/remote.jpg', 'Communications, excavator on remote ground' ),
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
		update_option( 'slc_communications_images_seeded', '1', false );
	}
}
