<?php
/**
 * Template Name: Contact
 *
 * Contact page. The header and footer are the shared theme sections.
 * The enquiry form is on this page, so the shared enquiry band is not shown.
 *
 * @package StreamlineConnect
 */

get_header();
?>
<main id="main">
	<section class="hero contact-hero" aria-label="<?php esc_attr_e( 'Contact', 'streamlineconnect' ); ?>">
		<?php
		echo slc_picture(
			array(
				'field'         => 'contact_hero_image',
				'file'          => 'images/contact/hero.png',
				'width'         => 1920,
				'height'        => 800,
				'alt'           => slc_plain( 'contact_hero_alt', __( 'Communications tower and site buildings on red earth at dusk.', 'streamlineconnect' ) ),
				'class'         => 'hero-photo',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<div class="hero-scrim" aria-hidden="true"></div>
		<div class="hero-body">
			<nav class="contact-crumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'streamlineconnect' ); ?>">
				<a href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php echo esc_html( slc_plain( 'contact_breadcrumb_home', __( 'Home', 'streamlineconnect' ) ) ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php echo esc_html( slc_plain( 'contact_breadcrumb_current', __( 'Contact', 'streamlineconnect' ) ) ); ?></span>
			</nav>
			<div class="hero-copy">
				<div class="hero-text">
					<h1><?php echo slc_inline( 'contact_heading', __( 'Contact', 'streamlineconnect' ) ); ?></h1>
					<div class="hero-intro"><?php echo slc_rich( 'contact_standfirst', __( 'Whether you’re planning a project, contacting us as a supplier or making a general enquiry, you can reach Streamline here. Early project briefs are welcome.', 'streamlineconnect' ) ); ?></div>
				</div>
			</div>
		</div>
	</section>
	<section class="section contact-enquiry" aria-labelledby="contact_intro_heading">
		<div class="wrap contact-layout">
			<div class="contact-intro">
				<h2 class="section-heading" id="contact_intro_heading"><?php echo slc_inline( 'contact_intro_heading', __( 'Let’s talk about the job', 'streamlineconnect' ) ); ?></h2>
				<div class="contact-intro-text"><?php echo slc_rich( 'contact_intro_body', __( 'Tell us a little about what you’re contacting us for.', 'streamlineconnect' ) ); ?></div>
				<?php
				echo slc_picture(
					array(
						'field'  => 'contact_intro_image',
						'file'   => 'images/contact/enquiry.jpg',
						'width'  => 739,
						'height' => 493,
						'alt'    => slc_plain( 'contact_intro_alt', __( 'Streamline truck crane lifting equipment beside a solar-powered site container.', 'streamlineconnect' ) ),
						'class'  => 'contact-photo',
					)
				);
				?>
			</div>
			<div class="contact-form">
				<?php echo slc_contact_form_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
