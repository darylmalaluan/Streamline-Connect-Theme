<?php
/**
 * Template Name: Projects
 *
 * Projects listing. Header, enquiry band, and footer are shared.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero projects-hero" aria-label="<?php esc_attr_e( 'Projects', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'projects_hero_image',
				'file'          => 'images/projects/hero.jpg',
				'width'         => 1920,
				'height'        => 729,
				'alt'           => slc_plain( 'projects_hero_alt', __( 'Modular facilities and solar arrays on a remote site.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="projects-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'projects_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'projects_breadcrumb_current', __( 'Projects', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'projects_heading', __( 'Projects', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'projects_intro', __( 'From communications networks to power systems and modular facilities, see Streamline\'s experience on actual projects. These case studies cover the challenges clients faced, the work our teams undertook and what they delivered.', 'streamlineconnect' ) ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<section class="section" aria-labelledby="project_case_studies">
		<div class="wrap">
			<h2 class="section-heading" id="project_case_studies" tabindex="-1"><?php echo slc_inline( 'projects_list_heading', __( 'Project case studies', 'streamlineconnect' ) ); ?></h2>
			<?php $slc_cards = slc_project_listing_cards(); ?>
			<?php if ( $slc_cards ) : ?>
				<div class="project-grid">
					<?php foreach ( $slc_cards as $card ) : ?>
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
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
