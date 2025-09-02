<?php
/*
 * Template Name: Hubpage
 */
?>

<?php
get_header();
?>
<main id="main-content" class="site-main" role="main">



<?php // determine image widths
  $has_image = get_field('header_image_toggle');  // Check if header has image
$image_size = get_field('header_image_size');  // Check size

// Text and Image columns
if (! $has_image) {
    $layout_class = 'col-12';
    $image_class = '';
} elseif ($image_size === 'small') {
    $layout_class = 'col-9';
    $image_class = 'col-3';
    $image_size_class = 'header-logo-image';
    $image_width_class = ' ';
} else {
    $layout_class = 'col-6';
    $image_class = 'col-6';
    $image_size_class = 'header-hero-image';
    $image_width_class = 'extend-to-edge-right';
}
?>



<section class="container-wrapper bg-color-warm-gray-800 header-bg" >
<div class="container article-header <?php if (! $has_image || $image_size === 'small') {
    echo 'no-hero-image';
} ?>">
  <div class="row justify-left"  >

	<div class="section-header col  <?php echo $layout_class; ?>">

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
						<div class="<?php echo $image_size_class; ?> col <?php echo $image_class; ?>"> 
							<figure class="<?php echo $image_width_class; ?>">				
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

                    <?php if (get_field('header_image_caption') && ($image_size !== 'small')) {  /// IMAGE CAPTION
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



      <!-- INTRO TEXT -->	
      <?php if (get_field('hubpage_introtext')) { ?>
        <div class="container-wrapper  container-padding-top container-padding-bottom bg-color-white" >
          <div class="container ">
            <div class="row  justify-center">
              <section  class="col-12 col" >

                              
                <?php echo wp_kses_post(get_field('hubpage_introtext')); ?>

              </section><!-- / section -->       
            </div><!-- / row -->
          </div><!-- / container -->
        </div><!-- / container wrapper -->
      <?php } ?>  



        
      <!-- CATEGORIES -->	
      <?php if (get_field('hubpage_category_homepages_toggle')) { ?>

        <?php if (get_field('hubpage_pages_columns_toggle') == 'odd-columns') {
            $grid_columns = 'odd-columns';
        } else {
            $grid_columns = 'even-columns';
        }
          ?>	


        <div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100 bdr-top-color-warm-gray-400 bdr-bottom-color-warm-gray-400" >
          <div class="container ">
            <div class="row  justify-center">
              <section  class="col-12 col cms-content <?php echo esc_attr($grid_columns); ?>" >





              

              <?php if (get_field('hubpage_pages_title')) {
                  echo  '<h4 class="accent-heading module-padding-bottom">' .   wp_kses_post(get_field('hubpage_pages_title')) . '</h4>';
              }  ?>

                              <div class="post-grid show-excerpts">
                                      <?php
                                        $featured_posts = get_field('hubpage_category_homepages');
          if ($featured_posts): ?>
                                            <?php foreach ($featured_posts as $post):
                                                setup_postdata($post); ?>




                              
                                 
                                  


                                                <?php if (get_field('header_image_toggle')) { //do you require an image??>
                                                  <article class="post-grid-item">
                                                    
                                                      <?php // determine image widths
                                                    $image_size = get_field('header_image_size');  // Check size
                                                    ?>

                                                      <?php if (get_field('header_image')) {
                                                          $image = get_field('header_image'); // Is an image selected?>				
                                                          
                                                              <figure class="image-grid <?php echo ($image_size === 'small') ? 'small-image' : ' '; ?>">				
                                                              <?php if ($image) {
                                                                  // Get the alt text, fallback to title if no alt
                                                                  $alt_text = get_post_meta($image['ID'], '_wp_attachment_image_alt', true);
                                                                  if (empty($alt_text)) {
                                                                      $alt_text = get_the_title();
                                                                  }
                                                                  echo wp_get_attachment_image(
                                                                      $image['ID'],
                                                                      'medium',
                                                                      false,
                                                                      [
                                                                      'alt' => $alt_text,
                                                                      'srcset' => wp_get_attachment_image_srcset($image['ID'], 'medium'),
                                                                      'sizes' => '(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw', //100% width on mobile, 50% on tablets, 33% on desktop
                                                                      'class' => 'grid-image',
                                                                      'loading' => 'lazy', // Load priority lazy below-fold content
                                                                        ]
                                                                  );
                                                              } ?>
                                                              </figure>

                                                      <?php }?> 
                                                <?php } else { ?>
                                                  <article class="post-grid-item no-image page-link">
                                                <?php } ?>

                                        <a href="<?php the_permalink(); ?>"  class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>
                                        
                                        <h5><?php the_title(); ?></h5> 
                                          
                                      
                                       
                                      <?php if (get_field('page_excerpt')) { // EXCERPT
                                          echo '<div class="post-excerpt">' . wp_kses_post(get_field('page_excerpt')) . '</div>';
                                      } else {
                                          echo '<div class="post-excerpt post-introduction-excerpt">' . get_page_excerpt() . '</div>';
                                      }  ?> 


                              </article>
                                            <?php endforeach; ?>
                                          <?php
                                          wp_reset_postdata(); ?>
                                      <?php endif; ?>
                              </div>

              </section><!-- / section -->       
            </div><!-- / row -->
          </div><!-- / container -->
        </div><!-- / container wrapper -->
      <?php } ?>



         <!-- POSTS -->	
        <?php if (get_field('hubpage_promoted_toggle')) { ?>

          <?php if (get_field('hubpage_keyreads_columns_toggle') == 'odd-columns') {
              $grid_columns = 'odd-columns';
          } else {
              $grid_columns = 'even-columns';
          }
            ?>	


          <?php  $pages_section = get_field('hubpage_category_homepages_toggle'); // Check if page has keyreads section?>
        <div class="container-wrapper container-padding-top container-padding-bottom <?php echo $pages_section ? 'bg-color-white' : 'bg-color-warm-gray-100 bdr-top-color-warm-gray-400'; ?>" >
          <div class="container ">
            <div class="row  justify-center">
              <section  class="col-12 col cms-content <?php echo esc_attr($grid_columns); ?>" >


                             <?php if (get_field('hubpage_promoted_title')) {
                                 echo '<h4 class="accent-heading module-padding-bottom">' . wp_kses_post(get_field('hubpage_promoted_title')) . '</h4>';
                             }  ?>
 
                              <div class="post-grid ">
                                      <?php
                                        $featured_posts = get_field('hubpage_promoted_posts');
            if ($featured_posts): ?>
                                            <?php foreach ($featured_posts as $post):
                                                setup_postdata($post); ?>
                             
                                                      <?php include('resources/includes/default.php'); ?>
                              
                                            <?php endforeach; ?>
                                          <?php
                                          wp_reset_postdata(); ?>
                                      <?php endif; ?>
                                </div>


              </section><!-- / section -->       
            </div><!-- / row -->
          </div><!-- / container -->
        </div><!-- / container wrapper -->
       <?php } ?> 


</main><!-- / main -->

<?php
get_footer();
