<?php
/*  Template Name: Category Page */
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



<!-- CONTENT -->

    <?php if (get_field('category_introduction_toggle')) { ?>
        <section class="container-wrapper container-padding-top container-padding-bottom bg-color-white" >
          <div class="container ">
            <div class="row  justify-center">

            

                                  <!-- CATEGORY MENU -->	
                                     <nav class="col col-3 category-menu" role="navigation" aria-label="Category menu" ><ul>    
                                          <?php if (have_rows('category_menu')) :
                                              while (have_rows('category_menu')) : the_row();

                                                  if (get_sub_field('category_menu_label')) {
                                                      $linktitle = get_sub_field('category_menu_label');
                                                  }
                                                  if (get_sub_field('category_menu_internal_url')) {
                                                      $linkinternalurl = get_sub_field('category_menu_internal_url');
                                                  }
                                                  if (get_sub_field('category_menu_external_url')) {
                                                      $linkexternalurl = get_sub_field('category_menu_external_url');
                                                  } ?>

                                              <?php if (get_sub_field('category_menu_type') == 'internal') { ?>
                                                          <li><a href="<?php echo $linkinternalurl; ?>" title="<?php echo $linktitle; ?>">
                                                              <?php echo $linktitle; ?>
                                                          </a> &nbsp;</li>
                                              <?php } elseif (get_sub_field('category_menu_type') == 'external') { ?>
                                                          <li><a href="<?php echo $linkexternalurl; ?>" title="<?php echo $linktitle; ?>">
                                                                <?php echo $linktitle; ?> 

                                                                <span class="icon-wrapper">
                                                                  <svg class="icon" aria-hidden="true">
                                                                    <use href="#ph--arrow-up-right-bold"></use>
                                                                  </svg>
                                                                </span>
                                                          </a></li>

                                              <?php }  ?>

                                          <?php endwhile;
        else :
        endif;?>
                                    </ul></nav>





                                <div  class="rte-content <?php if (get_field('category_menu')) {
                                    echo 'col col-9 ';
                                } else {
                                    echo 'col col-12 ';
                                }  ?>" ><?php  //INTRO TEXT
                                  if (get_field('category_introtext')) {
                                      echo wp_kses_post(get_field('category_introtext'));
                                  }
        ?></div>


            </div><!-- / row -->
          </div><!-- / container -->
        </section><!-- / container wrapper -->
      <?php }  ?>

 <!-- CATEGORY PAGES -->	
 




       <?php if (get_field('category_promoted_toggle')) { ?>

        <?php if (get_field('category_keyreads_columns_toggle') == 'odd-columns') {
            $grid_columns = 'odd-columns';
        } else {
            $grid_columns = 'even-columns';
        }
           ?>	

        <div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100 bdr-top-color-warm-gray-400 bdr-bottom-color-warm-gray-400" >
          <div class="container ">
            <div class="row  justify-center">
              <section  class="col col-12 cms-content  <?php echo esc_attr($grid_columns); ?>" >

                                     
                                    <?php if (get_field('category_promoted_title')) {
                                        echo '<h4 class="accent-heading module-padding-bottom">' . wp_kses_post(get_field('category_promoted_title')) . '</h4>';
                                    }  ?>

                                    <section class="post-grid ">
                                            <?php
                                              $featured_posts = get_field('category_promoted_posts');
           if ($featured_posts): ?>
                                                  <?php foreach ($featured_posts as $post):
                                                      setup_postdata($post); ?>                          

                                              <?php include('resources/includes/default.php'); ?>

                                                  <?php endforeach; ?>
                                                <?php
                                                wp_reset_postdata(); ?>
                                            <?php endif; ?>
                                    </section>

              </section><!-- / section -->       
            </div><!-- / row -->
          </div><!-- / container -->
        </div><!-- / container wrapper -->
      <?php }  ?>

      

<!-- AJAX LOAD MORE: CATEGORY POSTS -->	
 
<?php  $keyreads_section = get_field('category_promoted_toggle'); // Check if page has keyreads section?>
       <?php if (get_field('category_post_toggle')) { ?>


            <?php if (get_field('category_posts_columns_toggle') == 'odd-columns') {
                $grid_columns = 'odd-columns';
                $load_more_posts = '6';
            } else {
                $grid_columns = 'even-columns';
                $load_more_posts = '8';
            }
           ?>	


        <div class="container-wrapper container-padding-top container-padding-bottom <?php echo $keyreads_section ? 'bg-color-white' : 'bg-color-warm-gray-100 bdr-top-color-warm-gray-400'; ?>" >
          <div class="container">
            <div class="row  justify-center">
              <section  class="col col-12 cms-content <?php echo esc_attr($grid_columns); ?>" >

              
              <?php if (get_field('category_post_title')) {
                  echo '<h4 class="accent-heading module-padding-bottom">' . wp_kses_post(get_field('category_post_title')) . '</h4>';
              }  ?>
                                         

                                        <?php
                                        // Get the selected taxonomy terms from the ACF field
                                        $selected_terms = get_field('category_post_taxonomy');

           // Check if there are terms and display posts only when configured
           if ($selected_terms && ! is_wp_error($selected_terms)) {
               $term_names = [];

               // Loop through each term and get its name with double quotes
               foreach ($selected_terms as $term) {
                   $term_names[] = '"' . $term->name . '"';
               }

               // Join the quoted term names with commas
               $terms_list = implode(', ', $term_names);

               // AJAX LOAD MORE: SHORTCODE - Only show when categories are configured
               $shortcode = '[ajax_load_more container_type="div" loading_style="blue" css_classes="css-grid" scroll="false" post_type="post" button_label="More Articles" posts_per_page="' . $load_more_posts . '" category=' . $terms_list . ']';
               echo do_shortcode($shortcode);

           } else {
               // Show message when no categories are configured
               echo '<p>Category not configured</p>';
           }
           ?>

              </section><!-- / section -->       
            </div><!-- / row -->
          </div><!-- / container -->
        </div><!-- / container wrapper -->
      <?php } ?>


</main><!-- / main -->




<?php
get_footer();
