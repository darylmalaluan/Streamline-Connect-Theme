<?php
/**
 * Capabilities page fields and the copy from the WIP Capabilities frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_capabilities_page', 25 );
add_action( 'acf/init', 'slc_seed_capabilities_images', 40 );

/**
 * Whether a page is the Capabilities page, not one of its children.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_capabilities_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-capabilities.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'capabilities' === get_post_field( 'post_name', $post_id ) && ! wp_get_post_parent_id( $post_id );
}

/**
 * Use the Capabilities template so its fields appear in the editor.
 */
function slc_prepare_capabilities_page() {
	$page = get_page_by_path( 'capabilities' );
	if ( ! $page instanceof WP_Post || 'page-capabilities.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-capabilities.php' );
}

/**
 * Capabilities fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_capabilities_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'capabilities',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Page hero' );
	$add( 'image', 'capabilities_hero_image', 'Photograph', '', 'basic', 'Construction plant behind the headline.' );
	$add( 'text', 'capabilities_hero_alt', 'Photograph description', 'Cable reel and bulldozer on a red-earth construction site.' );
	$add( 'text', 'capabilities_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'capabilities_breadcrumb_current', 'Breadcrumb current', 'Capabilities' );
	$add( 'wysiwyg', 'capabilities_page_heading', 'Heading', 'Capabilities', 'inline' );
	$add( 'wysiwyg', 'capabilities_standfirst', 'Standfirst', 'Streamline has invested in its own crews, specialist plant and manufacturing facility to deliver communications networks, power systems and modular infrastructure together. You can plan the network, power supply and site construction with one contractor and resolve changes directly with the people responsible for the work.' );
	$add( 'text', 'capabilities_jump_label', 'Jump panel label', 'Jump to a capability' );
	$add( 'text', 'capabilities_jump_1', 'Jump link 1', 'Communications infrastructure' );
	$add( 'text', 'capabilities_jump_2', 'Jump link 2', 'Modular infrastructure' );
	$add( 'text', 'capabilities_jump_3', 'Jump link 3', 'Power and energy' );

	$add( 'tab', '', 'Capability cards' );
	foreach ( slc_capabilities_card_defaults() as $index => $card ) {
		$n = $index + 1;
		$add( 'image', "capabilities_card_{$n}_image", $card['title'] . ' photograph' );
		$add( 'text', "capabilities_card_{$n}_alt", $card['title'] . ' photograph description', $card['alt'] );
		$add( 'wysiwyg', "capabilities_card_{$n}_title", $card['title'] . ' title', $card['heading'], 'inline' );
		$add( 'wysiwyg', "capabilities_card_{$n}_text", $card['title'] . ' description', $card['text'] );
		$add( 'text', "capabilities_card_{$n}_link", $card['title'] . ' link label', $card['link'] );
		$add( 'text', "capabilities_card_{$n}_url", $card['title'] . ' link', $card['url'], 'basic', 'Path or full URL.' );
	}

	$add( 'tab', '', 'Closing enquiry' );
	$add( 'wysiwyg', 'capabilities_enquiry_heading', 'Heading', 'Tell us about your project', 'inline' );
	$add( 'wysiwyg', 'capabilities_enquiry_body', 'Body', 'Tell us what you’re planning, and we’ll discuss which parts Streamline can deliver and how they fit the rest of the project.' );
	$add( 'text', 'capabilities_enquiry_label', 'Button', 'Discuss your project' );

	return $items;
}

/**
 * The three capability cards, in the order drawn.
 *
 * @return array<int, array<string, string>>
 */
function slc_capabilities_card_defaults() {
	return array(
		array(
			'title'   => __( 'Communications infrastructure', 'streamlineconnect' ),
			'heading' => 'Communications<br>infrastructure',
			'text'    => __( 'Our teams deliver fibre networks, wireless infrastructure and critical communications for mine sites, rail corridors and public safety. Take a fibre route from ground preparation through installation, testing and commissioning with Streamline.', 'streamlineconnect' ),
			'link'    => __( 'Explore communications infrastructure', 'streamlineconnect' ),
			'url'     => '/capabilities/communications-infrastructure/',
			'file'    => 'images/capabilities/communications.png',
			'alt'     => __( 'Communications tower seen through tree branches against a blue sky.', 'streamlineconnect' ),
			'anchor'  => 'communications_infrastructure',
		),
		array(
			'title'   => __( 'Modular infrastructure', 'streamlineconnect' ),
			'heading' => 'Modular<br>infrastructure',
			'text'    => __( 'Specify a Data Room around the communications or IT equipment you need to house and the services available on site. We manufacture Communication Equipment Rooms and Modular Data Centres.', 'streamlineconnect' ),
			'link'    => __( 'Explore modular infrastructure', 'streamlineconnect' ),
			'url'     => '/capabilities/modular-infrastructure/',
			'file'    => 'images/capabilities/modular.png',
			'alt'     => __( 'Green modular equipment room on a prepared pad, with a crane beside it.', 'streamlineconnect' ),
			'anchor'  => 'modular_infrastructure',
		),
		array(
			'title'   => __( 'Power and energy', 'streamlineconnect' ),
			'heading' => 'Power and<br>energy',
			'text'    => __( 'Upgrade your electrical supply or power a remote site. Our electricians install low-voltage systems and solar, battery or hybrid supplies. Monitoring and control give your operators system status and performance information to plan inspections and servicing.', 'streamlineconnect' ),
			'link'    => __( 'Explore power and energy', 'streamlineconnect' ),
			'url'     => '/capabilities/power-and-energy/',
			'file'    => 'images/capabilities/power.png',
			'alt'     => __( 'Solar array in front of an equipment container and a communications tower.', 'streamlineconnect' ),
			'anchor'  => 'power_and_energy',
		),
	);
}

/**
 * Hero jump links, in card order.
 *
 * @return array<int, array<string, string>>
 */
function slc_capabilities_jumps() {
	$rows = array();
	foreach ( slc_capabilities_card_defaults() as $index => $card ) {
		$n      = $index + 1;
		$rows[] = array(
			'label' => slc_plain( "capabilities_jump_{$n}", $card['title'] ),
			'url'   => '#' . $card['anchor'],
		);
	}

	return $rows;
}

/**
 * Capability cards with saved copy and links.
 *
 * @return array<int, array<string, string>>
 */
function slc_capabilities_cards() {
	$rows = slc_capabilities_card_defaults();
	foreach ( $rows as $index => &$row ) {
		$n              = $index + 1;
		$row['number']  = (string) $n;
		$row['image']   = "capabilities_card_{$n}_image";
		$row['alt']   = slc_plain( "capabilities_card_{$n}_alt", $row['alt'] );
		$row['link']  = slc_plain( "capabilities_card_{$n}_link", $row['link'] );
		$row['url']   = slc_href( "capabilities_card_{$n}_url", slc_url( $row['url'] ) );
		$row['text']  = slc_rich( "capabilities_card_{$n}_text", $row['text'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Capabilities image fields when those fields are empty.
 */
function slc_seed_capabilities_images() {
	if ( '1' === get_option( 'slc_capabilities_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'capabilities' );
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'capabilities_hero_image'    => array( 'images/capabilities/hero.png', 'Capabilities hero, cable reel and bulldozer' ),
		'capabilities_card_1_image'  => array( 'images/capabilities/communications.png', 'Capabilities, communications tower' ),
		'capabilities_card_2_image'  => array( 'images/capabilities/modular.png', 'Capabilities, modular equipment room' ),
		'capabilities_card_3_image'  => array( 'images/capabilities/power.png', 'Capabilities, solar array and tower' ),
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
		update_option( 'slc_capabilities_images_seeded', '1', false );
	}
}
