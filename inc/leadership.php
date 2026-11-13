<?php
/**
 * Leadership page fields and the copy from the WIP Leadership frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_leadership_page', 25 );
add_action( 'acf/init', 'slc_seed_leadership_images', 40 );

/**
 * The Leadership page, under About.
 *
 * @return WP_Post|null
 */
function slc_leadership_page_post() {
	$page = get_page_by_path( 'about/leadership' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'leadership' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is Leadership.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_leadership_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-leadership.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'leadership' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Leadership template so its fields appear in the editor.
 */
function slc_prepare_leadership_page() {
	$page = slc_leadership_page_post();
	if ( ! $page instanceof WP_Post || 'page-leadership.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-leadership.php' );
}

/**
 * Leadership fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_leadership_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'leadership',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Leadership hero' );
	$add( 'image', 'leadership_hero_image', 'Photograph', '', 'basic', 'Photograph behind the headline.' );
	$add( 'text', 'leadership_hero_alt', 'Photograph description', 'Two people walking a rocky site toward a tower and a crane.' );
	$add( 'text', 'leadership_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'leadership_breadcrumb_parent', 'Breadcrumb parent', 'About' );
	$add( 'text', 'leadership_breadcrumb_current', 'Breadcrumb current', 'Leadership' );
	$add( 'wysiwyg', 'leadership_heading', 'Heading', 'Leadership', 'inline' );
	$add( 'wysiwyg', 'leadership_standfirst', 'Standfirst', 'Streamline’s people have experience across construction, telecommunications, electrical systems and modular manufacturing, developed on site, in project teams and in the factory. That expertise extends throughout the business to the people supervising worksites, solving technical problems and delivering projects firsthand. Our directors and senior managers oversee Streamline’s development, projects and commercial relationships.' );

	$add( 'tab', '', 'Leadership team' );
	foreach ( slc_leadership_person_defaults() as $index => $person ) {
		$n = $index + 1;
		$add( 'image', "leadership_person_{$n}_image", $person['name'] . ' photograph' );
		$add( 'text', "leadership_person_{$n}_alt", $person['name'] . ' photograph description', $person['alt'] );
		$add( 'text', "leadership_person_{$n}_name", $person['name'] . ' name', $person['name'] );
		$add( 'text', "leadership_person_{$n}_role", $person['name'] . ' role', $person['role'] );
		$add( 'wysiwyg', "leadership_person_{$n}_bio", $person['name'] . ' biography', $person['bio'] );
	}

	$add( 'tab', '', 'Leadership capabilities' );
	$add( 'image', 'leadership_team_image', 'Photograph', '', 'basic', 'Photograph behind the team statement.' );
	$add( 'text', 'leadership_team_alt', 'Photograph description', 'Yellow construction plant and a cable reel on red earth.' );
	$add( 'wysiwyg', 'leadership_team_heading', 'Heading', 'Team Capabilities', 'inline' );
	$add( 'wysiwyg', 'leadership_team_body', 'Body', 'Streamline’s expertise extends throughout its workforce.

On fibre projects, civil crews and plant operators select construction methods to suit the route and ground conditions. Communications technicians install, test and commission networks, while electricians work on the associated power infrastructure. At Embleton, manufacturing specialists fabricate and fit out equipment rooms, with inspections and testing undertaken before dispatch.

Engineers and project managers coordinate work across these disciplines. Clients can also speak directly with the people who understand the technical details firsthand, including those responsible for installation and commissioning.' );
	$add( 'text', 'leadership_team_link', 'Link label', 'Explore our capabilities' );
	$add( 'text', 'leadership_team_url', 'Link', '/capabilities/', 'basic', 'Path or full URL.' );

	$add( 'tab', '', 'Leadership enquiry' );
	$add( 'wysiwyg', 'leadership_enquiry_heading', 'Heading', 'Discuss your project', 'inline' );
	$add( 'wysiwyg', 'leadership_enquiry_body', 'Body', 'Tell us what you’re planning, where the site is and the programme you’re working on.' );
	$add( 'text', 'leadership_enquiry_label', 'Button', 'Discuss your project.' );

	return $items;
}

/**
 * The seven leadership cards, in carousel order.
 *
 * @return array<int, array<string, string>>
 */
function slc_leadership_person_defaults() {
	$portrait = 'images/leadership/portrait.png';
	$alt      = __( 'Placeholder portrait in a Streamline polo.', 'streamlineconnect' );

	return array(
		array(
			'name' => __( 'Tony Farrell', 'streamlineconnect' ),
			'role' => __( 'Managing Director', 'streamlineconnect' ),
			'bio'  => __( 'Tony Farrell’s career has centred on telecommunications and infrastructure construction, including major fibre and wireless projects across remote Australia. His experience combines an understanding of the commercial expectations of major infrastructure clients with the practical demands of managing construction, from mobilising crews and equipment to meeting project requirements on site.

Tony co-founded Streamline Connect with Nick Jenkins in 2018 and continues to set its direction as Managing Director. He remains involved in major client relationships and decisions about the company’s investment in people and equipment. As Streamline has grown, he has placed particular emphasis on developing its leadership and preserving the culture that established the business.', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '1',
		),
		array(
			'name' => __( 'Nick Jenkins', 'streamlineconnect' ),
			'role' => __( 'Director', 'streamlineconnect' ),
			'bio'  => __( 'Nick Jenkins’s industry experience spans telecommunications, mining connectivity and modular infrastructure. He has spoken publicly about communications networks supporting autonomous mining operations and represented Streamline in a modular communications facility project with DXN in the Pilbara. His experience includes projects where reliable network connections, equipment protection and power requirements are essential to remote operations.

Nick co-founded Streamline with Tony Farrell and remains involved in its communications and modular infrastructure work. This includes client discussions about Communication Equipment Rooms and Zero Emission Rooms, particularly where available power, network connections and site conditions influence the choice of facility.', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '1',
		),
		array(
			'name' => __( 'Andrew Angelatos', 'streamlineconnect' ),
			'role' => __( 'General Manager, Projects', 'streamlineconnect' ),
			'bio'  => __( 'Andrew Angelatos has managed major infrastructure works, including cable landing stations for the North West Cable System at Darwin and Port Hedland and communications infrastructure for Rio Tinto’s Cape Lambert Port B project. His experience spans civil operations and project management, with construction, technical installation and commissioning among the disciplines he has coordinated.

Andrew recently stepped into the role of General Manager, Projects, leading Streamline’s project managers and operational delivery teams. Alongside overseeing delivery, he is working to improve the systems and processes used across projects, supporting teams as the company takes on a growing range of work.', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '1',
		),
		array(
			'name' => __( 'Elliot Metcalf', 'streamlineconnect' ),
			'role' => __( 'Chief Technology Officer', 'streamlineconnect' ),
			'bio'  => __( 'Elliot Metcalf has worked in telecommunications for two decades, progressing from technical installation into network deployment and project management. His career includes roles with Westcom Consulting, Huawei, Telstra, Vodafone and Aqura Technologies, giving him experience of mobile network infrastructure from the perspectives of technicians, carriers, vendors and contractors.

At Streamline, Elliot contributes that experience to the company’s technical leadership, particularly its wireless communications work. Having worked across both field installation and network project delivery, he understands the requirements that must be considered when planning, installing and commissioning telecommunications infrastructure.', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '1',
		),
		array(
			'name' => __( 'Graeme', 'streamlineconnect' ),
			'role' => '',
			'bio'  => __( '[Full name, title and biography pending]', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '',
		),
		array(
			'name' => __( 'Antoinette', 'streamlineconnect' ),
			'role' => '',
			'bio'  => __( '[Full name, title and biography pending]', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '',
		),
		array(
			'name' => __( 'Anthony Auld', 'streamlineconnect' ),
			'role' => __( 'Head of Strategic Growth', 'streamlineconnect' ),
			'bio'  => __( 'Anthony Auld has more than 20 years of experience in IT, networking and data centre infrastructure across Asia-Pacific and Europe. At Rittal, he developed the data centre business and worked on modular and on-premise deployments. He subsequently spent several years at DXN, working with clients and technical teams on modular data centre opportunities across multiple industries.

Anthony joined Streamline in 2026 as Head of Strategic Growth. His work focuses on developing client relationships and commercial opportunities across the company’s infrastructure capabilities. He brings extensive experience of the technical and commercial requirements of modular data centre projects, particularly for clients in mining, telecommunications, defence and government.', 'streamlineconnect' ),
			'file' => $portrait,
			'alt'  => $alt,
			'more' => '1',
		),
	);
}

/**
 * Leadership cards with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_leadership_people() {
	$rows = slc_leadership_person_defaults();
	foreach ( $rows as $index => &$row ) {
		$n            = $index + 1;
		$row['image'] = "leadership_person_{$n}_image";
		$row['alt']   = slc_plain( "leadership_person_{$n}_alt", $row['alt'] );
		$row['name']  = slc_plain( "leadership_person_{$n}_name", $row['name'] );
		$row['role']  = slc_plain( "leadership_person_{$n}_role", $row['role'] );
		$row['bio']   = slc_rich( "leadership_person_{$n}_bio", $row['bio'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Leadership image fields when those fields are empty.
 */
function slc_seed_leadership_images() {
	if ( '1' === get_option( 'slc_leadership_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_leadership_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'leadership_hero_image' => array( 'images/our-story/roots.jpg', 'Leadership hero, people walking a site' ),
		'leadership_team_image' => array( 'images/leadership/team.png', 'Leadership, plant and cable reel' ),
	);
	foreach ( slc_leadership_person_defaults() as $index => $person ) {
		$assets[ 'leadership_person_' . ( $index + 1 ) . '_image' ] = array( $person['file'], $person['name'] . ' portrait' );
	}

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
		update_option( 'slc_leadership_images_seeded', '1', false );
	}
}
