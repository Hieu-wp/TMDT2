<?php
/**
 * Login Form
 * Custom Premium Split Screen Design for AnimeFigure Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' );
?>
<?php
$default_tab = ( isset( $_GET['action'] ) && 'register' === $_GET['action'] ) ? 'register' : 'login';
?>

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
            <div class="af-login-tabs">
                <button type="button" class="af-tab-btn<?php echo 'login' === $default_tab ? ' active' : ''; ?>" data-target="login">Đăng nhập</button>
                <button type="button" class="af-tab-btn<?php echo 'register' === $default_tab ? ' active' : ''; ?>" data-target="register">Đăng ký</button>
            </div>
            
            <div id="customer_login" class="af-form-container">
                <div class="af-form-pane<?php echo 'login' === $default_tab ? ' active' : ''; ?>" id="pane-login">


                    <form class="woocommerce-form woocommerce-form-login login af-custom-form" method="post">
                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <div class="af-input-group">
                            <input type="text" placeholder=" " class="woocommerce-Input woocommerce-Input--text input-text af-input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
                            <label for="username"><?php esc_html_e( 'Tên tài khoản hoặc email', 'woocommerce' ); ?></label>
                        </div>
                        
                        <div class="af-input-group">
                            <input class="woocommerce-Input woocommerce-Input--text input-text af-input" placeholder=" " type="password" name="password" id="password" autocomplete="current-password" required />
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

                <div class="af-form-pane<?php echo 'register' === $default_tab ? ' active' : ''; ?>" id="pane-register">
                    <form method="post" class="woocommerce-form woocommerce-form-register register af-custom-form" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                        <?php do_action( 'woocommerce_register_form_start' ); ?>



                        <div class="af-input-group">
                            <input type="email" placeholder=" " class="woocommerce-Input woocommerce-Input--text input-text af-input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                            <label for="reg_email"><?php esc_html_e( 'Địa chỉ Email', 'woocommerce' ); ?></label>
                        </div>

                        <div class="af-input-group">
                            <input type="password" placeholder=" " class="woocommerce-Input woocommerce-Input--text input-text af-input" name="password" id="reg_password" autocomplete="new-password" required />
                            <label for="reg_password"><?php esc_html_e( 'Mật khẩu', 'woocommerce' ); ?></label>
                        </div>

                        <?php do_action( 'woocommerce_register_form' ); ?>

                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <button type="submit" class="btn btn-primary af-submit-btn" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Đăng ký ngay', 'woocommerce' ); ?></button>

                        <?php do_action( 'woocommerce_register_form_end' ); ?>
                    </form>
                </div> <!-- /pane-register -->
            </div> <!-- /customer_login -->
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

    // Open register tab when ?action=register is present
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'register') {
        const registerTab = document.querySelector('.af-tab-btn[data-target="register"]');
        if (registerTab) {
            registerTab.click();
        }
    }
    
    // Floating label logic + autofill handling
    const inputs = document.querySelectorAll('.af-input');

    const updateLabelStateFor = function(input) {
        const group = input.closest('.af-input-group');
        if (!group) return;
        const label = group.querySelector('label');
        if (input.value && input.value.trim() !== '') {
            input.classList.add('has-val');
            if (label) label.classList.add('af-label-hidden');
        } else {
            input.classList.remove('has-val');
            if (label) label.classList.remove('af-label-hidden');
        }
    };

    inputs.forEach(input => {
        // Check initial state
        updateLabelStateFor(input);

        ['input','blur','focus','change'].forEach(evt => {
            input.addEventListener(evt, () => updateLabelStateFor(input));
        });

        // Some browsers autofill after load — re-check shortly
        setTimeout(() => { updateLabelStateFor(input); }, 500);
    });

    // Password show/hide toggle
    const toggles = document.querySelectorAll('.af-toggle-pass');
    toggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const group = btn.closest('.af-input-group');
            if (!group) return;
            const input = group.querySelector('.af-input');
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
                btn.setAttribute('aria-label', 'Ẩn mật khẩu');
            } else {
                input.type = 'password';
                btn.textContent = '👁';
                btn.setAttribute('aria-label', 'Hiện mật khẩu');
            }
            // Ensure label state updates when type changes
            updateLabelStateFor(input);
        });
    });

    // Extra autofill catch: listen for animationstart (Chrome autofill hack)
    document.addEventListener('animationstart', function(e) {
        if (e.animationName === 'onAutoFillStart') {
            setTimeout(() => inputs.forEach(i => updateLabelStateFor(i)), 50);
        }
    });
});
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
