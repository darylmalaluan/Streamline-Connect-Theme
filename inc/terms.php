<?php
/**
 * Legal Terms and Company Policies page fields and the WIP frame copy.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_terms_page', 25 );

/**
 * The Terms page.
 *
 * @return WP_Post|null
 */
function slc_terms_page_post() {
	$page = get_page_by_path( 'terms' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is Legal Terms and Company Policies.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_terms_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-terms.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'terms' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Terms template so its fields appear in the editor.
 */
function slc_prepare_terms_page() {
	$page = slc_terms_page_post();
	if ( ! $page instanceof WP_Post || 'page-terms.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-terms.php' );
}

/**
 * Policy documents, in the order drawn on the frame.
 *
 * @return array<int, array<string, string>>
 */
function slc_terms_documents() {
	$rows = array(
		array(
			'id'      => 'purchase_order_terms',
			'heading' => __( 'Purchase Order Terms', 'streamlineconnect' ),
			'body'    => __( 'If you are issued a Purchase Order by Streamline Connect, the purchase of goods or services will be governed by our Purchase Order Terms and Conditions.', 'streamlineconnect' ),
			'link'    => __( 'Download Purchase Order Terms and Conditions', 'streamlineconnect' ),
			'file'    => 'purchase-order-terms.pdf',
		),
		array(
			'id'      => 'health_and_safety_policy',
			'heading' => __( 'Health and Safety Policy', 'streamlineconnect' ),
			'body'    => __( 'Streamline Connect is committed to providing a safe and healthy workplace for employees, contractors and visitors. Our Health and Safety Policy outlines our approach to risk management, legislative compliance and maintaining a safety-focused workplace.', 'streamlineconnect' ),
			'link'    => __( 'Download Health and Safety Policy', 'streamlineconnect' ),
			'file'    => 'health-and-safety-policy.pdf',
		),
		array(
			'id'      => 'environmental_policy',
			'heading' => __( 'Environmental Policy', 'streamlineconnect' ),
			'body'    => __( 'Our Environmental Policy sets out Streamline Connect’s commitment to minimising environmental impacts through responsible practices, regulatory compliance and continual improvement.', 'streamlineconnect' ),
			'link'    => __( 'Download Environmental Policy', 'streamlineconnect' ),
			'file'    => 'environmental-policy.pdf',
		),
		array(
			'id'      => 'quality_policy',
			'heading' => __( 'Quality Policy', 'streamlineconnect' ),
			'body'    => __( 'Our Quality Policy establishes the framework for delivering services to the standards expected by our clients, supported by continuous improvement and a commitment to customer satisfaction.', 'streamlineconnect' ),
			'link'    => __( 'Download Quality Policy', 'streamlineconnect' ),
			'file'    => 'quality-policy.pdf',
		),
	);

	foreach ( $rows as $index => &$row ) {
		$n              = $index + 1;
		$row['heading'] = slc_inline( "terms_doc_{$n}_heading", $row['heading'] );
		$row['body']    = slc_rich( "terms_doc_{$n}_body", $row['body'] );
		$row['link']    = slc_plain( "terms_doc_{$n}_link", $row['link'] );
		$row['url']     = slc_asset( 'documents/' . $row['file'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Legal Terms fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_terms_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'terms',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Terms title' );
	$add( 'text', 'terms_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'terms_breadcrumb_current', 'Breadcrumb current', 'Legal Terms & Company Policies' );
	$add( 'wysiwyg', 'terms_heading', 'Heading', 'Legal Terms &<br>Company Policies', 'inline' );
	$add( 'wysiwyg', 'terms_intro', 'Introduction', 'Find Streamline Connect’s Purchase Order Terms and Conditions and company policies below. These documents outline our purchasing conditions and our commitments to workplace health and safety, environmental management and quality.

Suppliers and other relevant parties should review the applicable documents to understand the requirements and responsibilities associated with working with Streamline Connect.' );
	$add( 'text', 'terms_toc_label', 'On this page label', 'On this page' );

	$add( 'tab', '', 'Terms documents' );
	foreach ( slc_terms_documents() as $index => $document ) {
		$n = $index + 1;
		$add( 'wysiwyg', "terms_doc_{$n}_heading", "Document {$n} heading", wp_strip_all_tags( $document['heading'] ), 'inline' );
		$add( 'wysiwyg', "terms_doc_{$n}_body", "Document {$n} body", wp_strip_all_tags( $document['body'] ) );
		$add( 'text', "terms_doc_{$n}_link", "Document {$n} download label", wp_strip_all_tags( $document['link'] ) );
	}

	return $items;
}
