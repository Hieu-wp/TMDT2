<?php
/**
 * Lost password form
 * Custom AnimeFigure style matching login/register page.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="af-login-wrapper af-forgot-wrapper">
    <div class="af-login-image">
        <div class="af-login-quote">
            <h3>Quên mật khẩu?</h3>
            <p>Điền email hoặc tên tài khoản, chúng tôi sẽ gửi liên kết để bạn thiết lập lại mật khẩu mới.</p>
        </div>
    </div>

    <div class="af-login-content">
        <div class="af-login-box">
            <div class="af-login-tabs">
                <button type="button" class="af-tab-btn active">Quên mật khẩu</button>
            </div>

            <div class="af-form-container">
                <div class="af-form-pane active" id="pane-lost-password">
                    <form method="post" class="woocommerce-ResetPassword lost_reset_password af-custom-form">
                        <div class="af-login-title">Khôi phục mật khẩu</div>
                        <p class="af-password-hint">
                            <?php echo esc_html__( 'Nhập tên đăng nhập hoặc email để nhận liên kết đặt mật khẩu mới.', 'woocommerce' ); ?>
                        </p>

                        <div class="af-input-group">
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text af-input" name="user_login" id="user_login" placeholder=" " autocomplete="username" required />
                            <label for="user_login"><?php esc_html_e( 'Tên đăng nhập hoặc email', 'woocommerce' ); ?></label>
                        </div>

                        <?php do_action( 'woocommerce_lostpassword_form' ); ?>

                        <button type="submit" class="btn btn-primary af-submit-btn" name="wc_reset_password" value="true">
                            <?php esc_html_e( 'Reset password', 'woocommerce' ); ?>
                        </button>

                        <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                    </form>

                    <div class="af-forgot-footer">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Quay lại trang đăng nhập', 'woocommerce' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
