<?php
/**
 * Template Name: Privacy Policy
 *
 * Privacy Policy page. Header and footer are the shared theme sections.
 * This page has no enquiry band.
 *
 * @package StreamlineConnect
 */

get_header();

$slc_privacy_sections = slc_privacy_sections();
?>
<main id="main">
	<section class="privacy-title">
		<div class="wrap privacy-title-layout">
			<div>
				<nav class="privacy-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
					<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'privacy_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
					<span aria-hidden="true">/</span>
					<span aria-current="page"><?php echo esc_html( slc_plain( 'privacy_breadcrumb_current', __( 'Privacy Policy', 'streamlineconnect' ) ) ); ?></span>
				</nav>
				<h1><?php echo slc_inline( 'privacy_heading', __( 'Privacy Policy', 'streamlineconnect' ) ); ?></h1>
			</div>
			<div class="privacy-intro"><?php echo slc_rich( 'privacy_intro', __( 'Streamline Connect Pty Ltd (“we”, “our”, or “us”) respects your privacy and is committed to protecting the personal information you provide to us. This Privacy Policy outlines how we collect, use, store, and disclose your personal data, including through our website.', 'streamlineconnect' ) ); ?></div>
		</div>
	</section>
	<section class="privacy-body">
		<div class="wrap privacy-layout">
			<nav class="privacy-toc" aria-label="<?php echo esc_attr( slc_plain( 'privacy_toc_label', __( 'On this page', 'streamlineconnect' ) ) ); ?>" data-legal-toc>
				<p><?php echo esc_html( slc_plain( 'privacy_toc_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
				<ul>
					<?php foreach ( $slc_privacy_sections as $section ) : ?>
						<li><a href="#<?php echo esc_attr( $section['id'] ); ?>"><?php echo wp_strip_all_tags( $section['heading'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
			<div class="privacy-sections">
				<?php foreach ( $slc_privacy_sections as $index => $section ) : ?>
					<section id="<?php echo esc_attr( $section['id'] ); ?>" tabindex="-1">
						<h2><?php echo wp_kses( $section['heading'], array( 'br' => array(), 'em' => array(), 'strong' => array() ) ); ?></h2>
						<div class="privacy-copy"><?php echo wp_kses_post( $section['body'] ); ?></div>
						<?php if ( 'use_of_google_analytics' === $section['id'] ) : ?>
							<a class="text-link" href="<?php echo esc_url( slc_href( 'privacy_analytics_url', 'https://tools.google.com/dlpage/gaoptout' ) ); ?>"><?php echo esc_html( slc_plain( 'privacy_analytics_label', __( 'Google Analytics Opt-out Browser Add-on', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
						<?php endif; ?>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
