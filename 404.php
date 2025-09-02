<?php
get_header();
?>
<main id="main-content" class="site-main" role="main">


<!-- HEADER -->
<section class="container-wrapper bg-color-warm-gray-800 header-bg" >
<div class="container article-header no-hero-image">
  <div class="row justify-center"  >

					<div class="section-header col  col-12 ">
						<div class="section-header-title">

							
							<h1>Page Not Found</h1>
							<div class="header-subtitle">Use the search tool above, <a href="<?php echo home_url(); ?>">visit our homepage</a> or check our latest posts below.</div>


						</div><!-- / section-header-title -->
					</div><!-- / section-header -->


  </div><!-- / row -->
</div><!-- / container -->
</section><!-- / container-wrapper -->





<!-- ARTICLE -->
<div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100" >
<div class="container ">
  <div class="row justify-center">
	<div class="col col-12  cms-content odd-columns" >


	
	<!-- AJAX LOAD MORE: SHORTCODE -->	
				<?php $shortcode = '[ajax_load_more container_type="div" post_type="post" posts_per_page="8"  button_label="More Articles" scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"]';
echo do_shortcode($shortcode);
?>


	</div><!-- / col -->
  </div><!-- / row -->
</div><!-- / container -->
</div><!-- / container wrapper -->


</main><!-- / main -->
<?php
get_footer();
