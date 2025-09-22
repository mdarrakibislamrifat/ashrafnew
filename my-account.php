<?php
/**
 * Template Name: Custom My Account
 */
defined( 'ABSPATH' ) || exit;

// 1️⃣ Handle My Account form submission for logged-in users
if ( isset($_POST['custom_account_update']) && is_user_logged_in() ) {
    $user_id = get_current_user_id();

    update_user_meta( $user_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
    update_user_meta( $user_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
    update_user_meta( $user_id, 'business_name', sanitize_text_field( $_POST['business_name'] ) );

    if ( isset($_POST['email']) && is_email( $_POST['email'] ) ) {
        wp_update_user([
            'ID'         => $user_id,
            'user_email' => sanitize_email( $_POST['email'] ),
        ]);
    }

    // ✅ Redirect immediately to prevent form resubmission
    wp_safe_redirect( get_permalink() );
    exit;
}

// 2️⃣ Handle logout
if ( isset($_POST['custom_logout']) ) {
    wp_logout();
    wp_safe_redirect( get_permalink() ); 
    exit;
}

// 3️⃣ Now output the page content
get_header();

// 4️⃣ Show login form for logged-out users
if ( ! is_user_logged_in() ) : 
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


// Get current user ID
$current_user_id = get_current_user_id();

// Get orders for this user
$customer_orders = wc_get_orders( array(
    'customer_id' => $current_user_id,
    'limit'       => -1,
    'orderby'     => 'date',
    'order'       => 'DESC',
) );




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

            <table class="custom-account-orders-table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $customer_orders as $order ) : ?>
                    <?php 
                        $order_id     = $order->get_id();
                        $order_date   = wc_format_datetime( $order->get_date_created() );
                        $order_status = wc_get_order_status_name( $order->get_status() );
                        $order_total  = $order->get_formatted_order_total();
                        $order_view   = $order->get_view_order_url();
                    ?>
                    <tr>
                        <td>#<?php echo esc_html( $order_id ); ?></td>
                        <td><?php echo esc_html( $order_date ); ?></td>
                        <td><?php echo esc_html( $order_status ); ?></td>
                        <td><?php echo wp_kses_post( $order_total ); ?></td>
                        <td>
                            <a href="<?php echo esc_url( $order_view ); ?>">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <!-- Track Delivery Section -->
        <div class="custom-account-content-section" id="track-delivery">
            <h2 class="custom-account-page-title">Track Delivery</h2>
            <div class="custom-account-tracking-form">
                <form id="track-order-form" method="post" action="" novalidate>
                    <div class="custom-account-form-group">
                        <label class="custom-account-label" for="order-id">Order ID</label>
                        <input class="custom-account-input" type="text" id="order-id" name="order_id"
                            placeholder="Enter your Order ID">
                    </div>

                    <div class="custom-account-form-group">
                        <label class="custom-account-label" for="billing-email">Billing Email</label>
                        <input class="custom-account-input" type="text" id="billing-email" name="billing_email"
                            placeholder="Enter your Billing Email">

                    </div>

                    <div class="custom-account-tracking-input">
                        <button type="submit" class="custom-account-track-btn">Track Order</button>

                    </div>
                </form>

                <div class="custom-account-tracking-result">

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

<script>
jQuery(document).ready(function($) {
    $('#track-order-form').on('submit', function(e) {
        e.preventDefault(); // stop normal form submission

        var order_id = $('#order-id').val().trim();
        var billing_email = $('#billing-email').val().trim();

        // // Simple validation
        // if (order_id === '') {
        //     $('.custom-account-tracking-result').html(
        //         '<p style="color:red;">Please enter a tracking number</p>');
        //     return;
        // }
        // if (billing_email === '') {
        //     $('.custom-account-tracking-result').html(
        //         '<p style="color:red;">Please enter your billing email</p>');
        //     return;
        // }


        // AJAX request
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: {
                action: 'track_order_ajax',
                order_id: order_id,
                billing_email: billing_email
            },
            success: function(response) {
                $('.custom-account-tracking-result').html(response);
            },
            error: function() {
                $('.custom-account-tracking-result').html(
                    '<p>Something went wrong. Please try again.</p>');
            }
        });
    });
});
</script>


<?php get_footer(); ?>