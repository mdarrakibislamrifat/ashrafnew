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


// 1. Add extra fields at registration
function custom_save_extra_user_fields($user_id) {
    if (isset($_POST['first_name'])) {
        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    }
    if (isset($_POST['last_name'])) {
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    }
    if (isset($_POST['business_name'])) {
        update_user_meta($user_id, 'business_name', sanitize_text_field($_POST['business_name']));
    }
}
add_action('user_register', 'custom_save_extra_user_fields');


// custom update user profile

function custom_update_user_profile() {
    if (isset($_POST['custom_account_update'])) {
        $user_id = get_current_user_id();

        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
        update_user_meta($user_id, 'business_name', sanitize_text_field($_POST['business_name']));

        if (isset($_POST['email']) && is_email($_POST['email'])) {
            wp_update_user([
                'ID' => $user_id,
                'user_email' => sanitize_email($_POST['email']),
            ]);
        }
    }
}
add_action('init', 'custom_update_user_profile');


// Restrict access for logged-out users
function restrict_logged_out_users_pages() {
    if ( !is_user_logged_in() ) {

        // Allow only homepage and Custom My Account template
        if ( !is_front_page() && !is_page_template('my-account.php') ) {
            wp_redirect( home_url() ); // redirect to homepage
            exit;
        }
    }
}
add_action('template_redirect', 'restrict_logged_out_users_pages');