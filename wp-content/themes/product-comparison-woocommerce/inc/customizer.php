<?php
/**
 * Product Comparison Woocommerce Theme Customizer
 *
 * @package Product Comparison Woocommerce
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function product_comparison_woocommerce_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'product_comparison_woocommerce_custom_controls' );

function product_comparison_woocommerce_customize_register( $wp_customize ) {


	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo .site-title a',
	 	'render_callback' => 'product_comparison_woocommerce_Customize_partial_blogname',
	));

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => 'p.site-description',
		'render_callback' => 'product_comparison_woocommerce_Customize_partial_blogdescription',
	));

	// add home page setting pannel
	$wp_customize->add_panel( 'product_comparison_woocommerce_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'Frontpage Options', 'product-comparison-woocommerce' ),
		'priority' => 10,
	));

 	// Header Background color
	$wp_customize->add_setting('product_comparison_woocommerce_header_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_header_background_color', array(
		'label'    => __('Header Background Color', 'product-comparison-woocommerce'),
		'section'  => 'header_image',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_header_img_position',array(
	  'default' => 'center top',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_header_img_position',array(
		'type' => 'select',
		'label' => __('Header Image Position','product-comparison-woocommerce'),
		'section' => 'header_image',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'product-comparison-woocommerce' ),
			'center top'   => esc_html__( 'Top', 'product-comparison-woocommerce' ),
			'right top'   => esc_html__( 'Top Right', 'product-comparison-woocommerce' ),
			'left center'   => esc_html__( 'Left', 'product-comparison-woocommerce' ),
			'center center'   => esc_html__( 'Center', 'product-comparison-woocommerce' ),
			'right center'   => esc_html__( 'Right', 'product-comparison-woocommerce' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'product-comparison-woocommerce' ),
			'center bottom'   => esc_html__( 'Bottom', 'product-comparison-woocommerce' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'product-comparison-woocommerce' ),
		),
		));

	//Menus Settings
	$wp_customize->add_section( 'product_comparison_woocommerce_menu_section' , array(
    	'title' => __( 'Menus Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_panel_id'
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_menu_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_navigation_menu_font_weight',array(
        'default' => 500,
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_menu_section',
        'choices' => array(
        	'100' => __('100','product-comparison-woocommerce'),
            '200' => __('200','product-comparison-woocommerce'),
            '300' => __('300','product-comparison-woocommerce'),
            '400' => __('400','product-comparison-woocommerce'),
            '500' => __('500','product-comparison-woocommerce'),
            '600' => __('600','product-comparison-woocommerce'),
            '700' => __('700','product-comparison-woocommerce'),
            '800' => __('800','product-comparison-woocommerce'),
            '900' => __('900','product-comparison-woocommerce'),
        ),
	) );

	// text trasform
	$wp_customize->add_setting('product_comparison_woocommerce_menu_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_menu_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Menu Text Transform','product-comparison-woocommerce'),
		'choices' => array(
            'Uppercase' => __('Uppercase','product-comparison-woocommerce'),
            'Capitalize' => __('Capitalize','product-comparison-woocommerce'),
            'Lowercase' => __('Lowercase','product-comparison-woocommerce'),
        ),
		'section'=> 'product_comparison_woocommerce_menu_section',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_menus_item_style',array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_menus_item_style',array(
        'type' => 'select',
        'section' => 'product_comparison_woocommerce_menu_section',
		'label' => __('Menu Item Hover Style','product-comparison-woocommerce'),
		'choices' => array(
            'None' => __('None','product-comparison-woocommerce'),
            'Zoom In' => __('Zoom In','product-comparison-woocommerce'),
        ),
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_header_menus_color', array(
		'label'    => __('Menus Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_menu_section',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_menu_section',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_menu_section',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_menu_section',
	)));

	//Topbar
	$wp_customize->add_section('product_comparison_woocommerce_topbar_section' , array(
  		'title' => __( 'Topbar Section', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_panel_id'
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_header_topbar',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_header_topbar',array(
      	'label' => esc_html__( 'Show / Hide Topbar','product-comparison-woocommerce' ),
      	'section' => 'product_comparison_woocommerce_topbar_section'
    )));

	$wp_customize->add_setting('product_comparison_woocommerce_reviews_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_reviews_text',array(
		'label'	=> esc_html__('Add Reviews Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Reviews', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_meta_field_separator_topheader',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_meta_field_separator_topheader',array(
		'label'	=> __('Add Meta Separator','product-comparison-woocommerce'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_reviews_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('product_comparison_woocommerce_reviews_link',array(
		'label'	=> esc_html__('Reviews Link','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'https://example.com/page', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'url'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_supports_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_supports_text',array(
		'label'	=> esc_html__('Add Supports Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Supports', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_supports_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('product_comparison_woocommerce_supports_link',array(
		'label'	=> esc_html__('Supports Link','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'https://example.com/page', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'url'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_total_order',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_total_order',array(
		'label'	=> esc_html__('Add Total Order Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Free Shipping Above $100 Total Order', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'text'
	));

    $wp_customize->add_setting('product_comparison_woocommerce_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_phone_number'
	));
	$wp_customize->add_control('product_comparison_woocommerce_phone_number',array(
		'label'	=> __('Add Phone number','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '+101 987-456-3210', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_topbar_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_phone_icon',array(
		'default'	=> 'fas fa-mobile-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_phone_icon',array(
		'label'	=> __('Add Phone Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_topbar_section',
		'setting'	=> 'product_comparison_woocommerce_phone_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_lite_email',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_email'
	));
	$wp_customize->add_control('product_comparison_woocommerce_lite_email',array(
		'label' => __('Add Email','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'xyz123@example.com', 'product-comparison-woocommerce' ),
        ),
		'section' => 'product_comparison_woocommerce_topbar_section',
		'setting' => 'product_comparison_woocommerce_lite_email',
		'type'    => 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_email_icon',array(
		'default'	=> 'fas fa-paper-plane',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_email_icon',array(
		'label'	=> __('Add Email Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_topbar_section',
		'setting'	=> 'product_comparison_woocommerce_email_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_myaccount_icon',array(
		'default'	=> 'fas fa-sign-in-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_myaccount_icon',array(
		'label'	=> __('Add Myaccount Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_topbar_section',
		'setting'	=> 'product_comparison_woocommerce_myaccount_icon',
		'type'		=> 'icon'
	)));

	// Middle Header
	$wp_customize->add_setting( 'product_comparison_woocommerce_header_search',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_header_search',array(
      	'label' => esc_html__( 'Show / Hide Search','product-comparison-woocommerce' ),
      	'section' => 'product_comparison_woocommerce_topbar_section'
    )));

	$wp_customize->add_setting('product_comparison_woocommerce_openicon_icon',array(
		'default'	=> 'fas fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_openicon_icon',array(
		'label'	=> __('Add Search Open Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_topbar_section',
		'setting'	=> 'product_comparison_woocommerce_openicon_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_closeicon_icon',array(
		'default'	=> 'fa fa-window-close',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_closeicon_icon',array(
		'label'	=> __('Add Search Close Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_topbar_section',
		'setting'	=> 'product_comparison_woocommerce_closeicon_icon',
		'type'		=> 'icon'
	)));

	//Banner section
  	$wp_customize->add_section('product_comparison_woocommerce_banner',array(
		'title' => __('Banner Section','product-comparison-woocommerce'),
    	'description' => __('For more options of banner section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/price-comparison-wordpress-theme">GET PRO</a>','product-comparison-woocommerce'),
		'priority'  => null,
		'panel' => 'product_comparison_woocommerce_panel_id',
	)); 

	$wp_customize->add_setting( 'product_comparison_woocommerce_show_hide_banner',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_show_hide_banner',array(
      	'label' => esc_html__( 'Show / Hide Banner','product-comparison-woocommerce' ),
      	'section' => 'product_comparison_woocommerce_banner'
    )));

	$wp_customize->add_setting('product_comparison_woocommerce_banner_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'product_comparison_woocommerce_banner_image',array(
        'label' => __('Banner Background Image','product-comparison-woocommerce'),
        'description' => __('Image size (1400px x 750px)','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_banner'
	)));

   $wp_customize->add_setting('product_comparison_woocommerce_tagline_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('product_comparison_woocommerce_tagline_title',array(
		'label'	=> __('Banner Title','product-comparison-woocommerce'),
		'section'	=> 'product_comparison_woocommerce_banner',
		'input_attrs' => array(
            'placeholder' => __( 'Compare Price & Product', 'product-comparison-woocommerce' ),
        ),
		'type'		=> 'text'
	));

	 $wp_customize->add_setting('product_comparison_woocommerce_designation_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('product_comparison_woocommerce_designation_text',array(
		'label'	=> __('Banner Small Text','product-comparison-woocommerce'),
		'section'	=> 'product_comparison_woocommerce_banner',
		'type'		=> 'text',
		'input_attrs' => array(
            'placeholder' => __( 'Sell custom on-demand printed products without any up-front investment. From print providers directly to your customers.', 'product-comparison-woocommerce' ),
        ),
	));

	$wp_customize->add_setting('product_comparison_woocommerce_banner_button_label',array(
		'default' => 'Compare Now',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_banner_button_label',array(
		'label' => __('Button','product-comparison-woocommerce'),
		'section' => 'product_comparison_woocommerce_banner',
		'setting' => 'product_comparison_woocommerce_banner_button_label',
		'type' => 'text'
	));
	$wp_customize->add_setting('product_comparison_woocommerce_top_button_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));

	$wp_customize->add_control('product_comparison_woocommerce_top_button_url',array(
		'label'	=> __('Add Button URL','product-comparison-woocommerce'),
		'section'	=> 'product_comparison_woocommerce_banner',
		'setting'	=> 'product_comparison_woocommerce_top_button_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_show_hide_product',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_show_hide_product',array(
      	'label' => esc_html__( 'Show / Hide Product','product-comparison-woocommerce' ),
      	'section' => 'product_comparison_woocommerce_banner'
    )));
	
	$args = array(
       'type'      => 'product',
        'taxonomy' => 'product_cat'
    );
	$categories = get_categories($args);
		$cat_posts = array();
			$i = 0;
			$cat_posts[]='Select';
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('product_comparison_woocommerce_product_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices',
	));
	$wp_customize->add_control('product_comparison_woocommerce_product_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select Popular Product Category','product-comparison-woocommerce'),
		'section' => 'product_comparison_woocommerce_banner',
	));


	//  Best Product Section
	$wp_customize->add_section('product_comparison_woocommerce_best_product_section',array(
		'title'	=> __('Best Product Section','product-comparison-woocommerce'),
		'description' => __('For more options of best product section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/price-comparison-wordpress-theme">GET PRO</a>','product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_best_product_heading', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_best_product_heading', array(
		'label'    => __( 'Add Section Heading', 'product-comparison-woocommerce' ),
		'input_attrs' => array(
            'placeholder' => __( 'Popular Compare', 'product-comparison-woocommerce' ),
        ),
		'section'  => 'product_comparison_woocommerce_best_product_section',
		'type'     => 'text'
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_best_product_small_title', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_best_product_small_title', array(
		'label'    => __( 'Add Section Text', 'product-comparison-woocommerce' ),
		'section'  => 'product_comparison_woocommerce_best_product_section',
		'type'     => 'text'
	) );

	$args = array(
       'type'      => 'product',
        'taxonomy' => 'product_cat'
    );
	$categories = get_categories($args);
		$cat_posts = array();
			$i = 0;
			$cat_posts[]='Select';
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('product_comparison_woocommerce_best_product_category',array(
		'default'	=> 'select',
		'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices',
	));
	$wp_customize->add_control('product_comparison_woocommerce_best_product_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select Product Category','product-comparison-woocommerce'),
		'section' => 'product_comparison_woocommerce_best_product_section',
	));

	//top brand Section
	$wp_customize->add_section('product_comparison_woocommerce_top_brand_section', array(
		'title'       => __('Top Brand Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_top_brand_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_top_brand_text',array(
		'description' => __('<p>1. More options for top brand section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for top brand section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_top_brand_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_top_brand_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_top_brand_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_top_brand_section',
		'type'=> 'hidden'
	));

	//product banner Section
	$wp_customize->add_section('product_comparison_woocommerce_product_banner_section', array(
		'title'       => __('Product Banner Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_product_banner_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_product_banner_text',array(
		'description' => __('<p>1. More options for product banner section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for product banner section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_product_banner_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_product_banner_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_product_banner_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_product_banner_section',
		'type'=> 'hidden'
	));

	//category Section
	$wp_customize->add_section('product_comparison_woocommerce_category_section', array(
		'title'       => __('Category Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_category_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_category_text',array(
		'description' => __('<p>1. More options for category section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for category section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_category_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_category_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_category_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_category_section',
		'type'=> 'hidden'
	));


	//Popular Compare Section
	$wp_customize->add_section('product_comparison_woocommerce_popular_compare_section', array(
		'title'       => __('Popular Compare Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_popular_compare_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_popular_compare_text',array(
		'description' => __('<p>1. More options for popular compare section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for popular compare section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_popular_compare_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_popular_compare_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_popular_compare_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_popular_compare_section',
		'type'=> 'hidden'
	));

	//Get Instant Compaire Section
	$wp_customize->add_section('product_comparison_woocommerce_get_instant_compaire_section', array(
		'title'       => __('Get Instant Compaire Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_get_instant_compaire_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_get_instant_compaire_text',array(
		'description' => __('<p>1. More options for get instant compaire section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for get instant compaire section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_get_instant_compaire_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_get_instant_compaire_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_get_instant_compaire_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_get_instant_compaire_section',
		'type'=> 'hidden'
	));

	//upcoming product Section
	$wp_customize->add_section('product_comparison_woocommerce_upcoming_product_section', array(
		'title'       => __('Upcoming Product Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_upcoming_product_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_upcoming_product_text',array(
		'description' => __('<p>1. More options for upcoming product section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for upcoming product section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_upcoming_product_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_upcoming_product_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_upcoming_product_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_upcoming_product_section',
		'type'=> 'hidden'
	));


	//why choose us Section
	$wp_customize->add_section('product_comparison_woocommerce_why_choose_us_section', array(
		'title'       => __('Why Choose Us Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_why_choose_us_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_why_choose_us_text',array(
		'description' => __('<p>1. More options for why choose us section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for why choose us section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_why_choose_us_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_why_choose_us_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_why_choose_us_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_why_choose_us_section',
		'type'=> 'hidden'
	));

	//latest news Section
	$wp_customize->add_section('product_comparison_woocommerce_latest_news_section', array(
		'title'       => __('Latest News Section', 'product-comparison-woocommerce'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','product-comparison-woocommerce'),
		'priority'    => null,
		'panel'       => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_latest_news_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_latest_news_text',array(
		'description' => __('<p>1. More options for latest news section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for latest news section.</p>','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_latest_news_section',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_latest_news_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_latest_news_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='https://www.vwthemes.com/products/price-comparison-wordpress-theme'>More Info</a>",
		'section'=> 'product_comparison_woocommerce_latest_news_section',
		'type'=> 'hidden'
	));

	//Footer Text
	$wp_customize->add_section('product_comparison_woocommerce_footer',array(
		'title'	=> esc_html__('Footer Settings','product-comparison-woocommerce'),
		'description' => __('For more options of footer section </br> <a class="go-pro-btn" target="blank" href="https://www.vwthemes.com/products/price-comparison-wordpress-theme">GET PRO</a>','product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_panel_id',
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_footer_hide_show',array(
	  'default' => 1,
	  'transport' => 'refresh',
	  'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_footer_hide_show',array(
	'label' => esc_html__( 'Show / Hide Footer','product-comparison-woocommerce' ),
	'section' => 'product_comparison_woocommerce_footer'
	)));

	// font size
	$wp_customize->add_setting('product_comparison_woocommerce_button_footer_font_size',array(
		'default'=> 30,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_footer_font_size',array(
		'label'	=> __('Footer Heading Font Size','product-comparison-woocommerce'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'product_comparison_woocommerce_footer',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_button_footer_heading_letter_spacing',array(
		'default'=> 1,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_footer_heading_letter_spacing',array(
		'label'	=> __('Heading Letter Spacing','product-comparison-woocommerce'),
  		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'product_comparison_woocommerce_footer',
	));

	// text trasform
	$wp_customize->add_setting('product_comparison_woocommerce_button_footer_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_footer_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Heading Text Transform','product-comparison-woocommerce'),
		'choices' => array(
      'Uppercase' => __('Uppercase','product-comparison-woocommerce'),
      'Capitalize' => __('Capitalize','product-comparison-woocommerce'),
      'Lowercase' => __('Lowercase','product-comparison-woocommerce'),
    ),
		'section'=> 'product_comparison_woocommerce_footer',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_footer_heading_weight',array(
        'default' => 600,
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_footer_heading_weight',array(
        'type' => 'select',
        'label' => __('Heading Font Weight','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_footer',
        'choices' => array(
        	'100' => __('100','product-comparison-woocommerce'),
            '200' => __('200','product-comparison-woocommerce'),
            '300' => __('300','product-comparison-woocommerce'),
            '400' => __('400','product-comparison-woocommerce'),
            '500' => __('500','product-comparison-woocommerce'),
            '600' => __('600','product-comparison-woocommerce'),
            '700' => __('700','product-comparison-woocommerce'),
            '800' => __('800','product-comparison-woocommerce'),
            '900' => __('900','product-comparison-woocommerce'),
        ),
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_footer_template',array(
	  'default'	=> esc_html('product_comparison_woocommerce-footer-one'),
	  'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_footer_template',array(
	      'label'	=> esc_html__('Footer style','product-comparison-woocommerce'),
	      'section'	=> 'product_comparison_woocommerce_footer',
	      'setting'	=> 'product_comparison_woocommerce_footer_template',
	      'type' => 'select',
	      'choices' => array(
	          'product_comparison_woocommerce-footer-one' => esc_html__('Style 1', 'product-comparison-woocommerce'),
	          'product_comparison_woocommerce-footer-two' => esc_html__('Style 2', 'product-comparison-woocommerce'),
	          'product_comparison_woocommerce-footer-three' => esc_html__('Style 3', 'product-comparison-woocommerce'),
	          'product_comparison_woocommerce-footer-four' => esc_html__('Style 4', 'product-comparison-woocommerce'),
	          'product_comparison_woocommerce-footer-five' => esc_html__('Style 5', 'product-comparison-woocommerce'),
	          )
	));

	$wp_customize->add_setting('product_comparison_woocommerce_footer_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_footer_background_color', array(
		'label'    => __('Footer Background Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_footer',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'product_comparison_woocommerce_footer_background_image',array(
      'label' => __('Footer Background Image','product-comparison-woocommerce'),
      'section' => 'product_comparison_woocommerce_footer'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_footer_img_position',array(
	  'default' => 'center center',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','product-comparison-woocommerce'),
		'section' => 'product_comparison_woocommerce_footer',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'product-comparison-woocommerce' ),
			'center top'   => esc_html__( 'Top', 'product-comparison-woocommerce' ),
			'right top'   => esc_html__( 'Top Right', 'product-comparison-woocommerce' ),
			'left center'   => esc_html__( 'Left', 'product-comparison-woocommerce' ),
			'center center'   => esc_html__( 'Center', 'product-comparison-woocommerce' ),
			'right center'   => esc_html__( 'Right', 'product-comparison-woocommerce' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'product-comparison-woocommerce' ),
			'center bottom'   => esc_html__( 'Bottom', 'product-comparison-woocommerce' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'product-comparison-woocommerce' ),
		),
	));

  // Footer
  $wp_customize->add_setting('product_comparison_woocommerce_img_footer',array(
    'default'=> 'scroll',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_img_footer',array(
    'type' => 'select',
    'label' => __('Footer Background Attatchment','product-comparison-woocommerce'),
    'choices' => array(
      'fixed' => __('fixed','product-comparison-woocommerce'),
      'scroll' => __('scroll','product-comparison-woocommerce'),
    ),
    'section'=> 'product_comparison_woocommerce_footer',
  ));

  // footer padding
  $wp_customize->add_setting('product_comparison_woocommerce_footer_padding',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_footer_padding',array(
    'label' => __('Footer Top Bottom Padding','product-comparison-woocommerce'),
    'description' => __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
    'section'=> 'product_comparison_woocommerce_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting('product_comparison_woocommerce_footer_widgets_heading',array(
    'default' => 'Left',
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_footer_widgets_heading',array(
    'type' => 'select',
    'label' => __('Footer Widget Heading','product-comparison-woocommerce'),
    'section' => 'product_comparison_woocommerce_footer',
    'choices' => array(
      'Left' => __('Left','product-comparison-woocommerce'),
      'Center' => __('Center','product-comparison-woocommerce'),
      'Right' => __('Right','product-comparison-woocommerce')
    ),
  ) );

  $wp_customize->add_setting('product_comparison_woocommerce_footer_widgets_content',array(
    'default' => 'Left',
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_footer_widgets_content',array(
    'type' => 'select',
    'label' => __('Footer Widget Content','product-comparison-woocommerce'),
    'section' => 'product_comparison_woocommerce_footer',
    'choices' => array(
      'Left' => __('Left','product-comparison-woocommerce'),
      'Center' => __('Center','product-comparison-woocommerce'),
      'Right' => __('Right','product-comparison-woocommerce')
    ),
  	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('product_comparison_woocommerce_footer_text', array(
		'selector' => '.copyright p',
		'render_callback' => 'product_comparison_woocommerce_Customize_partial_product_comparison_woocommerce_footer_text',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_footer_text',array(
		'label'	=> esc_html__('Copyright Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Copyright 2021, .....', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_copyright_hide_show',array(
	  'default' => 1,
	  'transport' => 'refresh',
	  'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_copyright_hide_show',array(
		'label' => esc_html__( 'Show / Hide Copyright','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_footer'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_copyright_alingment',array(
        'default' => 'center',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Image_Radio_Control($wp_customize, 'product_comparison_woocommerce_copyright_alingment', array(
        'type' => 'select',
        'label' => esc_html__('Copyright Alignment','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_footer',
        'settings' => 'product_comparison_woocommerce_copyright_alingment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

	$wp_customize->add_setting('product_comparison_woocommerce_copyright_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_footer',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_copyright_font_size',array(
		'label' => __('Copyright Font Size','product-comparison-woocommerce'),
		'description' => __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
		        'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
		    ),
		'section'=> 'product_comparison_woocommerce_footer',
		'type'=> 'text'
	));

    $wp_customize->add_setting( 'product_comparison_woocommerce_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll to Top','product-comparison-woocommerce' ),
      	'section' => 'product_comparison_woocommerce_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('product_comparison_woocommerce_scroll_to_top_icon', array(
		'selector' => '.scrollup i',
		'render_callback' => 'product_comparison_woocommerce_Customize_partial_product_comparison_woocommerce_scroll_to_top_icon',
	));

    $wp_customize->add_setting('product_comparison_woocommerce_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Image_Radio_Control($wp_customize, 'product_comparison_woocommerce_scroll_top_alignment', array(
        'type' => 'select',
        'label' => esc_html__('Scroll To Top','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_footer',
        'settings' => 'product_comparison_woocommerce_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

     $wp_customize->add_setting('product_comparison_woocommerce_scroll_top_icon',array(
    'default' => 'fas fa-long-arrow-alt-up',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser($wp_customize,'product_comparison_woocommerce_scroll_top_icon',array(
    'label' => __('Add Scroll to Top Icon','product-comparison-woocommerce'),
    'transport' => 'refresh',
    'section' => 'product_comparison_woocommerce_footer',
    'setting' => 'product_comparison_woocommerce_scroll_top_icon',
    'type'    => 'icon'
  )));

  $wp_customize->add_setting('product_comparison_woocommerce_scroll_to_top_font_size',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_scroll_to_top_font_size',array(
    'label' => __('Icon Font Size','product-comparison-woocommerce'),
    'description' => __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
    'section'=> 'product_comparison_woocommerce_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting('product_comparison_woocommerce_scroll_to_top_padding',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_scroll_to_top_padding',array(
    'label' => __('Icon Top Bottom Padding','product-comparison-woocommerce'),
    'description' => __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
    'section'=> 'product_comparison_woocommerce_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting('product_comparison_woocommerce_scroll_to_top_width',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_scroll_to_top_width',array(
    'label' => __('Icon Width','product-comparison-woocommerce'),
    'description' => __('Enter a value in pixels Example:20px','product-comparison-woocommerce'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
  ),
  'section'=> 'product_comparison_woocommerce_footer',
  'type'=> 'text'
  ));

  $wp_customize->add_setting('product_comparison_woocommerce_scroll_to_top_height',array(
    'default'=> '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('product_comparison_woocommerce_scroll_to_top_height',array(
    'label' => __('Icon Height','product-comparison-woocommerce'),
    'description' => __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
    'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
    'section'=> 'product_comparison_woocommerce_footer',
    'type'=> 'text'
  ));

  $wp_customize->add_setting( 'product_comparison_woocommerce_scroll_to_top_border_radius', array(
    'default'              => '',
    'transport'        => 'refresh',
    'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
  ) );
  $wp_customize->add_control( 'product_comparison_woocommerce_scroll_to_top_border_radius', array(
    'label'       => esc_html__( 'Icon Border Radius','product-comparison-woocommerce' ),
    'section'     => 'product_comparison_woocommerce_footer',
    'type'        => 'range',
    'input_attrs' => array(
      'step'             => 1,
      'min'              => 1,
      'max'              => 50,
    ),
  ) );

  	// footer social icon
	$wp_customize->add_setting( 'product_comparison_woocommerce_footer_icon',array(
		'default' => false,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	) );
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_footer_icon',array(
		'label' => esc_html__( 'Show / Hide Footer Social Icon','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_footer'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_align_footer_social_icon',array(
        'default' => 'center',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_align_footer_social_icon',array(
        'type' => 'select',
        'label' => __('Social Icon Alignment ','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_footer',
        'choices' => array(
            'left' => __('Left','product-comparison-woocommerce'),
            'right' => __('Right','product-comparison-woocommerce'),
            'center' => __('Center','product-comparison-woocommerce'),
        ),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_copyright_sticky',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new product_comparison_woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_copyright_sticky',array(
      'label' => esc_html__( 'Show / Hide Sticky Copyright','product-comparison-woocommerce' ),
      'section' => 'product_comparison_woocommerce_footer'
    )));

   $wp_customize->add_setting('product_comparison_woocommerce_footer_social_icons_font_size',array(
       'default'=> 16,
       'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('product_comparison_woocommerce_footer_social_icons_font_size',array(
    'label' => __('Social Icon Font Size','product-comparison-woocommerce'),
    	'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'product_comparison_woocommerce_footer',
	 ));	

   	//Blog Post
	$wp_customize->add_panel( 'product_comparison_woocommerce_blog_post_parent_panel', array(
		'title' => esc_html__( 'Blog Post Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_panel_id',
		'priority' => 20,
	));

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'product_comparison_woocommerce_post_settings', array(
		'title' => esc_html__( 'Post Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('product_comparison_woocommerce_toggle_postdate', array(
		'selector' => '.post-main-box h2 a',
		'render_callback' => 'product_comparison_woocommerce_Customize_partial_product_comparison_woocommerce_toggle_postdate',
	));

	//Blog layout
  $wp_customize->add_setting('product_comparison_woocommerce_blog_layout_option',array(
    'default' => 'Default',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
  ));
  $wp_customize->add_control(new Product_Comparison_Woocommerce_Image_Radio_Control($wp_customize, 'product_comparison_woocommerce_blog_layout_option', array(
    'type' => 'select',
    'label' => __('Blog Post Layouts','product-comparison-woocommerce'),
    'section' => 'product_comparison_woocommerce_post_settings',
    'choices' => array(
        'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
        'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
        'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
  ))));

	$wp_customize->add_setting('product_comparison_woocommerce_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_theme_options',array(
        'type' => 'select',
        'label' => esc_html__('Post Sidebar Layout','product-comparison-woocommerce'),
        'description' => esc_html__('Here you can change the sidebar layout for posts. ','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_post_settings',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','product-comparison-woocommerce'),
            'Right Sidebar' => esc_html__('Right Sidebar','product-comparison-woocommerce'),
            'One Column' => esc_html__('One Column','product-comparison-woocommerce'),
       		'Three Columns' => __('Three Columns','product-comparison-woocommerce'),
        	'Four Columns' => __('Four Columns','product-comparison-woocommerce'),
            'Grid Layout' => esc_html__('Grid Layout','product-comparison-woocommerce')
        ),
	) );

  	$wp_customize->add_setting('product_comparison_woocommerce_toggle_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_toggle_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_post_settings',
		'setting'	=> 'product_comparison_woocommerce_toggle_postdate_icon',
		'type'		=> 'icon'
	)));

 	$wp_customize->add_setting( 'product_comparison_woocommerce_blog_toggle_postdate',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  ));
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_blog_toggle_postdate',array(
    'label' => esc_html__( 'Show / Hide Post Date','product-comparison-woocommerce' ),
    'section' => 'product_comparison_woocommerce_post_settings'
  )));

	$wp_customize->add_setting('product_comparison_woocommerce_toggle_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_toggle_author_icon',array(
		'label'	=> __('Add Author Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_post_settings',
		'setting'	=> 'product_comparison_woocommerce_toggle_author_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'product_comparison_woocommerce_blog_toggle_author',array(
	'default' => 1,
	'transport' => 'refresh',
	'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  ));
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_blog_toggle_author',array(
	'label' => esc_html__( 'Show / Hide Author','product-comparison-woocommerce' ),
	'section' => 'product_comparison_woocommerce_post_settings'
  )));

  $wp_customize->add_setting('product_comparison_woocommerce_toggle_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_toggle_comments_icon',array(
		'label'	=> __('Add Comments Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_post_settings',
		'setting'	=> 'product_comparison_woocommerce_toggle_comments_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'product_comparison_woocommerce_blog_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  ) );
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_blog_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_post_settings'
  )));

  $wp_customize->add_setting('product_comparison_woocommerce_toggle_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_toggle_time_icon',array(
		'label'	=> __('Add Time Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_post_settings',
		'setting'	=> 'product_comparison_woocommerce_toggle_time_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'product_comparison_woocommerce_blog_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  ) );
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_blog_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_post_settings'
  )));

  $wp_customize->add_setting( 'product_comparison_woocommerce_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_featured_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_post_settings'
  )));

  $wp_customize->add_setting( 'product_comparison_woocommerce_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Featured Image
	$wp_customize->add_setting('product_comparison_woocommerce_blog_post_featured_image_dimension',array(
       'default' => 'default',
       'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_blog_post_featured_image_dimension',array(
		'type' => 'select',
		'label'	=> __('Blog Post Featured Image Dimension','product-comparison-woocommerce'),
		'section'	=> 'product_comparison_woocommerce_post_settings',
		'choices' => array(
		'default' => __('Default','product-comparison-woocommerce'),
		'custom' => __('Custom Image Size','product-comparison-woocommerce'),
      ),
	));

	$wp_customize->add_setting('product_comparison_woocommerce_blog_post_featured_image_custom_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		));
	$wp_customize->add_control('product_comparison_woocommerce_blog_post_featured_image_custom_width',array(
		'label'	=> __('Featured Image Custom Width','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'product-comparison-woocommerce' ),),
		'section'=> 'product_comparison_woocommerce_post_settings',
		'type'=> 'text',
		'active_callback' => 'product_comparison_woocommerce_blog_post_featured_image_dimension'
		));

	$wp_customize->add_setting('product_comparison_woocommerce_blog_post_featured_image_custom_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_blog_post_featured_image_custom_height',array(
		'label'	=> __('Featured Image Custom Height','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
    	'placeholder' => __( '10px', 'product-comparison-woocommerce' ),),
		'section'=> 'product_comparison_woocommerce_post_settings',
		'type'=> 'text',
		'active_callback' => 'product_comparison_woocommerce_blog_post_featured_image_dimension'
	));

  $wp_customize->add_setting( 'product_comparison_woocommerce_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_post_settings',
		'type'        => 'range',
		'settings'    => 'product_comparison_woocommerce_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','product-comparison-woocommerce'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_post_settings',
		'type'=> 'text'
	));

  $wp_customize->add_setting('product_comparison_woocommerce_excerpt_settings',array(
    'default' => 'Excerpt',
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_excerpt_settings',array(
    'type' => 'select',
    'label' => esc_html__('Post Content','product-comparison-woocommerce'),
    'section' => 'product_comparison_woocommerce_post_settings',
    'choices' => array(
    	'Content' => esc_html__('Content','product-comparison-woocommerce'),
        'Excerpt' => esc_html__('Excerpt','product-comparison-woocommerce'),
        'No Content' => esc_html__('No Content','product-comparison-woocommerce')
        ),
	) );

  $wp_customize->add_setting('product_comparison_woocommerce_blog_page_posts_settings',array(
    'default' => 'Into Blocks',
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_blog_page_posts_settings',array(
    'type' => 'select',
    'label' => __('Display Blog Posts','product-comparison-woocommerce'),
    'section' => 'product_comparison_woocommerce_post_settings',
    'choices' => array(
    	'Into Blocks' => __('Into Blocks','product-comparison-woocommerce'),
        'Without Blocks' => __('Without Blocks','product-comparison-woocommerce')
        ),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_blog_pagination_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  ));
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_blog_pagination_hide_show',array(
		'label' => esc_html__( 'Show / Hide Blog Pagination','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_post_settings'
  )));
  // Web Frame // 
	
	$wp_customize->add_setting( 'product_comparison_woocommerce_blog_web_frame',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new product_comparison_woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_web_frame',array(
		'label' => esc_html__( 'Show / Hide Blog Page Border','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_post_settings'
    )));

	$wp_customize->add_setting('product_comparison_woocommerce_web_frame_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_web_frame_border_color', array(
		'label'    => __('Blog Page Border Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_post_settings',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_web_frame_border_width',array(
		'default'=> '',
		'sanitize_callback' => 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_web_frame_border_width',array(
		'label' => __('Blog Page Width','product-comparison-woocommerce'),
		'description' => __('Enter a value in pixels Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
		'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
	),
		'section'=> 'product_comparison_woocommerce_post_settings',
		'type'=> 'text'
));

	$wp_customize->add_setting('product_comparison_woocommerce_blog_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_blog_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_blog_pagination_type', array(
    'default'			=> 'blog-page-numbers',
    'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_choices'
  ));
  $wp_customize->add_control( 'product_comparison_woocommerce_blog_pagination_type', array(
    'section' => 'product_comparison_woocommerce_post_settings',
    'type' => 'select',
    'label' => __( 'Blog Pagination', 'product-comparison-woocommerce' ),
    'choices'		=> array(
        'blog-page-numbers'  => __( 'Numeric', 'product-comparison-woocommerce' ),
        'next-prev' => __( 'Older Posts/Newer Posts', 'product-comparison-woocommerce' ),
  )));

   $wp_customize->add_setting('product_comparison_woocommerce_show_first_caps', array(
	    'default'           => false,
	    'transport'         => 'refresh',
	    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization',
	));

	$wp_customize->add_control(new Product_comparison_woocommerce_Toggle_Switch_Custom_Control(
	    $wp_customize,
	    'product_comparison_woocommerce_show_first_caps',
	    array(
	        'label'   => esc_html__('First Cap (First Capital Letter)', 'product-comparison-woocommerce'),
	        'section' => 'product_comparison_woocommerce_post_settings',
	    )
	));

    // Button Settings
	$wp_customize->add_section( 'product_comparison_woocommerce_button_settings', array(
		'title' => esc_html__( 'Button Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('product_comparison_woocommerce_button_text', array(
		'selector' => '.post-main-box .more-btn a',
		'render_callback' => 'product_comparison_woocommerce_Customize_partial_product_comparison_woocommerce_button_text',
	));

  $wp_customize->add_setting('product_comparison_woocommerce_button_text',array(
		'default'=> esc_html__('Read More','product-comparison-woocommerce'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_text',array(
		'label'	=> esc_html__('Add Button Text','product-comparison-woocommerce'),
		'input_attrs' => array(
    'placeholder' => esc_html__( 'Read More', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_button_settings',
		'type'=> 'text'
	));

	// font size button
	$wp_customize->add_setting('product_comparison_woocommerce_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_font_size',array(
		'label'	=> __('Button Font Size','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
  		'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
  	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'product_comparison_woocommerce_button_settings',
	));


	$wp_customize->add_setting( 'product_comparison_woocommerce_button_border_radius', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	// button padding
	$wp_customize->add_setting('product_comparison_woocommerce_button_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_top_bottom_padding',array(
		'label'	=> __('Button Top Bottom Padding','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
		'section'=> 'product_comparison_woocommerce_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_button_left_right_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_left_right_padding',array(
		'label'	=> __('Button Left Right Padding','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
    ),
		'section'=> 'product_comparison_woocommerce_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_button_letter_spacing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_letter_spacing',array(
		'label'	=> __('Button Letter Spacing','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
      	'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
  ),
  	'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
	),
		'section'=> 'product_comparison_woocommerce_button_settings',
	));

	// Button weight button
	$wp_customize->add_setting('product_comparison_woocommerce_button_font_weight', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('product_comparison_woocommerce_button_font_weight', array(
		'label' => __('Button Font Weight','product-comparison-woocommerce'),
		'description' => __('Enter value between 100 to 900. Example: 400, 600','product-comparison-woocommerce'),
		'type' => 'number',
		'input_attrs' => array(
			'step' => 100,
			'min'  => 100,
			'max'  => 900,
    ),
		'section' => 'product_comparison_woocommerce_button_settings',
    ));

	// text trasform
	$wp_customize->add_setting('product_comparison_woocommerce_button_text_transform',array(
		'default'=> 'Capitalize',
		'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','product-comparison-woocommerce'),
		'choices' => array(
      'Uppercase' => __('Uppercase','product-comparison-woocommerce'),
      'Capitalize' => __('Capitalize','product-comparison-woocommerce'),
      'Lowercase' => __('Lowercase','product-comparison-woocommerce'),
    ),
		'section'=> 'product_comparison_woocommerce_button_settings',
	));

	// Button hover effect 
	$wp_customize->add_setting('product_comparison_woocommerce_button_hover_effect',array(
	'default' => '',
	'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
    ));
	$wp_customize->add_control('product_comparison_woocommerce_button_hover_effect', array(
        'type' => 'select',
        'label' => __( 'Button Hover Effect', 'product-comparison-woocommerce' ),
        'section' => 'product_comparison_woocommerce_button_settings',
        'choices' => array(
			'pulse'     => __( 'Pulse', 'product-comparison-woocommerce' ),
			'rubberBand'=> __( 'RubberBand', 'product-comparison-woocommerce' ),
			'swing'     => __( 'Swing', 'product-comparison-woocommerce' ),
			'tada'      => __( 'Tada', 'product-comparison-woocommerce' ),
			'jello'     => __( 'Jello', 'product-comparison-woocommerce' ),
			'disable'   => __( 'Disabled', 'product-comparison-woocommerce' )
        ),
    ));

	// Related Post Settings
	$wp_customize->add_section( 'product_comparison_woocommerce_related_posts_settings', array(
		'title' => esc_html__( 'Related Posts Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('product_comparison_woocommerce_related_post_title', array(
		'selector' => '.related-post h3',
		'render_callback' => 'product_comparison_woocommerce_Customize_partial_product_comparison_woocommerce_related_post_title',
	));

  	$wp_customize->add_setting( 'product_comparison_woocommerce_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	) );
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_post',array(
		'label' => esc_html__( 'Related Post','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_related_posts_settings'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_related_post_title',array(
		'label'	=> esc_html__('Add Related Post Title','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Related Post', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_related_posts_settings',
		'type'=> 'text'
	));

 	$wp_customize->add_setting('product_comparison_woocommerce_related_posts_count',array(
		'default'=> 3,
		'sanitize_callback'	=> 'product_comparison_woocommerce_sanitize_number_absint'
	));
	$wp_customize->add_control('product_comparison_woocommerce_related_posts_count',array(
		'label'	=> esc_html__('Add Related Post Count','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '3', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_related_posts_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_related_posts_excerpt_number', array(
		'default'              => 20,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_related_posts_excerpt_number', array(
		'label'       => esc_html__( 'Related Posts Excerpt length','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_related_posts_settings',
		'type'        => 'range',
		'settings'    => 'product_comparison_woocommerce_related_posts_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_related_toggle_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	));
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_toggle_postdate',array(
	    'label' => esc_html__( 'Show / Hide Post Date','product-comparison-woocommerce' ),
	    'section' => 'product_comparison_woocommerce_related_posts_settings'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_related_postdate_icon',array(
	    'default' => 'fas fa-calendar-alt',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
  	$wp_customize,'product_comparison_woocommerce_related_postdate_icon',array(
	    'label' => __('Add Post Date Icon','product-comparison-woocommerce'),
	    'transport' => 'refresh',
	    'section' => 'product_comparison_woocommerce_related_posts_settings',
	    'setting' => 'product_comparison_woocommerce_related_postdate_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_related_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	));
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_toggle_author',array(
		'label' => esc_html__( 'Show / Hide Author','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_related_posts_settings'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_related_author_icon',array(
	    'default' => 'fas fa-user',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
  	$wp_customize,'product_comparison_woocommerce_related_author_icon',array(
	    'label' => __('Add Author Icon','product-comparison-woocommerce'),
	    'transport' => 'refresh',
	    'section' => 'product_comparison_woocommerce_related_posts_settings',
	    'setting' => 'product_comparison_woocommerce_related_author_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_related_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	) );
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_toggle_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_related_posts_settings'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_related_comments_icon',array(
	    'default' => 'fa fa-comments',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
  	$wp_customize,'product_comparison_woocommerce_related_comments_icon',array(
	    'label' => __('Add Comments Icon','product-comparison-woocommerce'),
	    'transport' => 'refresh',
	    'section' => 'product_comparison_woocommerce_related_posts_settings',
	    'setting' => 'product_comparison_woocommerce_related_comments_icon',
	    'type'    => 'icon'
  	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_related_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	) );
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_toggle_time',array(
		'label' => esc_html__( 'Show / Hide Time','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_related_posts_settings'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_related_time_icon',array(
	    'default' => 'fas fa-clock',
	    'sanitize_callback' => 'sanitize_text_field'
  	));
  	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
  	$wp_customize,'product_comparison_woocommerce_related_time_icon',array(
	    'label' => __('Add Time Icon','product-comparison-woocommerce'),
	    'transport' => 'refresh',
	    'section' => 'product_comparison_woocommerce_related_posts_settings',
	    'setting' => 'product_comparison_woocommerce_related_time_icon',
	    'type'    => 'icon'
  	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_related_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_related_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','product-comparison-woocommerce'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_related_posts_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_related_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_related_posts_settings'
  	)));

  	$wp_customize->add_setting( 'product_comparison_woocommerce_related_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_related_image_box_shadow', array(
		'label'       => esc_html__( 'Related post Image Box Shadow','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_related_posts_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	$wp_customize->add_setting('product_comparison_woocommerce_related_button_text',array(
		'default'=> esc_html__('Read More','product-comparison-woocommerce'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_related_button_text',array(
		'label'	=> esc_html__('Add Button Text','product-comparison-woocommerce'),
		'input_attrs' => array(
      'placeholder' => esc_html__( 'Read More', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_related_posts_settings',
		'type'=> 'text'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'product_comparison_woocommerce_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_blog_post_parent_panel',
	));

  	$wp_customize->add_setting('product_comparison_woocommerce_single_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_single_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_single_blog_settings',
		'setting'	=> 'product_comparison_woocommerce_single_postdate_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'product_comparison_woocommerce_single_postdate',array(
    'default' => 1,
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	) );
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_postdate',array(
	   'label' => esc_html__( 'Show / Hide Date','product-comparison-woocommerce' ),
	   'section' => 'product_comparison_woocommerce_single_blog_settings'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_single_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_single_author_icon',array(
		'label'	=> __('Add Author Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_single_blog_settings',
		'setting'	=> 'product_comparison_woocommerce_single_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'product_comparison_woocommerce_single_author',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	) );
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_author',array(
	    'label' => esc_html__( 'Show / Hide Author','product-comparison-woocommerce' ),
	    'section' => 'product_comparison_woocommerce_single_blog_settings'
	)));

   	$wp_customize->add_setting('product_comparison_woocommerce_single_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_single_comments_icon',array(
		'label'	=> __('Add Comments Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_single_blog_settings',
		'setting'	=> 'product_comparison_woocommerce_single_comments_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_single_comments',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	) );
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_comments',array(
	    'label' => esc_html__( 'Show / Hide Comments','product-comparison-woocommerce' ),
	    'section' => 'product_comparison_woocommerce_single_blog_settings'
	)));

  	$wp_customize->add_setting('product_comparison_woocommerce_single_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_single_time_icon',array(
		'label'	=> __('Add Time Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_single_blog_settings',
		'setting'	=> 'product_comparison_woocommerce_single_time_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_single_time',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	) );
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_time',array(
	    'label' => esc_html__( 'Show / Hide Time','product-comparison-woocommerce' ),
	    'section' => 'product_comparison_woocommerce_single_blog_settings'
	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_toggle_tags',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_toggle_tags', array(
		'label' => esc_html__( 'Show / Hide Tags','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_single_blog_settings'
  )));

	$wp_customize->add_setting( 'product_comparison_woocommerce_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
 	 $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_single_blog_settings'
    )));

	// Single Posts Category
 	 $wp_customize->add_setting( 'product_comparison_woocommerce_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_post_category',array(
		'label' => esc_html__( 'Show / Hide Category','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_single_blog_settings'
    )));

	$wp_customize->add_setting('product_comparison_woocommerce_single_post_styling',array(
    'default' => 'Button',
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_single_post_styling',array(
	'description' => __('Change the styling of Category .','product-comparison-woocommerce'),
	'type' => 'select',
    'section' => 'product_comparison_woocommerce_single_blog_settings',
    'choices' => array(
        'Button' => __('Button','product-comparison-woocommerce'),
		'Underline' => __('Underline','product-comparison-woocommerce'),
		'Default' => __('Default','product-comparison-woocommerce'),
      ),
	) );

    $wp_customize->add_setting( 'product_comparison_woocommerce_singlepost_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_singlepost_image_box_shadow', array(
		'label'       => esc_html__( 'Single post Image Box Shadow','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_single_blog_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','product-comparison-woocommerce'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_blog_post_navigation_show_hide', array(
		  'label' => esc_html__( 'Show / Hide Post Navigation','product-comparison-woocommerce' ),
		  'section' => 'product_comparison_woocommerce_single_blog_settings'
	)));

	// Featured Image Hover Effect
	$wp_customize->add_setting(
		'product_comparison_woocommerce_featured_image_hover',
		array(
			'default'           => 'none',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'product_comparison_woocommerce_featured_image_hover',
		array(
			'label'   => __( 'Featured Image Hover Effect', 'product-comparison-woocommerce' ),
			'section' => 'product_comparison_woocommerce_single_blog_settings',
			'type'    => 'select',
			'choices' => array(
				'none'      => __( 'None', 'product-comparison-woocommerce' ),
				'zoom-in'   => __( 'Zoom In', 'product-comparison-woocommerce' ),
				'zoom-out'  => __( 'Zoom Out', 'product-comparison-woocommerce' ),
				'scale'     => __( 'Scale', 'product-comparison-woocommerce' ),
				'grayscale' => __( 'Grayscale', 'product-comparison-woocommerce' ),
				'blur'      => __( 'Blur', 'product-comparison-woocommerce' ),
				'bright'    => __( 'Bright', 'product-comparison-woocommerce' ),
				'sepia'     => __( 'Sepia', 'product-comparison-woocommerce' ),
				'translate' => __( 'Translate', 'product-comparison-woocommerce' ),
			),
		)
	);

	$wp_customize->add_setting( 'product_comparison_woocommerce_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
   $wp_customize->add_control( new product_comparison_woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_post_breadcrumb',array(
		'label' => esc_html__( 'Show / Hide Breadcrumb','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_single_blog_settings'
    )));

	//navigation text
	$wp_customize->add_setting('product_comparison_woocommerce_single_blog_prev_navigation_text',array(
		'default'=> 'PREVIOUS',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_single_blog_next_navigation_text',array(
		'default'=> 'NEXT',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_single_blog_comment_title',array(
		'default'=> 'Leave a Reply',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('product_comparison_woocommerce_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','product-comparison-woocommerce'),
		'input_attrs' => array(
        'placeholder' => __( 'Leave a Reply', 'product-comparison-woocommerce' ),
    	),
		'section'=> 'product_comparison_woocommerce_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_single_blog_comment_button_text',array(
		'default'=> 'Post Comment',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('product_comparison_woocommerce_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','product-comparison-woocommerce'),
		'input_attrs' => array(
    'placeholder' => __( 'Post Comment', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in %. Example:50%','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_single_blog_settings',
		'type'=> 'text'
	));

	 // Grid layout setting
	$wp_customize->add_section( 'product_comparison_woocommerce_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_blog_post_parent_panel',
	));

  	$wp_customize->add_setting('product_comparison_woocommerce_grid_postdate_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_grid_postdate_icon',array(
		'label'	=> __('Add Post Date Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_grid_layout_settings',
		'setting'	=> 'product_comparison_woocommerce_grid_postdate_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting( 'product_comparison_woocommerce_grid_postdate',array(
	  'default' => 1,
	  'transport' => 'refresh',
	  'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  ) );
  $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_grid_postdate',array(
    'label' => esc_html__( 'Show / Hide Post Date','product-comparison-woocommerce' ),
    'section' => 'product_comparison_woocommerce_grid_layout_settings'
  )));

	$wp_customize->add_setting('product_comparison_woocommerce_grid_author_icon',array(
		'default'	=> 'fas fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_grid_author_icon',array(
		'label'	=> __('Add Author Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_grid_layout_settings',
		'setting'	=> 'product_comparison_woocommerce_grid_author_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'product_comparison_woocommerce_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_grid_author',array(
		'label' => esc_html__( 'Show / Hide Author','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_grid_layout_settings'
    )));

    $wp_customize->add_setting('product_comparison_woocommerce_grid_comments_icon',array(
		'default'	=> 'fa fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_grid_comments_icon',array(
		'label'	=> __('Add Comments Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_grid_layout_settings',
		'setting'	=> 'product_comparison_woocommerce_grid_comments_icon',
		'type'		=> 'icon'
	)));

  $wp_customize->add_setting( 'product_comparison_woocommerce_grid_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_grid_time',array(
		'label' => esc_html__( 'Show / Hide Time','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_grid_layout_settings'
    )));

    $wp_customize->add_setting('product_comparison_woocommerce_grid_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_grid_time_icon',array(
		'label'	=> __('Add Time Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_grid_layout_settings',
		'setting'	=> 'product_comparison_woocommerce_grid_time_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting( 'product_comparison_woocommerce_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_grid_comments',array(
		'label' => esc_html__( 'Show / Hide Comments','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_grid_layout_settings'
    )));

    $wp_customize->add_setting( 'product_comparison_woocommerce_grid_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
	));
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_grid_image_hide_show', array(
		'label' => esc_html__( 'Show / Hide Featured Image','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_grid_layout_settings'
  	)));

 	$wp_customize->add_setting('product_comparison_woocommerce_grid_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_grid_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','product-comparison-woocommerce'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','product-comparison-woocommerce'),
		'section'=> 'product_comparison_woocommerce_grid_layout_settings',
		'type'=> 'text'
	));

  $wp_customize->add_setting('product_comparison_woocommerce_display_grid_posts_settings',array(
    'default' => 'Into Blocks',
    'transport' => 'refresh',
    'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_display_grid_posts_settings',array(
    'type' => 'select',
    'label' => __('Display Grid Posts','product-comparison-woocommerce'),
    'section' => 'product_comparison_woocommerce_grid_layout_settings',
    'choices' => array(
    	'Into Blocks' => __('Into Blocks','product-comparison-woocommerce'),
      'Without Blocks' => __('Without Blocks','product-comparison-woocommerce')
      ),
	) );

  	$wp_customize->add_setting('product_comparison_woocommerce_grid_button_text',array(
		'default'=> esc_html__('Read More','product-comparison-woocommerce'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_grid_button_text',array(
		'label'	=> esc_html__('Add Button Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Read More', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_grid_layout_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_grid_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_grid_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_grid_layout_settings',
		'type'=> 'text'
	));

    $wp_customize->add_setting('product_comparison_woocommerce_grid_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_grid_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Grid Post Content','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_grid_layout_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','product-comparison-woocommerce'),
            'Excerpt' => esc_html__('Excerpt','product-comparison-woocommerce'),
            'No Content' => esc_html__('No Content','product-comparison-woocommerce')
        ),
	) );

    $wp_customize->add_setting( 'product_comparison_woocommerce_grid_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_grid_featured_image_border_radius', array(
		'label'       => esc_html__( 'Grid Featured Image Border Radius','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_grid_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_grid_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Grid Featured Image Box Shadow','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_grid_layout_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Other
	$wp_customize->add_panel( 'product_comparison_woocommerce_other_parent_panel', array(
		'title' => esc_html__( 'Other Settings', 'product-comparison-woocommerce' ),
		'panel' => 'product_comparison_woocommerce_panel_id',
		'priority' => 20,
	));

	// Layout
	$wp_customize->add_section( 'product_comparison_woocommerce_left_right', array(
    	'title' => esc_html__('General Settings', 'product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_other_parent_panel'
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Image_Radio_Control($wp_customize, 'product_comparison_woocommerce_width_option', array(
        'type' => 'select',
        'label' => esc_html__('Width Layouts','product-comparison-woocommerce'),
        'description' => esc_html__('Here you can change the width layout of Website.','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('product_comparison_woocommerce_page_layout',array(
        'default' => 'One_Column',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_page_layout',array(
        'type' => 'select',
        'label' => esc_html__('Page Sidebar Layout','product-comparison-woocommerce'),
        'description' => esc_html__('Here you can change the sidebar layout for pages. ','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_left_right',
        'choices' => array(
            'Left_Sidebar' => esc_html__('Left Sidebar','product-comparison-woocommerce'),
            'Right_Sidebar' => esc_html__('Right Sidebar','product-comparison-woocommerce'),
            'One_Column' => esc_html__('One Column','product-comparison-woocommerce')
        ),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_single_page_breadcrumb1',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_single_page_breadcrumb1',array(
		'label' => esc_html__( 'Show / Hide Page Breadcrumb','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_left_right'
    )));

	// Progress Bar
	$wp_customize->add_setting( 'product_comparison_woocommerce_progress_bar', array(
		'default'           => 0, 
		'transport'         => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization',
	));

	$wp_customize->add_control(
		new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control(
			$wp_customize,
			'product_comparison_woocommerce_progress_bar',
			array(
				'label'   => esc_html__( 'Show / Hide Progress Bar', 'product-comparison-woocommerce' ),
				'section' => 'product_comparison_woocommerce_left_right',
			)
		)
	);

    //Wow Animation
	  $wp_customize->add_setting( 'product_comparison_woocommerce_animation',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
  	));
  	$wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_animation',array(
      'label' => esc_html__( 'Show / Hide Animations','product-comparison-woocommerce' ),
      'description' => __('Here you can disable overall site animation effect','product-comparison-woocommerce'),
	    'section' => 'product_comparison_woocommerce_left_right'
  	)));
	
    // Pre-Loader
	$wp_customize->add_setting( 'product_comparison_woocommerce_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','product-comparison-woocommerce' ),
        'section' => 'product_comparison_woocommerce_left_right'
    )));

	$wp_customize->add_setting('product_comparison_woocommerce_preloader_bg_color', array(
		'default'           => '#D50000',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_left_right',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_preloader_border_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_left_right',
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_preloader_bg_img',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'product_comparison_woocommerce_preloader_bg_img',array(
        'label' => __('Preloader Background Image','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_left_right'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_breadcrumbs_alignment',array(
        'default' => 'Left',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_breadcrumbs_alignment',array(
        'type' => 'select',
        'label' => __('Breadcrumbs Alignment','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_left_right',
        'choices' => array(
            'Left' => __('Left','product-comparison-woocommerce'),
            'Right' => __('Right','product-comparison-woocommerce'),
            'Center' => __('Center','product-comparison-woocommerce'),
        ),
	) );
	
	$wp_customize->add_setting( 'product_comparison_woocommerce_sticky_sidebar',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_sticky_sidebar',array(
      'label' => esc_html__( 'Show / Hide Sticky Sidebar','product-comparison-woocommerce' ),
      'section' => 'product_comparison_woocommerce_left_right'
    )));

    //404 Page Setting
	$wp_customize->add_section('product_comparison_woocommerce_404_page',array(
		'title'	=> __('404 Page Settings','product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_other_parent_panel',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('product_comparison_woocommerce_404_page_title',array(
		'label'	=> __('Add Title','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('product_comparison_woocommerce_404_page_content',array(
		'label'	=> __('Add Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_404_page_button_text',array(
		'label'	=> __('Add Button Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'Go Back', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('product_comparison_woocommerce_no_results_page',array(
		'title'	=> __('No Results Page Settings','product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_other_parent_panel',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('product_comparison_woocommerce_no_results_page_title',array(
		'label'	=> __('Add Title','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('product_comparison_woocommerce_no_results_page_content',array(
		'label'	=> __('Add Text','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('product_comparison_woocommerce_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_other_parent_panel',
	));

	$wp_customize->add_setting('product_comparison_woocommerce_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_social_icon_padding',array(
		'label'	=> __('Icon Padding','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_social_icon_width',array(
		'label'	=> __('Icon Width','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_social_icon_height',array(
		'label'	=> __('Icon Height','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_social_icon_settings',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('product_comparison_woocommerce_responsive_media',array(
		'title'	=> esc_html__('Responsive Media','product-comparison-woocommerce'),
		'panel' => 'product_comparison_woocommerce_other_parent_panel',
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_responsive_preloader_hide',array(
        'default' => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_responsive_preloader_hide',array(
        'label' => esc_html__( 'Show / Hide Preloader','product-comparison-woocommerce' ),
        'section' => 'product_comparison_woocommerce_responsive_media'
    )));

	$wp_customize->add_setting( 'product_comparison_woocommerce_responsive_topbar_hide',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_responsive_topbar_hide',array(
      'label' => esc_html__( 'Show / Hide Topbar','product-comparison-woocommerce' ),
      'section' => 'product_comparison_woocommerce_responsive_media'
    )));

    $wp_customize->add_setting( 'product_comparison_woocommerce_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));  
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','product-comparison-woocommerce' ),
      'section' => 'product_comparison_woocommerce_responsive_media'
    )));

    $wp_customize->add_setting( 'product_comparison_woocommerce_resp_scroll_top_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ));
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_resp_scroll_top_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','product-comparison-woocommerce' ),
      	'section' => 'product_comparison_woocommerce_responsive_media'
    )));

    $wp_customize->add_setting('product_comparison_woocommerce_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_responsive_media',
		'setting'	=> 'product_comparison_woocommerce_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_res_close_menu_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Product_Comparison_Woocommerce_Fontawesome_Icon_Chooser(
        $wp_customize,'product_comparison_woocommerce_res_close_menu_icon',array(
		'label'	=> __('Add Close Menu Icon','product-comparison-woocommerce'),
		'transport' => 'refresh',
		'section'	=> 'product_comparison_woocommerce_responsive_media',
		'setting'	=> 'product_comparison_woocommerce_res_close_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('product_comparison_woocommerce_resp_menu_toggle_btn_bg_color', array(
		'default'           => '#D50000',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'product_comparison_woocommerce_resp_menu_toggle_btn_bg_color', array(
		'label'    => __('Toggle Button Bg Color', 'product-comparison-woocommerce'),
		'section'  => 'product_comparison_woocommerce_responsive_media',
	)));

  //Woocommerce settings
	$wp_customize->add_section('product_comparison_woocommerce_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'product-comparison-woocommerce'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'product_comparison_woocommerce_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar',
		'render_callback' => 'product_comparison_woocommerce_customize_partial_product_comparison_woocommerce_woocommerce_shop_page_sidebar', ) );

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'product_comparison_woocommerce_woocommerce_shop_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Shop Page Sidebar','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_woocommerce_section'
    )));

   $wp_customize->add_setting('product_comparison_woocommerce_shop_page_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_shop_page_layout',array(
        'type' => 'select',
        'label' => __('Shop Page Sidebar Layout','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','product-comparison-woocommerce'),
            'Right Sidebar' => __('Right Sidebar','product-comparison-woocommerce'),
        ),
	) );

   //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'product_comparison_woocommerce_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar',
		'render_callback' => 'product_comparison_woocommerce_customize_partial_product_comparison_woocommerce_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'product_comparison_woocommerce_woocommerce_single_product_page_sidebar',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
   ) );
   $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Show / Hide Single Product Sidebar','product-comparison-woocommerce' ),
		'section' => 'product_comparison_woocommerce_woocommerce_section'
    )));

   $wp_customize->add_setting('product_comparison_woocommerce_single_product_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_single_product_layout',array(
        'type' => 'select',
        'label' => __('Single Product Sidebar Layout','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_woocommerce_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','product-comparison-woocommerce'),
            'Right Sidebar' => __('Right Sidebar','product-comparison-woocommerce'),
        ),
	) );

    //Products per page
    $wp_customize->add_setting('product_comparison_woocommerce_agency_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'product_comparison_woocommerce_agency_sanitize_float'
	));
	$wp_customize->add_control('product_comparison_woocommerce_agency_products_per_page',array(
		'label'	=> __('Products Per Page','product-comparison-woocommerce'),
		'description' => __('Display on shop page','product-comparison-woocommerce'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'product_comparison_woocommerce_agency_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('product_comparison_woocommerce_agency_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'product_comparison_woocommerce_agency_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_agency_products_per_row',array(
		'label'	=> __('Products Per Row','product-comparison-woocommerce'),
		'description' => __('Display on shop page','product-comparison-woocommerce'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'product_comparison_woocommerce_agency_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('product_comparison_woocommerce_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'product_comparison_woocommerce_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'product_comparison_woocommerce_products_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'product_comparison_woocommerce_products_button_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_products_button_border_radius', array(
		'label'       => esc_html__( 'Products Button Border Radius','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	//Products Sale Badge
	$wp_customize->add_setting('product_comparison_woocommerce_woocommerce_sale_position',array(
        'default' => 'right',
        'sanitize_callback' => 'product_comparison_woocommerce_sanitize_choices'
	));
	$wp_customize->add_control('product_comparison_woocommerce_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','product-comparison-woocommerce'),
        'section' => 'product_comparison_woocommerce_woocommerce_section',
        'choices' => array(
            'left' => __('Left','product-comparison-woocommerce'),
            'right' => __('Right','product-comparison-woocommerce'),
        ),
	) );

	$wp_customize->add_setting('product_comparison_woocommerce_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('product_comparison_woocommerce_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('product_comparison_woocommerce_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','product-comparison-woocommerce'),
		'description'	=> __('Enter a value in pixels. Example:20px','product-comparison-woocommerce'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'product-comparison-woocommerce' ),
        ),
		'section'=> 'product_comparison_woocommerce_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'product_comparison_woocommerce_woocommerce_sale_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'product_comparison_woocommerce_sanitize_number_range'
	) );
	$wp_customize->add_control( 'product_comparison_woocommerce_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','product-comparison-woocommerce' ),
		'section'     => 'product_comparison_woocommerce_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

  	// Related Product
    $wp_customize->add_setting( 'product_comparison_woocommerce_related_product_show_hide',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'product_comparison_woocommerce_switch_sanitization'
    ) );
    $wp_customize->add_control( new Product_Comparison_Woocommerce_Toggle_Switch_Custom_Control( $wp_customize, 'product_comparison_woocommerce_related_product_show_hide',array(
        'label' => esc_html__( 'Show / Hide Related product','product-comparison-woocommerce' ),
        'section' => 'product_comparison_woocommerce_woocommerce_section'
    )));


}

add_action( 'customize_register', 'product_comparison_woocommerce_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Product_Comparison_Woocommerce_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Product_Comparison_Woocommerce_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Product_Comparison_Woocommerce_Customize_Section_Pro( $manager,'product_comparison_woocommerce_go_pro', array(
			'priority'   => 1,
			'title'    => esc_html__( 'COMPARISON PRO', 'product-comparison-woocommerce' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'product-comparison-woocommerce' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/products/price-comparison-wordpress-theme'),
		) )	);

		// Register sections.
		$manager->add_section(new product_comparison_woocommerce_Customize_Section_Pro($manager,'product_comparison_woocommerce_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'product-comparison-woocommerce' ),
			'pro_text' => esc_html__( 'DOCS', 'product-comparison-woocommerce' ),
			'pro_url'  => esc_url('https://preview.vwthemesdemo.com/docs/free-product-comparison-woocommerce/'),
		)));

		$manager->add_section(new product_comparison_woocommerce_Customize_Section_Pro($manager,'product_comparison_woocommerce_live_demo_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'LIVE DEMO', 'product-comparison-woocommerce' ),
			'pro_text' => esc_html__( 'LIVE DEMO', 'product-comparison-woocommerce' ),
			'pro_url'  => esc_url('https://www.vwthemes.net/product-comparison-woocommerce/'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'product-comparison-woocommerce-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'product-comparison-woocommerce-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );

		// Pass popup status to JavaScript
		wp_localize_script( 'product-comparison-woocommerce-customize-controls', 'productComparisonWoocommerceCustomizer', array(
			'popupShown' => get_option( 'product_comparison_woocommerce_customizer_popup_shown', '0' ),
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'product_comparison_woocommerce_customizer_popup_nonce' )
		) );
	}
}

// Doing this customizer thang!
Product_Comparison_Woocommerce_Customize::get_instance();
