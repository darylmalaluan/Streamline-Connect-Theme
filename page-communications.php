<?php
/**
 * Template Name: Communications
 *
 * Communications and Infrastructure. Header, How we deliver, Why Streamline, and the footer are shared.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero comms-hero" aria-label="<?php esc_attr_e( 'Communications and infrastructure', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'comms_hero_image',
				'file'          => 'images/communications/hero.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'comms_hero_alt', __( 'Communications tower and crane on an industrial site.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="comms-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'comms_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/capabilities/' ) ); ?>"><?php echo esc_html( slc_plain( 'comms_breadcrumb_parent', __( 'Capabilities', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'comms_breadcrumb_current', __( 'Communications', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'comms_heading', __( 'One team for the<br>site and the network', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'comms_standfirst', __( 'Streamline has invested in the crews, specialist plant and technicians that put communications networks into service. We construct fibre routes and wireless sites, install equipment, and test and commission.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php esc_attr_e( 'On this page', 'streamlineconnect' ); ?>">
					<p><?php echo esc_html( slc_plain( 'comms_jump_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_communications_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( 'discuss_hero_label' ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>

	<section class="section comms-services" aria-labelledby="comms_services_heading">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="comms_services_heading"><?php echo slc_inline( 'comms_services_heading', __( 'Communications<br>infrastructure solutions', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'comms_services_intro', __( 'Across mine sites, rail corridors, utility networks and industrial facilities, dependable communications support operational continuity, worker safety and remote operations. Your groundworks are planned with the technicians who will install and commission the network, so cable routes, foundations and site connections are prepared for the equipment arriving on site.', 'streamlineconnect' ) ); ?></div>
			</div>
			<ul class="comms-rows">
				<?php foreach ( slc_communications_services() as $service ) : ?>
					<li class="comms-row" id="<?php echo esc_attr( $service['anchor'] ); ?>" tabindex="-1">
						<?php
						echo slc_picture(
							array(
								'field'  => $service['image'],
								'file'   => $service['file'],
								'width'  => 716,
								'height' => 477,
								'alt'    => $service['alt'],
								'class'  => 'comms-row-photo',
							)
						);
						?>
						<div class="comms-row-copy">
							<div>
								<h3><?php echo wp_kses_post( $service['title'] ); ?></h3>
								<div class="comms-row-text"><?php echo wp_kses_post( $service['text'] ); ?></div>
							</div>
							<a class="text-link" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( $service['link'] ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="section-bar"><a class="bar-link" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_plain( 'comms_services_bar', __( 'Discuss your project', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'plus-orange.svg' ); ?></a></div>
	</section>

	<section class="comms-remote" aria-labelledby="comms_remote_heading">
		<?php
		echo slc_picture(
			array(
				'field'  => 'comms_remote_image',
				'file'   => 'images/communications/remote.jpg',
				'width'  => 1920,
				'height' => 720,
				'alt'    => slc_plain( 'comms_remote_alt', __( 'Excavator with a rock breaker working on a remote site.', 'streamlineconnect' ) ),
				'class'  => 'comms-remote-photo',
			)
		);
		?>
		<div class="comms-remote-scrim" aria-hidden="true"></div>
		<div class="wrap comms-remote-copy">
			<h2 id="comms_remote_heading"><?php echo slc_inline( 'comms_remote_heading', __( 'Built for remote<br>and operational<br>environments', 'streamlineconnect' ) ); ?></h2>
			<div>
				<div class="comms-remote-text"><?php echo slc_rich( 'comms_remote_body', __( 'On mine sites and rail corridors, our crews account for difficult ground, restricted access and existing services when selecting plant and construction methods. Where site conditions require a change, clients deal directly with the people directing the work about its effect on access, equipment and programme.

When requirements change, clients can speak directly with experienced people who understand the site and can explain what needs to happen next.', 'streamlineconnect' ) ); ?></div>
				<a class="text-link text-link--light" href="<?php echo esc_url( slc_href( 'comms_remote_url', slc_url( '/capabilities/' ) ) ); ?>"><?php echo esc_html( slc_plain( 'comms_remote_link', __( 'Explore our capability', 'streamlineconnect' ) ) ); ?><?php slc_icon( 'arrow-light.svg' ); ?></a>
			</div>
		</div>
	</section>

	<section class="section delivery" aria-labelledby="<?php echo esc_attr( slc_content_id( 'delivery_heading', 'how_we_deliver' ) ); ?>">
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
