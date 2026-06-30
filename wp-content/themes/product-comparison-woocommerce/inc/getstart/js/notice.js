jQuery(document).ready(function($){

    $(document).on('click', '#product-comparison-woocommerce-welcome-notice .notice-dismiss', function(){
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'product_comparison_woocommerce_dismiss_notice'
            }
        });
    });

});