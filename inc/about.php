<?php
/**
 * About page fields and the copy from the WIP About frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_about_page', 25 );
add_action( 'acf/init', 'slc_seed_about_images', 40 );

/**
 * Whether a page is the About page, not one of its children.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_about_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-about.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'about' === get_post_field( 'post_name', $post_id ) && ! wp_get_post_parent_id( $post_id );
}

/**
 * Use the About template so its fields appear in the editor.
 */
function slc_prepare_about_page() {
	$page = get_page_by_path( 'about' );
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	if ( 'page-about.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-about.php' );
}

/**
 * About fields, in page order. Class and id fields stay off; the page uses the shared theme classes.
 *
 * @return array<int, array<string, string>>
 */
function slc_about_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'about',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Hero' );
	$add( 'image', 'about_hero_image', 'Photograph', '', 'basic', 'Construction scene. Shown behind the headline.' );
	$add( 'text', 'about_hero_alt', 'Photograph description', 'Operator in a tracked machine beside a truck on a construction site at dusk.' );
	$add( 'text', 'about_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'about_breadcrumb_current', 'Breadcrumb current', 'About' );
	$add( 'wysiwyg', 'about_heading', 'Heading', 'About Streamline', 'inline' );
	$add( 'wysiwyg', 'about_standfirst', 'Standfirst', 'Streamline Connect is a Western Australian contractor delivering communications networks, power systems and modular infrastructure across Australia. Our crews work in remote areas and around live mine and rail operations. Our head office is in Belmont, with manufacturing at Embleton and our plant maintenance yard in High Wycombe.' );
	$add( 'text', 'about_jump_label', 'Jump panel label', 'On this page' );
	$add( 'text', 'about_jump_1', 'Jump link 1', 'Proximity to the work' );
	$add( 'text', 'about_jump_2', 'Jump link 2', 'Our people' );
	$add( 'text', 'about_jump_3', 'Jump link 3', 'Explore Streamline' );

	$add( 'tab', '', 'Quote' );
	$add( 'wysiwyg', 'about_quote', 'Quote', 'Our founders, Tony Farrell and Nick Jenkins, wanted the freedom to make decisions and do the job right. We still expect the people making commitments to understand what the work will require on site.', 'basic', 'Publish only with approval to use the founders’ names.' );

	$add( 'tab', '', 'Proximity' );
	$add( 'wysiwyg', 'about_proximity_heading', 'Heading', 'Proximity to the work', 'inline' );
	$add( 'wysiwyg', 'about_proximity_body', 'Body', 'We love seeing a network go live, knowing our crews did the construction that made it possible. That’s why we’ve invested in our own people, plant and equipment, keeping construction knowledge and responsibility close to the job. We want to earn the next project through how we deliver this one.' );
	$add( 'image', 'about_proximity_image', 'Photograph' );
	$add( 'text', 'about_proximity_alt', 'Photograph description', 'Crew in high-visibility clothing lined up in front of modular containers at a yard.' );

	$add( 'tab', '', 'People' );
	$add( 'wysiwyg', 'about_people_heading', 'Heading', 'Our people', 'inline' );
	$add( 'wysiwyg', 'about_people_body', 'Body', 'Our site teams include civil crews, electricians and communications technicians. We want our people to have a future here, with opportunities to lead projects and develop teams of their own.' );
	foreach ( slc_about_people_defaults() as $index => $person ) {
		$n = $index + 1;
		$add( 'image', "about_people_{$n}_image", "Photograph {$n}" );
		$add( 'text', "about_people_{$n}_alt", "Photograph {$n} description", $person['alt'] );
	}

	$add( 'tab', '', 'Explore' );
	$add( 'wysiwyg', 'about_explore_heading', 'Heading', 'Explore Streamline', 'inline' );
	foreach ( slc_about_explore_defaults() as $index => $card ) {
		$n = $index + 1;
		$add( 'image', "about_explore_{$n}_image", $card['title'] . ' photograph' );
		$add( 'text', "about_explore_{$n}_alt", $card['title'] . ' photograph description', $card['alt'] );
		$add( 'text', "about_explore_{$n}_title", $card['title'] . ' title', $card['title'] );
		$add( 'wysiwyg', "about_explore_{$n}_text", $card['title'] . ' description', $card['text'] );
		$add( 'text', "about_explore_{$n}_link", $card['title'] . ' link label', $card['link'] );
		$add( 'text', "about_explore_{$n}_url", $card['title'] . ' link', $card['url'], 'basic', 'Path or full URL.' );
	}

	return $items;
}

/**
 * Fallback photographs and descriptions for the nine-image band, in reading order.
 *
 * @return array<int, array<string, string>>
 */
function slc_about_people_defaults() {
	return array(
		array(
			'file' => 'images/about/people-1.png',
			'alt'  => __( 'Three people at the doorway of a white container.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-2.png',
			'alt'  => __( 'A worker looking up at overhead pipework.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-3.png',
			'alt'  => __( 'A worker inside an equipment cabinet.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-4.png',
			'alt'  => __( 'A worker on a steel structure.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-5.png',
			'alt'  => __( 'Welding, with sparks.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-6.png',
			'alt'  => __( 'People and a tower structure on a site.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-7.png',
			'alt'  => __( 'Two people working at a mast with dishes.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-8.png',
			'alt'  => __( 'A crew on a prepared site.', 'streamlineconnect' ),
		),
		array(
			'file' => 'images/about/people-9.png',
			'alt'  => __( 'A crew beside an excavator on red earth.', 'streamlineconnect' ),
		),
	);
}

/**
 * Explore cards. Destinations are the pages already in the site map.
 *
 * @return array<int, array<string, string>>
 */
function slc_about_explore_defaults() {
	return array(
		array(
			'title' => __( 'How Streamline has grown', 'streamlineconnect' ),
			'text'  => __( 'Trace Streamline Connect’s development from its telecommunications heritage to its establishment in 2018 and expansion into power and modular manufacturing.', 'streamlineconnect' ),
			'link'  => __( 'Read our story', 'streamlineconnect' ),
			'url'   => '/about/our-story/',
			'file'  => 'images/about/explore-1.jpg',
			'alt'   => __( 'Streamline ute parked in open country at sunset.', 'streamlineconnect' ),
		),
		array(
			'title' => __( 'Leadership', 'streamlineconnect' ),
			'text'  => __( 'Our leaders work directly with clients and project teams, taking responsibility for the commitments we make and the work we deliver.', 'streamlineconnect' ),
			'link'  => __( 'Meet our leadership team', 'streamlineconnect' ),
			'url'   => '/about/leadership/',
			'file'  => 'images/about/explore-2.jpg',
			'alt'   => __( 'Two people walking a site track toward a tower.', 'streamlineconnect' ),
		),
		array(
			'title' => __( 'How we deliver', 'streamlineconnect' ),
			'text'  => __( 'We work from design through to commissioning, with support continuing after handover. Our own crews and technical teams handle the core work, with construction and manufacturing planned together when a project needs both.', 'streamlineconnect' ),
			'link'  => __( 'See how we deliver', 'streamlineconnect' ),
			'url'   => '/about/how-we-deliver/',
			'file'  => 'images/about/explore-3.png',
			'alt'   => __( 'Crew handling a cable reel from a truck.', 'streamlineconnect' ),
		),
	);
}

/**
 * Hero jump links.
 *
 * @return array<int, array<string, string>>
 */
function slc_about_jumps() {
	$rows = array(
		array(
			'field'  => 'about_jump_1',
			'label'  => __( 'Proximity to the work', 'streamlineconnect' ),
			'url'    => '#proximity_to_the_work',
		),
		array(
			'field'  => 'about_jump_2',
			'label'  => __( 'Our people', 'streamlineconnect' ),
			'url'    => '#our_people',
		),
		array(
			'field'  => 'about_jump_3',
			'label'  => __( 'Explore Streamline', 'streamlineconnect' ),
			'url'    => '#explore_streamline',
		),
	);

	foreach ( $rows as &$row ) {
		$row['label'] = slc_plain( $row['field'], $row['label'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Nine photographs in reading order.
 *
 * @return array<int, array<string, string>>
 */
function slc_about_people() {
	$rows = slc_about_people_defaults();
	foreach ( $rows as $index => &$row ) {
		$n             = $index + 1;
		$row['field']  = "about_people_{$n}_image";
		$row['alt']    = slc_plain( "about_people_{$n}_alt", $row['alt'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Explore cards with saved titles, copy, and links.
 *
 * @return array<int, array<string, string>>
 */
function slc_about_explore() {
	$rows = slc_about_explore_defaults();
	foreach ( $rows as $index => &$row ) {
		$n               = $index + 1;
		$row['image']    = "about_explore_{$n}_image";
		$row['title']    = slc_plain( "about_explore_{$n}_title", $row['title'] );
		$row['link']     = slc_plain( "about_explore_{$n}_link", $row['link'] );
		$row['alt']      = slc_plain( "about_explore_{$n}_alt", $row['alt'] );
		$row['url']      = slc_href( "about_explore_{$n}_url", slc_url( $row['url'] ) );
		$row['text']     = slc_rich( "about_explore_{$n}_text", $row['text'] );
	}
	unset( $row );

	return $rows;
}

/**
 * One people-band photograph.
 *
 * @param array<string, string> $shot Photograph row.
 * @return string
 */
function slc_about_shot( $shot ) {
	return slc_picture(
		array(
			'field'  => $shot['field'],
			'file'   => $shot['file'],
			'width'  => 900,
			'height' => 600,
			'alt'    => $shot['alt'],
		)
	);
}

/**
 * Put the Figma photographs into the About image fields when those fields are empty.
 */
function slc_seed_about_images() {
	if ( '1' === get_option( 'slc_about_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'about' );
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'about_hero_image'       => array( 'images/about/hero.jpg', 'About hero, construction site at dusk' ),
		'about_proximity_image'  => array( 'images/about/proximity.png', 'About, crew in front of modular containers' ),
		'about_people_1_image'   => array( 'images/about/people-1.png', 'About people 1' ),
		'about_people_2_image'   => array( 'images/about/people-2.png', 'About people 2' ),
		'about_people_3_image'   => array( 'images/about/people-3.png', 'About people 3' ),
		'about_people_4_image'   => array( 'images/about/people-4.png', 'About people 4' ),
		'about_people_5_image'   => array( 'images/about/people-5.png', 'About people 5' ),
		'about_people_6_image'   => array( 'images/about/people-6.png', 'About people 6' ),
		'about_people_7_image'   => array( 'images/about/people-7.png', 'About people 7' ),
		'about_people_8_image'   => array( 'images/about/people-8.png', 'About people 8' ),
		'about_people_9_image'   => array( 'images/about/people-9.png', 'About people 9' ),
		'about_explore_1_image'  => array( 'images/about/explore-1.jpg', 'About, how Streamline has grown' ),
		'about_explore_2_image'  => array( 'images/about/explore-2.jpg', 'About, leadership' ),
		'about_explore_3_image'  => array( 'images/about/explore-3.png', 'About, how we deliver' ),
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
		update_option( 'slc_about_images_seeded', '1', false );
	}
}
