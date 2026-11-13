<?php
/**
 * Site header and primary navigation.
 *
 * @package StreamlineConnect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slc_menus = slc_nav_menus();
?><!DOCTYPE html>
<html<?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>document.documentElement.className=document.documentElement.className.replace('no-js','js');</script>
<?php wp_head(); ?>
</head>
<body<?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- Skip link: first focusable control, jumps to #main. -->
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'streamlineconnect' ); ?></a>
<!-- Header: logo, the mobile menu button, then the primary navigation. -->
<header class="site-header" id="top" tabindex="-1" data-header>
	<div class="header-bar">
		<a class="logo" href="<?php echo esc_url( slc_url( '/' ) ); ?>"><?php
			echo slc_picture(
				array(
					'field'      => 'header_logo',
					'file'       => 'images/logo.svg',
					'width'      => 240,
					'height'     => 31,
					'alt'        => 'Streamline Connect',
					'attr_field' => 'header_logo',
					'loading'    => 'eager',
				)
			);
		?></a>
		<button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="site_nav"><?php esc_html_e( 'Menu', 'streamlineconnect' ); ?></button>
		<!-- Primary nav: menu Discuss button, each item, then the bar Discuss button. -->
		<nav class="site-nav" id="site_nav" aria-label="<?php esc_attr_e( 'Primary', 'streamlineconnect' ); ?>">
			<a<?php echo slc_attr_html( 'discuss_menu_label', 'btn nav-cta nav-cta--menu' ); ?> href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( 'discuss_menu_label' ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
			<?php foreach ( slc_nav_items() as $item ) : ?>
				<?php if ( ! empty( $item['panel'] ) && isset( $slc_menus[ $item['panel'] ] ) ) : ?>
					<?php
					$slc_menu = $slc_menus[ $item['panel'] ];
					$slc_menu_prefix = $slc_menu['prefix'];
					?>
					<div class="nav-group">
						<button<?php echo slc_attr_html( $item['field'], 'nav-button' ); ?> type="button" data-nav-toggle aria-expanded="false" aria-controls="<?php echo esc_attr( $slc_menu['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?><?php slc_icon( 'chevron.svg' ); ?></button>
						<div class="mega" id="<?php echo esc_attr( $slc_menu['id'] ); ?>" hidden>
							<div class="mega-intro">
								<p<?php echo slc_attr_html( $slc_menu_prefix . '_title', 'mega-title' ); ?>><?php echo slc_inline( $slc_menu_prefix . '_title', $slc_menu['title'] ); ?></p>
								<div<?php echo slc_attr_html( $slc_menu_prefix . '_intro' ); ?>><?php echo slc_rich( $slc_menu_prefix . '_intro', $slc_menu['intro'] ); ?></div>
								<a<?php echo slc_attr_html( $slc_menu_prefix . '_all_label', 'mega-all' ); ?> href="<?php echo esc_url( $slc_menu['all_url'] ); ?>"><?php echo esc_html( slc_plain( $slc_menu_prefix . '_all_label', $slc_menu['all_label'] ) ); ?><?php slc_icon( 'arrow-link.svg' ); ?></a>
								<?php if ( ! empty( $slc_menu['sections'] ) ) : ?>
									<ul class="mega-list">
										<?php foreach ( $slc_menu['sections'] as $section_index => $section ) : ?>
											<?php $section_field = $slc_menu_prefix . '_section_' . ( $section_index + 1 ); ?>
											<li><a<?php echo slc_attr_html( $section_field ); ?> href="<?php echo esc_url( slc_href( $section_field . '_url', $section['url'] ) ); ?>"><span aria-hidden="true">›</span><?php echo esc_html( slc_plain( $section_field, $section['label'] ) ); ?></a></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
							<?php foreach ( $slc_menu['columns'] as $column_index => $column ) : ?>
								<?php $column_number = $column_index + 1; ?>
								<div class="mega-col">
									<a<?php echo slc_attr_html( $slc_menu_prefix . '_' . $column_number . '_title', 'mega-heading' ); ?> href="<?php echo esc_url( slc_href( $slc_menu_prefix . '_' . $column_number . '_url', $column['url'] ) ); ?>"><?php echo esc_html( slc_plain( $slc_menu_prefix . '_' . $column_number . '_title', $column['title'] ) ); ?></a>
									<div<?php echo slc_attr_html( $slc_menu_prefix . '_' . $column_number . '_summary' ); ?>><?php echo slc_rich( $slc_menu_prefix . '_' . $column_number . '_summary', $column['summary'] ); ?></div>
									<ul class="mega-list">
										<?php foreach ( $column['links'] as $link_index => $link ) : ?>
											<?php $link_field = $slc_menu_prefix . '_' . $column_number . '_link_' . ( $link_index + 1 ); ?>
											<li><a<?php echo slc_attr_html( $link_field ); ?> href="<?php echo esc_url( slc_href( $link_field . '_url', $link['url'] ) ); ?>"><span aria-hidden="true">›</span><?php echo esc_html( slc_plain( $link_field, $link['label'] ) ); ?></a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else : ?>
					<a<?php echo slc_attr_html( $item['field'], 'nav-link' . ( empty( $item['chevron'] ) ? ' nav-link--plain' : '' ) ); ?> href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?><?php
					if ( ! empty( $item['chevron'] ) ) {
						slc_icon( 'chevron.svg' );
					}
					?></a>
				<?php endif; ?>
			<?php endforeach; ?>
			<a<?php echo slc_attr_html( 'discuss_header_label', 'btn nav-cta nav-cta--bar' ); ?> href="<?php echo esc_url( slc_discuss_url() ); ?>"><?php echo esc_html( slc_discuss_label( 'discuss_header_label' ) ); ?><?php slc_icon( 'plus.svg' ); ?></a>
		</nav>
	</div>
</header>
<div class="header-spacer" data-header-spacer hidden></div>
<!-- Scrim: covers the page while the menu is open. -->
<div class="scrim" data-scrim hidden></div>
