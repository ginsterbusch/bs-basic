<?php
/**
 * Bootstrap Basic theme
 * 
 * @package bootstrap-basic
 */


/**
 * Required WordPress variable.
 */
if (!isset($content_width)) {
	$content_width = 1170;
}

//add_action('after_setup_theme', array('bootstrapBasicTheme', 'get_instance' ) );


if( !class_exists( 'bootstrapBasicTheme' ) ) {
	require_once( get_template_directory() . '/bs-basic.class.php');

} // endif !class_exists

/**
 * Custom initialization, depending on whether we are using a regular theme or a child theme
 * Basically the Builder Pattern
 * 
 * To properly use this pattern in the child theme, you have to replace the get_instance call to the parent class with the child theme class.
 * 
 * @author Fabian Wolf (@link http://usability-idealist.de/)
 */

/*
if( !class_exists('bootstrapBasicBuilder') ) {
	class bootstrapBasicBuilder() {
		public static function init() {
			add_action( 'after_setup_theme', array('bootstrapBasicTheme', 'get_instance' ) );
		}
	}
	
	// init theme
	bootstrapBasicBuilder::init();
}
*/

/**
 * Check whether this is a regular parent or a child theme
 * The stylesheet path should differ from the template directory, if its a child theme.
 */
if( get_stylesheet_directory() != get_template_directory() ) { // child theme
	//__debug( array( 'get_stylesheet_directory' =>get_stylesheet_directory(), 'get_template_directory' => get_template_directory(), 'class_exists' => ( class_exists('bootstrapBasicBuilder') ? 'yo' : 'no' ) ), 'stylesheet vs template directory' );
	
	//add_action( 'after_setup_theme', array('bootstrapBasicThemeBuilder', 'get_instance' ) ); // gets defined in the child theme
} else { // regular (parent) theme = regular init 
	
	if( !class_exists( 'bootstrapBasicBuilder' ) ) { // better safe than sorry
		class bootstrapBasicBuilder {
			public static function init() {
				add_action( 'after_setup_theme', array('bootstrapBasicTheme', 'get_instance' ) );
			}
		}
	}
}

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/extras.php';


/**
 * Custom dropdown menu and navbar in walker class
 */
require_once get_template_directory() . '/inc/BootstrapBasicMyWalkerNavMenu.php';


/**
 * Template functions
 */
require_once get_template_directory() . '/inc/template-functions.php';


/**
 * --------------------------------------------------------------
 * Theme widget & widget hooks
 * --------------------------------------------------------------
 */
require_once get_template_directory() . '/inc/widgets/BootstrapBasicSearchWidget.php';
require_once get_template_directory() . '/inc/template-widgets-hook.php';

// init theme
if( class_exists( 'bootstrapBasicBuilder' ) && !defined('BOOTSTRAP_THEME_LOADED') ) {
	bootstrapBasicBuilder::init();
	define( 'BOOTSTRAP_THEME_LOADED', true );
}

