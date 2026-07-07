<?php
/**
 * My Account Dashboard - Standard POST Custom Profile with Redirect
 * Integrated CSS, PHP Exception Handling & Traditional Page Reload Fix
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$msg_text = '';
$msg_type = ''; // 'success' hoặc 'error'

// 1. XỬ LÝ LƯU DỮ LIỆU KHI BẤM NÚT
if ( isset( $_POST['shopee_save_profile_submit'] ) ) {
    
    // Kiểm tra bảo mật Nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'shopee_save_profile_action' ) ) {
        $msg_text = 'Lỗi bảo mật (Xác thực hết hạn), vui lòng tải lại trang!';
        $msg_type = 'error';
    } else {
        $current_user = wp_get_current_user();
        $inserted_name   = isset($_POST['display_name']) ? sanitize_text_field( $_POST['display_name'] ) : '';
        $inserted_gender = isset($_POST['gender']) ? sanitize_text_field( $_POST['gender'] ) : '';
        $inserted_email  = isset($_POST['user_email']) ? sanitize_email( $_POST['user_email'] ) : '';
        
        // BẮT NGOẠI LỆ CHO EMAIL
        if ( empty( $inserted_email ) ) {
            $msg_text = 'Địa chỉ Email không được để trống.';
            $msg_type = 'error';
        } elseif ( ! is_email( $inserted_email ) ) {
            $msg_text = 'Địa chỉ Email không đúng định dạng hợp lệ.';
            $msg_type = 'error';
        } elseif ( $inserted_email !== $current_user->user_email && email_exists( $inserted_email ) ) {
            $msg_text = 'Địa chỉ Email này đã được sử dụng bởi một tài khoản khác.';
            $msg_type = 'error';
        } else {
            // Cập nhật vào Cơ sở dữ liệu
            $user_id = wp_update_user( array(
                'ID'           => $current_user->ID,
                'display_name' => $inserted_name,
                'user_email'   => $inserted_email
            ) );
            
            if ( ! is_wp_error( $user_id ) ) {
                update_user_meta( $current_user->ID, 'gender', $inserted_gender );
                
                if ( isset($_POST['dob_date'], $_POST['dob_month'], $_POST['dob_year']) ) {
                    $dob = sanitize_text_field($_POST['dob_year'] . '-' . $_POST['dob_month'] . '-' . $_POST['dob_date']);
                    update_user_meta( $current_user->ID, 'billing_birthdate', $dob );
                }
                
                // [QUAN TRỌNG] Tự động chuyển hướng lại chính trang này để ép buộc hệ thống nạp dữ liệu mới
                // Thêm tham số ?profile_updated=1 để nhận diện vừa cập nhật xong
                $redirect_url = add_query_arg( 'profile_updated', '1', wp_get_referer() ? wp_get_referer() : window.location.href );
                wp_safe_redirect( $redirect_url );
                exit; // Dừng chương trình để trình duyệt thực hiện chuyển hướng
            } else {
                $msg_text = 'Có lỗi xảy ra: ' . $user_id->get_error_message();
                $msg_type = 'error';
            }
        }
    }
}

// 2. BẮT THAM SỐ TỪ URL ĐỂ HIỂN THỊ THÔNG BÁO THÀNH CÔNG (Sau khi trang đã được reload sạch sẽ)
if ( isset( $_GET['profile_updated'] ) && $_GET['profile_updated'] == '1' ) {
    $msg_text = 'Hồ sơ tài khoản đã được cập nhật thành công!';
    $msg_type = 'success';
}

// 3. LẤY DỮ LIỆU HIỆN TẠI MỚI NHẤT ĐỂ ĐỔ VÀO FORM
$current_user  = wp_get_current_user(); // Luôn lấy cục dữ liệu mới nhất tại đây
$username      = $current_user->user_login;
$display_name  = $current_user->display_name;
$user_email    = $current_user->user_email;
$user_gender   = get_user_meta( $current_user->ID, 'gender', true );
$user_phone    = get_user_meta( $current_user->ID, 'billing_phone', true );
$user_dob      = get_user_meta( $current_user->ID, 'billing_birthdate', true );

$dob_d = $dob_m = $dob_y = '';
if ( ! empty( $user_dob ) ) {
    $dob_time = strtotime( $user_dob );
    $dob_d = date( 'j', $dob_time );
    $dob_m = date( 'n', $dob_time );
    $dob_y = date( 'Y', $dob_time );
}

function mask_shopee_phone( $phone ) {
    if ( empty( $phone ) ) return '---------';
    return str_repeat( '*', max( 0, strlen( $phone ) - 2 ) ) . substr( $phone, -2 );
}
?>

<style type="text/css">
.shopee-profile-container {
    font-family: var(--font-primary, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto), sans-serif !important;
    background: #fff !important;
    padding: 30px !important;
    color: #2d2d2d !important;
    border-radius: 8px !important;
    border: 1px solid #ececec !important;
    width: 100% !important;
    box-sizing: border-box !important;
    display: block !important;
}

.profile-header h2 {
    font-size: 22px !important;
    font-weight: 700 !important;
    margin: 0 0 5px 0 !important;
    color: #2D2D2D !important;
    line-height: 1.2 !important;
}
.profile-header p {
    font-size: 14px !important;
    color: #666666 !important;
    margin: 0 !important;
}
.profile-divider {
    border: 0 !important;
    border-top: 1px solid #ECECEC !important;
    margin: 20px 0 !important;
    display: block !important;
    height: 1px !important;
}

.profile-body {
    display: flex !important;
    flex-wrap: wrap !important;
    width: 100% !important;
    flex-direction: row !important;
}
.profile-left-col {
    flex: 1 !important;
    min-width: 300px !important;
    padding-right: 40px !important;
    box-sizing: border-box !important;
}
.profile-right-col {
    width: 250px !important;
    border-left: 1px solid #ECECEC !important;
    display: flex !important;
    justify-content: center !important;
    align-items: flex-start !important;
    padding-top: 10px !important;
    box-sizing: border-box !important;
}

.shopee-profile-container .form-group {
    display: flex !important;
    margin-bottom: 25px !important;
    align-items: flex-start !important;
    font-size: 14px !important;
    width: 100% !important;
    flex-direction: row !important;
}
.shopee-profile-container .form-group label {
    width: 130px !important;
    min-width: 130px !important;
    text-align: right !important;
    padding-right: 20px !important;
    color: #666666 !important;
    margin-top: 10px !important;
    font-weight: 600 !important;
    float: none !important;
    display: block !important;
}
.shopee-profile-container .form-group .input-wrap {
    flex: 1 !important;
    display: block !important;
}

.shopee-profile-container input[type="text"],
.shopee-profile-container input[type="email"] {
    width: 100% !important;
    max-width: 400px !important;
    padding: 10px 14px !important;
    border: 1px solid #ECECEC !important;
    border-radius: 6px !important;
    box-sizing: border-box !important;
    background-color: #FFFFFF !important;
    color: #2D2D2D !important;
    height: auto !important;
}
.shopee-profile-container input[type="text"]:focus,
.shopee-profile-container input[type="email"]:focus {
    border-color: #F28C8C !important; 
    outline: none !important;
}
.shopee-profile-container input[readonly] {
    background-color: #F8F9FC !important;
    color: #666666 !important;
    cursor: not-allowed !important;
}
.shopee-profile-container .field-hint {
    display: block !important;
    font-size: 12px !important;
    color: #666666 !important;
    margin-top: 6px !important;
}

.shopee-profile-container .action-link {
    color: #F28C8C !important;
    text-decoration: none !important;
    margin-left: 12px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    cursor: pointer !important;
}
.shopee-profile-container .action-link:hover {
    text-decoration: underline !important;
}

.shopee-profile-container .radio-group {
    padding-top: 10px !important;
    display: flex !important;
    gap: 15px !important;
}
.shopee-profile-container .radio-group label {
    width: auto !important;
    min-width: auto !important;
    text-align: left !important;
    padding-right: 0 !important;
    color: #2D2D2D !important;
    cursor: pointer !important;
    font-weight: normal !important;
    margin-top: 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 5px !important;
}
.shopee-profile-container .radio-group input[type="radio"] {
    accent-color: #F28C8C !important;
    margin: 0 !important;
}
.shopee-profile-container .dob-group select {
    padding: 10px 12px !important;
    border: 1px solid #ECECEC !important;
    border-radius: 6px !important;
    margin-right: 10px !important;
    min-width: 100px !important;
    background: #FFFFFF !important;
    cursor: pointer !important;
    display: inline-block !important;
    width: auto !important;
    height: auto !important;
}

.shopee-profile-container .btn-save {
    background-color: #F28C8C !important;
    color: #FFFFFF !important;
    border: none !important;
    padding: 12px 35px !important;
    border-radius: 30px !important; 
    cursor: pointer !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    display: inline-block !important;
    box-shadow: 0 4px 12px rgba(242,140,140,0.3) !important;
    transition: all 0.2s ease !important;
}
.shopee-profile-container .btn-save:hover {
    background-color: #d97878 !important;
    transform: translateY(-1px) !important;
}

.avatar-upload-wrap {
    text-align: center !important;
    width: 100% !important;
}
.avatar-preview {
    width: 110px !important;
    height: 110px !important;
    border-radius: 50% !important;
    background-color: #F8F9FC !important;
    margin: 0 auto 15px auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: 1px solid #ECECEC !important;
    overflow: hidden !important;
}
.avatar-preview img, .avatar-preview .avatar {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    border-radius: 50% !important;
}
.btn-select-image {
    background: #FFFFFF !important;
    border: 1px solid #ECECEC !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
    cursor: pointer !important;
    color: #666666 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
}
.btn-select-image:hover {
    background: #fff0f2 !important;
    border-color: #fbc4cb !important;
    color: #F28C8C !important;
}

/* HỘP THÔNG BÁO SAU KHI TRANH ĐƯỢC LOAD LẠI */
.shopee-msg-box {
    margin-bottom: 20px !important;
    padding: 12px 20px !important;
    border-radius: 6px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
}
.msg-success {
    background-color: #e6f7ed !important;
    color: #1e7e34 !important;
    border: 1px solid #c3e6cb !important;
}
.msg-error {
    background-color: #fff0f2 !important;
    color: #d97878 !important;
    border: 1px solid #fbc4cb !important;
}

@media (max-width: 768px) {
    .profile-body { flex-direction: column-reverse !important; }
    .profile-right-col {
        width: 100% !important;
        border-left: none !important;
        border-bottom: 1px solid #ECECEC !important;
        padding-bottom: 30px !important;
        margin-bottom: 30px !important;
    }
    .profile-left-col { padding-right: 0 !important; }
    .shopee-profile-container .form-group { flex-direction: column !important; }
    .shopee-profile-container .form-group label { text-align: left !important; margin-bottom: 5px !important; }
}
</style>

<div class="shopee-profile-container">

    <?php if ( ! empty( $msg_text ) ) : ?>
        <div class="shopee-msg-box msg-<?php echo $msg_type; ?>">
            <?php echo ( $msg_type === 'error' ? '❌ ' : '' ) . esc_html( $msg_text ); ?>
        </div>
    <?php endif; ?>

    <div class="profile-header">
        <h2>Hồ sơ của tôi</h2>
        <p>Quản lý và bảo mật thông tin tài khoản cá nhân</p>
    </div>
    
    <hr class="profile-divider">

    <form id="shopee-profile-form" method="post" action="">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('shopee_save_profile_action'); ?>">
        
        <div class="profile-body">
            
            <div class="profile-left-col">
                
                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <div class="input-wrap">
                        <input type="text" value="<?php echo esc_attr( $username ); ?>" readonly />
                        <span class="field-hint">Tên đăng nhập cố định và không thể thay đổi.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Họ và tên</label>
                    <div class="input-wrap">
                        <input type="text" id="display_name_input" name="display_name" value="<?php echo esc_attr( $display_name ); ?>" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrap" style="display: flex !important; align-items: center !important; gap: 10px !important;">
                        <input type="email" id="user_email_field" name="user_email" value="<?php echo esc_attr( $user_email ); ?>" readonly style="flex: 1 !important;" />
                        <span class="action-link" onclick="document.getElementById('user_email_field').removeAttribute('readonly'); document.getElementById('user_email_field').focus();" style="white-space: nowrap !important;">Thay đổi</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <div class="input-wrap" style="display: flex !important; align-items: center !important; gap: 10px !important; padding-top:10px;">
                        <span style="font-weight:600;"><?php echo esc_html( mask_shopee_phone( $user_phone ) ); ?></span>
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="action-link">Thay đổi</a>
                    </div>
                </div>

                <div class="form-group">
                    <label>Giới tính</label>
                    <div class="input-wrap radio-group">
                        <label><input type="radio" name="gender" value="male" <?php checked( $user_gender, 'male' ); ?>> Nam</label>
                        <label><input type="radio" name="gender" value="female" <?php checked( $user_gender, 'female' ); ?>> Nữ</label>
                        <label><input type="radio" name="gender" value="other" <?php checked( $user_gender, 'other' ); ?>> Khác</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ngày sinh</label>
                    <div class="input-wrap dob-group">
                        <select name="dob_date">
                            <option value="">Ngày</option>
                            <?php for( $i=1; $i<=31; $i++ ) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($dob_d, $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        
                        <select name="dob_month">
                            <option value="">Tháng</option>
                            <?php for( $i=1; $i<=12; $i++ ) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($dob_m, $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        
                        <select name="dob_year">
                            <option value="">Năm</option>
                            <?php for( $i=date('Y'); $i>=1920; $i-- ) : ?>
                                <option value="<?php echo $i; ?>" <?php selected($dob_y, $i); ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label></label>
                    <div class="input-wrap">
                        <button type="submit" name="shopee_save_profile_submit" class="btn-save">Lưu lại</button>
                    </div>
                </div>

            </div>

            <div class="profile-right-col">
                <div class="avatar-upload-wrap">
                    <div class="avatar-preview">
                        <?php echo get_avatar( $current_user->ID, 110, '', 'Ảnh đại diện' ); ?>
                    </div>
                    <button type="button" class="btn-select-image" onclick="alert('Tính năng đổi ảnh đang liên kết thông qua hệ thống tài khoản WordPress Gravatar.');">Chọn ảnh</button>
                    <div style="margin-top: 15px !important; font-size: 12px !important; color: #666666 !important; line-height: 1.6 !important;">
                        <p style="margin:0;">Dung lượng tệp tối đa: 1 MB</p>
                        <p style="margin:0;">Định dạng tệp cho phép: .JPEG, .PNG</p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<?php
do_action( 'woocommerce_account_dashboard' );
do_action( 'woocommerce_before_my_account' );
do_action( 'woocommerce_after_my_account' );