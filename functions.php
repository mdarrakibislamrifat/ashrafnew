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






// Restrict shop page only for logged-out users
function restrict_shop_page_for_logged_out() {
    if ( ! is_user_logged_in() ) {
        // Get the shop page ID from WooCommerce settings
        $shop_id = intval( get_option( 'woocommerce_shop_page_id' ) );

        // If this is the shop page and user is logged out -> redirect to brands
        if ( is_page( $shop_id ) ) {
            wp_safe_redirect( home_url( '/brands/' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'restrict_shop_page_for_logged_out' );






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









// Track Order fields and AJAX handler
add_action('wp_ajax_track_order_ajax', 'custom_track_order_ajax');
add_action('wp_ajax_nopriv_track_order_ajax', 'custom_track_order_ajax');

function custom_track_order_ajax() {
    $order_input   = sanitize_text_field($_POST['order_id']);
    $billing_email = sanitize_email($_POST['billing_email']);
    $result_msg    = '';

    // Try by order ID
    $order = wc_get_order( absint($order_input) );

    // If not found, try by custom order number meta
    if ( ! $order ) {
        $args = array(
            'numberposts' => 1,
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys( wc_get_order_statuses() ),
            'meta_query'  => array(
                array(
                    'key'   => '_order_number',
                    'value' => $order_input,
                ),
            ),
        );
        $orders = get_posts( $args );
        if ( $orders ) {
            $order = wc_get_order( $orders[0]->ID );
        }
    }

    if ( $order && strtolower( $order->get_billing_email() ) === strtolower( $billing_email ) ) {
        $result_msg = '<p>✅ Order Found!<br> 
            Order ID: #' . esc_html( $order->get_id() ) . '<br>
            Status: ' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '<br>
            Total: ' . wp_kses_post( $order->get_formatted_order_total() ) . '</p>';
    } else {
        $result_msg = '<p>❌ Order not found or email does not match.</p>';
    }

    echo $result_msg;
    wp_die();
}