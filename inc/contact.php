<?php
/**
 * Contact page fields, photographs, and the Contact Form 7 enquiry.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'slc_prepare_contact_page', 25 );
add_action( 'init', 'slc_sync_contact_form', 30 );
add_action( 'acf/init', 'slc_seed_contact_images', 40 );
add_action( 'acf/init', 'slc_sync_contact_form', 50 );
add_filter( 'wpcf7_autop_or_not', 'slc_contact_form_autop', 10, 2 );

/**
 * Whether a page is the Contact page, not Locations.
 *
 * @param int $post_id Page id. Defaults to the queried page.
 * @return bool
 */
function slc_is_contact_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return false;
	}

	if ( 'page-contact.php' === get_page_template_slug( $post_id ) ) {
		return true;
	}

	return 'contact' === get_post_field( 'post_name', $post_id ) && ! wp_get_post_parent_id( $post_id );
}

/**
 * The Contact page post.
 *
 * @return WP_Post|null
 */
function slc_contact_page_post() {
	$page = get_page_by_path( 'contact' );
	return $page instanceof WP_Post ? $page : null;
}

/**
 * Use the Contact template so its fields appear in the editor.
 */
function slc_prepare_contact_page() {
	$page = slc_contact_page_post();
	if ( ! $page instanceof WP_Post || 'page-contact.php' === get_page_template_slug( $page->ID ) ) {
		return;
	}

	update_post_meta( $page->ID, '_wp_page_template', 'page-contact.php' );
}

/**
 * Saved Contact copy, or the theme sentence when the field is empty.
 *
 * @param string $key      Field name.
 * @param string $fallback Theme copy.
 * @return string
 */
function slc_contact_copy( $key, $fallback ) {
	$page = slc_contact_page_post();
	if ( $page instanceof WP_Post && function_exists( 'get_field' ) ) {
		$value = get_field( $key, $page->ID );
		if ( is_string( $value ) && '' !== trim( wp_strip_all_tags( $value ) ) ) {
			return trim( wp_strip_all_tags( $value ) );
		}
	}

	return $fallback;
}

/**
 * Saved Contact HTML, or the theme sentence when the field is empty.
 *
 * @param string $key      Field name.
 * @param string $fallback Theme HTML.
 * @return string
 */
function slc_contact_html( $key, $fallback ) {
	$page = slc_contact_page_post();
	if ( $page instanceof WP_Post && function_exists( 'get_field' ) ) {
		$value = get_field( $key, $page->ID );
		if ( is_string( $value ) && '' !== trim( wp_strip_all_tags( $value ) ) ) {
			return $value;
		}
	}

	return $fallback;
}

/**
 * Contact fields, in page order.
 *
 * @return array<int, array<string, string>>
 */
function slc_contact_field_catalog() {
	$items = array();
	$add   = function ( $type, $name, $label, $default = '', $toolbar = 'basic', $instructions = '' ) use ( &$items ) {
		$items[] = array(
			'type'         => $type,
			'name'         => $name,
			'label'        => $label,
			'default'      => $default,
			'toolbar'      => $toolbar,
			'plain'        => true,
			'scope'        => 'contact',
			'instructions' => $instructions,
		);
	};

	$add( 'tab', '', 'Contact hero' );
	$add( 'image', 'contact_hero_image', 'Photograph', '', 'basic', 'Site photograph behind the headline.' );
	$add( 'text', 'contact_hero_alt', 'Photograph description', 'Communications tower and site buildings on red earth at dusk.' );
	$add( 'text', 'contact_breadcrumb_home', 'Breadcrumb home', 'Home' );
	$add( 'text', 'contact_breadcrumb_current', 'Breadcrumb current', 'Contact' );
	$add( 'wysiwyg', 'contact_heading', 'Heading', 'Contact', 'inline' );
	$add( 'wysiwyg', 'contact_standfirst', 'Standfirst', 'Whether you’re planning a project, contacting us as a supplier or making a general enquiry, you can reach Streamline here. Early project briefs are welcome.' );

	$add( 'tab', '', 'Enquiry introduction' );
	$add( 'wysiwyg', 'contact_intro_heading', 'Heading', 'Let’s talk about the job', 'inline' );
	$add( 'wysiwyg', 'contact_intro_body', 'Body', 'Tell us a little about what you’re contacting us for.' );
	$add( 'image', 'contact_intro_image', 'Photograph', '', 'basic', 'Photograph beside the enquiry form.' );
	$add( 'text', 'contact_intro_alt', 'Photograph description', 'Streamline truck crane lifting equipment beside a solar-powered site container.' );

	$add( 'tab', '', 'Form copy' );
	$add( 'text', 'contact_label_type', 'Enquiry type label', 'Enquiry type (Required)' );
	$add( 'text', 'contact_label_capability', 'Capability label', 'Capability, solution or product (Optional)' );
	$add( 'text', 'contact_label_industry', 'Industry label', 'Industry (Optional)' );
	$add( 'text', 'contact_label_location', 'Site location label', 'Site location (Optional)' );
	$add( 'text', 'contact_label_timeframe', 'Timeframe label', 'Required timeframe (Optional)' );
	$add( 'text', 'contact_label_enquiry', 'Enquiry label', 'Your enquiry (Required)' );
	$add( 'text', 'contact_helper_enquiry', 'Enquiry helper', 'Tell us about your project or question, including any requirements or details you already have.' );
	$add( 'text', 'contact_label_name', 'Name label', 'Name (Required)' );
	$add( 'text', 'contact_label_company', 'Company label', 'Company (Optional)' );
	$add( 'text', 'contact_label_email', 'Email label', 'Email (Required)' );
	$add( 'text', 'contact_label_phone', 'Phone label', 'Phone (Optional)' );
	$add( 'text', 'contact_label_privacy', 'Privacy label', 'Privacy consent (Required)' );
	$add( 'wysiwyg', 'contact_privacy_text', 'Privacy consent', 'I have read the <a href="/privacy-policy/">Privacy Policy</a> and agree to Streamline Connect using my details to respond to this enquiry.' );
	$add( 'text', 'contact_submit_label', 'Submit button', 'Send enquiry' );
	$add( 'text', 'contact_success', 'Success message', 'Thanks for contacting Streamline Connect. Your enquiry has been submitted.' );
	$add( 'text', 'contact_error', 'Send error', 'We couldn’t submit your enquiry. Please try again or contact us by phone or email.' );
	$add( 'text', 'contact_error_required', 'Required field error', 'Please complete this field.' );
	$add( 'text', 'contact_error_email', 'Email error', 'Enter a valid email address.' );
	$add( 'text', 'contact_error_privacy', 'Privacy error', 'Please confirm that you have read the Privacy Policy.' );

	return $items;
}

/**
 * Capability choices for a project enquiry.
 *
 * @return string[]
 */
function slc_contact_capabilities() {
	return array(
		__( 'Communications infrastructure', 'streamlineconnect' ),
		__( 'Power and energy', 'streamlineconnect' ),
		__( 'Modular infrastructure', 'streamlineconnect' ),
		__( 'Data Rooms', 'streamlineconnect' ),
		__( 'Communication Equipment Rooms', 'streamlineconnect' ),
		__( 'Modular Data Centres', 'streamlineconnect' ),
		__( 'Facilities', 'streamlineconnect' ),
	);
}

/**
 * Industry choices for a project enquiry.
 *
 * @return string[]
 */
function slc_contact_industries() {
	return array(
		__( 'Mining and resources', 'streamlineconnect' ),
		__( 'Telecommunications', 'streamlineconnect' ),
		__( 'Energy and utilities', 'streamlineconnect' ),
		__( 'Rail and transport', 'streamlineconnect' ),
		__( 'Government', 'streamlineconnect' ),
	);
}

/**
 * Quote a Contact Form 7 option.
 *
 * @param string $value Option label.
 * @return string
 */
function slc_contact_form_option( $value ) {
	return '"' . str_replace( '"', '', $value ) . '"';
}

/**
 * Contact Form 7 markup. Project fields stay in the form and are shown for project enquiries.
 *
 * @return string
 */
function slc_contact_form_markup() {
	$privacy = slc_contact_html(
		'contact_privacy_text',
		'I have read the <a href="' . esc_url( slc_url( '/privacy-policy/' ) ) . '">Privacy Policy</a> and agree to Streamline Connect using my details to respond to this enquiry.'
	);
	$privacy = wp_kses(
		$privacy,
		array(
			'a' => array(
				'href' => true,
			),
		)
	);

	$capabilities = implode( ' ', array_map( 'slc_contact_form_option', slc_contact_capabilities() ) );
	$industries   = implode( ' ', array_map( 'slc_contact_form_option', slc_contact_industries() ) );

	$field = function ( $label_key, $label, $control ) {
		return '<div class="contact-field"><label>' . esc_html( slc_contact_copy( $label_key, $label ) ) . $control . '</label></div>';
	};

	$markup  = $field( 'contact_label_type', 'Enquiry type (Required)', '[select* enquiry-type id:enquiry-type class:contact-control "Project enquiry" "General enquiry" "Supplier enquiry" "Careers enquiry"]' );
	$markup .= '<div class="contact-project" data-contact-project>';
	$markup .= $field( 'contact_label_capability', 'Capability, solution or product (Optional)', '[select capability id:capability class:contact-control include_blank ' . $capabilities . ']' );
	$markup .= $field( 'contact_label_industry', 'Industry (Optional)', '[select industry id:industry class:contact-control include_blank ' . $industries . ']' );
	$markup .= $field( 'contact_label_location', 'Site location (Optional)', '[text site-location id:site-location class:contact-control]' );
	$markup .= $field( 'contact_label_timeframe', 'Required timeframe (Optional)', '[text timeframe id:timeframe class:contact-control]' );
	$markup .= '</div>';
	$markup .= '<div class="contact-field"><label>' . esc_html( slc_contact_copy( 'contact_label_enquiry', 'Your enquiry (Required)' ) );
	$markup .= '<span class="contact-helper">' . esc_html( slc_contact_copy( 'contact_helper_enquiry', 'Tell us about your project or question, including any requirements or details you already have.' ) ) . '</span>';
	$markup .= '[textarea* enquiry id:enquiry class:contact-control]</label></div>';
	$markup .= '<div class="contact-pair">';
	$markup .= $field( 'contact_label_name', 'Name (Required)', '[text* your-name akismet:author autocomplete:name id:your-name class:contact-control]' );
	$markup .= $field( 'contact_label_company', 'Company (Optional)', '[text company autocomplete:organization id:company class:contact-control]' );
	$markup .= '</div><div class="contact-pair">';
	$markup .= $field( 'contact_label_email', 'Email (Required)', '[email* your-email akismet:author_email autocomplete:email id:your-email class:contact-control]' );
	$markup .= $field( 'contact_label_phone', 'Phone (Optional)', '[tel phone autocomplete:tel id:phone class:contact-control]' );
	$markup .= '</div>';
	$markup .= '<div class="contact-consent"><p class="contact-label">' . esc_html( slc_contact_copy( 'contact_label_privacy', 'Privacy consent (Required)' ) ) . '</p><label class="contact-check">[acceptance privacy] ' . $privacy . '</label></div>';
	$markup .= '[submit class:btn class:contact-submit "' . esc_attr( slc_contact_copy( 'contact_submit_label', 'Send enquiry' ) ) . '"]';

	return $markup;
}

/**
 * Messages from the Contact form-states frame.
 *
 * @return array<string, string>
 */
function slc_contact_form_messages() {
	return array(
		'mail_sent_ok'     => slc_contact_copy( 'contact_success', 'Thanks for contacting Streamline Connect. Your enquiry has been submitted.' ),
		'mail_sent_ng'     => slc_contact_copy( 'contact_error', 'We couldn’t submit your enquiry. Please try again or contact us by phone or email.' ),
		'invalid_required' => slc_contact_copy( 'contact_error_required', 'Please complete this field.' ),
		'invalid_email'    => slc_contact_copy( 'contact_error_email', 'Enter a valid email address.' ),
		'accept_terms'     => slc_contact_copy( 'contact_error_privacy', 'Please confirm that you have read the Privacy Policy.' ),
	);
}

/**
 * Keep Contact Form 7 from adding paragraphs around the designed fields.
 *
 * @param bool              $autop        Whether to wrap the form.
 * @param WPCF7_ContactForm $contact_form Form object.
 * @return bool
 */
function slc_contact_form_autop( $autop ) {
	if ( function_exists( 'slc_is_contact_page' ) && slc_is_contact_page() ) {
		return false;
	}

	return $autop;
}

/**
 * Create or update the enquiry form so Flamingo can store submissions.
 */
function slc_sync_contact_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$markup   = slc_contact_form_markup();
	$messages = slc_contact_form_messages();
	$settings = implode(
		"\n",
		array(
			'flamingo_email: "[your-email]"',
			'flamingo_name: "[your-name]"',
			'flamingo_subject: "[enquiry-type] from [your-name]"',
		)
	);
	$hash     = md5( $markup . wp_json_encode( $messages ) . $settings );
	if ( get_option( 'slc_contact_form_hash' ) === $hash ) {
		return;
	}

	$form_id = (int) get_option( 'slc_contact_form_id' );
	$form    = $form_id ? WPCF7_ContactForm::get_instance( $form_id ) : null;
	if ( ! $form instanceof WPCF7_ContactForm ) {
		$form = WPCF7_ContactForm::get_template(
			array(
				'title' => 'Contact enquiry',
			)
		);
	}

	$mail = $form->prop( 'mail' );
	if ( ! is_array( $mail ) ) {
		$mail = array();
	}
	$mail['active']             = true;
	$mail['recipient']          = 'hello@streamlineconnect.com.au';
	$mail['sender']             = '[_site_title] <[_site_admin_email]>';
	$mail['subject']            = '[enquiry-type] from [your-name]';
	$mail['additional_headers'] = 'Reply-To: [your-name] <[your-email]>';
	$mail['body']               = "Enquiry type: [enquiry-type]\nCapability, solution or product: [capability]\nIndustry: [industry]\nSite location: [site-location]\nRequired timeframe: [timeframe]\n\nEnquiry:\n[enquiry]\n\nName: [your-name]\nCompany: [company]\nEmail: [your-email]\nPhone: [phone]";
	$mail['exclude_blank']      = true;

	$stored = $form->prop( 'messages' );
	if ( ! is_array( $stored ) ) {
		$stored = array();
	}

	$form->set_properties(
		array(
			'form'                => $markup,
			'mail'                => $mail,
			'messages'            => array_merge( $stored, $messages ),
			'additional_settings' => $settings,
		)
	);
	$form->save();

	update_option( 'slc_contact_form_id', $form->id(), false );
	update_option( 'slc_contact_form_hash', $hash, false );
}

/**
 * The Contact Form 7 shortcode for this page.
 *
 * @return string
 */
function slc_contact_form_html() {
	$form_id = (int) get_option( 'slc_contact_form_id' );
	if ( ! $form_id ) {
		return '';
	}

	return do_shortcode( '[contact-form-7 id="' . $form_id . '"]' );
}

/**
 * Put the Contact photographs into the image fields when those fields are empty.
 */
function slc_seed_contact_images() {
	if ( '1' === get_option( 'slc_contact_images_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = slc_contact_page_post();
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	$assets = array(
		'contact_hero_image'  => array( 'images/contact/hero.png', 'Contact hero, communications site at dusk' ),
		'contact_intro_image' => array( 'images/contact/enquiry.jpg', 'Contact, truck crane beside a solar-powered container' ),
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
		update_option( 'slc_contact_images_seeded', '1', false );
	}
}
