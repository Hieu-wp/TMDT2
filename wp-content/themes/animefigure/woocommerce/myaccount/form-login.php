<?php
/**
 * Login Form
 * Custom Premium Split Screen Design for AnimeFigure Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="af-login-wrapper">
    <div class="af-login-image">
        <!-- Banner image is set via CSS background -->
        <div class="af-login-quote">
            <h3>Thiên đường Figure của bạn</h3>
            <p>Tham gia cộng đồng sưu tập lớn nhất Việt Nam</p>
        </div>
    </div>
    
    <div class="af-login-content">
        <div class="af-login-box">
            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            
            <div class="af-login-tabs">
                <button type="button" class="af-tab-btn active" data-target="login">Đăng nhập</button>
                <button type="button" class="af-tab-btn" data-target="register">Đăng ký</button>
            </div>
            
            <div id="customer_login" class="af-form-container">
                <div class="af-form-pane active" id="pane-login">
            <?php else: ?>
            <div class="af-form-container">
                <div class="af-form-pane active" id="pane-login">
                    <h2 class="af-login-title"><?php esc_html_e( 'Đăng nhập', 'woocommerce' ); ?></h2>
            <?php endif; ?>

                    <form class="woocommerce-form woocommerce-form-login login af-custom-form" method="post">
                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <div class="af-input-group">
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text af-input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
                            <label for="username"><?php esc_html_e( 'Tên tài khoản hoặc email', 'woocommerce' ); ?></label>
                        </div>
                        
                        <div class="af-input-group">
                            <input class="woocommerce-Input woocommerce-Input--text input-text af-input" type="password" name="password" id="password" autocomplete="current-password" required />
                            <label for="password"><?php esc_html_e( 'Mật khẩu', 'woocommerce' ); ?></label>
                        </div>

                        <?php do_action( 'woocommerce_login_form' ); ?>

                        <div class="af-form-actions">
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme af-checkbox-label">
                                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Ghi nhớ đăng nhập', 'woocommerce' ); ?></span>
                            </label>
                            <p class="woocommerce-LostPassword lost_password">
                                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Quên mật khẩu?', 'woocommerce' ); ?></a>
                            </p>
                        </div>

                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="btn btn-primary af-submit-btn" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Đăng nhập', 'woocommerce' ); ?></button>

                        <?php do_action( 'woocommerce_login_form_end' ); ?>
                    </form>
                </div> <!-- /pane-login -->

            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                <div class="af-form-pane" id="pane-register">
                    <form method="post" class="woocommerce-form woocommerce-form-register register af-custom-form" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                        <?php do_action( 'woocommerce_register_form_start' ); ?>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                            <div class="af-input-group">
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text af-input" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
                                <label for="reg_username"><?php esc_html_e( 'Tên tài khoản', 'woocommerce' ); ?></label>
                            </div>
                        <?php endif; ?>

                        <div class="af-input-group">
                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text af-input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                            <label for="reg_email"><?php esc_html_e( 'Địa chỉ Email', 'woocommerce' ); ?></label>
                        </div>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                            <div class="af-input-group">
                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text af-input" name="password" id="reg_password" autocomplete="new-password" required />
                                <label for="reg_password"><?php esc_html_e( 'Mật khẩu', 'woocommerce' ); ?></label>
                            </div>
                        <?php else : ?>
                            <p class="af-password-hint"><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_register_form' ); ?>

                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <button type="submit" class="btn btn-primary af-submit-btn" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Đăng ký ngay', 'woocommerce' ); ?></button>

                        <?php do_action( 'woocommerce_register_form_end' ); ?>
                    </form>
                </div> <!-- /pane-register -->
            </div> <!-- /customer_login -->
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.af-tab-btn');
    const panes = document.querySelectorAll('.af-form-pane');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding pane
            tab.classList.add('active');
            const targetId = 'pane-' + tab.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });
    
    // Floating label logic
    const inputs = document.querySelectorAll('.af-input');
    inputs.forEach(input => {
        // Check initial state
        if(input.value.trim() !== '') {
            input.classList.add('has-val');
        }
        
        input.addEventListener('blur', function() {
            if(this.value.trim() !== '') {
                this.classList.add('has-val');
            } else {
                this.classList.remove('has-val');
            }
        });
    });
});
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
