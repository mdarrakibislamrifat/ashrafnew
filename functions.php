<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );




// Custom My Account Page Template
function my_account_enqueue_styles() {
   

    // Load your custom CSS from assets/css/custom.css
    wp_enqueue_style(
        'my-account-custom',
        get_stylesheet_directory_uri() . '/assets/css/my-account.css',
    );
}
add_action( 'wp_enqueue_scripts', 'my_account_enqueue_styles' );


// i want to enque my custom js file only on my-account page template
function my_account_enqueue_scripts() {
	if ( is_page_template( 'my-account.php' ) ) {
		wp_enqueue_script(
			'my-account-custom',
			get_stylesheet_directory_uri() . '/assets/js/my-account.js',
			array( 'jquery' ), // Dependencies
			'1.0.0', // Version
			true // Load in footer
		);
	}
}
add_action( 'wp_enqueue_scripts', 'my_account_enqueue_scripts' );