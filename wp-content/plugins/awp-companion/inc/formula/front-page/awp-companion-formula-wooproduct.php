<?php
if ( class_exists( 'WooCommerce' ) ) {
	$formula_woocommerce_disabled = get_theme_mod( 'formula_woocommerce_disabled', 'true' );
	if ( $formula_woocommerce_disabled == true ) :
		$formula_woocommerce_container_size = get_theme_mod( 'formula_woocommerce_container_size', 'container-full' );
		$formula_woocommerce_column_layout  = get_theme_mod( 'formula_woocommerce_column_layout', 4 );
		$formula_woocommerce_autoplay       = get_theme_mod( 'formula_woocommerce_autoplay', 1 );
		?>
<!-- Woocommerce Section -->
<section id="woocommerce-selector-scroll" class="section woocommerce-section">
	<div class="<?php echo esc_attr( $formula_woocommerce_container_size ); ?>">
		<?php
		$formula_woocommerce_area_title = get_theme_mod( 'formula_woocommerce_area_title', __( 'Featured products', 'formula' ) );
		$formula_woocommerce_area_desc  = get_theme_mod( 'formula_woocommerce_area_desc', 'Showcase your products in this beautiful shop section' );
		if ( ( $formula_woocommerce_area_title ) || ( $formula_woocommerce_area_desc ) != '' ) {
			?>
		<!-- Section Title -->
		<div class="row">
			<div class="col-md-12">
				<div class="section-header wow animate fadeInUp" data-wow-delay=".3s">
					<p class="section-subtitle"><?php echo $formula_woocommerce_area_desc; ?></p>
					<h1 class="section-title"><?php echo $formula_woocommerce_area_title; ?></h1>
					<div class="divider-line"></div>
				</div>
			</div>
		</div>
		<!-- /Section Title -->        
		<?php } ?>        
		<!-- Item Scroll -->
		<?php
		$args = array(
			'post_type' => 'product',
		);
		/* Exclude hidden products from the loop */
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			),
		);
		?>
		<div class="row wow animate fadeInUp" data-wow-delay=".3s">
			<div id="woocommerce-carousel" class="owl-carousel owl-theme col-md-12 woocommerce">
			<?php
				$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) :
				$loop->the_post();
				global $product;
				?>
					<div class="item wow fadeInUp animated" data-wow-delay="300ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
						<div class="woocommerce-module">
							<div class="woo-img-wrapper">
								<?php if ( $product->is_on_sale() ) : ?>
									<span class="onsale"><?php esc_html_e( 'ON SALE!', 'formula' ); ?></span>
								<?php endif; ?>
								<a href="#" class="woo-wishlist-heart" onclick="return false;" title="<?php esc_attr_e( 'Add to Wishlist', 'formula' ); ?>"><i class="far fa-heart"></i></a>
								<a href="<?php the_permalink(); ?>" class="woo-img-link">
									<img class="img-responsive woo-product-img" src="<?php echo the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
								</a>
								
								<!-- Hover Slide-In Icons Bar -->
								<div class="woo-hover-icons-bar">
									<a href="<?php the_permalink(); ?>" class="woo-view-btn" title="<?php esc_attr_e( 'View Product', 'formula' ); ?>">
										<i class="fas fa-eye"></i>
									</a>
									<div class="woo-add-btn-wrapper">
										<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
									</div>
								</div>
							</div>
							<div class="woo-info-wrapper">
								<div class="woo-meta-row">
									<?php
									$categories = wp_get_post_terms( get_the_ID(), 'product_cat' );
									$category_name = ! empty( $categories ) ? esc_html( $categories[0]->name ) : esc_html__( 'APPAREL', 'formula' );
									?>
									<span class="woo-category"><?php echo esc_html( strtoupper( $category_name ) ); ?></span>
									
									<?php
									$average_rating = $product->get_average_rating();
									if ( $average_rating > 0 ) :
										$rating_val = number_format( (float)$average_rating, 1, '.', '' );
									?>
										<span class="woo-rating"><i class="fas fa-star"></i> <?php echo esc_html( $rating_val ); ?></span>
									<?php endif; ?>
								</div>
								<h3 class="woo-product-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="woo-footer-row">
									<span class="woo-price"><?php echo $product->get_price_html(); ?></span>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				<?php
				wp_reset_postdata();
				?>
			</div>
		</div>

	</div>
</section>
<script>
	jQuery(window).load(function(){
		jQuery("#woocommerce-carousel").owlCarousel({
			navigation : true, 
			<?php if ( $formula_woocommerce_autoplay == 1 ) { ?>
				autoplay: true,  // autoplay
			<?php } ?>
			autoplayTimeout: <?php echo esc_html( get_theme_mod( 'formula_woocommerce_animation_speed', 4000 ) ); ?>, 
			autoplayHoverPause: true,
			smartSpeed: 700,        
			loop:true, // loop is true up to 1199px screen.
			nav:false, // is true across all sizes
			margin:30, // margin 10px till 960 breakpoint
			autoHeight: true,
			responsiveClass:true, 
			dots: true,
			navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
			responsive:{ 
				100:{ items:1 },    
				480:{ items:1 },
				768:{ items:2 },
				1000:{ items:<?php echo esc_attr( $formula_woocommerce_column_layout ); ?> }
			}
		});

		// Interactive Wishlist Heart Toggle & Heartbeat Animation
		jQuery(document).on('click', '.woo-wishlist-heart', function(e) {
			e.preventDefault();
			var $heart = jQuery(this);
			var $icon = $heart.find('i');
			
			if ($icon.hasClass('far')) {
				// Toggle to solid red active heart
				$icon.removeClass('far fa-heart').addClass('fas fa-heart');
				$heart.addClass('active');
				
				// Trigger heartbeat pulse micro-animation
				$heart.addClass('heartbeat-anim');
				setTimeout(function() {
					$heart.removeClass('heartbeat-anim');
				}, 600);
			} else {
				// Toggle back to clean outlined heart
				$icon.removeClass('fas fa-heart').addClass('far fa-heart');
				$heart.removeClass('active');
			}
		});
	});
</script>
<!-- /Woocommerce Section -->
<div class="clearfix"></div>
	<?php endif; ?>
<?php } ?>
