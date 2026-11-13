<?php
/**
 * Template Name: Data Rooms
 *
 * Data Rooms page. Header, How we deliver, Why Streamline, and the footer are shared.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero dataroom-hero" aria-label="<?php esc_attr_e( 'Data Rooms', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'dataroom_hero_image',
				'file'          => 'images/data-rooms/hero.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'dataroom_hero_alt', __( 'Bundles of turquoise network cables.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="dataroom-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'dataroom_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/capabilities/' ) ); ?>"><?php echo esc_html( slc_plain( 'dataroom_breadcrumb_parent', __( 'Capabilities', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'dataroom_breadcrumb_current', __( 'Data Rooms', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'dataroom_heading', __( 'Data Rooms with field experience behind the specification', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'dataroom_standfirst', __( 'Streamline spent years installing, upgrading and decommissioning communications facilities before clients asked us to manufacture them. We knew the equipment, connections and site services awaiting those rooms because our teams had dealt with them firsthand.

That experience informs the Communication Equipment Rooms (CERs) and Modular Data Centres (MDCs) we design and manufacture at Embleton, Western Australia. On combined projects, our civil, electrical and communications teams also undertake the supporting infrastructure, planning the factory fit-out and site connections together.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php esc_attr_e( 'On this page', 'streamlineconnect' ); ?>">
					<p><?php echo esc_html( slc_plain( 'dataroom_jump_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_data_rooms_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_plain( 'dataroom_hero_button', __( 'Discuss your Data Room project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>

	<section class="section dataroom-products" aria-label="<?php esc_attr_e( 'Data Rooms', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<ul class="dataroom-rows">
				<?php foreach ( slc_data_rooms_products() as $product ) : ?>
					<li class="dataroom-row" id="<?php echo esc_attr( $product['anchor'] ); ?>" tabindex="-1">
						<?php
						echo slc_picture(
							array(
								'field'  => $product['image'],
								'file'   => $product['file'],
								'width'  => 716,
								'height' => 477,
								'alt'    => $product['alt'],
								'class'  => 'dataroom-row-photo',
							)
						);
						?>
						<div class="dataroom-row-copy">
							<div>
								<h2><?php echo wp_kses_post( $product['title'] ); ?></h2>
								<div class="dataroom-row-text"><?php echo wp_kses_post( $product['text'] ); ?></div>
							</div>
							<a class="text-link" href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['link'] ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="dataroom-built" aria-labelledby="dataroom_built_heading">
		<?php
		echo slc_picture(
			array(
				'field'  => 'dataroom_built_image',
				'file'   => 'images/data-rooms/built.png',
				'width'  => 1920,
				'height' => 720,
				'alt'    => slc_plain( 'dataroom_built_alt', __( 'A welder working inside a modular room.', 'streamlineconnect' ) ),
				'class'  => 'dataroom-built-photo',
			)
		);
		?>
		<div class="dataroom-built-scrim" aria-hidden="true"></div>
		<div class="wrap dataroom-built-copy">
			<h2 id="dataroom_built_heading"><?php echo slc_inline( 'dataroom_built_heading', __( 'Built here.<br>Delivered with confidence.', 'streamlineconnect' ) ); ?></h2>
			<div>
				<div class="dataroom-built-text"><?php echo slc_rich( 'dataroom_built_body', __( 'At our Embleton factory in Western Australia, you can inspect your Data Room and witness Factory Acceptance Testing. The people who assembled it are on hand to investigate and resolve issues before dispatch. Our site crews can prepare the foundations and connections while the factory team completes your room.', 'streamlineconnect' ) ); ?></div>
				<a class="text-link text-link--light" href="<?php echo esc_url( slc_href( 'dataroom_built_url', slc_url( '/capabilities/modular-infrastructure/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'dataroom_built_link', __( 'Explore our modular manufacturing capability', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'arrow-light.svg' ); ?></a>
			</div>
		</div>
	</section>

	<section class="section section--grey dataroom-project" aria-labelledby="dataroom_related_projects">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="dataroom_related_projects"><?php echo slc_inline( 'dataroom_projects_heading', __( 'Related projects', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'dataroom_projects_intro', __( 'Streamline’s Zero Emission offices, crib rooms and ablution blocks supported crews installing a major wireless network at a Pilbara mine site. Powered by integrated solar and battery systems, they provided the project team with offices and amenities without separate diesel generators.', 'streamlineconnect' ) ); ?></div>
			</div>
		</div>
		<article class="project">
			<?php
			echo slc_picture(
				array(
					'field'  => 'dataroom_project_image',
					'file'   => 'images/facilities/project.jpg',
					'width'  => 716,
					'height' => 477,
					'alt'    => slc_plain( 'dataroom_project_alt', __( 'Zero Emission Rooms lined along a red-dirt track at sunset.', 'streamlineconnect' ) ),
					'class'  => 'dataroom-project-photo',
				)
			);
			?>
			<div class="project-copy">
				<h3><?php echo esc_html( slc_plain( 'dataroom_project_title', __( 'Rio Tinto rail operations', 'streamlineconnect' ) ) ); ?></h3>
				<div class="project-summary"><?php echo slc_rich( 'dataroom_project_summary', __( 'ZER supplied 20-foot office configurations to support rail operations, providing relocatable infrastructure that meets the changing requirements of regional rail environments.', 'streamlineconnect' ) ); ?></div>
				<ul class="chips">
					<li><?php echo esc_html( slc_plain( 'dataroom_project_chip_1', __( 'Facilities', 'streamlineconnect' ) ) ); ?></li>
					<li><?php echo esc_html( slc_plain( 'dataroom_project_chip_2', __( 'Power', 'streamlineconnect' ) ) ); ?></li>
				</ul>
			</div>
			<div class="project-spec">
				<dl>
					<div><dt><?php esc_html_e( 'Sector', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'dataroom_project_sector', __( 'Mining and resources', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Client', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'dataroom_project_client', __( 'Mining operator', 'streamlineconnect' ) ) ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Location', 'streamlineconnect' ); ?></dt><dd><?php echo esc_html( slc_plain( 'dataroom_project_location', __( 'Pilbara, WA', 'streamlineconnect' ) ) ); ?></dd></div>
				</dl>
			</div>
		</article>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_href( 'dataroom_projects_url', slc_url( '/projects/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'dataroom_projects_bar', __( 'Explore projects', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
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
