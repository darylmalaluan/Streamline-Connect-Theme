<?php
/**
 * Privacy Policy page fields and the WIP frame copy.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_privacy_page', 25 );

/**
 * The Privacy Policy page.
 *
 * @return WP_Post|null
 */
function slc_privacy_page_post() {
	$page = get_page_by_path( 'privacy-policy' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Whether a page is the Privacy Policy.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_privacy_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-privacy-policy.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'privacy-policy' === get_post_field( 'post_name', $post_id );
}

/**
 * Use the Privacy Policy template so its fields appear in the editor.
 */
function slc_prepare_privacy_page() {
	$page = slc_privacy_page_post();
	if ( ! $page instanceof WP_Post || 'page-privacy-policy.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-privacy-policy.php' );
}

/**
 * Policy sections, in reading order.
 *
 * @return array<int, array<string, string>>
 */
function slc_privacy_sections() {
	$contact = esc_url( slc_url( '/contact/' ) );
	$rows    = array(
		array(
			'id'      => 'information_we_collect',
			'heading' => __( '1. Information We Collect', 'streamlineconnect' ),
			'body'    => __( '<p>We may collect and store the following types of personal information when you interact with our website:</p>
<ul>
<li><strong>Contact Information:</strong> If you contact us via email or contact forms, we may collect your name, email address, phone number, and any other details you provide.</li>
<li><strong>Website Analytics:</strong> We use Google Analytics to collect anonymised data about how visitors interact with our website. This includes data such as pages visited, time spent on site, browser type, and geographical location.</li>
</ul>', 'streamlineconnect' ),
		),
		array(
			'id'      => 'how_we_use_your_information',
			'heading' => __( '2. How We Use Your Information', 'streamlineconnect' ),
			'body'    => __( '<p>Your personal information may be used to:</p>
<ul>
<li>Respond to your enquiries or requests</li>
<li>Improve our website and services</li>
<li>Analyse website traffic and usage patterns (via Google Analytics)</li>
<li>Comply with legal obligations</li>
</ul>', 'streamlineconnect' ),
		),
		array(
			'id'      => 'use_of_google_analytics',
			'heading' => __( '3. Use of Google Analytics', 'streamlineconnect' ),
			'body'    => __( '<p>We use Google Analytics, a web analytics service provided by Google Inc., to help us understand how visitors engage with our website. Google Analytics uses cookies to collect information such as:</p>
<ul>
<li>IP address (anonymised)</li>
<li>Browser type and version</li>
<li>Pages visited and time spent on those pages</li>
</ul>
<p>This data helps us improve the usability and content of our site. You can opt out of Google Analytics tracking by installing the Google Analytics Opt-out Browser Add-on:</p>', 'streamlineconnect' ),
		),
		array(
			'id'      => 'storage_and_security',
			'heading' => __( '4. Storage and Security', 'streamlineconnect' ),
			'body'    => __( '<p>We take reasonable steps to protect your personal information from misuse, loss, unauthorised access, modification, or disclosure. However, no method of transmission over the Internet is completely secure.</p>', 'streamlineconnect' ),
		),
		array(
			'id'      => 'sharing_of_information',
			'heading' => __( '5. Sharing of Information', 'streamlineconnect' ),
			'body'    => __( '<p>We do not sell, rent, or trade your personal information to third parties. We may disclose your personal information only if required by law or in circumstances permitted by the Privacy Act 1988 (Cth).</p>', 'streamlineconnect' ),
		),
		array(
			'id'      => 'your_rights',
			'heading' => __( '6. Your Rights', 'streamlineconnect' ),
			'body'    => sprintf(
				/* translators: %s: contact page URL */
				__( '<p>You may request access to or correction of your personal information we hold. To make such a request, please visit our <a href="%s">Contact page</a> and submit your enquiry, noting that it relates to a privacy matter.</p>', 'streamlineconnect' ),
				$contact
			),
		),
		array(
			'id'      => 'updates_to_this_policy',
			'heading' => __( '7. Updates to This Policy', 'streamlineconnect' ),
			'body'    => __( '<p>We may update this Privacy Policy from time to time. The latest version will always be available on our website.</p>', 'streamlineconnect' ),
		),
		array(
			'id'      => 'contact_us',
			'heading' => __( '8. Contact Us', 'streamlineconnect' ),
			'body'    => sprintf(
				/* translators: %s: contact page URL */
				__( '<p>If you have any questions or concerns about this Privacy Policy or how we handle your information, please reach out to us via our <a href="%s">Contact page</a> or:</p>
<p>Streamline Connect Pty Ltd<br>10 Belmont Avenue<br>Rivervale, WA, 6103<br><a href="tel:+61893039039">(08) 9303 9039</a></p>', 'streamlineconnect' ),
				$contact
			),
		),
	);

	foreach ( $rows as $index => &$row ) {
		$n               = $index + 1;
		$row['heading']  = slc_inline( "privacy_section_{$n}_heading", $row['heading'] );
		$row['body']     = slc_rich( "privacy_section_{$n}_body", $row['body'] );
	}
	unset( $row );

	return $rows;
}

/**
 * Privacy Policy fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_privacy_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'privacy',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Privacy title' );
	$add( 'text', 'privacy_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'privacy_breadcrumb_current', 'Breadcrumb current', 'Privacy Policy' );
	$add( 'wysiwyg', 'privacy_heading', 'Heading', 'Privacy Policy', 'inline' );
	$add( 'wysiwyg', 'privacy_intro', 'Introduction', 'Streamline Connect Pty Ltd (“we”, “our”, or “us”) respects your privacy and is committed to protecting the personal information you provide to us. This Privacy Policy outlines how we collect, use, store, and disclose your personal data, including through our website.' );
	$add( 'text', 'privacy_toc_label', 'On this page label', 'On this page' );

	$add( 'tab', '', 'Privacy sections' );
	$defaults = array(
		'1. Information We Collect'       => '<p>We may collect and store the following types of personal information when you interact with our website:</p><ul><li><strong>Contact Information:</strong> If you contact us via email or contact forms, we may collect your name, email address, phone number, and any other details you provide.</li><li><strong>Website Analytics:</strong> We use Google Analytics to collect anonymised data about how visitors interact with our website. This includes data such as pages visited, time spent on site, browser type, and geographical location.</li></ul>',
		'2. How We Use Your Information'  => '<p>Your personal information may be used to:</p><ul><li>Respond to your enquiries or requests</li><li>Improve our website and services</li><li>Analyse website traffic and usage patterns (via Google Analytics)</li><li>Comply with legal obligations</li></ul>',
		'3. Use of Google Analytics'      => '<p>We use Google Analytics, a web analytics service provided by Google Inc., to help us understand how visitors engage with our website. Google Analytics uses cookies to collect information such as:</p><ul><li>IP address (anonymised)</li><li>Browser type and version</li><li>Pages visited and time spent on those pages</li></ul><p>This data helps us improve the usability and content of our site. You can opt out of Google Analytics tracking by installing the Google Analytics Opt-out Browser Add-on:</p>',
		'4. Storage and Security'         => '<p>We take reasonable steps to protect your personal information from misuse, loss, unauthorised access, modification, or disclosure. However, no method of transmission over the Internet is completely secure.</p>',
		'5. Sharing of Information'       => '<p>We do not sell, rent, or trade your personal information to third parties. We may disclose your personal information only if required by law or in circumstances permitted by the Privacy Act 1988 (Cth).</p>',
		'6. Your Rights'                  => '<p>You may request access to or correction of your personal information we hold. To make such a request, please visit our <a href="/contact/">Contact page</a> and submit your enquiry, noting that it relates to a privacy matter.</p>',
		'7. Updates to This Policy'       => '<p>We may update this Privacy Policy from time to time. The latest version will always be available on our website.</p>',
		'8. Contact Us'                   => '<p>If you have any questions or concerns about this Privacy Policy or how we handle your information, please reach out to us via our <a href="/contact/">Contact page</a> or:</p><p>Streamline Connect Pty Ltd<br>10 Belmont Avenue<br>Rivervale, WA, 6103<br><a href="tel:+61893039039">(08) 9303 9039</a></p>',
	);
	$number = 1;
	foreach ( $defaults as $heading => $body ) {
		$add( 'wysiwyg', "privacy_section_{$number}_heading", "Section {$number} heading", $heading, 'inline' );
		$add( 'wysiwyg', "privacy_section_{$number}_body", "Section {$number} body", $body );
		$number++;
	}
	$add( 'text', 'privacy_analytics_label', 'Analytics opt-out label', 'Google Analytics Opt-out Browser Add-on' );
	$add( 'text', 'privacy_analytics_url', 'Analytics opt-out link', 'https://tools.google.com/dlpage/gaoptout', 'basic', 'Full URL.' );

	return $items;
}
