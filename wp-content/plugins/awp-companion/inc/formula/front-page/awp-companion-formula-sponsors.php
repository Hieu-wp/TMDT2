<?php
$activate_theme_data     = wp_get_theme(); // getting current theme data.
$activate_theme          = $activate_theme_data->name;
$formula_client_disabled = get_theme_mod( 'formula_client_disabled', true );
if ( $formula_client_disabled == true ) :
	$formula_client_content    = get_theme_mod( 'formula_client_content' );
	$formula_client_autoplay   = get_theme_mod( 'formula_client_autoplay', true );
	$formula_client_area_title = get_theme_mod( 'formula_client_area_title', __( 'Meet The Partners', 'formula' ) );
	$formula_client_area_desc  = get_theme_mod( 'formula_client_area_desc', __( 'SPONSORS', 'formula' ) );

	$formula_client_container_size = get_theme_mod( 'formula_client_container_size', 'container-full' );
	$formula_client_column_layout  = get_theme_mod( 'formula_client_column_layout', 5 );
	?><!-- Sponsors Section -->
		<section id="client-selector-scroll" class="sponsors">
			<div class="<?php echo esc_attr( $formula_client_container_size ); ?> sponsors-selector">
				<div class="row">
					<?php
					if ( ( $formula_client_area_title ) || ( $formula_client_area_desc ) != '' ) {
						?>
						<!-- Section Title -->
						<div class="row">
							<div class="col-md-12">
								<div class="section-header">
									<?php if ( $formula_client_area_desc != null ) : ?>
										<p class="section-subtitle"><?php echo wp_kses_post( $formula_client_area_desc ); ?></p>
									<?php endif; ?>
									<?php if ( $formula_client_area_title != null ) : ?>
										<h2 class="section-title"><?php echo wp_kses_post( $formula_client_area_title ); ?></h2>
									<?php endif; ?>
									<div class="divider-line"></div>
								</div>
							</div>
						</div>
						<!-- /Section Title -->
						<?php 
					} ?>
					<?php
					$formula_client_content_decoded = json_decode( $formula_client_content );
					if ( ! empty( $formula_client_content_decoded ) ) { ?>
						<div class="owl-carousel owl-theme col-md-12" id="sponsors-demo">
							<?php
							foreach ( $formula_client_content_decoded as $client_iteam ) {
								$title        = ! empty( $client_iteam->title ) ? apply_filters( 'formula_translate_single_string', $client_iteam->title, 'Client section' ) : '';
								$subtitle     = ! empty( $client_iteam->subtitle ) ? apply_filters( 'formula_translate_single_string', $client_iteam->subtitle, 'Client section' ) : '';
								$link         = ! empty( $client_iteam->link ) ? apply_filters( 'formula_translate_single_string', $client_iteam->link, 'Client section' ) : '#';
								$open_new_tab = ! empty( $client_iteam->open_new_tab ) ? $client_iteam->open_new_tab : 'no';
								?>
								<div class="item">
									<div class="partner-card">
										<div class="partner-logo">
											<a href="<?php echo esc_url( $link ); ?>" 
												<?php if ( $open_new_tab == 'yes' ) { echo 'target="_blank"'; } ?>>
												<img src="<?php echo esc_url( $client_iteam->image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>">
											</a>
										</div>
										<?php if ( ! empty( $title ) ) : ?>
											<h4 class="partner-title"><?php echo esc_html( $title ); ?></h4>
										<?php endif; ?>
										<?php if ( ! empty( $subtitle ) ) : ?>
											<span class="partner-subtitle"><?php echo esc_html( $subtitle ); ?></span>
										<?php endif; ?>
									</div>
								</div>
								<?php
							} ?>
						</div>
					<?php } else {
						// Build the fallback partners data dynamically based on the active child theme
						$partners_data = array();

						if ( 'Education Formula' == $activate_theme ) {
							$partners_data = array(
								array('img' => '1.png', 'title' => __('E-Learning', 'formula'), 'subtitle' => __('ACADEMIC PORTAL', 'formula')),
								array('img' => '2.png', 'title' => __('Edu Plus', 'formula'), 'subtitle' => __('DIGITAL COURSES', 'formula')),
								array('img' => '3.png', 'title' => __('Global Study', 'formula'), 'subtitle' => __('UNIVERSITY GLOBAL', 'formula')),
								array('img' => '1.png', 'title' => __('E-Learning', 'formula'), 'subtitle' => __('ACADEMIC PORTAL', 'formula')),
								array('img' => '2.png', 'title' => __('Edu Plus', 'formula'), 'subtitle' => __('DIGITAL COURSES', 'formula')),
							);
						} elseif ( 'Medical Formula' == $activate_theme ) {
							$partners_data = array(
								array('img' => 'mf1.jpg', 'title' => __('Health Care', 'formula'), 'subtitle' => __('CLINIC PORTAL', 'formula')),
								array('img' => 'mf2.jpg', 'title' => __('Medi Lab', 'formula'), 'subtitle' => __('RESEARCH LAB', 'formula')),
								array('img' => 'mf3.jpg', 'title' => __('Bio Tech', 'formula'), 'subtitle' => __('MEDICINAL ASSETS', 'formula')),
								array('img' => 'mf1.jpg', 'title' => __('Health Care', 'formula'), 'subtitle' => __('CLINIC PORTAL', 'formula')),
								array('img' => 'mf2.jpg', 'title' => __('Medi Lab', 'formula'), 'subtitle' => __('RESEARCH LAB', 'formula')),
							);
						} elseif ( 'Metaverse' == $activate_theme ) {
							$partners_data = array(
								array('img' => 'partner-1.png', 'title' => __('Quantum Soft', 'formula'), 'subtitle' => __('CLOUD INFRASTRUCTURE', 'formula')),
								array('img' => 'partner-2.png', 'title' => __('Lumina Media', 'formula'), 'subtitle' => __('DIGITAL CONTENT', 'formula')),
								array('img' => 'partner-3.png', 'title' => __('Vanguard Est', 'formula'), 'subtitle' => __('GLOBAL PROPERTY', 'formula')),
								array('img' => 'partner-4.png', 'title' => __('Capital Fin', 'formula'), 'subtitle' => __('STRATEGIC ASSETS', 'formula')),
								array('img' => 'partner-5.png', 'title' => __('Apex Global', 'formula'), 'subtitle' => __('LOGISTICS & SUPPLY', 'formula')),
							);
						} else {
							// Default Formula / Dark / Light partners
							$partners_data = array(
								array('img' => 'Apex Global.png', 'title' => __('Apex Global', 'formula'), 'subtitle' => __('LOGISTICS & SUPPLY', 'formula')),								
								array('img' => 'Quantum Soft.png', 'title' => __('Quantum Soft', 'formula'), 'subtitle' => __('CLOUD INFRASTRUCTURE', 'formula')),
								array('img' => 'Lumina Media.png', 'title' => __('Lumina Media', 'formula'), 'subtitle' => __('DIGITAL CONTENT', 'formula')),
								array('img' => 'Vanguard Est.png', 'title' => __('Vanguard Est', 'formula'), 'subtitle' => __('GLOBAL PROPERTY', 'formula')),
								array('img' => 'Capital Fin.png', 'title' => __('Capital Fin', 'formula'), 'subtitle' => __('STRATEGIC ASSETS', 'formula')),
							);
						}
						?>
						<div class="owl-carousel owl-theme col-md-12" id="sponsors-demo">
							<?php foreach ( $partners_data as $partner ) { ?>
								<div class="item">
									<div class="partner-card">
										<div class="partner-logo">
											<a href="#"><img src="<?php echo awp_companion_plugin_url; ?>/inc/formula/img/client/<?php echo $partner['img']; ?>" alt="<?php echo esc_attr($partner['title']); ?>"></a>
										</div>
										<h4 class="partner-title"><?php echo esc_html($partner['title']); ?></h4>
										<span class="partner-subtitle"><?php echo esc_html($partner['subtitle']); ?></span>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>

					</div>
				</div>
			</div>
		</section>
		<script>
			jQuery(window).load(function(){
				jQuery("#sponsors-demo").owlCarousel({
					navigation : false,
					<?php if ( $formula_client_autoplay == true ) { ?>
						autoplay: true,
					<?php } ?>
					autoplayTimeout: <?php echo esc_html( get_theme_mod( 'formula_client_animation_speed', 3000 ) ); ?>, //autoplay speed
					autoplayHoverPause: true,
					smartSpeed: 700,
					loop:true,
					nav:false,
					margin:30,
					autoHeight: true,
					responsiveClass:true,
					dots: false,
					navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
					responsive:{
						200:{ items:1 },	
						480:{ items:1 },
						768:{ items:3 },
						1000:{ items:<?php echo esc_attr( $formula_client_column_layout ); ?> }
					}
				});
			});
		</script>

<?php endif; ?>

<!-- End of Sponsors Section -->			
<div class="clearfix"></div>
