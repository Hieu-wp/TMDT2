<?php
/**
 * The sidebar for WooCommerce shop page (Custom Filter UI)
 */
defined( 'ABSPATH' ) || exit;

$current_cat = isset( $_GET['product_cat'] ) ? sanitize_text_field( $_GET['product_cat'] ) : '';
// If we are on a category page (not via GET but rewrite), we can try to detect it
if ( is_product_category() ) {
    $queried_obj = get_queried_object();
    if ( $queried_obj ) {
        $current_cat = $queried_obj->slug;
    }
}

$current_min = isset( $_GET['min_price'] ) ? intval( $_GET['min_price'] ) : 0;
$current_max = isset( $_GET['max_price'] ) ? intval( $_GET['max_price'] ) : 0;

$current_price_value = '';
if ( $current_max == 500000 ) $current_price_value = 'under-500';
elseif ( $current_min == 500000 && $current_max == 2000000 ) $current_price_value = '500-2000';
elseif ( $current_min == 2000000 && $current_max == 5000000 ) $current_price_value = '2000-5000';
elseif ( $current_min == 5000000 && $current_max == 10000000 ) $current_price_value = '5000-10000';
elseif ( $current_min == 10000000 ) $current_price_value = 'over-10000';
?>
<div class="shop-filter-widget">
    <div class="filter-header">
        <h3 class="filter-title">BỘ LỌC SẢN PHẨM</h3>
        <p class="filter-subtitle">Giúp lọc nhanh sản phẩm bạn tìm kiếm</p>
    </div>

    <form id="shop-filter-form" action="" method="GET">
        <!-- Danh mục sản phẩm -->
        <div class="filter-group">
            <div class="filter-group-header">
                <h4>Danh mục sản phẩm</h4>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            </div>
            <div class="filter-group-content custom-scrollbar">
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="" onchange="applyFilters()" <?php checked( $current_cat, '' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Tất cả sản phẩm</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="figma" onchange="applyFilters()" <?php checked( $current_cat, 'figma' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Figma</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="nendoroid" onchange="applyFilters()" <?php checked( $current_cat, 'nendoroid' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Nendoroid</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="scale-figure" onchange="applyFilters()" <?php checked( $current_cat, 'scale-figure' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Scale Figure</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="pop-up-parade" onchange="applyFilters()" <?php checked( $current_cat, 'pop-up-parade' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Pop Up Parade</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="card" onchange="applyFilters()" <?php checked( $current_cat, 'card' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Card</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="hop-trung-bay" onchange="applyFilters()" <?php checked( $current_cat, 'hop-trung-bay' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Hộp trưng bày</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="product_cat" value="de-dung-mo-hinh" onchange="applyFilters()" <?php checked( $current_cat, 'de-dung-mo-hinh' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Đế đứng mô hình</span>
                </label>
            </div>
        </div>



        <!-- Lọc giá -->
        <div class="filter-group">
            <div class="filter-group-header">
                <h4>Lọc giá</h4>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            </div>
            <div class="filter-group-content custom-scrollbar">
                <label class="custom-radio">
                    <input type="radio" name="price" value="" onchange="applyFilters()" <?php checked( $current_price_value, '' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Tất cả mức giá</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="price" value="under-500" onchange="applyFilters()" <?php checked( $current_price_value, 'under-500' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Dưới 500k</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="price" value="500-2000" onchange="applyFilters()" <?php checked( $current_price_value, '500-2000' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Từ 500k - 2000k</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="price" value="2000-5000" onchange="applyFilters()" <?php checked( $current_price_value, '2000-5000' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Từ 2000k - 5000k</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="price" value="5000-10000" onchange="applyFilters()" <?php checked( $current_price_value, '5000-10000' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Từ 5000k - 10000k</span>
                </label>
                <label class="custom-radio">
                    <input type="radio" name="price" value="over-10000" onchange="applyFilters()" <?php checked( $current_price_value, 'over-10000' ); ?>>
                    <span class="radio-mark"></span>
                    <span class="label-text">Trên 10 triệu</span>
                </label>
            </div>
        </div>
        
        <button type="submit" id="shop-filter-submit" style="display:none;">Submit</button>
    </form>
</div>

<script>
function applyFilters() {
    document.getElementById('shop-filter-submit').click();
}

document.getElementById('shop-filter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const cat = formData.get('product_cat');
    const price = formData.get('price');
    
    // Shop base URL
    let url = '<?php echo esc_url( wc_get_page_permalink("shop") ); ?>';
    let params = new URLSearchParams();
    
    if (cat) params.set('product_cat', cat);
    
    if (price === 'under-500') {
        params.set('max_price', '500000');
    } else if (price === '500-2000') {
        params.set('min_price', '500000');
        params.set('max_price', '2000000');
    } else if (price === '2000-5000') {
        params.set('min_price', '2000000');
        params.set('max_price', '5000000');
    } else if (price === '5000-10000') {
        params.set('min_price', '5000000');
        params.set('max_price', '10000000');
    } else if (price === 'over-10000') {
        params.set('min_price', '10000000');
    }
    
    // Maintain sort order if it exists in current URL
    const currentParams = new URLSearchParams(window.location.search);
    if (currentParams.has('orderby')) {
        params.set('orderby', currentParams.get('orderby'));
    }
    
    const queryString = params.toString();
    if (queryString) {
        window.location.href = url + '?' + queryString;
    } else {
        window.location.href = url;
    }
});
</script>
