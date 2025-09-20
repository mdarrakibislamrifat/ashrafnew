<?php
/**
 * Template Name: Custom My Account
 */
defined( 'ABSPATH' ) || exit;

get_header();

// Handle logout without redirect
if ( isset($_POST['custom_logout']) ) {
    wp_logout();
}

// Show login form for logged-out users
if ( !is_user_logged_in() ) : 
    // Get shop-2 page URL for redirect after login
    $shop2_url = get_permalink( get_page_by_path( 'shop-2' ) );
?>
<div class="custom-account-login-wrapper">
    <div class="custom-account-login-form">
        <h2>Login</h2>
        <?php
            wp_login_form( array(
                'redirect'       => $shop2_url, 
                'label_username' => 'Email or Username',
                'label_password' => 'Password',
                'label_log_in'   => 'Login',
            ) );
        ?>

        <div class="custom-account-login-links">
            <!-- Lost Password link points to wp-login.php?action=lostpassword -->
            <a href="<?php echo esc_url( site_url('wp-login.php?action=lostpassword') ); ?>">Lost your password?</a>


        </div>
    </div>
</div>




<style>
.custom-account-login-wrapper {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    text-align: center;
    width: 100% !important;
    flex-direction: column !important;
}


.custom-account-login-form {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    margin-bottom: 50px;
}

.custom-account-login-form h2 {
    margin-bottom: 20px;
}
</style>
<?php
    get_footer();
    exit;
endif;

// Show custom account container for logged-in users
$current_user = wp_get_current_user();



?>



<div class="custom-account-container">
    <div class="custom-account-sidebar">
        <a href="#" class="custom-account-sidebar-item custom-account-active" data-section="my-account">My Account</a>
        <a href="#" class="custom-account-sidebar-item" data-section="my-orders">My Orders</a>
        <a href="#" class="custom-account-sidebar-item" data-section="track-delivery">Track Delivery</a>
        <a href="#" class="custom-account-sidebar-item" data-section="logout">Logout</a>
    </div>

    <div class="custom-account-content-area">
        <!-- My Account Section -->
        <div class="custom-account-content-section custom-account-active" id="my-account">
            <form method="post" id="custom-account-form">
                <input type="hidden" name="custom_account_update" value="1">

                <div class="custom-account-form-row">
                    <div class="custom-account-form-group">
                        <label for="first-name">First name</label>
                        <input type="text" name="first_name" id="first-name"
                            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'first_name', true)); ?>"
                            disabled>
                    </div>
                    <div class="custom-account-form-group">
                        <label for="last-name">Last name</label>
                        <input type="text" name="last_name" id="last-name"
                            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'last_name', true)); ?>"
                            disabled>
                    </div>
                </div>

                <div class="custom-account-form-row">
                    <div class="custom-account-form-group custom-account-full-width">
                        <label for="business-name">Business Name</label>
                        <input type="text" name="business_name" id="business-name"
                            value="<?php echo esc_attr(get_user_meta($current_user->ID, 'business_name', true)); ?>"
                            disabled>
                    </div>
                </div>

                <div class="custom-account-form-row">
                    <div class="custom-account-form-group custom-account-full-width">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email"
                            value="<?php echo esc_attr($current_user->user_email); ?>" disabled>
                    </div>
                </div>

                <button type="button" id="edit-save-btn" class="custom-account-edit-btn">Edit</button>
            </form>
        </div>



        <!-- My Orders Section -->
        <div class="custom-account-content-section" id="my-orders">
            <h2 class="custom-account-page-title">My Orders</h2>
            <div class="custom-account-order-item">
                <div class="custom-account-order-header">
                    <span class="custom-account-order-number">Order #12345</span>
                    <span class="custom-account-order-status">Completed</span>
                </div>
                <div>Date: September 15, 2025</div>
                <div>Total: $99.99</div>
            </div>

            <div class="custom-account-order-item">
                <div class="custom-account-order-header">
                    <span class="custom-account-order-number">Order #12346</span>
                    <span class="custom-account-order-status">Processing</span>
                </div>
                <div>Date: September 18, 2025</div>
                <div>Total: $149.99</div>
            </div>
        </div>

        <!-- Track Delivery Section -->
        <div class="custom-account-content-section" id="track-delivery">
            <h2 class="custom-account-page-title">Track Delivery</h2>
            <div class="custom-account-tracking-form">
                <div class="custom-account-form-group">
                    <label class="custom-account-label" for="tracking-number">Enter Tracking Number</label>
                    <input class="custom-account-input" type="text" id="tracking-number"
                        placeholder="Enter your tracking number">
                </div>
                <div class="custom-account-tracking-input">
                    <button class="custom-account-track-btn">Track Package</button>
                </div>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="custom-account-content-section" id="logout">
            <h2 class="custom-account-page-title">Logout</h2>
            <p>Are you sure you want to logout?</p>
            <form method="post">
                <input type="hidden" name="custom_logout" value="1">
                <button type="submit" class="custom-account-edit-btn"
                    style="background-color: #dc3545; margin-top: 20px;">
                    Confirm Logout
                </button>
            </form>
        </div>
    </div>
</div>


<?php get_footer(); ?>