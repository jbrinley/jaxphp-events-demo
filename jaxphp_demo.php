<?php
/*
Plugin Name: JaxPHP Demo Plugin
Description: Demonstrates the creation of a custom post type
Author: Flightless, Inc.
Author URI: http://flightless.us/
Contributors: jbrinley
Version: 1.0
*/


if ( !function_exists('jaxphp_events_initialize') ) {
	function jaxphp_events_initialize() {
		spl_autoload_register( 'jaxphp_events_autoloader' );
		JaxPHP_Event::register_post_type();
		add_action( 'widgets_init', array( 'JaxPHP_Events_Widget', 'register_widget' ), 10, 0 );
	}

	function jaxphp_events_autoloader( $class ) {
		if ( strpos($class, 'JaxPHP_') === 0 ) {
			$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$class.'.php';
			if ( file_exists($path) ) {
				include_once($path);
			}
		}
	}

	add_action( 'plugins_loaded', 'jaxphp_events_initialize' );
}