<?php
/**
 * My Account Dashboard - Shopee Style Profile Customization
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 1. XỬ LÝ LƯU DỮ LIỆU KHI USER NHẤN "SAVE"
$current_user = wp_get_current_user();
$update_success = false;

if ( isset( $_POST['shopee_save_profile'] ) && wp_verify_nonce( $_POST['shopee_profile_nonce'], 'shopee_save_profile_action' ) ) {
    $inserted_name = sanitize_text_field( $_POST['display_name'] );
    $inserted_gender = sanitize_text_field( $_POST['gender'] );
    
    // Cập nhật Tên hiển thị vào WordPress
    wp_update_user( array(
        'ID'           => $current_user->ID,
        'display_name' => $inserted_name
    ) );
    
    // Cập nhật Giới tính và Ngày sinh vào User Meta
    update_user_meta( $current_user->ID, 'gender', $inserted_gender );
    
    if ( isset($_POST['dob_date'], $_POST['dob_month'], $_POST['dob_year']) ) {
        $dob = sanitize_text_field($_POST['dob_year'] . '-' . $_POST['dob_month'] . '-' . $_POST['dob_date']);
        update_user_meta( $current_user->ID, 'billing_birthdate', $dob ); // Hoặc meta key bạn tự định nghĩa
    }
    
    $update_success = true;
    // Refresh lại dữ liệu user mới
    $current_user = wp_get_current_user();
}

// 2. LẤY DỮ LIỆU HIỆN TẠI ĐỂ ĐỔ VÀO FORM
$username      = $current_user->user_login;
$display_name  = $current_user->display_name;
$user_email    = $current_user->user_email;
$user_gender   = get_user_meta( $current_user->ID, 'gender', true );
$user_phone    = get_user_meta( $current_user->ID, 'billing_phone', true ); // Lấy số điện thoại từ WooCommerce
$user_dob      = get_user_meta( $current_user->ID, 'billing_birthdate', true );

// Tách ngày/tháng/năm sinh
$dob_d = $dob_m = $dob_y = '';
if ( ! empty( $user_dob ) ) {
    $dob_time = strtotime( $user_dob );
    $dob_d = date( 'j', $dob_time );
    $dob_m = date( 'n', $dob_time );
    $dob_y = date( 'Y', $dob_time );
}

// Hàm ẩn ký tự bảo mật cho email giống hình
function mask_shopee_email( $email ) {
    $parts = explode( '@', $email );
    $name = $parts[0];
    $domain = isset( $parts[1 ] ) ? $parts[1] : '';
    $masked_name = substr( $name, 0, 2 ) . str_repeat( '*', max( 0, strlen( $name ) - 2 ) );
    return $masked_name . '@' . $domain;
}

// Hàm ẩn ký tự bảo mật cho số điện thoại
function mask_shopee_phone( $phone ) {
    if ( empty( $phone ) ) return '---------';
    return str_repeat( '*', max( 0, strlen( $phone ) - 2 ) ) . substr( $phone, -2 );
}
?>

<div class="shopee-profile-container">
    
    <div class="shopee-alert-banner">
      
        <button class="close-alert" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>

    <?php if ( $update_success ) : ?>
        <div class="woocommerce-message" style="margin-bottom: 20px;">Hồ sơ của bạn đã được cập nhật thành công!</div>
    <?php endif; ?>

    <div class="profile-header">
        <h2>My Profile</h2>
        <p>Manage and protect your account</p>
    </div>
    
    <hr class="profile-divider">

    <form id="shopee-profile-form" method="post" action="">
        <?php wp_nonce_field( 'shopee_save_profile_action', 'shopee_profile_nonce' ); ?>
        
        <div class="profile-body">
            
            <div class="profile-left-col">
                
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrap">
                        <input type="text" value="<?php echo esc_attr( $username ); ?>" readonly class="readonly-field" />
                        <span class="field-hint">Username can only be changed once.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <div class="input-wrap">
                        <input type="text" name="display_name" value="<?php echo esc_attr( $display_name ); ?>" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrap text-display">
                        <span><?php echo esc_html( mask_shopee_email( $user_email ) ); ?></span>
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="action-link">Change</a>
                    </div>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-wrap text-display">
                        <span><?php echo esc_html( mask_shopee_phone( $user_phone ) ); ?></span>
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="action-link">Change</a>
                    </div>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div class="input-wrap radio-group">
                        <label><input type="radio" name="gender" value="male" <?php checked( $user_gender, 'male' ); ?>> Male</label>
                        <label><input type="radio" name="gender" value="female" <?php checked( $user_gender, 'female' ); ?>> Female</label>
                        <label><input type="radio" name="gender" value="other" <?php checked( $user_gender, 'other' ); ?>> Other</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Date of birth</label>
                    <div class="input-wrap dob-group">
                        <select name="dob_date">
                            <option value="">Date</option>
                            <?php for( $i=1; $i<=31; $i++ ) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($dob_d, $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        
                        <select name="dob_month">
                            <option value="">Month</option>
                            <?php for( $i=1; $i<=12; $i++ ) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($dob_m, $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        
                        <select name="dob_year">
                            <option value="">Year</option>
                            <?php for( $i=date('Y'); $i>=1920; $i-- ) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($dob_y, $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrap">
                        <button type="submit" name="shopee_save_profile" class="btn-save">Save</button>
                    </div>
                </div>

            </div>

            <div class="profile-right-col">
                <div class="avatar-upload-wrap">
                    <div class="avatar-preview">
                        <?php 
                        // Lấy avatar của WordPress hiện tại, nếu không có sẽ tự ra icon mặc định
                        echo get_avatar( $current_user->ID, 120, '', 'User Avatar', array('class' => 'shopee-avatar-img') ); 
                        ?>
                    </div>
                    <button type="button" class="btn-select-image" onclick="alert('Tính năng đổi ảnh đang liên kết với hệ thống WordPress Avatar');">Select Image</button>
                    <div class="upload-hint">
                        <p>File size: maximum 1 MB</p>
                        <p>File extension: .JPEG, .PNG</p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<?php
/**
 * Giữ nguyên các Khóa Action Hook gốc của WooCommerce để không làm lỗi các plugin bổ trợ khác.
 */
do_action( 'woocommerce_account_dashboard' );
do_action( 'woocommerce_before_my_account' );
do_action( 'woocommerce_after_my_account' );