<div class="theme-offer">
	<?php 
        // Check if the demo import has been completed
        $product_comparison_woocommerce_demo_import_completed = get_option('product_comparison_woocommerce_demo_import_completed', false);

        // If the demo import is completed, display the "View Site" button
        if ($product_comparison_woocommerce_demo_import_completed) {
        echo '<p class="notice-text">' . esc_html__('Your demo import has been completed successfully.', 'product-comparison-woocommerce') . '</p>';
        echo '<span><a href="' . esc_url(home_url()) . '" class="button button-primary site-btn" target="_blank">' . esc_html__('View Site', 'product-comparison-woocommerce') . '</a></span>';
        }

		// POST and update the customizer and other related data
        if (isset($_POST['submit'])) {

        // Check if woocommerce is installed and activated
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
          // Install the plugin if it doesn't exist
          $product_comparison_woocommerce_plugin_slug = 'woocommerce';
          $product_comparison_woocommerce_plugin_file = 'woocommerce/woocommerce.php';

          // Check if plugin is installed
          $product_comparison_woocommerce_installed_plugins = get_plugins();
          if (!isset($product_comparison_woocommerce_installed_plugins[$product_comparison_woocommerce_plugin_file])) {
              include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
              include_once(ABSPATH . 'wp-admin/includes/file.php');
              include_once(ABSPATH . 'wp-admin/includes/misc.php');
              include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

              // Install the plugin
              $product_comparison_woocommerce_upgrader = new Plugin_Upgrader();
              $product_comparison_woocommerce_upgrader->install('https://downloads.wordpress.org/plugin/woocommerce.latest-stable.zip');
          }
          // Activate the plugin
          activate_plugin($product_comparison_woocommerce_plugin_file);
        }   

        // Check if ibtana visual editor is installed and activated
        if (!is_plugin_active('ibtana-visual-editor/plugin.php')) {
          // Install the plugin if it doesn't exist
          $product_comparison_woocommerce_plugin_slug = 'ibtana-visual-editor';
          $product_comparison_woocommerce_plugin_file = 'ibtana-visual-editor/plugin.php';

          // Check if plugin is installed
          $product_comparison_woocommerce_installed_plugins = get_plugins();
          if (!isset($product_comparison_woocommerce_installed_plugins[$product_comparison_woocommerce_plugin_file])) {
              include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
              include_once(ABSPATH . 'wp-admin/includes/file.php');
              include_once(ABSPATH . 'wp-admin/includes/misc.php');
              include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

              // Install the plugin
              $product_comparison_woocommerce_upgrader = new Plugin_Upgrader();
              $product_comparison_woocommerce_upgrader->install('https://downloads.wordpress.org/plugin/ibtana-visual-editor.latest-stable.zip');
          }
          // Activate the plugin
          activate_plugin($product_comparison_woocommerce_plugin_file);
        }   

            // Create a front page and assign the template
            $product_comparison_woocommerce_home_page = null;
            // Using WP_Query instead of get_page_by_title()
            $product_comparison_woocommerce_home_query = new WP_Query(array(
               'post_type' => 'page',
               'title' => 'Home',
               'post_status' => 'publish',
               'posts_per_page' => 1
            ));
            if (!$product_comparison_woocommerce_home_query->have_posts()) {
               $product_comparison_woocommerce_home_title = 'Home';           
               // Create the page
               $product_comparison_woocommerce_home = array(
                   'post_type' => 'page',
                   'post_title' => $product_comparison_woocommerce_home_title,
                   'post_status' => 'publish',
                   'post_author' => 1,
                   'post_slug' => 'home'
               );
               $product_comparison_woocommerce_home_id = wp_insert_post($product_comparison_woocommerce_home);
            } else {
               $product_comparison_woocommerce_home_page = $product_comparison_woocommerce_home_query->posts[0];
               $product_comparison_woocommerce_home_id = $product_comparison_woocommerce_home_page->ID;
            }

            // Set the home page template
            add_post_meta($product_comparison_woocommerce_home_id, '_wp_page_template', 'page-template/custom-home-page.php');

            // Set the static front page
            update_option('page_on_front', $product_comparison_woocommerce_home_id);
            update_option('show_on_front', 'page');

            // Create another page if needed
            $product_comparison_woocommerce_page_query = new WP_Query(array(
               'post_type' => 'page',
               'title' => 'Page',
               'post_status' => 'publish',
               'posts_per_page' => 1
            ));

            if (!$product_comparison_woocommerce_page_query->have_posts()) {
               $product_comparison_woocommerce_page_title = 'Page';
               $product_comparison_woocommerce_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

                 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                    All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
               
                $product_comparison_woocommerce_page = array(
                   'post_type' => 'page',
                   'post_title' => $product_comparison_woocommerce_page_title,
                   'post_content' => $product_comparison_woocommerce_content,
                   'post_status' => 'publish',
                   'post_author' => 1,
                   'post_slug' => 'page'
                );
                $product_comparison_woocommerce_page_id = wp_insert_post($product_comparison_woocommerce_page);
            }       
        
            // Set the demo import completion flag
    		update_option('product_comparison_woocommerce_demo_import_completed', true);
    		// Display success message and "View Site" button
    		echo '<p class="notice-text">' . esc_html__('Your demo import has been completed successfully.', 'product-comparison-woocommerce') . '</p>';
    		echo '<span><a href="' . esc_url(home_url()) . '" class="button button-primary site-btn" target="_blank">' . esc_html__('View Site', 'product-comparison-woocommerce') . '</a></span>';
            //end 


            // Top Bar //
            set_theme_mod( 'product_comparison_woocommerce_reviews_text', 'Reviews' ); 
            set_theme_mod( 'product_comparison_woocommerce_meta_field_separator_topheader', '|' ); 
            set_theme_mod( 'product_comparison_woocommerce_reviews_link', '#' ); 
            set_theme_mod( 'product_comparison_woocommerce_supports_text', 'Supports' ); 
            set_theme_mod( 'product_comparison_woocommerce_supports_link', '#' ); 
            set_theme_mod( 'product_comparison_woocommerce_total_order', 'Free Shipping Above $100 Total Order' ); 
            set_theme_mod( 'product_comparison_woocommerce_phone_number', '+101 987-456-3210' ); 
            set_theme_mod( 'product_comparison_woocommerce_phone_icon', 'fas fa-mobile-alt' ); 
            set_theme_mod( 'product_comparison_woocommerce_lite_email', 'xyz123@example.com' );
            set_theme_mod( 'product_comparison_woocommerce_email_icon', 'fas fa-paper-plane' ); 
            set_theme_mod( 'product_comparison_woocommerce_myaccount_icon', 'fas fa-sign-in-alt' );  
            set_theme_mod( 'product_comparison_woocommerce_openicon_icon', 'fas fa-search' ); 
            set_theme_mod( 'product_comparison_woocommerce_closeicon_icon', 'fa fa-window-close' );  


            // slider section start //        
            set_theme_mod( 'product_comparison_woocommerce_banner_image', get_template_directory_uri().'/assets/images/banner.png' ); 
            
            set_theme_mod( 'product_comparison_woocommerce_tagline_title', 'Compare Price & Product' );
            set_theme_mod( 'product_comparison_woocommerce_designation_text', 'Sell custom on-demand printed products without any up-front investment. From print providers directly to your customers.' );
            set_theme_mod( 'product_comparison_woocommerce_banner_button_label', 'Compare Now' );
            set_theme_mod( 'product_comparison_woocommerce_top_button_url', '#' );

            set_theme_mod('product_comparison_woocommerce_product_category', 'productcategory1');

            // Define product category names and product titles
            $product_comparison_woocommerce_category_names = array('productcategory1', 'productcategory2', 'productcategory3');
            $product_comparison_woocommerce_title_array = array(
                array("Lenovo ThinkPad E14 Intel Core i7", "Samsung galaxy S22 ultra", "boat Blaze Smart watch", "Ipad 14 Pro"),
                array("Lenovo ThinkPad E14 Intel Core i7", "Samsung galaxy S22 ultra", "boat Blaze Smart watch", "Ipad 14 Pro"),
                array("Lenovo ThinkPad E14 Intel Core i7", "Samsung galaxy S22 ultra", "boat Blaze Smart watch", "Ipad 14 Pro")
            );

            foreach ($product_comparison_woocommerce_category_names as $product_comparison_woocommerce_index => $product_comparison_woocommerce_category_name) {
                // Create or retrieve the product category term ID
                $product_comparison_woocommerce_term = term_exists($product_comparison_woocommerce_category_name, 'product_cat');
                if ($product_comparison_woocommerce_term === 0 || $product_comparison_woocommerce_term === null) {
                    // If the term does not exist, create it
                    $product_comparison_woocommerce_term = wp_insert_term($product_comparison_woocommerce_category_name, 'product_cat');
                }

                if (is_wp_error($product_comparison_woocommerce_term)) {
                    error_log('Error creating category: ' . $product_comparison_woocommerce_term->get_error_message());
                    continue; // Skip to the next iteration if category creation fails
                }

                // Loop to create 4 products for each category
                for ($product_comparison_woocommerce_i = 0; $product_comparison_woocommerce_i < 4; $product_comparison_woocommerce_i++) {
                    // Create product content
                    $product_comparison_woocommerce_title = $product_comparison_woocommerce_title_array[$product_comparison_woocommerce_index][$product_comparison_woocommerce_i];
                    $product_comparison_woocommerce_content = 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.';

                    // Create product post object
                    $product_comparison_woocommerce_my_post = array(
                        'post_title'    => wp_strip_all_tags($product_comparison_woocommerce_title),
                        'post_content'  => $product_comparison_woocommerce_content,
                        'post_status'   => 'publish',
                        'post_type'     => 'product', // Post type set to 'product'
                    );

                    // Insert the product into the database
                    $product_comparison_woocommerce_post_id = wp_insert_post($product_comparison_woocommerce_my_post);

                    if (is_wp_error($product_comparison_woocommerce_post_id)) {
                        error_log('Error creating product: ' . $product_comparison_woocommerce_post_id->get_error_message());
                        continue; // Skip to the next product if creation fails
                    }

                    // Assign the category to the product
                    wp_set_object_terms($product_comparison_woocommerce_post_id, (int)$product_comparison_woocommerce_term['term_id'], 'product_cat');

                    // Add product meta (price, etc.)
                    update_post_meta($product_comparison_woocommerce_post_id, '_regular_price', '50'); // Regular price
                    update_post_meta($product_comparison_woocommerce_post_id, '_sale_price', '49.99'); // Sale price
                    update_post_meta($product_comparison_woocommerce_post_id, '_price', '49.99'); // Active price

                    // Handle the featured image using media_sideload_image
                    $product_comparison_woocommerce_image_url = get_template_directory_uri() . '/assets/images/banner-product' . ($product_comparison_woocommerce_i + 1) . '.png';
                    $product_comparison_woocommerce_image_id = media_sideload_image($product_comparison_woocommerce_image_url, $product_comparison_woocommerce_post_id, null, 'id');

                    if (is_wp_error($product_comparison_woocommerce_image_id)) {
                        error_log('Error downloading image: ' . $product_comparison_woocommerce_image_id->get_error_message());
                        continue; // Skip to the next product if image download fails
                    }

                    // Assign featured image to product
                    set_post_thumbnail($product_comparison_woocommerce_post_id, $product_comparison_woocommerce_image_id);

                }
            }


            // Best Product Section //
            set_theme_mod( 'product_comparison_woocommerce_best_product_heading', 'Popular Compare' );
            set_theme_mod( 'product_comparison_woocommerce_best_product_small_title', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' );
           
            set_theme_mod('product_comparison_woocommerce_best_product_category', 'productcat1');

            // Define product category names and product titles
            $product_comparison_woocommerce_procategory_names = array('productcat1', 'productcat2', 'productcat3');
            $product_comparison_woocommerce_protitle_array = array(
                array("iPhone 13 Pro", "HP Victus 16 laptop", "Fire Bolt SmartWatch", "Ipad 14 Pro", "iPhone 13 Pro"),
                array("iPhone 13 Pro", "HP Victus 16 laptop", "Fire Bolt SmartWatch", "Ipad 14 Pro", "iPhone 13 Pro"),
                array("iPhone 13 Pro", "HP Victus 16 laptop", "Fire Bolt SmartWatch", "Ipad 14 Pro", "iPhone 13 Pro")
            );

            foreach ($product_comparison_woocommerce_procategory_names as $product_comparison_woocommerce_index => $product_comparison_woocommerce_category_name) {
                // Create or retrieve the product category term ID
                $product_comparison_woocommerce_term = term_exists($product_comparison_woocommerce_category_name, 'product_cat');
                if ($product_comparison_woocommerce_term === 0 || $product_comparison_woocommerce_term === null) {
                    // If the term does not exist, create it
                    $product_comparison_woocommerce_term = wp_insert_term($product_comparison_woocommerce_category_name, 'product_cat');
                }

                if (is_wp_error($product_comparison_woocommerce_term)) {
                    error_log('Error creating category: ' . $product_comparison_woocommerce_term->get_error_message());
                    continue; // Skip to the next iteration if category creation fails
                }

                // Loop to create 4 products for each category
                for ($product_comparison_woocommerce_i = 0; $product_comparison_woocommerce_i < 5; $product_comparison_woocommerce_i++) {
                    // Create product content
                    $product_comparison_woocommerce_title = $product_comparison_woocommerce_protitle_array[$product_comparison_woocommerce_index][$product_comparison_woocommerce_i];
                    $product_comparison_woocommerce_content = 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.';

                    // Create product post object
                    $product_comparison_woocommerce_my_post = array(
                        'post_title'    => wp_strip_all_tags($product_comparison_woocommerce_title),
                        'post_content'  => $product_comparison_woocommerce_content,
                        'post_status'   => 'publish',
                        'post_type'     => 'product', // Post type set to 'product'
                    );

                    // Insert the product into the database
                    $product_comparison_woocommerce_post_id = wp_insert_post($product_comparison_woocommerce_my_post);

                    if (is_wp_error($product_comparison_woocommerce_post_id)) {
                        error_log('Error creating product: ' . $product_comparison_woocommerce_post_id->get_error_message());
                        continue; // Skip to the next product if creation fails
                    }

                    // Assign the category to the product
                    wp_set_object_terms($product_comparison_woocommerce_post_id, (int)$product_comparison_woocommerce_term['term_id'], 'product_cat');

                    // Add product meta (price, etc.)
                    update_post_meta($product_comparison_woocommerce_post_id, '_regular_price', '50'); // Regular price
                    update_post_meta($product_comparison_woocommerce_post_id, '_sale_price', '49.99'); // Sale price
                    update_post_meta($product_comparison_woocommerce_post_id, '_price', '49.99'); // Active price

                    // Handle the featured image using media_sideload_image
                    $product_comparison_woocommerce_image_url = get_template_directory_uri() . '/assets/images/product' . ($product_comparison_woocommerce_i + 1) . '.png';
                    $product_comparison_woocommerce_image_id = media_sideload_image($product_comparison_woocommerce_image_url, $product_comparison_woocommerce_post_id, null, 'id');

                    if (is_wp_error($product_comparison_woocommerce_image_id)) {
                        error_log('Error downloading image: ' . $product_comparison_woocommerce_image_id->get_error_message());
                        continue; // Skip to the next product if image download fails
                    }

                    // Assign featured image to product
                    set_post_thumbnail($product_comparison_woocommerce_post_id, $product_comparison_woocommerce_image_id);

                }
            }
                echo "<script>window.location.href='" . admin_url('themes.php?page=product_comparison_woocommerce_guide') . "';</script>";
                //Copyright Text
                set_theme_mod( 'product_comparison_woocommerce_footer_text', 'By VWThemes' );  
        }
    ?>
  
	<p><?php esc_html_e('Please back up your website if it’s already live with data. This importer will overwrite your existing settings with the new customizer values for Product Comparison Woocommerce', 'product-comparison-woocommerce'); ?></p>
    <form action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php?page=product_comparison_woocommerce_guide" method="POST" onsubmit="return validate(this);">
        <?php if (!get_option('product_comparison_woocommerce_demo_import_completed')) : ?>
            <input class="run-import" type="submit" name="submit" value="<?php esc_attr_e('Run Importer', 'product-comparison-woocommerce'); ?>" class="button button-primary button-large">
        <?php endif; ?>
        <div id="spinner" style="display:none;">         
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/spinner.png" alt="" />
        </div>
    </form>
    <script type="text/javascript">
        function validate(form) {
            if (confirm("Do you really want to import the theme demo content?")) {
                // Show the spinner
                document.getElementById('spinner').style.display = 'block';
                // Allow the form to be submitted
                return true;
            } 
            else {
                return false;
            }
        }
    </script>
</div>

