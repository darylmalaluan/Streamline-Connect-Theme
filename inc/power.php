<?php
/**
 * Power and Energy page fields and the WIP frame copy.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_power_page', 25 );
add_action( 'acf/init', 'slc_seed_power_images', 40 );

/**
 * The Power and Energy page, under Capabilities.
 *
 * @return WP_Post|null
 */
function slc_power_page_post() {
	$page = get_page_by_path( 'capabilities/power-and-energy' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'power-and-energy' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is Power and Energy.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_power_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-power.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'power-and-energy' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Power and Energy template so its fields appear in the editor.
 */
function slc_prepare_power_page() {
	$page = slc_power_page_post();
	if ( ! $page instanceof WP_Post || 'page-power.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-power.php' );
}

/**
 * Service rows, in the order drawn on the frame.
 *
 * @return array<int, array<string, mixed>>
 */
function slc_power_service_defaults() {
	return array(
		array(
			'anchor' => 'electrical_infrastructure',
			'title'  => __( 'Electrical work around the<br>services you already use', 'streamlineconnect' ),
			'text'   => __( 'Your new supply is planned around the services you already use and the equipment you need to connect. Our electricians install and upgrade the low-voltage distribution supplying communications equipment and facilities, and modify existing site electrical installations.', 'streamlineconnect' ),
			'file'   => 'images/power/electrical.jpg',
			'alt'    => __( 'Cell tower and antennas.', 'streamlineconnect' ),
			'links'  => array(
				array(
					'label' => __( 'Discuss your electrical requirements', 'streamlineconnect' ),
					'url'   => '/contact/?capability=power-and-energy',
				),
			),
		),
		array(
			'anchor' => 'remote_power',
			'title'  => __( 'Power designed for remote operation', 'streamlineconnect' ),
			'text'   => __( 'We plan your solar, battery or hybrid supply around the equipment it needs to power and the electricity already available at the site.

Monitoring and control give your operators system status and performance information. Your maintenance team uses it to plan inspections and servicing before travelling to site.', 'streamlineconnect' ),
			'file'   => '',
			'alt'    => '',
			'links'  => array(
				array(
					'label' => __( 'Discuss your remote power project', 'streamlineconnect' ),
					'url'   => '/contact/?capability=power-and-energy',
				),
			),
		),
		array(
			'anchor' => 'factory_tested_fitout',
			'title'  => __( 'Electrical fit-out tested before deployment', 'streamlineconnect' ),
			'text'   => __( 'We use the equipment load and cooling requirements to specify a Data Room’s power distribution and backup. At Embleton, we inspect and test the electrical fit-out before dispatch. Factory Acceptance Testing also checks how a Data Room’s power, cooling and controls operate together. Final connections to site power and networks are completed after installation, followed by integration and commissioning.

Explore the power and backup options within our Data Rooms.', 'streamlineconnect' ),
			'file'   => '',
			'alt'    => '',
			'links'  => array(
				array(
					'label' => __( 'Explore Communication Equipment Rooms.', 'streamlineconnect' ),
					'url'   => '/products/data-rooms/#communication_equipment_rooms',
				),
				array(
					'label' => __( 'Explore Modular Data Centres.', 'streamlineconnect' ),
					'url'   => '/products/data-rooms/#modular_data_centres',
				),
			),
		),
		array(
			'anchor' => 'zero_emission_rooms',
			'title'  => __( 'Solar and battery power<br>in Zero Emission Rooms', 'streamlineconnect' ),
			'text'   => __( 'Our Zero Emission Rooms (ZER) give your crews offices and amenities with solar panels, battery storage and intelligent power management.

ZER began with a requirement from our own remote crews. We developed and used the facilities on our own projects before offering them to other teams.', 'streamlineconnect' ),
			'file'   => '',
			'alt'    => '',
			'links'  => array(
				array(
					'label' => __( 'Explore Zero Emission Rooms.', 'streamlineconnect' ),
					'url'   => '/products/facilities/#explore_our_facilities',
				),
			),
		),
	);
}

/**
 * Service rows with saved copy.
 *
 * @return array<int, array<string, mixed>>
 */
function slc_power_services() {
	$rows = slc_power_service_defaults();
	foreach ( $rows as $index => &$row ) {
		$n             = $index + 1;
		$row['image']  = "power_service_{$n}_image";
		$row['alt']    = slc_plain( "power_service_{$n}_alt", $row['alt'] );
		$row['title']  = slc_inline( "power_service_{$n}_title", $row['title'] );
		$row['text']   = slc_rich( "power_service_{$n}_text", $row['text'] );
		foreach ( $row['links'] as $link_index => &$link ) {
			$link_number    = $link_index + 1;
			$link['label']  = slc_plain( "power_service_{$n}_link_{$link_number}", $link['label'] );
			$link['url']    = slc_href( "power_service_{$n}_link_{$link_number}_url", slc_url( $link['url'] ) );
		}
		unset( $link );
	}
	unset( $row );

	return $rows;
}

/**
 * Hero jump links.
 *
 * @return array<int, array<string, string>>
 */
function slc_power_jumps() {
	$rows = array(
		array(
			'field' => 'power_jump_1',
			'label' => __( 'Electrical infrastructure', 'streamlineconnect' ),
			'url'   => '#electrical_infrastructure',
		),
		array(
			'field' => 'power_jump_2',
			'label' => __( 'Remote power', 'streamlineconnect' ),
			'url'   => '#remote_power',
		),
		array(
			'field' => 'power_jump_3',
			'label' => __( 'Factory-tested fit-out', 'streamlineconnect' ),
			'url'   => '#factory_tested_fitout',
		),
		array(
			'field' => 'power_jump_4',
			'label' => __( 'Zero Emission Rooms', 'streamlineconnect' ),
			'url'   => '#zero_emission_rooms',
		),
		array(
			'field' => 'power_jump_5',
			'label' => __( 'Related projects', 'streamlineconnect' ),
			'url'   => '#related_projects',
		),
		array(
			'field' => 'power_jump_6',
			'label' => __( 'How we deliver', 'streamlineconnect' ),
			'url'   => '#how_we_deliver',
		),
		array(
			'field' => 'power_jump_7',
			'label' => __( 'Why Streamline', 'streamlineconnect' ),
			'url'   => '#why_streamline',
		),
	);

	foreach ( $rows as &$row ) {
		$row['label'] = slc_plain( $row['field'], $row['label'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Power and Energy fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_power_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'power',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Power hero' );
	$add( 'image', 'power_hero_image', 'Photograph', '', 'basic', 'Solar array behind the headline.' );
	$add( 'text', 'power_hero_alt', 'Photograph description', 'Solar array beside a communications tower and equipment building.' );
	$add( 'text', 'power_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'power_breadcrumb_parent', 'Breadcrumb parent', 'Capabilities' );
	$add( 'text', 'power_breadcrumb_current', 'Breadcrumb current', 'Power & Energy' );
	$add( 'wysiwyg', 'power_heading', 'Heading', 'Power systems backed<br>by construction and manufacturing', 'inline' );
	$add( 'wysiwyg', 'power_standfirst', 'Standfirst', 'We install and upgrade low-voltage electrical infrastructure and deliver renewable, hybrid and stand-alone remote power systems, including monitoring and control. Streamline’s electricians work alongside our civil crews preparing sites and the technicians fitting out modular facilities. They understand the groundworks, equipment connections and maintenance access that an electrical installation depends on.

Planning around those requirements before equipment reaches site reduces the risk of difficult, costly alterations after installation.' );
	$add( 'text', 'power_jump_label', 'Jump panel label', 'On this page' );
	foreach ( slc_power_jumps() as $jump ) {
		$add( 'text', $jump['field'], $jump['label'], $jump['label'] );
	}
	$add( 'text', 'power_hero_button', 'Hero button', 'Discuss your power project' );

	$add( 'tab', '', 'Power services' );
	foreach ( slc_power_service_defaults() as $index => $service ) {
		$n = $index + 1;
		$add( 'image', "power_service_{$n}_image", "Photograph {$n}", '', 'basic', 'Leave empty where the frame has no photograph.' );
		$add( 'text', "power_service_{$n}_alt", "Photograph {$n} description", $service['alt'] );
		$add( 'wysiwyg', "power_service_{$n}_title", "Service {$n} title", $service['title'], 'inline' );
		$add( 'wysiwyg', "power_service_{$n}_text", "Service {$n} body", $service['text'] );
		foreach ( $service['links'] as $link_index => $link ) {
			$link_number = $link_index + 1;
			$add( 'text', "power_service_{$n}_link_{$link_number}", "Service {$n} link {$link_number}", $link['label'] );
			$add( 'text', "power_service_{$n}_link_{$link_number}_url", "Service {$n} link {$link_number} URL", $link['url'], 'basic', 'Path or full URL.' );
		}
	}

	$add( 'tab', '', 'Power project' );
	$add( 'wysiwyg', 'power_projects_heading', 'Heading', 'Related projects', 'inline' );
	$add( 'wysiwyg', 'power_projects_intro', 'Intro', 'Explore Streamline’s electrical, renewable energy and remote power projects. See how our teams install power systems around the equipment, site services and operating conditions they need to support.' );
	$add( 'image', 'power_project_image', 'Photograph' );
	$add( 'text', 'power_project_alt', 'Photograph description', 'Zero Emission Rooms at a remote site in warm evening light.' );
	$add( 'text', 'power_project_title', 'Title', 'Rio Tinto rail operations' );
	$add( 'wysiwyg', 'power_project_summary', 'Summary', 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.' );
	$add( 'text', 'power_project_chip_1', 'Chip 1', 'Facilities' );
	$add( 'text', 'power_project_chip_2', 'Chip 2', 'Power' );
	$add( 'text', 'power_project_sector', 'Sector', 'Mining and resources' );
	$add( 'text', 'power_project_client', 'Client', 'Mining operator' );
	$add( 'text', 'power_project_location', 'Location', 'Pilbara, WA' );
	$add( 'text', 'power_projects_bar', 'Section button', 'View our projects.' );
	$add( 'text', 'power_projects_url', 'Section button link', '/projects/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Power enquiry' );
	$add( 'wysiwyg', 'power_enquiry_heading', 'Heading', 'Discuss your power project', 'inline' );
	$add( 'wysiwyg', 'power_enquiry_body', 'Body', 'Tell us what needs powering, where it will operate and which services are already available.' );
	$add( 'text', 'power_enquiry_label', 'Button', 'Discuss your project.' );

	return $items;
}

/**
 * Put the Power and Energy photographs into the image fields when those fields are empty.
 */
function slc_seed_power_images() {
	if ( '1' === get_option( 'slc_power_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_power_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'power_hero_image'     => array( 'images/power/hero.jpg', 'Power and Energy hero, solar array and tower' ),
		'power_service_1_image' => array( 'images/power/electrical.jpg', 'Power and Energy, cell tower and antennas' ),
		'power_project_image'  => array( 'images/power/project.jpg', 'Power and Energy, remote Zero Emission Rooms' ),
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
		update_option( 'slc_power_images_seeded', '1', false );
	}
}
