<?php
get_header();
?>
<main id="main-content" class="site-main" role="main">


<!-- HEADER -->
<section class="container-wrapper bg-color-warm-gray-800 header-bg" >
<div class="container article-header no-hero-image">
  <div class="row justify-left"  >

					<div class="section-header col  col-10">
						<div class="section-header-title">




									<?php if (get_field('author_name')) {
									    echo  '<h1 class="entry-title">' .   wp_kses_post(get_field('author_name')) . '</h1>';
									}  ?>
									<?php if (get_field('author_biography')) {
									    echo  '<div class="header-subtitle">' .    wp_kses_post(get_field('author_biography')). '</div>';
									}  ?>
									

						<?php // LINKS
                            if (have_rows('author_links')) :
                                ?> <nav class="author-links-menu"><ul class="author-menu"> <?php
                                    while (have_rows('author_links')) : the_row(); ?>

										 
										<?php if (get_sub_field('author_links_url')) {
										    $linkurl = get_sub_field('author_links_url');
										}  ?>
										<?php if (get_sub_field('author_links_label')) {
										    $linklabel = get_sub_field('author_links_label');
										}  ?>
										<?php if (get_sub_field('author_links_icon')) {
										    $iconurl = get_sub_field('author_links_icon');
										}  ?>

							
											<?php if (get_sub_field('author_links_url') && get_sub_field('author_links_label')) {  ?>  
												
												<li>
													<a href="<?php echo esc_url($linkurl); ?>" title="<?php echo esc_attr($linklabel); ?>" aria-label="<?php echo esc_attr($linklabel); ?>">
														<span class="icon-wrapper">
															<svg class="icon author-links-icon" aria-hidden="true"><use href="<?php echo esc_url('#' . $iconurl); ?>"></use></svg>
														</span>
														<?php if (get_sub_field('author_links_label')) {
														    echo wp_kses_post(get_sub_field('author_links_label'));
														}  ?>
													</a>
												</li>

											<?php } ?> 


							<?php endwhile;
                                ?> </ul></nav> <?php else :
                                endif;?>


								
						</div><!-- / section-header-title -->
					</div><!-- / section-header -->


  </div><!-- / row -->
</div><!-- / container -->
</section><!-- / container-wrapper -->

 

<!-- POSTS -->
<div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100" >
 <div class="container ">
    <div class="row  justify-center">

	<div class="col col-12 even-columns">
		

	

				<!-- AJAX LOAD MORE: SHORTCODE -->	
				<?php $author_id = get_the_ID();
echo do_shortcode('[ajax_load_more  
					container_type="div" 
					post_type="post" 
					posts_per_page="8" 
					button_label="More Articles"
					meta_compare="LIKE" meta_key="post_authors"
					meta_value="' . $author_id . '"
					scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
				]'); ?>




	</div><!-- / col -->
  </div><!-- / row -->
</div><!-- / container -->
</div><!-- / container wrapper -->


</main><!-- #main -->

<?php

get_footer();
