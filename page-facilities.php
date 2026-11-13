<?php
/**
 * Template Name: Facilities
 *
 * Facilities page. Header, How we deliver, Why Streamline, and the footer are shared.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero facility-hero" aria-label="<?php esc_attr_e( 'Facilities', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'facility_hero_image',
				'file'          => 'images/facilities/hero.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'facility_hero_alt', __( 'A row of white Zero Emission Rooms with air conditioners.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="facility-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'facility_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/products/' ) ); ?>"><?php echo esc_html( slc_plain( 'facility_breadcrumb_parent', __( 'Products', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'facility_breadcrumb_current', __( 'Facilities', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'facility_heading', __( 'Modular offices and<br>amenities for remote sites', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'facility_standfirst', __( 'The first people to use Streamline’s Zero Emission Rooms were our own crews. We needed offices and amenities that could operate without permanent mains power or a separate diesel generator. So we developed our own.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php esc_attr_e( 'Explore facilities', 'streamlineconnect' ); ?>">
					<p><?php echo esc_html( slc_plain( 'facility_jump_label', __( 'Explore facilities', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_facilities_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_plain( 'facility_hero_button', __( 'Discuss your facilities project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>

	<section class="section facility-overview">
		<div class="wrap facility-overview-row">
			<div class="facility-overview-text"><?php echo slc_rich( 'facility_overview', __( 'Those facilities now serve other project teams too. Our Zero Emission Rooms (ZER) incorporate solar generation, battery storage and intelligent power management into site offices, crib rooms, respite spaces and ablution facilities.

Without a separate diesel generator, crews have a quieter environment for work and breaks, while site teams avoid the associated refuelling and routine engine servicing. Standard ZER configurations are available for hire or purchase, with customised options for different requirements.', 'streamlineconnect' ) ); ?></div>
			<?php
			echo slc_picture(
				array(
					'field'  => 'facility_logo',
					'file'   => 'images/facilities/zer-logo.svg',
					'width'  => 304,
					'height' => 200,
					'alt'    => slc_plain( 'facility_logo_alt', __( 'Zero Emission Rooms', 'streamlineconnect' ) ),
					'class'  => 'facility-logo',
				)
			);
			?>
		</div>
	</section>

	<section class="section section--navy facility-explore" aria-labelledby="explore_our_facilities">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="explore_our_facilities" tabindex="-1"><?php echo slc_inline( 'facility_explore_heading', __( 'Explore our facilities', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'facility_explore_intro', __( 'Browse the full range by application, power type and size, including our Zero Emission Rooms. From a single site office to amenities for a larger compound, you can choose facilities according to their intended use, occupancy and available services. For sites with suitable mains power, Streamline also manufactures grid-connected facilities. Layouts and fittings are tailored to their intended purpose, with associated electrical installations available through our teams.', 'streamlineconnect' ) ); ?></div>
			</div>
			<ul class="facility-cards">
				<?php foreach ( slc_facilities_cards() as $card ) : ?>
					<li class="facility-card" id="<?php echo esc_attr( $card['anchor'] ); ?>" tabindex="-1">
						<?php
						echo slc_picture(
							array(
								'field'  => $card['image'],
								'file'   => $card['file'],
								'width'  => 371,
								'height' => 235,
								'alt'    => $card['alt'],
								'class'  => 'facility-card-photo',
							)
						);
						?>
						<div class="facility-card-copy">
							<h3><?php echo wp_kses_post( $card['title'] ); ?></h3>
							<div><?php echo wp_kses_post( $card['text'] ); ?></div>
						</div>
						<a class="text-link text-link--light" href="<?php echo esc_url( $card['url'] ); ?>"><?php echo esc_html( $card['link'] ); ?><?php slc_icon( 'arrow-light.svg' ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_plain( 'facility_explore_bar', __( 'Discuss your project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
	</section>

	<section class="section facility-project" aria-labelledby="related_projects">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="related_projects" tabindex="-1"><?php echo slc_inline( 'facility_projects_heading', __( 'Related projects', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'facility_projects_intro', __( 'Streamline’s Zero Emission offices, crib rooms and ablution blocks supported crews installing a major wireless network at a Pilbara mine site. Powered by integrated solar and battery systems, they provided the project team with offices and amenities without separate diesel generators.', 'streamlineconnect' ) ); ?></div>
			</div>
		</div>
		<article class="project">
			<?php
			echo slc_picture(
				array(
					'field'  => 'facility_project_image',
					'file'   => 'images/facilities/project.jpg',
					'width'  => 716,
					'height' => 477,
					'alt'    => slc_plain( 'facility_project_alt', __( 'Zero Emission Rooms lined along a red-dirt track at sunset.', 'streamlineconnect' ) ),
					'class'  => 'facility-project-photo',
				)
			);
			?>
			<div class="project-copy">
				<h3><?php echo esc_html( slc_plain( 'facility_project_title', __( 'Rio Tinto rail operations', 'streamlineconnect' ) ) ); ?></h3>
				<div class="project-summary"><?php echo slc_rich( 'facility_project_summary', __( 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.', 'streamlineconnect' ) ); ?></div>
				<ul class="chips">
					<li><?php echo esc_html( slc_plain( 'facility_project_chip_1', __( 'Facilities', 'streamlineconnect' ) ) ); ?></li>
					<li><?php echo esc_html( slc_plain( 'facility_project_chip_2', __( 'Power', 'streamlineconnect' ) ) ); ?></li>
				</ul>
			</div>
			<div class="project-spec">
				<dl>
					<div><dt><?php esc_html_e( 'Sector', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'facility_project_sector', __( 'Mining and resources', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Client', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'facility_project_client', __( 'Mining operator', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Location', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'facility_project_location', __( 'Pilbara, WA', 'streamlineconnect' ) ) ); ?></dd></div>
				</dl>
			</div>
		</article>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_href( 'facility_projects_url', slc_url( '/projects/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'facility_projects_bar', __( 'Explore projects', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
	</section>

	<section class="facility-built" aria-labelledby="facility_built_heading">
		<?php
		echo slc_picture(
			array(
				'field'  => 'facility_built_image',
				'file'   => 'images/facilities/built.jpg',
				'width'  => 1920,
				'height' => 720,
				'alt'    => slc_plain( 'facility_built_alt', __( 'Manufacturing bay for modular facilities.', 'streamlineconnect' ) ),
				'class'  => 'facility-built-photo',
			)
		);
		?>
		<div class="facility-built-scrim" aria-hidden="true"></div>
		<div class="wrap facility-built-copy">
			<h2 id="facility_built_heading"><?php echo slc_inline( 'facility_built_heading', __( 'Built here.<br>Delivered with confidence.', 'streamlineconnect' ) ); ?></h2>
			<div>
				<div class="facility-built-text"><?php echo slc_rich( 'facility_built_body', __( 'We manufacture and fit out our facilities at Embleton, Western Australia. We incorporate the specified interiors and electrical systems before dispatch, with the remaining site requirements established for installation.', 'streamlineconnect' ) ); ?></div>
				<a class="text-link text-link--light" href="<?php echo esc_url( slc_href( 'facility_built_url', slc_url( '/capabilities/modular-infrastructure/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'facility_built_link', __( 'Explore our modular infrastructure capability', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'arrow-light.svg' ); ?></a>
			</div>
		</div>
	</section>

	<section class="section delivery" aria-labelledby="how_we_deliver">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="how_we_deliver" tabindex="-1"><?php echo slc_inline( 'delivery_heading', __( 'How We Deliver', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'delivery_intro', __( 'Streamline can deliver a defined construction or installation package, or take on a project from design through to support. We’ll agree which stages you need us to deliver, with site construction and manufacturing planned in parallel on combined projects.', 'streamlineconnect' ) ); ?></div>
			</div>
			<ol class="stage-grid">
				<?php foreach ( slc_stages() as $stage ) : ?>
					<li class="stage" tabindex="0">
						<div class="stage-top">
							<p><span class="stage-index"><?php echo esc_html( $stage['index'] ); ?></span><?php if ( $stage['parallel'] ) : ?><span class="parallel"><?php slc_icon( 'parallel.svg' ); ?><?php esc_html_e( 'Runs in parallel', 'streamlineconnect' ); ?></span><?php endif; ?></p>
							<?php slc_icon( 'arrow-stage.svg' ); ?>
						</div>
						<h3><?php echo esc_html( $stage['title'] ); ?></h3>
						<div><?php echo slc_rich( $stage['text_field'], $stage['text'] ); ?></div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( 'discuss_delivery_label' ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
	</section>

	<section class="section section--navy why" aria-labelledby="why_streamline">
		<div class="wrap">
			<h2 class="section-heading" id="why_streamline" tabindex="-1"><?php echo slc_inline( 'why_heading', __( 'Why Streamline', 'streamlineconnect' ) ); ?></h2>
			<ol class="reason-grid">
				<?php foreach ( slc_reasons() as $reason ) : ?>
					<li>
						<p class="reason-index"><span aria-hidden="true">›</span> <?php echo esc_html( $reason['index'] ); ?></p>
						<h3><?php echo esc_html( $reason['title'] ); ?></h3>
						<div><?php echo slc_rich( $reason['text_field'], $reason['text'] ); ?></div>
					</li>
				<?php endforeach; ?>
			</ol>
			<dl class="stats">
				<?php foreach ( slc_stats() as $stat ) : ?>
					<div>
						<dt><?php echo esc_html( $stat['label'] ); ?></dt>
						<dd>
							<?php if ( '' !== $stat['prefix'] ) : ?><span class="stat-prefix"><?php echo esc_html( $stat['prefix'] ); ?></span><?php endif; ?>
							<span class="stat-figure"><?php echo esc_html( $stat['figure'] ); ?></span>
							<?php if ( '' !== $stat['suffix'] ) : ?><span class="stat-suffix"><?php echo esc_html( $stat['suffix'] ); ?></span><?php endif; ?>
						</dd>
					</div>
				<?php endforeach; ?>
			</dl>
		</div>
	</section>
</main>
<?php
get_footer();
