<?php
/*
 * Template Name: Homepage
 */
?>

<?php
get_header();
?>
<main id="main-content" class="site-main copim-home-page"role="main">



<?php  $has_image = get_field('header_image_toggle'); // Check if header has image?>
<section class="container-wrapper bg-color-warm-gray-800 header-bg" style="position: relative;" >
<div class="container article-header <?php echo $has_image ? '' : 'no-hero-image'; ?>">
  <div class="row justify-left"  >

	<div class="section-header col  <?php echo $has_image ? 'col-6' : 'col-10'; ?>">

	<div class="section-header-title">


          <h1><?php  // TITLE
            if (get_field('homepage_header_title')) {
                echo wp_kses_post(get_field('homepage_header_title'));
            }
?></h1>

            <?php // Subtitle
    if (get_field('header_subtitle')) { ?>
                <?php echo  '<div class="header-subtitle">' .   wp_kses_post(get_field('header_subtitle')) . '</div>'; ?> 
            <?php  } ?>


          <?php if (get_field('homepage_header_button_toggle')) { // BUTTON

              if (get_field('homepage_header_button_label')) {
                  $buttonlabel = get_field('homepage_header_button_label');
              } else {
                  $buttonlabel = 'Read More';
              }

              if (get_field('homepage_header_button_url')) {
                  $buttonurl = get_field('homepage_header_button_url');
              } else {
                  $buttonurl = '#';
              } ?>

              <div class="home-button-link"><a href="<?php echo esc_url($buttonurl); ?>" title="<?php echo esc_attr($buttonlabel); ?>" class="button-link" aria-label="<?php echo esc_attr($buttonlabel); ?>">
                  <?php echo esc_html($buttonlabel); ?><span class="icon-wrapper"><svg class="icon button-icon" aria-hidden="true"><use href="#ph--plus-bold"></use></svg></span>
              </a></div>

          <?php } ?>

      

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








<!-- LATEST POSTS -->	
      <?php if (get_field('homepage_posts_toggle') != 'none') { // Not None?>

         <?php if (get_field('homepage_posts_columns_toggle') == 'odd-columns') {
             $grid_columns = 'odd-columns';
             $load_more_posts = '6';
         } else {
             $grid_columns = 'even-columns';
             $load_more_posts = '8';
         }
          ?>	

        <div class="container-wrapper container-padding-top container-padding-bottom bg-color-white " >
          <div class="container ">
            <div class="row  justify-center">
              <section  class="col col-12 cms-content <?php echo esc_attr($grid_columns); ?>" >

                  <?php if (get_field('homepage_posts_intro')) {
                      $has_intro = 'subtitle-margin';
                  } else {
                      $has_intro = 'module-padding-bottom';
                  } ?>

                  <?php if (get_field('homepage_posts_title')) {
                      echo '<h4 class="accent-heading ' . $has_intro . '">' . wp_kses_post(get_field('homepage_posts_title')) . '</h4>';
                  }  ?>
                  <?php if (get_field('homepage_posts_intro')) {
                      echo '<div class="module-intro module-padding-bottom">' . wp_kses_post(get_field('homepage_posts_intro')) . '</div>';
                  }  ?>

      <?php } ?>


      <?php if (get_field('homepage_posts_toggle') == 'latest') { // Latest Posts?>	
                              
       

                      <?php // AJaX LOAD MORE
                          $shortcode = '[ajax_load_more container_type="div" loading_style="blue" scroll="false" post_type="post" posts_per_page="' . $load_more_posts . '" max_pages="3"  button_label="More Articles" ]';
          echo do_shortcode($shortcode);
          ?>
                        
                  </section><!-- / section -->       
                </div><!-- / row -->
              </div><!-- / container -->
            </div><!-- / container wrapper -->

      <?php } elseif (get_field('homepage_posts_toggle') == 'manual') { // Manually select Posts?>	


                        <div>
                            <?php
                  $featured_posts = get_field('homepage_posts');
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







<!-- PAGE BLOCK -->	
<?php if (get_field('homepage_pages_toggle')) { ?>

    <?php if (get_field('homepage_pages_columns_toggle') == 'odd-columns') {
        $grid_columns = 'odd-columns';
    } else {
        $grid_columns = 'even-columns';
    }
    ?>	

          
    <div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-200 bdr-top-color-warm-gray-400 bdr-bottom-color-warm-gray-400  " >
      <div class="container ">
        <div class="row  justify-center">
          <section  class="col col-12 cms-content <?php echo esc_attr($grid_columns); ?>" >


                  <?php if (get_field('homepage_pages_intro')) {
                      $has_intro = 'subtitle-margin';
                  } else {
                      $has_intro = 'module-padding-bottom';
                  } ?>


                <?php if (get_field('homepage_pages_title')) {
                    echo '<h4 class="accent-heading ' . $has_intro . '">' . wp_kses_post(get_field('homepage_pages_title')) . '</h4>';
                }  ?>
                <?php if (get_field('homepage_pages_intro')) {
                    echo '<div class="module-intro module-padding-bottom">' .  wp_kses_post(get_field('homepage_pages_intro')) . '</div>';
                }  ?>


                  <section class="homepage-pages">
                          <?php
                            $featured_posts = get_field('homepage_pages');
    if ($featured_posts): ?>
                                <?php foreach ($featured_posts as $post):
                                    setup_postdata($post); ?>



                                
                                   <article class="grid-item">

                                       
                                        <a href="<?php the_permalink(); ?>"  class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>

                                        <h5><?php the_title(); ?></h5> 
                              
                                            <?php if (get_field('page_excerpt')) { // EXCERPT
                                                echo '<div class="post-excerpt">' . wp_kses_post(get_field('page_excerpt')) . '</div>';
                                            } else {
                                                echo '<div class="post-excerpt post-introduction-excerpt">' . get_page_excerpt() . '</div>';
                                            }  ?> 
                                          
                                          
                                          
                                          <div class="article-link" >More <span class="icon-wrapper"><svg class="icon article-icon" aria-hidden="true"><use href="#ph--plus-bold"></use></svg></span></div>
                                      

                                    </article>
                                  

                                <?php endforeach; ?>
                              <?php
                              wp_reset_postdata(); ?>
                          <?php endif; ?>
                  </section>


        </section><!-- / section -->       
      </div><!-- / row -->
    </div><!-- / container -->
  </div><!-- / container wrapper -->
<?php } ?>  





<!-- SLIDER -->	
<?php if (get_field('homepage_page_slider_toggle')) { ?>
    <div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-800   " >
      <div class="container ">
        <div class="row  justify-center">
          <section  class="col col-12 cms-content" >


                  <?php if (get_field('homepage_page_slider_intro')) {
                      $has_intro = 'subtitle-margin';
                  } else {
                      $has_intro = 'module-padding-bottom';
                  } ?>

    <?php if (get_field('homepage_page_slider_title')) {
        echo  '<h4 class="accent-heading ' . $has_intro . '">' . wp_kses_post(get_field('homepage_page_slider_title')) . '</h4>';
    }  ?>
    <?php if (get_field('homepage_page_slider_intro')) {
        echo '<div class="module-intro module-padding-bottom">' .  wp_kses_post(get_field('homepage_page_slider_intro')) . '</div>';
    }  ?>


              <div class="swiper">
                  <div class="swiper-wrapper">

                      <?php  // SLIDES
                        $featured_posts = get_field('homepage_page_slider');
    if ($featured_posts): ?>
                            <?php foreach ($featured_posts as $post):
                                setup_postdata($post); ?>
                                   

                                      

                                          <?php // determine image widths
                                            $image_size = get_field('header_image_size');  // Check size
                                ?>

                                            

                                            <?php if (get_field('header_image_toggle')) { //do you require an image??>

                                              <article class=" swiper-slide"><div class="swiper-slide-content"> 
                                                <a href="<?php the_permalink(); ?>"  class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>
                                      
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
                                              <article class=" swiper-slide no-image"><div class="swiper-slide-content"> 
                                              <a href="<?php the_permalink(); ?>"  class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>
                                            <?php } ?>



                                                
                                                      <h5><?php the_title(); ?></h5>
                                                
                                                <?php if (get_field('page_excerpt')) { // EXCERPT
                                                    echo '<div class="post-excerpt">' . wp_kses_post(get_field('page_excerpt')) . '</div>';
                                                } else {
                                                    echo '<div class="post-excerpt post-introduction-excerpt">' . get_page_excerpt() . '</div>';
                                                }  ?> 
                                        
                                      </div></article>
                                            
                            <?php endforeach; ?>
                          <?php
                          wp_reset_postdata(); ?>
                      <?php endif; ?>



                  </div><!-- / Swiper Wrapper -->

                  <!-- PAGINATION -->
                  <div class="swiper-pagination"></div>

              </div><!-- / Swiper -->



              <script>
                    const swiper = new Swiper('.swiper', {
                      direction: 'horizontal',
                      //loop: true,
                      //slidesPerView: 3,
                      // slidesPerGroup: 3,
                      // centeredSlides: true,
                      spaceBetween: 42,
                      lazy: true,
                      //rewind: true,
                      grabCursor: true,
                      keyboard: {
                        enabled: true,
                      },
                      breakpoints: {
                            0: {
                              slidesPerView: 1,
                              slidesPerGroup: 1,
                              spaceBetween: 16,
                            },
                            476: {
                              slidesPerView: 2,
                              slidesPerGroup: 2,
                              spaceBetween: 24,
                            },
                            768: {
                              slidesPerView: 2,
                              slidesPerGroup: 2,
                              spaceBetween: 24,
                            },
                            992: {
                              slidesPerView: 3,
                              slidesPerGroup: 3,
                            },
                            1200: {
                              slidesPerView: 3,
                              slidesPerGroup: 3,
                            },
                          },

                      // Pagination
                      pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        bulletClass: 'swiper-pagination-bullet', 
                        bulletActiveClass: 'swiper-pagination-bullet-active' 
                      },
                    });
              </script>







        </section><!-- / section -->       
      </div><!-- / row -->
    </div><!-- / container -->
  </div><!-- / container wrapper -->
<?php } ?>  











<!-- MASTODON SHORTCODE -->	

<?php if (get_field('homepage_mastodon_toggle')) { ?>



          <?php if (get_field('homepage_mastodon_columns_toggle') == 'odd-columns') {
              $grid_columns = 'odd-columns';
              $limit = '3';
          } else {
              $grid_columns = 'even-columns';
              $limit = '4';
          }
    ?>	




  <div class="container-wrapper  container-padding-top container-padding-bottom bg-color-warm-gray-100  " >
  <div class="container ">
    <div class="row  justify-center">
      <section  class="col col-12 <?php echo esc_attr($grid_columns); ?>" >


    <div class="heading-link" >  
    <?php if (get_field('homepage_mastodon_title')) {
        echo  '<h4 class="accent-heading">' .  wp_kses_post(get_field('homepage_mastodon_title')) . '</h4>';
    }  ?>
    <?php if (get_field('homepage_mastodon_url')) {
        echo '<a href="' .  esc_url(get_field('homepage_mastodon_url')) . '" class="heading-url" aria-label="Visit Mastodon Feed" >More<span class="icon-wrapper"><svg class="icon"  aria-hidden="true"><use href="#ph--plus-bold"></use></svg></span></a>';
    } ?>
    </div>
                                                                   


                                  

    <?php $mastodon_account = get_field('homepage_mastodon_account');

    if ($mastodon_account) {

        $instance = isset($mastodon_account['homepage_mastodon_instance']) ? $mastodon_account['homepage_mastodon_instance'] : '';
        $account = isset($mastodon_account['homepage_mastodon_accountid']) ? $mastodon_account['homepage_mastodon_accountid'] : '';
        // $limit = isset($mastodon_account['homepage_mastodon_limit']) ? $mastodon_account['homepage_mastodon_limit'] : '';

        // Construct the shortcode
        $shortcode = '[include-mastodon-feed';

        // Add parameters if they exist
        if (! empty($instance)) {
            $shortcode .= ' instance="' . esc_attr($instance) . '"';
        }

        if (! empty($account)) {
            $shortcode .= ' account="' . esc_attr($account) . '"';
        }

        if (! empty($limit)) {
            $shortcode .= ' limit="' . esc_attr($limit) . '"';
        }

        // Close the shortcode and add any final non-optional requirements
        $shortcode .= '  showPreviewCards="false" hideStatusMeta="false"   date-locale="en-UK"  hideStatusMeta="false" linkTarget="_self"  ]';

        // Execute/render the shortcode
        echo do_shortcode($shortcode);

    } else {

    }
    ?>
 



        </section><!-- / section -->       
      </div><!-- / row -->
    </div><!-- / container -->
  </div><!-- / container wrapper -->
<?php } ?>  



</main><!-- #main -->






<?php
get_footer();
