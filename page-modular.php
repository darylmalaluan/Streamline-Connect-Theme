<?php
/**
 * Template Name: Modular Infrastructure
 *
 * Modular Infrastructure. Header, How we deliver, Why Streamline, and the footer are shared.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero modular-hero" aria-label="<?php esc_attr_e( 'Modular Infrastructure', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'modular_hero_image',
				'file'          => 'images/facilities/hero.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'modular_hero_alt', __( 'A row of white modular rooms with air conditioners.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="modular-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'modular_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/capabilities/' ) ); ?>"><?php echo esc_html( slc_plain( 'modular_breadcrumb_parent', __( 'Capabilities', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'modular_breadcrumb_current', __( 'Modular Infrastructure', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'modular_heading', __( 'Modular Data Rooms with the groundwork covered', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'modular_standfirst', __( 'Communication Equipment Rooms (CERs) and Modular Data Centres (MDCs) house critical communications and IT equipment. Their power, cooling and protection systems must meet the equipment’s requirements, while foundations and site connections need to be ready when the room arrives.

Streamline brings these requirements into the project from the start. We manufacture both room types at Embleton, Western Australia, with our own civil, electrical and communications crews available to undertake the supporting site infrastructure. The people preparing the destination understand what the room needs, and the manufacturing team knows what awaits it on site.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php esc_attr_e( 'On this page', 'streamlineconnect' ); ?>">
					<p><?php echo esc_html( slc_plain( 'modular_jump_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_modular_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_plain( 'modular_hero_button', __( 'Discuss your Data Room project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>

	<section class="section modular-rows" aria-label="<?php esc_attr_e( 'Modular infrastructure', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<ul class="modular-list">
				<?php foreach ( slc_modular_rows() as $row ) : ?>
					<li class="modular-row" id="<?php echo esc_attr( $row['anchor'] ); ?>" tabindex="-1">
						<?php
						echo slc_picture(
							array(
								'field'  => $row['image'],
								'file'   => $row['file'],
								'width'  => 716,
								'height' => 477,
								'alt'    => $row['alt'],
								'class'  => 'modular-row-photo',
							)
						);
						?>
						<div class="modular-row-copy">
							<div>
								<h2><?php echo wp_kses_post( $row['title'] ); ?></h2>
								<div class="modular-row-text"><?php echo wp_kses_post( $row['text'] ); ?></div>
							</div>
							<a class="text-link" href="<?php echo esc_url( $row['url'] ); ?>"><?php echo esc_html( $row['link'] ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="section section--grey modular-project" aria-labelledby="modular_projects">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="modular_projects" tabindex="-1"><?php echo slc_inline( 'modular_projects_heading', __( 'Modular projects', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'modular_projects_intro', __( 'See how Streamline applies its modular manufacturing and construction capability on projects, from factory fit-out to installation and site connections.', 'streamlineconnect' ) ); ?></div>
			</div>
		</div>
		<article class="project">
			<?php
			echo slc_picture(
				array(
					'field'  => 'modular_project_image',
					'file'   => 'images/facilities/project.jpg',
					'width'  => 716,
					'height' => 477,
					'alt'    => slc_plain( 'modular_project_alt', __( 'Zero Emission Rooms lined along a red-dirt track at sunset.', 'streamlineconnect' ) ),
					'class'  => 'modular-project-photo',
				)
			);
			?>
			<div class="project-copy">
				<h3><?php echo esc_html( slc_plain( 'modular_project_title', __( 'Rio Tinto rail operations', 'streamlineconnect' ) ) ); ?></h3>
				<div class="project-summary"><?php echo slc_rich( 'modular_project_summary', __( 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.', 'streamlineconnect' ) ); ?></div>
				<ul class="chips">
					<li><?php echo esc_html( slc_plain( 'modular_project_chip_1', __( 'Facilities', 'streamlineconnect' ) ) ); ?></li>
					<li><?php echo esc_html( slc_plain( 'modular_project_chip_2', __( 'Power', 'streamlineconnect' ) ) ); ?></li>
				</ul>
			</div>
			<div class="project-spec">
				<dl>
					<div><dt><?php esc_html_e( 'Sector', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'modular_project_sector', __( 'Mining and resources', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Client', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'modular_project_client', __( 'Mining operator', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Location', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'modular_project_location', __( 'Pilbara, WA', 'streamlineconnect' ) ) ); ?></dd></div>
				</dl>
			</div>
		</article>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_href( 'modular_projects_url', slc_url( '/projects/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'modular_projects_bar', __( 'Explore our projects', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
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
