<?php
/**
 * Template Name: Our Story
 *
 * Our Story page. Header, enquiry band, and footer are the shared theme sections.
 *
 * @package StreamlineConnect
 */

get_header();

$slc_cards = slc_story_cards();
$slc_links = slc_story_links();
$slc_total = count( $slc_cards );
?>
<main id="main">
	<!-- Hero: shared header stays above this. Photograph, navy scrim, breadcrumb, and headline. No jump panel. -->
	<section class="hero story-hero" aria-label="<?php esc_attr_e( 'Our Story', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'story_hero_image',
				'file'          => 'images/our-story/hero.png',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'story_hero_alt', __( 'Streamline crew lined up in front of modular rooms.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="story-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'story_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( slc_url( '/about/' ) ); ?>"><?php echo esc_html( slc_plain( 'story_breadcrumb_parent', __( 'About', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'story_breadcrumb_current', __( 'Our Story', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'story_heading', __( 'Our Story', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'story_standfirst', __( 'Tony Farrell and Nick Jenkins had seen how far project managers could be from the crews doing the work. A client needed an answer, but that answer might have to pass through several layers of contractors before it came back.', 'streamlineconnect' ) ); ?></div>
				</div>
			</div>
		</div>
	</section>
	<!-- Story carousel. Desktop shows two cards and moves one card at a time. -->
	<section class="section story-carousel" data-story-carousel aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Our story', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<div class="story-viewport">
				<ul class="story-track">
					<?php foreach ( $slc_cards as $card ) : ?>
						<li class="story-card">
							<?php
							echo slc_picture(
								array(
									'field'  => $card['image'],
									'file'   => $card['file'],
									'width'  => 892,
									'height' => 500,
									'alt'    => $card['alt'],
									'class'  => 'story-card-photo',
								)
							);
							?>
							<div class="story-card-text"><?php echo wp_kses_post( $card['text'] ); ?></div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="story-controls">
				<p class="story-count" data-story-count aria-live="polite"><?php echo esc_html( sprintf( '1–%1$d / %2$d', min( 2, $slc_total ), $slc_total ) ); ?></p>
				<div class="story-progress" aria-hidden="true"><span data-story-thumb></span></div>
				<div class="story-nav">
					<button class="story-arrow story-arrow--prev" type="button" data-story-prev disabled aria-label="<?php esc_attr_e( 'Previous', 'streamlineconnect' ); ?>"><?php slc_icon( 'arrow.svg' ); ?></button>
					<button class="story-arrow" type="button" data-story-next aria-label="<?php esc_attr_e( 'Next', 'streamlineconnect' ); ?>"><?php slc_icon( 'arrow.svg' ); ?></button>
				</div>
			</div>
		</div>
	</section>
	<!-- Three routes on from the story. -->
	<section class="section section--navy story-links" aria-label="<?php esc_attr_e( 'Explore Streamline', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<ul class="story-links-row">
				<?php foreach ( $slc_links as $link ) : ?>
					<li>
						<a class="story-link" href="<?php echo esc_url( $link['url'] ); ?>">
							<span class="story-link-icon"><?php slc_icon( $link['icon'] ); ?></span>
							<div class="story-link-text"><?php echo wp_kses_post( $link['text'] ); ?></div>
							<span class="text-link text-link--light"><?php echo esc_html( $link['link'] ); ?><?php slc_icon( 'arrow-light.svg' ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
</main>
<?php
get_footer();
