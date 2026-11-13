<?php
/**
 * Template Name: Capabilities
 *
 * Capabilities page. Header, enquiry band, and footer are the shared theme sections.
 *
 * @package StreamlineConnect
 */

get_header();

$slc_cards = slc_capabilities_cards();
?>
<main id="main">
	<!-- Hero: shared header stays above this. Photograph, navy scrim, breadcrumb, headline, and the jump panel. -->
	<section class="hero cap-hero" aria-label="<?php esc_attr_e( 'Capabilities', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'capabilities_hero_image',
				'file'          => 'images/capabilities/hero.png',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'capabilities_hero_alt', __( 'Cable reel and bulldozer on a red-earth construction site.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="cap-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'capabilities_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'capabilities_breadcrumb_current', __( 'Capabilities', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'capabilities_page_heading', __( 'Capabilities', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'capabilities_standfirst', __( 'Streamline has invested in its own crews, specialist plant and manufacturing facility to deliver communications networks, power systems and modular infrastructure together. You can plan the network, power supply and site construction with one contractor and resolve changes directly with the people responsible for the work.', 'streamlineconnect' ) ); ?></div>
				</div>
				<nav class="jump" aria-label="<?php esc_attr_e( 'Jump to a capability', 'streamlineconnect' ); ?>">
					<p><?php echo esc_html( slc_plain( 'capabilities_jump_label', __( 'Jump to a capability', 'streamlineconnect' ) ) ); ?></p>
					<ul>
						<?php foreach ( slc_capabilities_jumps() as $jump ) : ?>
							<li><a href="<?php echo esc_url( $jump['url'] ); ?>"><?php echo esc_html( $jump['label'] ); ?><?php slc_icon( 'arrow.svg' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--block" href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( 'discuss_hero_label' ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
				</nav>
			</div>
		</div>
	</section>
	<!-- Three capability cards. Each photograph, title, and link open the same page. -->
	<section class="section cap-section" aria-label="<?php esc_attr_e( 'Capabilities', 'streamlineconnect' ); ?>">
		<div class="wrap">
			<ul class="cap-cards">
				<?php foreach ( $slc_cards as $card ) : ?>
					<li>
						<a class="cap-card" href="<?php echo esc_url( $card['url'] ); ?>">
							<?php
							echo slc_picture(
								array(
									'field'  => $card['image'],
									'file'   => $card['file'],
									'width'  => 880,
									'height' => 1164,
									'alt'    => $card['alt'],
									'class'  => 'cap-card-photo',
								)
							);
							?>
							<h2 id="<?php echo esc_attr( $card['anchor'] ); ?>" tabindex="-1"><?php echo slc_inline( 'capabilities_card_' . $card['number'] . '_title', $card['heading'] ); ?></h2>
							<div class="cap-card-text"><?php echo wp_kses_post( $card['text'] ); ?></div>
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
