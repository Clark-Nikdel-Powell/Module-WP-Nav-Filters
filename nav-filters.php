<?php

/**
 * Nav Menu Default Args Filter
 *
 * Adjusts the default arguments of a wp_nav_menu function call,
 * unless "suppress_filters" has been set to true.
 *
 * Defaults are:
 * fallback_cb = FALSE - No fallback menu if the requested menu is not found.
 * container = nav - The container for the menu is a <nav> element.
 * container_class = $args['menu'] - Container class is based on the menu name.
 * strip_li - Strip the <li> elements from the nav, applied in cnp_wp_nav_menu
 *
 * @since 0.1.0
 *
 * @see wp_nav_menu
 * @link https://codex.wordpress.org/Function_Reference/wp_nav_menu
 *
 * @param array $args WP Nav Menu args.
 *
 * @return array $args Args for the WP Nav Menu.
 */
function cnp_wp_nav_menu_default_args( $args ) {

	// This filter can be disabled if "suppress_filters" is set to TRUE in the $args array.
	if ( isset( $args['suppress_filters'] ) && true === $args['suppress_filters'] ) {
		return $args;
	}

	$args['fallback_cb'] = false;
	$args['items_wrap']  = PHP_EOL . '%3$s';

	if ( ! isset( $args['container'] ) ) {
		$args['container'] = 'nav';
	}

	if ( ! isset( $args['container_class'] ) ) {
		$args['container_class'] = sanitize_title( $args['menu'] );
	}

	if ( ! isset( $args['strip_li'] ) ) {
		$args['strip_li'] = true;
	}

	return $args;

}

add_filter( 'wp_nav_menu_args', 'cnp_wp_nav_menu_default_args', 20, 1 );


/**
 * Nav Menu Markup Adjustments
 *
 * Adjusts the default markup of a wp_nav_menu function call.
 *
 * WARNING: apparently the $args parameter gets switched to
 * an object, not an array.
 *
 * @since 0.1.0
 *
 * @see wp_nav_menu
 * @link https://codex.wordpress.org/Function_Reference/wp_nav_menu
 *
 * @param string $nav_menu Nav menu markup.
 * @param object $args WP Nav Menu args.
 *
 * @return array $nav_menu Adjusted nav menu markup.
 */
function cnp_wp_nav_menu_markup( $nav_menu, $args ) {

	if ( isset( $args->strip_li ) && true === $args->strip_li ) {

		$find     = array( '><a', '</a>', '<li', '</li' );
		$replace  = array( '', '', '<a', '</a' );
		$nav_menu = str_replace( $find, $replace, $nav_menu );

		$nav_menu = trim( $nav_menu );
		$nav_menu = str_replace( "\r", "", $nav_menu );
		$nav_menu = str_replace( "\n", "", $nav_menu );

	}

	return $nav_menu;

}

add_filter( 'wp_nav_menu', 'cnp_wp_nav_menu_markup', 20, 2 );
