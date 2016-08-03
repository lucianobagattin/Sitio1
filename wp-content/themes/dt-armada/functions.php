<?php
/**
 * Vogue theme.
 *
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require( trailingslashit( get_template_directory() ) . 'inc/init.php' );


//Esto lo agregué para poner el buscador en el menú.
add_filter( 'wp_nav_menu_items', 'test', 10, 2 );

function test($menu, $args) {
$args = (array)$args;
if ( 'primary' !== $args['theme_location'] )
return $menu;
ob_start();
dynamic_sidebar('test');
$social = ob_get_clean();
return $menu . $social;
}