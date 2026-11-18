<?php
/**
 * Template Name: Power and Energy
 *
 * Power and Energy page. Header, enquiry band, and footer are the shared theme sections.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero power-hero" aria-label="<?php esc_attr_e( 'Power and Energy', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'power_hero_image',
				'file'          => 'images/power/hero.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'power_hero_alt', __( 'Solar array beside a communications tower and equipment building.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="power-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'power_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/capabilities/' ) ); ?>"><?php echo esc_html( slc_plain( 'power_breadcrumb_parent', __( 'Capabilities', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'power_breadcrumb_current', __( 'Power & Energy', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'power_heading', __( 'Power systems backed<br>by construction and manufacturing', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'power_standfirst', __( 'We install and upgrade low-voltage electrical infrastructure and deliver renewable, hybrid and stand-alone remote power systems, including monitoring and control. Streamline’s electricians work alongside our civil crews preparing sites and the technicians fitting out modular facilities. They understand the groundworks, equipment connections and maintenance access that an electrical installation depends on.

Planning around those requirements before equipment reaches site reduces the risk of difficult, costly alterations after installation.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php echo esc_attr( slc_plain( 'power_jump_label', __( 'On this page', 'streamlineconnect' ) ) ); ?>">
					<p><?php echo esc_html( slc_plain( 'power_jump_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_power_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_url( '/contact/?capability=power-and-energy' ) ); ?>"><?php echo esc_html( slc_plain( 'power_hero_button', __( 'Discuss your power project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>

	<section class="section power-services" aria-label="<?php esc_attr_e( 'Power and electrical services', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<ul class="power-rows">
				<?php foreach ( slc_power_services() as $service ) : ?>
					<li class="power-row" id="<?php echo esc_attr( $service['anchor'] ); ?>" tabindex="-1">
						<?php if ( '' !== $service['file'] ) : ?>
							<?php
							echo slc_picture(
								array(
									'field'  => $service['image'],
									'file'   => $service['file'],
									'width'  => 716,
									'height' => 477,
									'alt'    => $service['alt'],
									'class'  => 'power-row-photo',
								)
							);
							?>
						<?php else : ?>
							<div class="power-row-placeholder" aria-hidden="true"></div>
						<?php endif; ?>
						<div class="power-row-copy">
							<div>
								<h2><?php echo wp_kses( $service['title'], array( 'br' => array(), 'em' => array(), 'strong' => array() ) ); ?></h2>
								<div class="power-row-text"><?php echo wp_kses_post( $service['text'] ); ?></div>
							</div>
							<div class="power-row-links">
								<?php foreach ( $service['links'] as $link ) : ?>
									<a class="text-link" href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="section section--grey power-projects" aria-labelledby="related_projects">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="related_projects" tabindex="-1"><?php echo slc_inline( 'power_projects_heading', __( 'Related projects', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'power_projects_intro', __( 'Explore Streamline’s electrical, renewable energy and remote power projects. See how our teams install power systems around the equipment, site services and operating conditions they need to support.', 'streamlineconnect' ) ); ?></div>
			</div>
		</div>
		<article class="project">
			<?php
			echo slc_picture(
				array(
					'field'  => 'power_project_image',
					'file'   => 'images/power/project.jpg',
					'width'  => 716,
					'height' => 477,
					'alt'    => slc_plain( 'power_project_alt', __( 'Zero Emission Rooms at a remote site in warm evening light.', 'streamlineconnect' ) ),
					'class'  => 'power-project-photo',
				)
			);
			?>
			<div class="project-copy">
				<h3><?php echo esc_html( slc_plain( 'power_project_title', __( 'Rio Tinto rail operations', 'streamlineconnect' ) ) ); ?></h3>
				<div class="project-summary"><?php echo slc_rich( 'power_project_summary', __( 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.', 'streamlineconnect' ) ); ?></div>
				<ul class="chips">
					<li><?php echo esc_html( slc_plain( 'power_project_chip_1', __( 'Facilities', 'streamlineconnect' ) ) ); ?></li>
					<li><?php echo esc_html( slc_plain( 'power_project_chip_2', __( 'Power', 'streamlineconnect' ) ) ); ?></li>
				</ul>
			</div>
			<div class="project-spec">
				<dl>
					<div><dt><?php esc_html_e( 'Sector', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'power_project_sector', __( 'Mining and resources', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Client', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'power_project_client', __( 'Mining operator', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Location', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'power_project_location', __( 'Pilbara, WA', 'streamlineconnect' ) ) ); ?></dd></div>
				</dl>
			</div>
		</article>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_href( 'power_projects_url', slc_url( '/projects/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'power_projects_bar', __( 'View our projects.', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
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
