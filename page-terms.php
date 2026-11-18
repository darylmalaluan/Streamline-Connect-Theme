<?php
/**
 * Template Name: Legal Terms
 *
 * Legal Terms and Company Policies. Header and footer are the shared theme sections.
 * This page has no enquiry band.
 *
 * @package StreamlineConnect
 */

get_header();

$slc_terms_documents = slc_terms_documents();
?>
<main id="main">
	<section class="terms-title">
		<div class="wrap terms-title-layout">
			<div>
				<nav class="terms-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
					<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'terms_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
					<span aria-hidden="true">/</span>
					<span aria-current="page"><?php echo esc_html( slc_plain( 'terms_breadcrumb_current', __( 'Legal Terms & Company Policies', 'streamlineconnect' ) ) ); ?></span>
				</nav>
				<h1><?php echo slc_inline( 'terms_heading', __( 'Legal Terms &<br>Company Policies', 'streamlineconnect' ) ); ?></h1>
			</div>
			<div class="terms-intro"><?php echo slc_rich( 'terms_intro', __( 'Find Streamline Connect’s Purchase Order Terms and Conditions and company policies below. These documents outline our purchasing conditions and our commitments to workplace health and safety, environmental management and quality.

Suppliers and other relevant parties should review the applicable documents to understand the requirements and responsibilities associated with working with Streamline Connect.', 'streamlineconnect' ) ); ?></div>
		</div>
	</section>
	<section class="terms-body">
		<div class="wrap terms-layout">
			<nav class="terms-toc" aria-label="<?php echo esc_attr( slc_plain( 'terms_toc_label', __( 'On this page', 'streamlineconnect' ) ) ); ?>" data-legal-toc>
				<p><?php echo esc_html( slc_plain( 'terms_toc_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
				<ul>
					<?php foreach ( $slc_terms_documents as $document ) : ?>
						<li><a href="#<?php echo esc_attr( $document['id'] ); ?>"><?php echo wp_strip_all_tags( $document['heading'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
			<div class="terms-sections">
				<?php foreach ( $slc_terms_documents as $document ) : ?>
					<section id="<?php echo esc_attr( $document['id'] ); ?>" tabindex="-1">
						<h2><?php echo wp_kses( $document['heading'], array( 'br' => array(), 'em' => array(), 'strong' => array() ) ); ?></h2>
						<div class="terms-copy"><?php echo wp_kses_post( $document['body'] ); ?></div>
						<?php if ( file_exists( get_theme_file_path( 'assets/documents/' . $document['file'] ) ) ) : ?>
							<a class="text-link" href="<?php echo esc_url( $document['url'] ); ?>" download><?php echo esc_html( $document['link'] ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
						<?php endif; ?>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
