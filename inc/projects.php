<?php
/**
 * Projects listing page. Cards come from published projects.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_projects_page', 25 );
add_action( 'acf/init', 'slc_seed_projects_image', 40 );

/**
 * The Projects page.
 *
 * @return WP_Post|null
 */
function slc_projects_page_post() {
	$page = get_page_by_path( 'projects' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is the Projects listing.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_projects_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-projects.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'projects' === get_post_field( 'post_name', $post_id ) && ! wp_get_post_parent_id( $post_id );
}

/**
 * Use the Projects template so its fields appear in the editor.
 */
function slc_prepare_projects_page() {
	$page = slc_projects_page_post();
	if ( ! $page instanceof WP_Post || 'page-projects.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-projects.php' );
}

/**
 * Listing copy, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_projects_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'projects',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Listing hero' );
	$add( 'text', 'projects_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'projects_breadcrumb_current', 'Breadcrumb current', 'Projects' );
	$add( 'text', 'projects_heading', 'Heading', 'Projects' );
	$add( 'wysiwyg', 'projects_intro', 'Introduction', 'From communications networks to power systems and modular facilities, see Streamline\'s experience on actual projects. These case studies cover the challenges clients faced, the work our teams undertook and what they delivered.' );
	$add( 'image', 'projects_hero_image', 'Photograph' );
	$add( 'text', 'projects_hero_alt', 'Photograph description', 'Modular facilities and solar arrays on a remote site.' );

	$add( 'tab', '', 'Listing cards' );
	$add( 'text', 'projects_list_heading', 'Heading', 'Project case studies' );
	$add( 'text', 'projects_client_label', 'Client label', 'Client' );
	$add( 'text', 'projects_region_label', 'Region label', 'Region' );
	$add( 'text', 'projects_view_label', 'View label', 'View project' );

	return $items;
}

/**
 * A saved project value, ignoring the case study prompts.
 *
 * @param int    $post_id Project id.
 * @param string $key     Field name.
 * @return string
 */
function slc_project_card_text( $post_id, $key ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$value = get_field( $key, $post_id );
	if ( ! is_string( $value ) ) {
		return '';
	}

	$value = trim( wp_strip_all_tags( $value ) );
	return $value;
}

/**
 * One listing card for each published project.
 *
 * @return array<int, array<string, mixed>>
 */
function slc_project_listing_cards() {
	$cards = array();

	foreach ( slc_project_posts() as $project ) {
		$image_id = function_exists( 'slc_attachment_id' ) ? slc_attachment_id( get_field( 'case_image_1', $project->ID ) ) : 0;
		$image    = ( $image_id && function_exists( 'slc_attachment_exists' ) && slc_attachment_exists( $image_id ) ) ? $image_id : 0;
		$alt      = slc_project_card_text( $project->ID, 'case_image_1_alt' );
		if ( '' === $alt ) {
			$alt = get_the_title( $project );
		}

		$client = slc_project_card_text( $project->ID, 'case_client' );
		$region = slc_project_card_text( $project->ID, 'case_location' );

		$cards[] = array(
			'url'        => get_permalink( $project ),
			'title'      => get_the_title( $project ),
			'capability' => slc_project_card_text( $project->ID, 'case_capability' ),
			'client'     => '' !== $client ? $client : __( 'Company name', 'streamlineconnect' ),
			'region'     => '' !== $region ? $region : __( 'Project location', 'streamlineconnect' ),
			'image'      => $image,
			'alt'        => $alt,
		);
	}

	return $cards;
}

/**
 * Put the listing photograph into the hero field when that field is empty.
 */
function slc_seed_projects_image() {
	if ( '1' === get_option( 'slc_projects_image_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_projects_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$current = get_field( 'projects_hero_image', $page->ID );
	if ( function_exists( 'slc_attachment_exists' ) && slc_attachment_exists( slc_attachment_id( $current ) ) ) {
		update_option( 'slc_projects_image_seeded', '1', false );
		return;
	}

	$id = slc_import_theme_asset( 'images/projects/hero.jpg', 'Projects hero, modular facilities and solar arrays' );
	if ( $id && update_field( 'projects_hero_image', $id, $page->ID ) ) {
		update_option( 'slc_projects_image_seeded', '1', false );
	}
}
