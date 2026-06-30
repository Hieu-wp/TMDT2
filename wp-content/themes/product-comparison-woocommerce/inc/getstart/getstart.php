<?php
//about theme info
add_action( 'admin_menu', 'product_comparison_woocommerce_gettingstarted' );
function product_comparison_woocommerce_gettingstarted() {
	add_theme_page( esc_html__('About Product Comparison Woocommerce ', 'product-comparison-woocommerce'), esc_html__('Theme Demo Import', 'product-comparison-woocommerce'), 'edit_theme_options', 'product_comparison_woocommerce_guide', 'product_comparison_woocommerce_mostrar_guide');
}

// Add a Custom CSS file to WP Admin Area
function product_comparison_woocommerce_admin_theme_style() {
	wp_enqueue_style('product-comparison-woocommerce-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
	wp_enqueue_script('product-comparison-woocommerce-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');

	// Admin notice code START
	wp_register_script('product-comparison-woocommerce-notice', esc_url(get_template_directory_uri()) . '/inc/getstart/js/notice.js', array('jquery'), time(), true);
	wp_enqueue_script('product-comparison-woocommerce-notice');
	// Admin notice code END
}
add_action('admin_enqueue_scripts', 'product_comparison_woocommerce_admin_theme_style');

//guidline for about theme
function product_comparison_woocommerce_mostrar_guide() { 
	//custom function about theme customizer
	$product_comparison_woocommerce_return = add_query_arg( array()) ;
	$product_comparison_woocommerce_theme = wp_get_theme( 'product-comparison-woocommerce' );
?>

<div class="wrapper-info">
    <div class="col-left sshot-section">
    	<h2><?php esc_html_e( 'Welcome to Product Comparison Woocommerce ', 'product-comparison-woocommerce' ); ?> <span class="version"><?php esc_html_e( 'Version', 'product-comparison-woocommerce' ); ?>: <?php echo esc_html($product_comparison_woocommerce_theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','product-comparison-woocommerce'); ?></p>
    </div>
	<div class="col-right coupen-section">
    	<div class="logo-section">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
		</div>
		<div class="logo-right">			
			<div class="update-now">
				<div class="theme-info">
					<div class="theme-info-left">
						<h2><?php esc_html_e('TRY PREMIUM','product-comparison-woocommerce'); ?></h2>
						<h4><?php esc_html_e('PRODUCT COMPARISON WOOCOMMERCE THEME','product-comparison-woocommerce'); ?></h4>
					</div>	
					<div class="theme-info-right"></div>
				</div>	
				<div class="dicount-row">
					<div class="disc-sec">	
						<h5 class="disc-text"><?php esc_html_e('GET THE FLAT DISCOUNT OF','product-comparison-woocommerce'); ?></h5>
						<h1 class="disc-per"><?php esc_html_e('20%','product-comparison-woocommerce'); ?></h1>	
					</div>
					<div class="coupen-info">
						<h5 class="coupen-code"><?php esc_html_e('"VWPRO20"','product-comparison-woocommerce'); ?></h5>
						<h5 class="coupen-text"><?php esc_html_e('USE COUPON CODE','product-comparison-woocommerce'); ?></h5>
						<div class="info-link">						
							<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'UPGRADE TO PRO', 'product-comparison-woocommerce' ); ?></a>
						</div>	
					</div>	
				</div>				
			</div>
		</div>
		
    </div>

    <div class="tab-sec">
    	<div class="tab">
    		<button class="tablinks" onclick="product_comparison_woocommerce_open_tab(event, 'theme_offer')"><?php esc_html_e( 'Demo Importer', 'product-comparison-woocommerce' ); ?></button>
			<button class="tablinks" onclick="product_comparison_woocommerce_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'product-comparison-woocommerce' ); ?></button>
			
			<button class="tablinks" onclick="product_comparison_woocommerce_open_tab(event, 'theme_pro')"><?php esc_html_e( 'Get Premium', 'product-comparison-woocommerce' ); ?></button>
  			<button class="tablinks" onclick="product_comparison_woocommerce_open_tab(event, 'free_pro')"><?php esc_html_e( 'Free Vs premium', 'product-comparison-woocommerce' ); ?></button>
  			<button class="tablinks" onclick="product_comparison_woocommerce_open_tab(event, 'get_bundle')"><?php esc_html_e( 'Get 485+ Themes Bundle at $99', 'product-comparison-woocommerce' ); ?></button>
		</div>

		<?php 
			$product_comparison_woocommerce_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$product_comparison_woocommerce_plugin_custom_css ='display: block';
			}
		?>

		<div id="theme_offer" class="tabcontent open">
			<div class="demo-content">
				<h3><?php esc_html_e( 'Click the below run importer button to import demo content', 'product-comparison-woocommerce' ); ?></h3>
				<?php 
				/* Get Started. */ 
				require get_parent_theme_file_path( '/inc/getstart/demo-content.php' );
				 ?>
			</div>
		</div>

		<div id="lite_theme" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = Product_Comparison_Woocommerce_Plugin_Activation_Settings::get_instance();
				$product_comparison_woocommerce_actions = $plugin_ins->recommended_actions;
				?>
				<div class="product-comparison-woocommerce-recommended-plugins">
				    <div class="product-comparison-woocommerce-action-list">
				        <?php if ($product_comparison_woocommerce_actions): foreach ($product_comparison_woocommerce_actions as $key => $product_comparison_woocommerce_actionValue): ?>
				                <div class="product-comparison-woocommerce-action" id="<?php echo esc_attr($product_comparison_woocommerce_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($product_comparison_woocommerce_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($product_comparison_woocommerce_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($product_comparison_woocommerce_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','product-comparison-woocommerce'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($product_comparison_woocommerce_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Product Comparison Woocommerce', 'product-comparison-woocommerce' ); ?></h3>
				<hr class="h3hr">
				<p><?php esc_html_e('The Product Comparison WooCommerce theme is a versatile and easy-to-use website template designed for those looking to enhance their online stores with product comparison features. Ideal for e-commerce businesses, bloggers, and affiliate marketers, this theme focuses on creating a smooth shopping experience for customers. Crafted specifically for WooCommerce-powered sites, the theme helps to simplify the process of comparing various products, showcasing their features, prices, and other key details side by side. It\'s a great fit for anyone, from beginners to experienced webmasters, regardless of technical skills. Whether you\’re exploring affiliate marketing, showcasing products on Etsy, or running a retail online store, this theme allows you to create comprehensive comparison tables without hassle. The customization options mean you can easily align the theme with your brand\’s aesthetics. Visually, the Product Comparison WooCommerce theme features a clean and responsive design, ensuring optimal performance on all devices. The focus on clarity makes it easier for customers to assess their choices and make informed purchasing decisions. This is particularly important for anyone looking to elevate their e-commerce offerings, whether for product reviews, price comparisons, or listing items for sale. Overall, this WordPress theme is a valuable tool for those in the eCommerce space, aiming to provide customers with the ability to compare products effortlessly. Its user-friendly interface and appealing design make it a great asset for boosting online sales and improving customer satisfaction. ','product-comparison-woocommerce'); ?></p>
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'product-comparison-woocommerce' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'product-comparison-woocommerce' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'product-comparison-woocommerce' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'product-comparison-woocommerce'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'product-comparison-woocommerce'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'product-comparison-woocommerce'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'product-comparison-woocommerce'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'product-comparison-woocommerce'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'product-comparison-woocommerce'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'product-comparison-woocommerce'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'product-comparison-woocommerce'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'product-comparison-woocommerce'); ?></a>
					</div>

					<div class="link-customizer">
						<h3><?php esc_html_e( 'Link to customizer', 'product-comparison-woocommerce' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','product-comparison-woocommerce'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=product_comparison_woocommerce_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','product-comparison-woocommerce'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=product_comparison_woocommerce_banner') ); ?>" target="_blank"><?php esc_html_e('Banner Settings','product-comparison-woocommerce'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=product_comparison_woocommerce_best_product_section') ); ?>" target="_blank"><?php esc_html_e('Best Product Section','product-comparison-woocommerce'); ?></a>
								</div>
							</div>
						
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','product-comparison-woocommerce'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','product-comparison-woocommerce'); ?></a>
								</div>
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=product_comparison_woocommerce_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','product-comparison-woocommerce'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=product_comparison_woocommerce_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','product-comparison-woocommerce'); ?></a>
								</div>
							</div>
						</div>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','product-comparison-woocommerce'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','product-comparison-woocommerce'); ?></p>
                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','product-comparison-woocommerce'); ?></span><?php esc_html_e(' Go to ','product-comparison-woocommerce'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','product-comparison-woocommerce'); ?></b></p>
                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','product-comparison-woocommerce'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','product-comparison-woocommerce'); ?></span><?php esc_html_e(' Go to ','product-comparison-woocommerce'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','product-comparison-woocommerce'); ?></b></p>
				  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','product-comparison-woocommerce'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
                  	<p><?php esc_html_e(' Once you are done with setup, then follow the','product-comparison-woocommerce'); ?> <a class="doc-links" href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_FREE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation','product-comparison-woocommerce'); ?></a></p>
			  	</div>
			</div>
		</div>


		<div id="theme_pro" class="tabcontent">
		  	<h3><?php esc_html_e( 'Premium Theme Information', 'product-comparison-woocommerce' ); ?></h3>
			<hr class="h3hr">
		    <div class="col-left-pro">
		    	<p><?php esc_html_e('The Price Comparison WordPress Theme is a superior website template tailored specifically for crafting unparalleled price comparison sites. Designed with both seasoned affiliate marketers and dynamic e-commerce business owners in mind, this theme is the optimal choice for those wishing to showcase affiliate products from platforms like Amazon, eBay, Flipkart, Walmart, and more. It’s a dynamic, feature-rich theme that boasts price comparison on single product pages for leading platforms, ensuring users have access to the most current pricing data. Additionally, users will appreciate the separate product comparison section that highlights all detailed product attributes, providing a thorough comparison experience. Another standout feature is the tab menu functionality, which elevates site navigation, enabling users to swiftly move between sections. Beyond its advanced capabilities, this theme emanates professionalism, instilling a sense of reliability and credibility in visitors, crucial for boosting user confidence and conversions. Furthermore, the Price Comparison WordPress Theme guarantees regular updates for compatibility with the latest WordPress iterations, ensuring your site remains secure and efficient. Plus, our dedicated customer support is always at the ready to assist with any customization or technical challenges.','product-comparison-woocommerce'); ?></p>
		    	
		    </div>
		    <div class="col-right-pro">
		    	<div class="pro-links">
			    	<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'product-comparison-woocommerce'); ?></a>
					<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'product-comparison-woocommerce'); ?></a>
					<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'product-comparison-woocommerce'); ?></a>
					<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get 485+ Themes Bundle at $99', 'product-comparison-woocommerce'); ?></a>
				</div>
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" />
		    </div>
		    
		</div>

		<div id="free_pro" class="tabcontent">
		  	<div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'product-comparison-woocommerce' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th><?php esc_html_e('Features', 'product-comparison-woocommerce'); ?></th>
								<th><?php esc_html_e('Free Themes', 'product-comparison-woocommerce'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'product-comparison-woocommerce'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Product Slider Settings', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Number of Product Slides', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('Unlimited', 'product-comparison-woocommerce'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('10', 'product-comparison-woocommerce'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'product-comparison-woocommerce'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><?php esc_html_e('10', 'product-comparison-woocommerce'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'product-comparison-woocommerce'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'product-comparison-woocommerce'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Mega Menu', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Woo-Commerce Compatibility', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Gallery', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('WordPress 6.4 or later', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('PHP 8.2 or 8.3', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('MySQL 5.6 (or greater) | MariaDB 10.0 (or greater)', 'product-comparison-woocommerce'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'product-comparison-woocommerce'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="get_bundle" class="tabcontent">		  	
		   <div class="col-left-pro">
		   	<h3><?php esc_html_e( 'WP Theme Bundle', 'product-comparison-woocommerce' ); ?></h3>
		    	<p><?php esc_html_e('Enhance your website effortlessly with our WP Theme Bundle. Get access to 485+ premium WordPress themes and 5+ powerful plugins, all designed to meet diverse business needs. Enjoy seamless integration with any plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.','product-comparison-woocommerce'); ?></p>
		    	<div class="feature">
		    		<h4><?php esc_html_e( 'Features:', 'product-comparison-woocommerce' ); ?></h4>
		    		<p><?php esc_html_e('485+ Premium Themes & 5+ Plugins.', 'product-comparison-woocommerce'); ?></p>
		    		<p><?php esc_html_e('Seamless Integration.', 'product-comparison-woocommerce'); ?></p>
		    		<p><?php esc_html_e('Customization Flexibility.', 'product-comparison-woocommerce'); ?></p>
		    		<p><?php esc_html_e('Regular Updates.', 'product-comparison-woocommerce'); ?></p>
		    		<p><?php esc_html_e('Dedicated Support.', 'product-comparison-woocommerce'); ?></p>
		    	</div>
		    	<p><?php esc_html_e('Upgrade now and give your website the professional edge it deserves, all at an unbeatable price of $99!', 'product-comparison-woocommerce'); ?></p>
		    	<div class="pro-links">
					<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'product-comparison-woocommerce'); ?></a>
					<a href="<?php echo esc_url( PRODUCT_COMPARISON_WOOCOMMERCE_THEME_BUNDLE_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'product-comparison-woocommerce'); ?></a>
				</div>
		   </div>
		   <div class="col-right-pro">
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/bundle.png" alt="" />
		   </div>		    
		</div>
	</div>
</div>

<?php } ?>