<?php
/**
 * Shared enquiry band and footer.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$slc_enquiry_heading_field = 'enquiry_heading';
$slc_enquiry_heading       = __( 'Tell us about your project', 'streamlineconnect' );
$slc_enquiry_body_field    = 'enquiry_body';
$slc_enquiry_body          = __( 'Tell us what you\'re planning, where the site is and the programme you\'re working on.', 'streamlineconnect' );
$slc_enquiry_label_field   = 'discuss_enquiry_label';
$slc_enquiry_label         = __( 'Discuss your project.', 'streamlineconnect' );

if ( function_exists( 'slc_is_capabilities_page' ) && slc_is_capabilities_page() ) {
	$slc_enquiry_heading_field = 'capabilities_enquiry_heading';
	$slc_enquiry_body_field    = 'capabilities_enquiry_body';
	$slc_enquiry_body          = __( 'Tell us what you’re planning, and we’ll discuss which parts Streamline can deliver and how they fit the rest of the project.', 'streamlineconnect' );
	$slc_enquiry_label_field   = 'capabilities_enquiry_label';
	$slc_enquiry_label         = __( 'Discuss your project', 'streamlineconnect' );
}

if ( function_exists( 'slc_is_story_page' ) && slc_is_story_page() ) {
	$slc_enquiry_heading_field = 'story_enquiry_heading';
	$slc_enquiry_heading       = __( 'Discuss your project', 'streamlineconnect' );
	$slc_enquiry_body_field    = 'story_enquiry_body';
	$slc_enquiry_body          = __( 'Tell us what you’re planning, where the site is and the programme you’re working to.', 'streamlineconnect' );
	$slc_enquiry_label_field   = 'story_enquiry_label';
	$slc_enquiry_label         = __( 'Discuss your project.', 'streamlineconnect' );
}

if ( function_exists( 'slc_is_communications_page' ) && slc_is_communications_page() ) {
	$slc_enquiry_heading_field = 'comms_enquiry_heading';
	$slc_enquiry_heading       = __( 'Discuss your communications project', 'streamlineconnect' );
	$slc_enquiry_body_field    = 'comms_enquiry_body';
	$slc_enquiry_body          = __( 'Tell us about the network you’re planning, the site and the programme you’re working on. We’ll establish Streamline’s scope and the steps needed to get the work underway.', 'streamlineconnect' );
	$slc_enquiry_label_field   = 'comms_enquiry_label';
	$slc_enquiry_label         = __( 'Discuss your project', 'streamlineconnect' );
}

if ( function_exists( 'slc_is_facilities_page' ) && slc_is_facilities_page() ) {
	$slc_enquiry_heading_field = 'facility_enquiry_heading';
	$slc_enquiry_heading       = __( 'Discuss your<br>facilities project', 'streamlineconnect' );
	$slc_enquiry_body_field    = 'facility_enquiry_body';
	$slc_enquiry_body          = __( 'Tell us which facilities your team needs, how many people they’ll serve and where they’ll be used. We’ll discuss suitable configurations, power options and any supporting infrastructure required.', 'streamlineconnect' );
	$slc_enquiry_label_field   = 'facility_enquiry_label';
	$slc_enquiry_label         = __( 'Discuss your project', 'streamlineconnect' );
}

if ( function_exists( 'slc_is_data_rooms_page' ) && slc_is_data_rooms_page() ) {
	$slc_enquiry_heading_field = 'dataroom_enquiry_heading';
	$slc_enquiry_heading       = __( 'Discuss your<br>Data Room project', 'streamlineconnect' );
	$slc_enquiry_body_field    = 'dataroom_enquiry_body';
	$slc_enquiry_body          = __( 'Tell us what equipment needs housing, the intended location and which services are available. We’ll discuss the room’s configuration and the site connections you need.', 'streamlineconnect' );
	$slc_enquiry_label_field   = 'dataroom_enquiry_label';
	$slc_enquiry_label         = __( 'Discuss your project', 'streamlineconnect' );
}

if ( function_exists( 'slc_is_modular_page' ) && slc_is_modular_page() ) {
	$slc_enquiry_heading_field = 'modular_enquiry_heading';
	$slc_enquiry_heading       = __( 'Discuss your<br>Data Room project', 'streamlineconnect' );
	$slc_enquiry_body_field    = 'modular_enquiry_body';
	$slc_enquiry_body          = __( 'Tell us what infrastructure you’re planning, where the room will operate and what services are already available. We’ll work through the manufacturing requirements and any site works needed for installation.', 'streamlineconnect' );
	$slc_enquiry_label_field   = 'modular_enquiry_label';
	$slc_enquiry_label         = __( 'Discuss your project', 'streamlineconnect' );
}
?>
<!-- Enquiry band: headline, then the note and button. Capabilities uses its own copy. -->
<section class="enquiry" aria-labelledby="<?php echo esc_attr( slc_content_id( $slc_enquiry_heading_field, 'enquiry_heading' ) ); ?>">
	<div class="wrap enquiry-layout">
		<h2<?php echo slc_attr_html( $slc_enquiry_heading_field, '', 'enquiry_heading' ); ?> data-reveal style="--i:0"><?php echo slc_inline( $slc_enquiry_heading_field, $slc_enquiry_heading ); ?></h2>
		<div class="enquiry-copy">
			<div<?php echo slc_attr_html( $slc_enquiry_body_field ); ?> data-reveal style="--i:1"><?php echo slc_rich( $slc_enquiry_body_field, $slc_enquiry_body ); ?></div>
			<a<?php echo slc_attr_html( $slc_enquiry_label_field, 'btn' ); ?> data-reveal style="--i:2" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( $slc_enquiry_label_field, $slc_enquiry_label ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
		</div>
	</div>
</section>
<!-- Footer: brand column, then the link columns and contact. -->
<footer class="site-footer">
	<?php // HOME-FIGMA-UPDATE: Footer-top is full-bleed so the divider spans the section width. ?>
	<div class="footer-top">
		<!-- Brand: logo, then the accreditation label and the three ISO marks. -->
		<div class="footer-brand">
			<a class="logo" href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php
				echo slc_picture(
					array(
						'field'      => 'footer_logo',
						'file'       => 'images/logo-footer.svg',
						'width'      => 240,
						'height'     => 31,
						'alt'        => 'Streamline Connect',
						'attr_field' => 'footer_logo',
					)
				);
			?></a>
			<div class="accreditations">
				<p<?php echo slc_attr_html( 'accreditations_label' ); ?>><?php echo esc_html( slc_plain( 'accreditations_label', __( 'Accreditations & licences', 'streamlineconnect' ) ) ); ?></p>
				<ul>
					<li><?php echo slc_picture( array( 'field' => 'iso_9001', 'file' => 'images/iso-9001.png', 'width' => 58, 'height' => 128, 'alt' => __( 'ISO 9001 quality management', 'streamlineconnect' ), 'attr_field' => 'iso_9001' ) ); ?></li>
					<li><?php echo slc_picture( array( 'field' => 'iso_45001', 'file' => 'images/iso-45001.png', 'width' => 58, 'height' => 128, 'alt' => __( 'ISO 45001 occupational health and safety', 'streamlineconnect' ), 'attr_field' => 'iso_45001' ) ); ?></li>
					<li><?php echo slc_picture( array( 'field' => 'iso_14001', 'file' => 'images/iso-14001.png', 'width' => 58, 'height' => 128, 'alt' => __( 'ISO 14001 environmental management', 'streamlineconnect' ), 'attr_field' => 'iso_14001' ) ); ?></li>
				</ul>
			</div>
		</div>
		<!-- Link columns from the sitemap, with contact as the last column. -->
		<div class="footer-columns">
			<?php foreach ( slc_footer_columns() as $column ) : ?>
				<nav class="footer-col" aria-label="<?php echo esc_attr( $column['heading'] ); ?>">
					<h2><?php echo esc_html( $column['heading'] ); ?></h2>
					<ul>
						<?php foreach ( $column['links'] as $link ) : ?>
							<li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
			<div class="footer-col">
				<h2><?php esc_html_e( 'Contact', 'streamlineconnect' ); ?></h2>
				<ul>
					<li><a<?php echo slc_attr_html( 'footer_email' ); ?> href="mailto:<?php echo esc_attr( slc_plain( 'footer_email', 'hello@streamlineconnect.com.au' ) ); ?>"><?php echo esc_html( slc_plain( 'footer_email', 'hello@streamlineconnect.com.au' ) ); ?></a></li>
					<?php
					$slc_footer_phone = slc_plain( 'footer_phone', '' ); // HOME-FIGMA-UPDATE: hidden until a real number is saved
					if ( '' !== $slc_footer_phone ) :
						$slc_footer_tel = preg_replace( '/[^0-9+]/', '', $slc_footer_phone );
						?>
						<li><a<?php echo slc_attr_html( 'footer_phone' ); ?> href="tel:<?php echo esc_attr( $slc_footer_tel ); ?>"><?php echo esc_html( $slc_footer_phone ); ?></a></li>
					<?php endif; ?>
					<li<?php echo slc_attr_html( 'footer_location' ); ?>><?php echo esc_html( slc_plain( 'footer_location', __( 'Perth, Western Australia', 'streamlineconnect' ) ) ); ?></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- Legal bar: copyright, policy links, then back to top. -->
	<div class="legal">
		<p<?php echo slc_attr_html( 'footer_copyright', 'legal-copy' ); ?>><?php echo esc_html( slc_plain( 'footer_copyright', __( '© 2026 Streamline Connect Pty Ltd', 'streamlineconnect' ) ) ); ?></p>
		<a<?php echo slc_attr_html( 'legal_privacy' ); ?> href="<?php echo esc_url( slc_url( '/privacy-policy/' ) ); ?>"><?php echo esc_html( slc_plain( 'legal_privacy', __( 'Privacy', 'streamlineconnect' ) ) ); ?></a>
		<a<?php echo slc_attr_html( 'legal_terms' ); ?> href="<?php echo esc_url( slc_url( '/terms/' ) ); ?>"><?php echo esc_html( slc_plain( 'legal_terms', __( 'Terms', 'streamlineconnect' ) ) ); ?></a>
		<a<?php echo slc_attr_html( 'legal_accessibility' ); ?> href="<?php echo esc_url( slc_url( '/accessibility/' ) ); ?>"><?php echo esc_html( slc_plain( 'legal_accessibility', __( 'Accessibility', 'streamlineconnect' ) ) ); ?></a>
		<a<?php echo slc_attr_html( 'legal_top' ); ?> href="#top"><?php echo esc_html( slc_plain( 'legal_top', __( 'Back to top ↑', 'streamlineconnect' ) ) ); ?></a>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
