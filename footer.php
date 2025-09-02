<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package copim
 */
?>
<div class="container-wrapper bg-color-black container-padding-top container-padding-bottom" >
<div class="container">
	<div class="row justify-center">
		<footer class="site-footer col col-12" role="contentinfo" id="colophon">

		

					<div class="footer-top">



					<nav class="footer-menu-1 footer-menu-vert" aria-label="Footer Menu 1">
								<?php // FOOTER MENUS 1 & 2
                                    wp_nav_menu([
                                        'theme_location' => 'footer-menu-1',
                                        'menu_class' => 'footer-menu',
                                        'container' => false,
                                        'container_class' => 'footer-menu-1 footer-menu-vert',
                                        'aria_label' => 'Footer Menu 1',
                                ]); ?>
					</nav>

					<nav class="footer-menu-2 footer-menu-vert" aria-label="Footer Menu 2">
								<?php	wp_nav_menu([
                                        'theme_location' => 'footer-menu-2',
                                        'menu_class' => 'footer-menu',
                                        'container' => false,
                                        'container_class' => 'footer-menu-2 footer-menu-vert',
                                        'aria_label' => 'Footer Menu 2',
                                ]); ?>
					</nav>

						<?php // SOCIAL MENU
                            if (function_exists('have_rows') && have_rows('footer_social_menu_options', 'option')) :
                                ?> <nav class="social-menu-icons" aria-label="Social media menu"><ul class="social-menu" > <?php
                                    while (have_rows('footer_social_menu_options', 'option')) : the_row(); ?>

										 
										<?php if (function_exists('get_sub_field') && get_sub_field('footer_social_menu_url')) {
										    $linkurl = get_sub_field('footer_social_menu_url', 'option');
										}  ?>

								
											<?php if (function_exists('get_sub_field') && get_sub_field('footer_social_menu_icon')) {
											    $iconurl = get_sub_field('footer_social_menu_icon', 'option'); ?>  
												<li><a href="<?php echo esc_url($linkurl); ?>" title="<?php echo esc_url($linkurl); ?>" class="icon-wrapper" aria-label="Follow us on <?php echo esc_attr(ucfirst($iconurl)); ?>">
													<svg class="icon footer-social-icon" aria-hidden="true"><use href="<?php echo esc_url('#' . $iconurl); ?>"></use></svg>
												</a></li> 

												 

											<?php } ?> 


							<?php endwhile;
                                ?> </ul></nav> <?php else :
                                endif;?>


					</div>



					<div class="footer-base">



								<?php // LOGO?>
								<div class="footer-logo">	
									<a href="<?php echo home_url(); ?>" aria-label="Homepage" >
										<img src="<?php bloginfo('template_directory'); ?>/resources/img/copim_logo_neg.svg" width="250" alt="Homepage" title="Homepage" >
									</a>
								</div>



								<div class="footer-credits">
								<nav class="footer-menu-credits footer-menu-horz" aria-label="Website Credits Menu">
									<?php // CREDITS MENU
                                                wp_nav_menu([
                                                    'theme_location' => 'footer-menu-credits',
                                                    'menu_class' => 'footer-menu-credits',
                                                    'container' => false,
                                                    'container_class' => 'footer-menu-credits footer-menu-horz',
                                                    'aria_label' => 'Website Credits Menu',
                                            ]); ?>
								</nav>

									<div class="footer-menu-copyright">
										Copim is licensed under a <a href="https://creativecommons.org/licenses/by/4.0/">CC Attribution 4.0 International License</a> (CC BY 4.0)&nbsp; | &nbsp;
										<?php // Add copyright at the end
                                                    echo '&copy;2023-' . date('Y') . ' ' . get_bloginfo('name');
?>
									</div>
								</div>



					</div>





	</footer><!-- #colophon -->
  </div><!-- / row -->
</div><!-- / container -->
</div><!-- / container-wrapper -->
	



<?php wp_footer(); ?>



</body>
</html>
