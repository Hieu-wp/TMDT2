<?php
/**
 * AnimeFigure Store — woocommerce/myaccount/my-address.php
 *
 * Override WC default: templates/myaccount/my-address.php
 * - Hiển thị địa chỉ giao hàng chính (WC shipping address)
 * - Hệ thống địa chỉ phụ lưu trong user meta (_af_extra_addresses)
 * - Nút "+ Thêm địa chỉ khác" mở modal form
 * - Sửa / Xóa từng địa chỉ phụ qua AJAX
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

// SVG Icons Definition
$icon_location = '<svg class="af-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
$icon_edit = '<svg class="af-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';
$icon_home = '<svg class="af-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
$icon_office = '<svg class="af-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>';
$icon_trash = '<svg class="af-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
$icon_plus = '<svg class="af-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';

?>

<div class="af-address-page">

    <!-- ── Địa chỉ giao hàng chính (WC) ───────────────────────── -->
    <div class="af-address-section">
        <div class="af-address-section__header">
            <h3 class="af-address-section__title"><?php echo $icon_location; ?> Địa chỉ giao hàng chính</h3>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', 'shipping' ) ); ?>"
               class="af-btn-edit">
                <?php echo $icon_edit; ?> <?php echo wc_get_account_formatted_address('shipping') ? 'Sửa' : 'Thêm'; ?> địa chỉ
            </a>
        </div>
        <div class="af-address-card af-address-card--primary">
            <?php
            $shipping_address = wc_get_account_formatted_address( 'shipping' );
            if ( $shipping_address ) {
                echo wp_kses_post( $shipping_address );
            } else {
                echo '<span class="af-address-empty">Chưa có địa chỉ giao hàng.</span>';
            }
            ?>
        </div>
    </div>

    <!-- ── Địa chỉ phụ ─────────────────────────────────────────── -->
    <div class="af-address-section" id="af-extra-addresses-section">
        <div class="af-address-section__header">
            <h3 class="af-address-section__title"><?php echo $icon_home; ?> Địa chỉ khác</h3>
            <button type="button" class="af-btn-add" id="af-open-add-modal">
                <?php echo $icon_plus; ?> Thêm địa chỉ
            </button>
        </div>

        <div class="af-extra-list" id="af-extra-list">
            <?php
            $extra_addresses = get_user_meta( $customer_id, '_af_extra_addresses', true );
            $extra_addresses = is_array( $extra_addresses ) ? $extra_addresses : [];

            if ( ! empty( $extra_addresses ) ) :
                foreach ( $extra_addresses as $idx => $addr ) :
            ?>
                <div class="af-address-card" data-idx="<?php echo esc_attr( $idx ); ?>">
                    <div class="af-address-card__body">
                        <p><strong><?php echo esc_html( $addr['full_name'] ); ?></strong></p>
                        <p><?php echo esc_html( $addr['phone'] ); ?></p>
                        <p><?php echo esc_html( $addr['address'] ); ?>, <?php echo esc_html( $addr['ward'] ); ?>, <?php echo esc_html( $addr['district'] ); ?>, <?php echo esc_html( $addr['city'] ); ?></p>
                        <?php if ( ! empty( $addr['label'] ) ) : ?>
                            <span class="af-address-label">
                                <?php 
                                    if ( $addr['label'] === 'Nhà riêng' ) echo $icon_home;
                                    elseif ( $addr['label'] === 'Văn phòng' ) echo $icon_office;
                                ?>
                                <?php echo esc_html( $addr['label'] ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="af-address-card__actions">
                        <button type="button" class="af-btn-edit-extra"
                                data-idx="<?php echo esc_attr( $idx ); ?>"
                                data-addr="<?php echo esc_attr( json_encode( $addr ) ); ?>">
                            <?php echo $icon_edit; ?> Sửa
                        </button>
                        <button type="button" class="af-btn-delete-extra"
                                data-idx="<?php echo esc_attr( $idx ); ?>">
                            <?php echo $icon_trash; ?> Xóa
                        </button>
                    </div>
                </div>
            <?php
                endforeach;
            else :
            ?>
                <div class="af-address-empty-state" id="af-empty-state">
                    <?php echo $icon_home; ?>
                    <p>Chưa có địa chỉ nào khác. Thêm địa chỉ để thanh toán nhanh hơn!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div><!-- .af-address-page -->

<!-- ── Modal Thêm / Sửa Địa Chỉ ───────────────────────────────── -->
<div class="af-modal-overlay" id="af-address-modal" style="display:none;">
    <div class="af-modal">
        <div class="af-modal__header">
            <h3 id="af-modal-title">Thêm địa chỉ mới</h3>
            <button type="button" class="af-modal__close" id="af-close-modal">✕</button>
        </div>
        <form class="af-modal__form" id="af-address-form">
            <input type="hidden" id="af-edit-idx" value="-1">

            <div class="af-form-row af-form-row--2col">
                <div class="af-form-group">
                    <label for="af-full-name">Họ và tên <span>*</span></label>
                    <input type="text" id="af-full-name" placeholder="Nguyễn Văn A" required>
                </div>
                <div class="af-form-group">
                    <label for="af-phone">Số điện thoại <span>*</span></label>
                    <input type="tel" id="af-phone" placeholder="0912345678" required>
                </div>
            </div>

            <div class="af-form-group">
                <label for="af-address">Địa chỉ cụ thể (số nhà, tên đường) <span>*</span></label>
                <input type="text" id="af-address" placeholder="123 Đường ABC" required>
            </div>

            <div class="af-form-row af-form-row--3col">
                <div class="af-form-group">
                    <label for="af-ward">Phường / Xã <span>*</span></label>
                    <input type="text" id="af-ward" placeholder="Phường 1" required>
                </div>
                <div class="af-form-group">
                    <label for="af-district">Quận / Huyện <span>*</span></label>
                    <input type="text" id="af-district" placeholder="Quận 1" required>
                </div>
                <div class="af-form-group">
                    <label for="af-city">Tỉnh / Thành phố <span>*</span></label>
                    <input type="text" id="af-city" placeholder="TP. Hồ Chí Minh" required>
                </div>
            </div>

            <div class="af-form-group">
                <label for="af-label">Nhãn (tuỳ chọn)</label>
                <div class="af-label-options">
                    <button type="button" class="af-label-btn" data-value="Nhà riêng"><?php echo $icon_home; ?> Nhà riêng</button>
                    <button type="button" class="af-label-btn" data-value="Văn phòng"><?php echo $icon_office; ?> Văn phòng</button>
                    <button type="button" class="af-label-btn" data-value="">Khác</button>
                </div>
                <input type="hidden" id="af-label" value="">
            </div>

            <div class="af-form-footer">
                <button type="button" class="af-btn-cancel" id="af-cancel-modal">Huỷ</button>
                <button type="submit" class="af-btn-save" id="af-save-address">
                    <span class="af-btn-text">Lưu địa chỉ</span>
                    <span class="af-btn-loading" style="display:none;">Đang lưu...</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function($) {
    var nonce    = '<?php echo wp_create_nonce( "af_address_nonce" ); ?>';
    var ajaxUrl  = '<?php echo admin_url( "admin-ajax.php" ); ?>';
    
    var iconEdit = '<?php echo str_replace("'", "\\'", $icon_edit); ?>';
    var iconTrash = '<?php echo str_replace("'", "\\'", $icon_trash); ?>';
    var iconHome = '<?php echo str_replace("'", "\\'", $icon_home); ?>';
    var iconOffice = '<?php echo str_replace("'", "\\'", $icon_office); ?>';

    // ── Mở modal thêm mới ─────────────────────────────────────────
    $('#af-open-add-modal').on('click', function() {
        resetForm();
        $('#af-modal-title').text('Thêm địa chỉ mới');
        $('#af-edit-idx').val('-1');
        openModal();
    });

    // ── Mở modal sửa ─────────────────────────────────────────────
    $(document).on('click', '.af-btn-edit-extra', function() {
        var idx  = $(this).data('idx');
        var addr = $(this).data('addr');
        if (typeof addr === 'string') { try { addr = JSON.parse(addr); } catch(e) {} }

        $('#af-modal-title').text('Sửa địa chỉ');
        $('#af-edit-idx').val(idx);
        $('#af-full-name').val(addr.full_name || '');
        $('#af-phone').val(addr.phone || '');
        $('#af-address').val(addr.address || '');
        $('#af-ward').val(addr.ward || '');
        $('#af-district').val(addr.district || '');
        $('#af-city').val(addr.city || '');
        $('#af-label').val(addr.label || '');
        setLabelBtn(addr.label || '');
        openModal();
    });

    // ── Đóng modal ────────────────────────────────────────────────
    $('#af-close-modal, #af-cancel-modal').on('click', closeModal);
    $('#af-address-modal').on('click', function(e) {
        if ($(e.target).is('#af-address-modal')) closeModal();
    });

    // ── Label buttons ─────────────────────────────────────────────
    $(document).on('click', '.af-label-btn', function() {
        $('.af-label-btn').removeClass('active');
        $(this).addClass('active');
        $('#af-label').val($(this).data('value'));
    });

    // ── Submit form (Thêm hoặc Sửa) ──────────────────────────────
    $('#af-address-form').on('submit', function(e) {
        e.preventDefault();

        var $saveBtn  = $('#af-save-address');
        $saveBtn.prop('disabled', true);
        $saveBtn.find('.af-btn-text').hide();
        $saveBtn.find('.af-btn-loading').show();

        var data = {
            action  : 'af_save_extra_address',
            nonce   : nonce,
            idx     : $('#af-edit-idx').val(),
            full_name: $('#af-full-name').val().trim(),
            phone   : $('#af-phone').val().trim(),
            address : $('#af-address').val().trim(),
            ward    : $('#af-ward').val().trim(),
            district: $('#af-district').val().trim(),
            city    : $('#af-city').val().trim(),
            label   : $('#af-label').val()
        };

        $.post(ajaxUrl, data, function(res) {
            $saveBtn.prop('disabled', false);
            $saveBtn.find('.af-btn-text').show();
            $saveBtn.find('.af-btn-loading').hide();

            if (res.success) {
                closeModal();
                renderAddresses(res.data.addresses);
            } else {
                alert(res.data || 'Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    });

    // ── Xóa địa chỉ ──────────────────────────────────────────────
    $(document).on('click', '.af-btn-delete-extra', function() {
        if (!confirm('Bạn có chắc chắn muốn xóa địa chỉ này không?')) return;

        var idx = $(this).data('idx');
        $.post(ajaxUrl, {
            action: 'af_delete_extra_address',
            nonce : nonce,
            idx   : idx
        }, function(res) {
            if (res.success) {
                renderAddresses(res.data.addresses);
            } else {
                alert(res.data || 'Có lỗi xảy ra.');
            }
        });
    });

    // ── Render lại danh sách địa chỉ phụ ─────────────────────────
    function renderAddresses(addresses) {
        var $list = $('#af-extra-list');
        $list.empty();

        if (!addresses || addresses.length === 0) {
            $list.html('<div class="af-address-empty-state" id="af-empty-state">' + iconHome + '<p>Chưa có địa chỉ nào khác. Thêm địa chỉ để thanh toán nhanh hơn!</p></div>');
            return;
        }

        $.each(addresses, function(idx, addr) {
            var iconForLabel = '';
            if (addr.label === 'Nhà riêng') iconForLabel = iconHome;
            if (addr.label === 'Văn phòng') iconForLabel = iconOffice;
            
            var labelHtml = addr.label ? '<span class="af-address-label">' + iconForLabel + ' ' + escHtml(addr.label) + '</span>' : '';
            var addrData  = JSON.stringify(addr).replace(/"/g, '&quot;');
            var card = '<div class="af-address-card" data-idx="' + idx + '">'
                + '<div class="af-address-card__body">'
                + '<p><strong>' + escHtml(addr.full_name) + '</strong></p>'
                + '<p>' + escHtml(addr.phone) + '</p>'
                + '<p>' + escHtml(addr.address) + ', ' + escHtml(addr.ward) + ', ' + escHtml(addr.district) + ', ' + escHtml(addr.city) + '</p>'
                + labelHtml
                + '</div>'
                + '<div class="af-address-card__actions">'
                + '<button type="button" class="af-btn-edit-extra" data-idx="' + idx + '" data-addr="' + addrData + '">' + iconEdit + ' Sửa</button>'
                + '<button type="button" class="af-btn-delete-extra" data-idx="' + idx + '">' + iconTrash + ' Xóa</button>'
                + '</div></div>';
            $list.append(card);
        });
    }

    function escHtml(str) {
        return $('<div>').text(str || '').html();
    }
    function openModal() {
        $('#af-address-modal').fadeIn(200);
        $('body').css('overflow', 'hidden');
    }
    function closeModal() {
        $('#af-address-modal').fadeOut(200);
        $('body').css('overflow', '');
    }
    function resetForm() {
        $('#af-address-form')[0].reset();
        $('#af-label').val('');
        $('#af-edit-idx').val('-1');
        $('.af-label-btn').removeClass('active');
    }
    function setLabelBtn(val) {
        $('.af-label-btn').removeClass('active');
        $('.af-label-btn[data-value="' + val + '"]').addClass('active');
    }

})(jQuery);
</script>

<style>
/* =====================================================
   ADDRESS PAGE STYLES
   ===================================================== */
.af-address-page { font-family: 'Outfit', sans-serif; }

.af-icon {
    width: 16px;
    height: 16px;
    display: inline-block;
    vertical-align: middle;
}
.af-address-section__title .af-icon {
    width: 20px;
    height: 20px;
    color: #F28C8C;
    margin-right: 6px;
}
.af-btn-edit .af-icon, .af-btn-add .af-icon { width: 14px; height: 14px; margin-right: 4px; }
.af-address-label .af-icon { width: 12px; height: 12px; margin-right: 2px; }
.af-btn-edit-extra .af-icon, .af-btn-delete-extra .af-icon { width: 14px; height: 14px; margin-right: 2px; }

.af-address-section {
    margin-bottom: 32px;
}
.af-address-section__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.af-address-section__title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
    display: flex;
    align-items: center;
}

/* Address cards */
.af-address-card {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 12px;
    font-size: 14px;
    line-height: 1.7;
    color: #444;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    transition: border-color 0.2s;
}
.af-address-card:hover { border-color: #ffcdd2; }
.af-address-card--primary {
    border-color: #ffcdd2;
    background: linear-gradient(135deg, #fff8f8, #fff);
    display: block;
}
.af-address-card p { margin: 0 0 2px; }
.af-address-card__body { flex: 1; }
.af-address-card__actions {
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex-shrink: 0;
}
.af-address-label {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    background: #fff0f2;
    color: #F28C8C;
    margin-top: 6px;
}
.af-address-empty {
    color: #aaa;
    font-style: italic;
}
.af-address-empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #bbb;
    background: #fafafa;
    border-radius: 14px;
    border: 2px dashed #e0e0e0;
}
.af-address-empty-state .af-icon {
    width: 48px;
    height: 48px;
    color: #ffcdd2;
    margin-bottom: 12px;
}
.af-address-empty-state p { margin: 0; }

/* Buttons */
.af-btn-edit, .af-btn-add {
    display: inline-flex;
    align-items: center;
    padding: 8px 18px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
}
.af-btn-edit {
    background: #f5f5f5;
    color: #333;
}
.af-btn-edit:hover { background: #fff0f2; color: #F28C8C; text-decoration: none; }
.af-btn-add {
    background: linear-gradient(135deg, #F28C8C, #fca5a5);
    color: #fff;
}
.af-btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(242,140,140,0.35); }
.af-btn-edit-extra, .af-btn-delete-extra {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.2s;
    background: none;
}
.af-btn-edit-extra { border-color: #ffcdd2; color: #F28C8C; }
.af-btn-edit-extra:hover { background: #fff0f2; }
.af-btn-delete-extra { border-color: #fecaca; color: #ef4444; }
.af-btn-delete-extra:hover { background: #fef2f2; }

/* Modal */
.af-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.af-modal {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: modalIn 0.25s ease;
}
@keyframes modalIn {
    from { opacity: 0; transform: translateY(20px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.af-modal__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f0f0f0;
}
.af-modal__header h3 { font-size: 18px; font-weight: 700; margin: 0; color: #1a1a2e; }
.af-modal__close {
    width: 32px; height: 32px;
    border-radius: 50%;
    border: none;
    background: #f5f5f5;
    font-size: 14px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s;
}
.af-modal__close:hover { background: #fee2e2; color: #ef4444; }

/* Form */
.af-modal__form { padding: 20px 24px 24px; }
.af-form-row { display: flex; gap: 12px; }
.af-form-row--2col > * { flex: 1; }
.af-form-row--3col > * { flex: 1; }
.af-form-group { margin-bottom: 16px; }
.af-form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
}
.af-form-group label span { color: #ef4444; }
.af-form-group input[type="text"],
.af-form-group input[type="tel"] {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-family: 'Outfit', sans-serif;
    transition: border-color 0.2s;
    box-sizing: border-box;
    outline: none;
}
.af-form-group input:focus { border-color: #fca5a5; box-shadow: 0 0 0 3px rgba(242,140,140,0.15); }
.af-label-options { display: flex; gap: 8px; flex-wrap: wrap; }
.af-label-btn {
    padding: 7px 14px;
    border-radius: 100px;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    color: #555;
    display: inline-flex;
    align-items: center;
}
.af-label-btn.active, .af-label-btn:hover {
    background: #fff0f2;
    border-color: #fca5a5;
    color: #F28C8C;
}
.af-form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #f0f0f0;
}
.af-btn-cancel {
    padding: 10px 22px;
    border-radius: 100px;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    color: #555;
    transition: all 0.2s;
}
.af-btn-cancel:hover { background: #f5f5f5; }
.af-btn-save {
    padding: 10px 28px;
    border-radius: 100px;
    border: none;
    background: linear-gradient(135deg, #F28C8C, #fca5a5);
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.af-btn-save:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(242,140,140,0.4); }
.af-btn-save:disabled { opacity: 0.7; cursor: not-allowed; }

@media (max-width: 480px) {
    .af-form-row--3col { flex-direction: column; gap: 0; }
    .af-form-row--2col { flex-direction: column; gap: 0; }
}
</style>
