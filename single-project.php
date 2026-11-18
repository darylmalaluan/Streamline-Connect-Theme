<?php
/**
 * Single project detail.
 *
 * Replaces the earlier case study layout. The previous template is kept in
 * single-project.backup.php. Header, enquiry band, and footer are shared.
 *
 * @package StreamlineConnect
 */

get_header();

while ( have_posts() ) :
	the_post();
	$slc_project_id = get_the_ID();
	$slc_terms      = slc_project_categories( $slc_project_id );
	$slc_industry   = array();
	foreach ( $slc_terms as $slc_term ) {
		$slc_industry[] = $slc_term->name;
	}
	$slc_feature = slc_attachment_id( slc_raw( 'case_feature_image' ) );
	$slc_feature = ( $slc_feature && slc_attachment_exists( $slc_feature ) ) ? $slc_feature : 0;
	$slc_pdf     = slc_case_pdf();
	$slc_others  = array();
	foreach ( slc_project_listing_cards() as $slc_card ) {
		if ( (int) $slc_card['id'] !== (int) $slc_project_id ) {
			$slc_others[] = $slc_card;
		}
	}
	?>
<main id="main" class="project-detail">
	<section class="project-detail-hero" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<div class="wrap project-detail-hero-body">
			<nav class="projects-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'streamlineconnect' ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/projects/' ) ); ?>"><?php esc_html_e( 'Projects', 'streamlineconnect' ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php the_title(); ?></span>
			</nav>
			<div class="project-detail-hero-copy">
				<h1><?php the_title(); ?></h1>
				<dl class="project-facts">
					<div>
						<dt><?php echo esc_html( slc_plain( 'case_client_label', __( 'Client', 'streamlineconnect' ) ) ); ?></dt>
						<dd><?php echo esc_html( slc_plain( 'case_client', __( 'Company name', 'streamlineconnect' ) ) ); ?></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Capability', 'streamlineconnect' ); ?></dt>
						<dd><?php echo esc_html( slc_plain( 'case_capability', '' ) ); ?></dd>
					</div>
					<div>
						<dt><?php echo esc_html( slc_plain( 'case_industry_label', __( 'Industry', 'streamlineconnect' ) ) ); ?></dt>
						<dd><?php echo esc_html( implode( ' / ', $slc_industry ) ); ?></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Region', 'streamlineconnect' ); ?></dt>
						<dd><?php echo esc_html( slc_plain( 'case_location', __( 'Project location', 'streamlineconnect' ) ) ); ?></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Status', 'streamlineconnect' ); ?></dt>
						<dd><?php echo esc_html( slc_plain( 'case_status', __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'streamlineconnect' ) ) ); ?></dd>
					</div>
				</dl>
			</div>
		</div>
	</section>

	<section class="project-feature">
		<div class="wrap">
			<div class="project-feature-media">
				<?php if ( $slc_feature ) : ?>
					<?php
					echo wp_get_attachment_image(
						$slc_feature,
						'full',
						false,
						array(
							'alt' => slc_plain( 'case_feature_alt', get_the_title() ),
						)
					);
					?>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="section project-overview">
		<div class="wrap">
			<div class="project-overview-copy">
				<?php echo slc_rich( 'case_background', __( 'Briefly explain who the client is, the operating context and what the client needed to achieve.', 'streamlineconnect' ) ); ?>
				<?php if ( $slc_pdf ) : ?>
					<a class="text-link" href="<?php echo esc_url( $slc_pdf['url'] ); ?>" download="<?php echo esc_attr( $slc_pdf['name'] ); ?>"><?php echo esc_html( slc_plain( 'case_pdf_label', __( 'Lorem ipsum dolor sit amet.', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="project-gallery" aria-label="<?php echo esc_attr( slc_plain( 'case_images_heading', __( 'Project images', 'streamlineconnect' ) ) ); ?>">
		<div class="wrap">
			<ul class="project-gallery-grid">
				<?php foreach ( slc_case_images() as $image ) : ?>
					<?php $slc_gallery = slc_attachment_id( slc_raw( $image['field'] ) ); ?>
					<li>
						<?php if ( $slc_gallery && slc_attachment_exists( $slc_gallery ) ) : ?>
							<?php echo wp_get_attachment_image( $slc_gallery, 'large', false, array( 'alt' => $image['alt'] ) ); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<?php if ( $slc_others ) : ?>
		<section class="section" aria-labelledby="other_projects">
			<div class="wrap">
				<h2 class="section-heading" id="other_projects" tabindex="-1"><?php echo esc_html( slc_plain( 'case_other_heading', __( 'Lorem ipsum dolor sit amet.', 'streamlineconnect' ) ) ); ?></h2>
				<div class="project-grid">
					<?php foreach ( $slc_others as $card ) : ?>
						<a class="project-card" href="<?php echo esc_url( $card['url'] ); ?>">
							<div class="project-card-media">
								<?php if ( $card['image'] ) : ?>
									<?php echo wp_get_attachment_image( $card['image'], 'large', false, array( 'alt' => $card['alt'] ) ); ?>
								<?php endif; ?>
							</div>
							<div class="project-card-copy">
								<?php if ( '' !== $card['capability'] ) : ?>
									<p class="project-card-capability"><?php echo esc_html( $card['capability'] ); ?></p>
								<?php endif; ?>
								<p class="project-card-title"><?php echo esc_html( $card['title'] ); ?></p>
							</div>
							<dl class="project-card-meta">
								<div>
									<dt><?php echo esc_html( slc_plain( 'projects_client_label', __( 'Client', 'streamlineconnect' ) ) ); ?></dt>
									<dd><?php echo esc_html( $card['client'] ); ?></dd>
								</div>
								<div>
									<dt><?php echo esc_html( slc_plain( 'projects_region_label', __( 'Region', 'streamlineconnect' ) ) ); ?></dt>
									<dd><?php echo esc_html( $card['region'] ); ?></dd>
								</div>
							</dl>
							<span class="project-card-action"><span class="bar-link"><?php echo esc_html( slc_plain( 'projects_view_label', __( 'View project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></span></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>
	<?php
endwhile;

get_footer();
