<?php
/**
 * Our Story page fields and the copy from the WIP Our Story frame.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_story_page', 25 );
add_action( 'acf/init', 'slc_seed_story_images', 40 );

/**
 * The Our Story page, which sits under About.
 *
 * @return WP_Post|null
 */
function slc_story_page_post() {
	$page = get_page_by_path( 'about/our-story' );
	if ( $page instanceof WP_Post ) {
		return $page;
	}

	$page = get_page_by_path( 'our-story' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is Our Story.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_story_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-our-story.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'our-story' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Our Story template so its fields appear in the editor.
 */
function slc_prepare_story_page() {
	$page = slc_story_page_post();
	if ( ! $page instanceof WP_Post || 'page-our-story.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-our-story.php' );
}

/**
 * Our Story fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_story_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'story',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Story hero' );
	$add( 'image', 'story_hero_image', 'Photograph', '', 'basic', 'Crew photograph behind the headline.' );
	$add( 'text', 'story_hero_alt', 'Photograph description', 'Streamline crew lined up in front of modular rooms.' );
	$add( 'text', 'story_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'story_breadcrumb_parent', 'Breadcrumb parent', 'About' );
	$add( 'text', 'story_breadcrumb_current', 'Breadcrumb current', 'Our Story' );
	$add( 'wysiwyg', 'story_heading', 'Heading', 'Our Story', 'inline' );
	$add( 'wysiwyg', 'story_standfirst', 'Standfirst', 'Tony Farrell and Nick Jenkins had seen how far project managers could be from the crews doing the work. A client needed an answer, but that answer might have to pass through several layers of contractors before it came back.' );

	$add( 'tab', '', 'Story cards' );
	foreach ( slc_story_card_defaults() as $index => $card ) {
		$n = $index + 1;
		$add( 'image', "story_card_{$n}_image", $card['title'] . ' photograph' );
		$add( 'text', "story_card_{$n}_alt", $card['title'] . ' photograph description', $card['alt'] );
		$add( 'wysiwyg', "story_card_{$n}_text", $card['title'] . ' text', $card['text'] );
	}

	$add( 'tab', '', 'Story links' );
	foreach ( slc_story_link_defaults() as $index => $card ) {
		$n = $index + 1;
		$add( 'wysiwyg', "story_link_{$n}_text", $card['title'] . ' text', $card['text'] );
		$add( 'text', "story_link_{$n}_label", $card['title'] . ' link label', $card['link'] );
		$add( 'text', "story_link_{$n}_url", $card['title'] . ' link', $card['url'], 'basic', 'Path or full URL.' );
	}

	$add( 'tab', '', 'Story enquiry' );
	$add( 'wysiwyg', 'story_enquiry_heading', 'Heading', 'Discuss your project', 'inline' );
	$add( 'wysiwyg', 'story_enquiry_body', 'Body', 'Tell us what you’re planning, where the site is and the programme you’re working to.' );
	$add( 'text', 'story_enquiry_label', 'Button', 'Discuss your project.' );

	return $items;
}

/**
 * Carousel cards, in order. Two are visible at a time on desktop.
 *
 * @return array<int, array<string, string>>
 */
function slc_story_card_defaults() {
	return array(
		array(
			'title' => __( 'Roots', 'streamlineconnect' ),
			'text'  => __( 'They wanted their own people and equipment behind every promise to a client, with fewer people standing between a decision and the work itself. In 2018, they backed themselves and started Streamline Connect. They had experience to draw on from the beginning. People from Streamline Underground Services joined the new business, which also acquired assets from the Western Australian company. Its roots in fibre and underground construction went back to 1996.', 'streamlineconnect' ),
			'file'  => 'images/our-story/roots.jpg',
			'alt'   => __( 'Two people walking a rocky site toward a tower and a crane.', 'streamlineconnect' ),
		),
		array(
			'title' => __( 'Growth', 'streamlineconnect' ),
			'text'  => __( 'Fibre remained central to our work as we expanded into wireless installation and commissioning for carriers and private network operators. Clients kept our teams engaged between scopes and spoke to us early about future projects. They knew Streamline by the standard of work we’d already delivered, and trusted us to take on more. To extend that responsibility to the power and monitoring systems supporting their networks, we invested in specialist plant and technical teams.', 'streamlineconnect' ),
			'file'  => 'images/our-story/growth.png',
			'alt'   => __( 'Tracked machine laying cable from a large reel on red earth.', 'streamlineconnect' ),
		),
		array(
			'title' => __( 'Manufacture', 'streamlineconnect' ),
			'text'  => __( 'When clients began asking us to manufacture equipment rooms, we saw a chance to make the next installer’s job easier. We knew from working on site how the placement of a cable entry or the space left for maintenance could affect the work that followed. We could now plan those details from the start, drawing on what our teams had learned in the field. Today, we’re proud to manufacture and test Data Rooms at our Embleton factory.', 'streamlineconnect' ),
			'file'  => 'images/our-story/manufacture.png',
			'alt'   => __( 'Welder kneeling inside a modular room.', 'streamlineconnect' ),
		),
	);
}

/**
 * Navy link cards under the carousel.
 *
 * @return array<int, array<string, string>>
 */
function slc_story_link_defaults() {
	return array(
		array(
			'title' => __( 'Leadership', 'streamlineconnect' ),
			'text'  => __( 'Tony and Nick still lead Streamline, supported by a management team that understands what clients expect and what it takes to get the work done on site.', 'streamlineconnect' ),
			'link'  => __( 'Meet our leadership team.', 'streamlineconnect' ),
			'url'   => '/about/leadership/',
			'icon'  => 'story-people.svg',
		),
		array(
			'title' => __( 'Capabilities', 'streamlineconnect' ),
			'text'  => __( 'Our clients first knew us for fibre. As they trusted us to take on more, we invested in the people and equipment to deliver power systems and modular infrastructure too.', 'streamlineconnect' ),
			'link'  => __( 'Explore our capabilities.', 'streamlineconnect' ),
			'url'   => '/capabilities/',
			'icon'  => 'story-grid.svg',
		),
		array(
			'title' => __( 'Deliver', 'streamlineconnect' ),
			'text'  => __( 'We started Streamline to put our own people and equipment behind every promise to a client. That principle still shapes how we plan and deliver our projects.', 'streamlineconnect' ),
			'link'  => __( 'See how we deliver.', 'streamlineconnect' ),
			'url'   => '/about/how-we-deliver/',
			'icon'  => 'story-nodes.svg',
		),
	);
}

/**
 * Carousel cards with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_story_cards() {
	$rows = slc_story_card_defaults();
	foreach ( $rows as $index => &$row ) {
		$n            = $index + 1;
		$row['image'] = "story_card_{$n}_image";
		$row['alt']   = slc_plain( "story_card_{$n}_alt", $row['alt'] );
		$row['text']  = slc_rich( "story_card_{$n}_text", $row['text'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Link cards with saved copy.
 *
 * @return array<int, array<string, string>>
 */
function slc_story_links() {
	$rows = slc_story_link_defaults();
	foreach ( $rows as $index => &$row ) {
		$n           = $index + 1;
		$row['text'] = slc_rich( "story_link_{$n}_text", $row['text'] );
		$row['link'] = slc_plain( "story_link_{$n}_label", $row['link'] );
		$row['url']  = slc_href( "story_link_{$n}_url", slc_url( $row['url'] ) );
	}
	unset( $row );

	return $rows;
}

/**
 * Put the Figma photographs into the Our Story image fields when those fields are empty.
 */
function slc_seed_story_images() {
	if ( '1' === get_option( 'slc_story_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_story_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'story_hero_image'    => array( 'images/our-story/hero.png', 'Our Story hero, crew at the yard' ),
		'story_card_1_image'  => array( 'images/our-story/roots.jpg', 'Our Story, roots' ),
		'story_card_2_image'  => array( 'images/our-story/growth.png', 'Our Story, growth' ),
		'story_card_3_image'  => array( 'images/our-story/manufacture.png', 'Our Story, manufacture' ),
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
		update_option( 'slc_story_images_seeded', '1', false );
	}
}
