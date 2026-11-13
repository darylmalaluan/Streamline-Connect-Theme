<?php
/**
 * Template Name: Leadership
 *
 * Leadership page. Header, enquiry band, and footer are the shared theme sections.
 *
 * @package StreamlineConnect
 */

get_header();

$slc_people = slc_leadership_people();
$slc_total  = count( $slc_people );
?>
<main id="main">
	<section class="hero leadership-hero" aria-label="<?php esc_attr_e( 'Leadership', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'leadership_hero_image',
				'file'          => 'images/our-story/roots.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'leadership_hero_alt', __( 'Two people walking a rocky site toward a tower and a crane.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="leadership-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'leadership_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/about/' ) ); ?>"><?php echo esc_html( slc_plain( 'leadership_breadcrumb_parent', __( 'About', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'leadership_breadcrumb_current', __( 'Leadership', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'leadership_heading', __( 'Leadership', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'leadership_standfirst', __( 'Streamline’s people have experience across construction, telecommunications, electrical systems and modular manufacturing, developed on site, in project teams and in the factory. That expertise extends throughout the business to the people supervising worksites, solving technical problems and delivering projects firsthand. Our directors and senior managers oversee Streamline’s development, projects and commercial relationships.', 'streamlineconnect' ) ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<section class="section leadership-team" data-leadership-carousel aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Leadership team', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<div class="leadership-viewport">
				<ul class="leadership-track">
					<?php foreach ( $slc_people as $person ) : ?>
						<li class="leader-card">
							<?php
							echo slc_picture(
								array(
									'field'  => $person['image'],
									'file'   => $person['file'],
									'width'  => 587,
									'height' => 733,
									'alt'    => $person['alt'],
									'class'  => 'leader-photo',
								)
							);
							?>
							<div class="leader-copy">
								<h2><?php echo esc_html( $person['name'] ); ?></h2>
								<?php if ( '' !== $person['role'] ) : ?>
									<p class="leader-role"><?php echo esc_html( $person['role'] ); ?></p>
								<?php endif; ?>
								<div class="leader-bio"><?php echo wp_kses_post( $person['bio'] ); ?></div>
								<?php if ( '1' === $person['more'] ) : ?>
									<button class="text-link leader-more" type="button" aria-expanded="false"><?php esc_html_e( 'Read more', 'streamlineconnect' ); ?><?php slc_icon( 'arrow-link.svg' ); ?></button>
								<?php endif; ?>
							</div>
							<?php if ( '1' === $person['more'] ) : ?>
								<div class="leader-overlay" hidden>
									<div class="leader-overlay-head">
										<h2><?php echo esc_html( $person['name'] ); ?></h2>
										<button class="text-link text-link--light leader-close" type="button"><?php esc_html_e( 'Close', 'streamlineconnect' ); ?><?php slc_icon( 'arrow-light.svg' ); ?></button>
									</div>
									<?php if ( '' !== $person['role'] ) : ?>
										<p class="leader-role"><?php echo esc_html( $person['role'] ); ?></p>
									<?php endif; ?>
									<div class="leader-overlay-bio"><?php echo wp_kses_post( $person['bio'] ); ?></div>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="leadership-controls">
				<p class="leadership-count" data-leadership-count aria-live="polite"><?php echo esc_html( sprintf( '1–%1$d / %2$d', min( 3, $slc_total ), $slc_total ) ); ?></p>
				<div class="leadership-progress" aria-hidden="true"><span data-leadership-thumb></span></div>
				<div class="leadership-nav">
					<button class="leadership-arrow leadership-arrow--prev" type="button" data-leadership-prev disabled aria-label="<?php esc_attr_e( 'Previous', 'streamlineconnect' ); ?>"><?php slc_icon( 'arrow.svg' ); ?></button>
					<button class="leadership-arrow" type="button" data-leadership-next aria-label="<?php esc_attr_e( 'Next', 'streamlineconnect' ); ?>"><?php slc_icon( 'arrow.svg' ); ?></button>
				</div>
			</div>
		</div>
	</section>

	<section class="leadership-capabilities" aria-labelledby="leadership_team_heading">
		<?php
		echo slc_picture(
			array(
				'field'  => 'leadership_team_image',
				'file'   => 'images/leadership/team.png',
				'width'  => 1920,
				'height' => 720,
				'alt'    => slc_plain( 'leadership_team_alt', __( 'Yellow construction plant and a cable reel on red earth.', 'streamlineconnect' ) ),
				'class'  => 'leadership-capabilities-photo',
			)
		);
		?>
		<div class="leadership-capabilities-scrim" aria-hidden="true"></div>
		<div class="wrap leadership-capabilities-copy">
			<h2 id="leadership_team_heading"><?php echo slc_inline( 'leadership_team_heading', __( 'Team Capabilities', 'streamlineconnect' ) ); ?></h2>
			<div>
				<div class="leadership-capabilities-text"><?php echo slc_rich( 'leadership_team_body', __( 'Streamline’s expertise extends throughout its workforce.

On fibre projects, civil crews and plant operators select construction methods to suit the route and ground conditions. Communications technicians install, test and commission networks, while electricians work on the associated power infrastructure. At Embleton, manufacturing specialists fabricate and fit out equipment rooms, with inspections and testing undertaken before dispatch.

Engineers and project managers coordinate work across these disciplines. Clients can also speak directly with the people who understand the technical details firsthand, including those responsible for installation and commissioning.', 'streamlineconnect' ) ); ?></div>
				<a class="text-link text-link--light" href="<?php echo esc_url( slc_href( 'leadership_team_url', slc_url( '/capabilities/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'leadership_team_link', __( 'Explore our capabilities', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'arrow-light.svg' ); ?></a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
