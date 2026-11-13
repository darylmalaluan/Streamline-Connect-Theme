<?php
/**
 * Template Name: About
 *
 * About page. Header, enquiry band, and footer are the shared theme sections.
 *
 * @package StreamlineConnect
 */

get_header();

$slc_people  = slc_about_people();
$slc_explore = slc_about_explore();
?>
<main id="main">
	<!-- Hero: shared header stays above this. Photograph, navy scrim, breadcrumb, headline, and the jump panel. -->
	<section class="hero about-hero" aria-label="<?php esc_attr_e( 'About', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'about_hero_image',
				'file'          => 'images/about/hero.jpg',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'about_hero_alt', __( 'Operator in a tracked machine beside a truck on a construction site at dusk.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="about-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'about_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'about_breadcrumb_current', __( 'About', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1 class="about-hero-title"><?php echo slc_inline( 'about_heading', __( 'About Streamline', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'about_standfirst', __( 'Streamline Connect is a Western Australian contractor delivering communications networks, power systems and modular infrastructure across Australia. Our crews work in remote areas and around live mine and rail operations. Our head office is in Belmont, with manufacturing at Embleton and our plant maintenance yard in High Wycombe.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php esc_attr_e( 'On this page', 'streamlineconnect' ); ?>">
					<p><?php echo esc_html( slc_plain( 'about_jump_label', __( 'On this page', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_about_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( 'discuss_hero_label' ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>
	<!-- Founders' statement. No attribution unless one is added later. -->
	<section class="section section--navy about-quote" aria-label="<?php esc_attr_e( 'Founders', 'streamlineconnect' ); ?>">
		<div class="wrap about-quote-row">
			<p class="about-quote-mark" aria-hidden="true">“</p>
			<blockquote class="about-quote-text"><?php echo slc_rich( 'about_quote', __( 'Our founders, Tony Farrell and Nick Jenkins, wanted the freedom to make decisions and do the job right. We still expect the people making commitments to understand what the work will require on site.', 'streamlineconnect' ) ); ?></blockquote>
		</div>
	</section>
	<!-- Proximity: heading beside the explanation, then one photograph. Id hook: #proximity_to_the_work. -->
	<section class="section" aria-labelledby="proximity_to_the_work">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="proximity_to_the_work" tabindex="-1"><?php echo slc_inline( 'about_proximity_heading', __( 'Proximity to the work', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'about_proximity_body', __( 'We love seeing a network go live, knowing our crews did the construction that made it possible. That’s why we’ve invested in our own people, plant and equipment, keeping construction knowledge and responsibility close to the job. We want to earn the next project through how we deliver this one.', 'streamlineconnect' ) ); ?></div>
			</div>
			<?php
			echo slc_picture(
				array(
					'field' => 'about_proximity_image',
					'file'  => 'images/about/proximity.png',
					'width' => 1808,
					'height'=> 1017,
					'alt'   => slc_plain( 'about_proximity_alt', __( 'Crew in high-visibility clothing lined up in front of modular containers at a yard.', 'streamlineconnect' ) ),
					'class' => 'about-photo',
				)
			);
			?>
		</div>
	</section>
	<!-- Our people: heading row, then nine photographs in reading order. Id hook: #our_people. -->
	<section class="section section--grey" aria-labelledby="our_people">
		<div class="wrap">
			<div class="section-intro">
				<h2 class="section-heading" id="our_people" tabindex="-1"><?php echo slc_inline( 'about_people_heading', __( 'Our people', 'streamlineconnect' ) ); ?></h2>
				<div><?php echo slc_rich( 'about_people_body', __( 'Our site teams include civil crews, electricians and communications technicians. We want our people to have a future here, with opportunities to lead projects and develop teams of their own.', 'streamlineconnect' ) ); ?></div>
			</div>
			<div class="about-mosaic">
				<div class="about-band">
					<figure class="about-shot about-shot--feature"><?php echo slc_about_shot( $slc_people[0] ); ?></figure>
					<div class="about-band__split">
						<div class="about-stack">
							<figure class="about-shot"><?php echo slc_about_shot( $slc_people[1] ); ?></figure>
							<figure class="about-shot"><?php echo slc_about_shot( $slc_people[2] ); ?></figure>
						</div>
						<figure class="about-shot"><?php echo slc_about_shot( $slc_people[3] ); ?></figure>
					</div>
				</div>
				<div class="about-band">
					<div class="about-band__split">
						<div class="about-stack">
							<figure class="about-shot"><?php echo slc_about_shot( $slc_people[4] ); ?></figure>
							<figure class="about-shot"><?php echo slc_about_shot( $slc_people[5] ); ?></figure>
						</div>
						<figure class="about-shot"><?php echo slc_about_shot( $slc_people[6] ); ?></figure>
					</div>
					<div class="about-stack">
						<figure class="about-shot"><?php echo slc_about_shot( $slc_people[7] ); ?></figure>
						<figure class="about-shot"><?php echo slc_about_shot( $slc_people[8] ); ?></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Explore: three cards. Id hook: #explore_streamline. -->
	<section class="section section--navy" aria-labelledby="explore_streamline">
		<div class="wrap">
			<h2 class="section-heading about-explore-heading" id="explore_streamline" tabindex="-1"><?php echo slc_inline( 'about_explore_heading', __( 'Explore Streamline', 'streamlineconnect' ) ); ?></h2>
			<ul class="about-cards">
				<?php foreach ( $slc_explore as $card ) : ?>
					<li>
						<a class="about-card" href="<?php echo esc_url( $card['url'] ); ?>">
							<?php
							echo slc_picture(
								array(
									'field'  => $card['image'],
									'file'   => $card['file'],
									'width'  => 640,
									'height' => 320,
									'alt'    => $card['alt'],
									'class'  => 'about-card-photo',
								)
							);
							?>
							<span class="about-card-copy">
								<span class="about-card-title"><?php echo esc_html( $card['title'] ); ?></span>
								<span class="about-card-text"><?php echo wp_strip_all_tags( $card['text'] ); ?></span>
							</span>
							<span class="text-link text-link--light"><?php echo esc_html( $card['link'] ); ?><?php slc_icon( 'arrow-light.svg' ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
</main>
<?php
get_footer();
