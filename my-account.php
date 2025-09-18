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
if ( !is_user_logged_in() ) : ?>
<div class="custom-account-login-wrapper">
    <div class="custom-account-login-form">
        <h2>Login</h2>
        <?php
            wp_login_form(array(
                'redirect' => get_permalink(),
                'label_username' => 'Email or Username',
                'label_password' => 'Password',
                'label_log_in' => 'Login',
            ));
            ?>
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
            <div class="custom-account-form-row">
                <div class="custom-account-form-group">
                    <label class="custom-account-label" for="first-name">First name <span
                            class="custom-account-required">*</span></label>
                    <input class="custom-account-input" type="text" id="first-name" value="Mohammed">
                </div>
                <div class="custom-account-form-group">
                    <label class="custom-account-label" for="last-name">Last name <span
                            class="custom-account-required">*</span></label>
                    <input class="custom-account-input" type="text" id="last-name" value="Ashraf">
                </div>
            </div>

            <div class="custom-account-form-row">
                <div class="custom-account-form-group custom-account-full-width">
                    <label class="custom-account-label" for="business-name">Business Name <span
                            class="custom-account-required">*</span></label>
                    <input class="custom-account-input" type="text" id="business-name" value="Hashmis- admin">
                    <div class="custom-account-help-text">This will be how your name will be displayed in the account
                        section and in reviews</div>
                </div>
            </div>

            <div class="custom-account-form-row">
                <div class="custom-account-form-group custom-account-full-width">
                    <label class="custom-account-label" for="email">Email address <span
                            class="custom-account-required">*</span></label>
                    <input class="custom-account-input" type="email" id="email" value="mohammedashraf1102@gmail.com">
                </div>
            </div>

            <button class="custom-account-edit-btn">Edit</button>
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