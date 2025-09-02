<?php
get_header();
?>
<main id="main-content" class="site-main" role="main">


<?php  $has_image = get_field('header_image_toggle'); // Check if header has image?>
<section class="container-wrapper bg-color-warm-gray-800 header-bg" >
<div class="container article-header <?php echo $has_image ? '' : 'no-hero-image'; ?>">
  <div class="row justify-left"  >

	<div class="section-header col  <?php echo $has_image ? 'col-6' : 'col-10'; ?>">

	<div class="section-header-title">

		<?php // TITLE
            the_title('<h1 class="entry-title">', '</h1>');
?>

 

		<?php // Subtitle
    if (get_field('header_subtitle')) { ?>
				<?php echo  '<div class="header-subtitle">' .   wp_kses_post(get_field('header_subtitle')) . '</div>'; ?> 
		<?php  } ?>



 	</div><!-- / section-header-title -->


 	</div><!-- / section-header -->


		<?php // HEADER IMAGE
    if (get_field('header_image_toggle')) {

        if (get_field('header_image_toggle')) { //do you require an image??>

					<?php if (get_field('header_image')) {
					    $image = get_field('header_image'); // Is an image selected?>				
						<div class="header-hero-image col col-6"> 
							<figure class="extend-to-edge-right ">				
							<?php if ($image) {
							    // Get the alt text, fallback to title if no alt
							    $alt_text = get_post_meta($image['ID'], '_wp_attachment_image_alt', true);
							    if (empty($alt_text)) {
							        $alt_text = get_the_title();
							    }
							    echo wp_get_attachment_image(
							        $image['ID'],
							        'hero',
							        false,
							        [
							                'alt' => $alt_text,
							                'srcset' => wp_get_attachment_image_srcset($image['ID'], 'hero'),
							                'sizes' => '100vw', // 100% viewport width
							                'class' => 'hero-image',
							                'loading' => 'eager', // Load priority for above-fold content
							            ]
							    );
							} ?>


								<?php if (get_field('header_image_caption')) {  /// IMAGE CAPTION
								    $header_image_caption = get_field('header_image_caption');
								    echo '<figcaption class="wp-caption-text">' . wp_kses_post($header_image_caption) . '</figcaption>';
								}  ?>


							</figure>
						</div><!-- / image -->

					<?php }
					}
    } ?>

	
  </div><!-- / row -->
</div><!-- / container -->
</section><!-- / container-wrapper -->







<!-- ARTICLE -->
<div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100" >
<div class="container ">
  <div class="row  justify-center">

	<div class="rte-content col col-8<?php if (get_field('rte_dropcap_toggle')) {  ?> rte-dropcap <?php } else {
	}  ?> "  >

   




			<?php // ACF FLEX CONTENT

	        if (have_rows('rte_flexible_content')) {

	            while (have_rows('rte_flexible_content')) : the_row();

	                if (get_row_layout() == 'rte_content') {  // CONTENT BLOCK
	                    $content = get_sub_field('rte_content_block');
	                    if ($content) {
	                        echo '<div class="rte-content rte-content-block">';
	                        echo do_shortcode(wpautop($content)); // allows footnotes to register/detected/counted without injecting output
	                        echo '</div>';
	                    }
	                } elseif (get_row_layout() == 'rte_table') { // TABLE
	                    if (get_sub_field('rte_table_width') == 'wide') {
	                        $rte_table_width = 'rte-full-width';
	                    } else {
	                        $rte_table_width = '';
	                    }
	                    echo '<div class="rte-content table-wrapper  ' . $rte_table_width . '">' . do_shortcode(get_sub_field('rte_table_shortcode')) . '</div>';
	                } elseif (get_row_layout() == 'rte_code') { // CODE BLOCK
	                    $rte_code = get_sub_field('rte_code_block');
	                    echo '<div class="rte-content "><pre class="rte-code"><code>' . $rte_code . '</code></pre></div>';

	                } elseif (get_row_layout() == 'rte_large_image') { // LARGE IMAGE

	                    if (get_sub_field('rte_large_image_block')) {
	                        $image = get_sub_field('rte_large_image_block'); // Is an image selected?>				
									
									<figure class="rte-content rte-full-width">				
									<?php if ($image) {
									    // Get the alt text, fallback to title if no alt
									    $alt_text = get_post_meta($image['ID'], '_wp_attachment_image_alt', true);
									    if (empty($alt_text)) {
									        $alt_text = get_the_title();
									    }
									    echo wp_get_attachment_image(
									        $image['ID'],
									        'hero',
									        false,
									        [
									                    'alt' => $alt_text,
									                    'srcset' => wp_get_attachment_image_srcset($image['ID'], 'hero'),
									                    'sizes' => '100vw', // 100% viewport width
									                    'class' => 'large-image',
									                    'loading' => 'lazy',
									                ]
									    );
									} ?>

												<?php if (get_sub_field('rte_large_image_caption')) {  // caption
												    $rte_large_image_caption = get_sub_field('rte_large_image_caption');
												    echo '<figcaption class="wp-caption-text">' . $rte_large_image_caption . '</figcaption>';
												}  ?>
									</figure>

							<?php }?> 



				<?php	} // Close ACF Conditions

	            endwhile;
	        } else {

	        } ?>





		</div><!-- / col -->
  </div><!-- / row -->
</div><!-- / container -->
</div><!-- / container wrapper -->





</main><!-- / main -->

<?php
    get_footer();
