
<?php
get_header();
?>
<main id="main-content" class="site-main" role="main">








<?php // LOOP
    while (have_posts()) :
        the_post(); ?> 
			


			
<!-- HEADER -->
<?php  $has_image = get_field('header_image_toggle'); // Check if header has image?>
<section class="container-wrapper bg-color-warm-gray-800 header-bg " >
<div class="container article-header <?php echo $has_image ? '' : 'no-hero-image'; ?>">
  <div class="row justify-left"  >

	


	<div class="section-header col  <?php echo $has_image ? 'col-6' : 'col-10'; ?>">



	<div class="section-header-title">

		<?php // CATEGORIES
            if (has_category()) :
                echo '<ul class="post-categories">';

                // Get the categories for this post
                $categories = get_the_category();

                // Loop through each category
                foreach ($categories as $category) {
                    // Check if the ACF field exists and has a value
                    $custom_url = get_field('category_homepage', 'category_' . $category->term_id);

                    // Determine which URL to use
                    $url = ! empty($custom_url) ? $custom_url : get_category_link($category->term_id);

                    // Output each category as a list item
                    echo '<li><a href="' . esc_url($url) . '">' . esc_html($category->name) . '</a></li>';
                }

                echo '</ul>';
            endif;
        ?>


		<?php // TITLE
            the_title('<h1 class="entry-title">', '</h1>');
        ?>


		<?php  // AUTHORS
            $authors = get_field('post_authors');
        if ($authors): ?>
				<div class="post-authors">By 
					<?php
                $author_names = [];
            foreach ($authors as $author) {
                $author_names[] = '<a href="' . esc_url(get_permalink($author->ID))  . '">' . esc_html(get_the_title($author->ID)) . '</a>';
            }
            if (count($author_names) === 1) {
                echo $author_names[0];
            } else {
                $last_author = array_pop($author_names);
                echo implode(', ', $author_names) . ' and ' . $last_author;
            }
        ?>
				</div>
		<?php endif; ?>


 	</div><!-- / section-header-title -->


		<?php // PUBLISHED?>	
			<div class="post-date ">Published: <?php the_time('d F Y');
        ?></div>



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
							</figure>
						</div><!-- / image -->

					<?php }
					}
            } ?>

	



	
  </div><!-- / row -->
</div><!-- / container -->
</section><!-- / container-wrapper -->



<!-- ARTICLE -->
<div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100 bdr-bottom-color-warm-gray-400" >
<div class="container ">
  <div class="row  justify-center">

	<div class="article-main col col-8<?php if (get_field('rte_dropcap_toggle')) {  ?> rte-dropcap <?php } else {
	}  ?> " >




	
<!-- AddToAny BEGIN -->
	<div class="a2a_kit a2a_kit_size_32 a2a_default_style sharing-buttons">
		<a class="a2a_button_mastodon icon-wrapper" aria-label="Share on Mastodon"><svg class="icon sharing-icon" aria-hidden="true"><use href="#mastodon"></use></svg></a>
		<a class="a2a_button_bluesky icon-wrapper" aria-label="Share on Bluesky"><svg class="icon sharing-icon" aria-hidden="true"><use href="#bluesky"></use></svg></a>
		<a class="a2a_button_linkedin icon-wrapper" aria-label="Share on LinkedIn"><svg class="icon sharing-icon" aria-hidden="true"><use href="#linkedin"></use></svg></a>
		<a class="a2a_button_email icon-wrapper" aria-label="Share by email"><svg class="icon sharing-icon" aria-hidden="true"><use href="#email"></use></svg></a>
		<a class="a2a_button_copy_link icon-wrapper" aria-label="Copy link"><svg class="icon sharing-icon" aria-hidden="true"><use href="#ph--link-light"></use></svg></a>
	</div>
	<script defer src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->




		<?php // INTRODUCTION
	        if (get_field('rte_content_introduction')) { ?>
				<div class="rte-content post-introduction"><?php echo wp_kses_post(get_field('rte_content_introduction')); ?> </div>
		<?php  } ?>

		<!--  RELATED ASIDE  -->
			<aside role="complementary" class="right-aside"> 	
				
				<?php // RELATED POSTS
	                if (get_field('post_comment_toggle')) { ?>
					
					<div class="aside-item">
						<h4>Related Posts</h4>

						<?php
	                        $commenton_post = get_field('post_comment_post');
	                    if ($commenton_post):
	                        foreach ($commenton_post as $post):
	                            setup_postdata($post); ?>
									
								<div class="related-post"> <a href="<?php the_permalink(); ?>" class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>
									<div>

										<h5 class="card-title"><?php the_title(); ?></h5> 		

									<?php // DISPLAY AUTHORS
	                                $authors = get_field('post_authors');
	                            if ($authors): ?>
											<div class="post-authors"> 
												<?php
	                                    $author_count = count($authors);
	                                $author_names = [];

	                                foreach ($authors as $author) {
	                                    $author_names[] = '<a href="' . get_permalink($author->ID) . '">' . get_the_title($author->ID) . '</a>';
	                                }

	                                if ($author_count === 1) { // Single author
	                                    echo $author_names[0];
	                                } elseif ($author_count === 2) { // Two authors
	                                    echo $author_names[0] . ' & ' . $author_names[1];
	                                } else { // Multiple authors
	                                    echo $author_names[0] . ' & ' . ($author_count - 1) . ' others';
	                                }
	                            ?>
											</div>
									<?php endif; ?>
								</div> <!-- / heading + author -->

									<?php // DISPLAY THUMBNAIL
	                                if (get_field('header_image_toggle')) { //do you require an image??>
											<?php if (get_field('header_image')) {
											    $image = get_field('header_image'); // Is an image selected?>				
													
												<figure class="image-thumbnail" >				
												<?php if ($image) {
												    // Get the alt text, fallback to title if no alt
												    $alt_text = get_post_meta($image['ID'], '_wp_attachment_image_alt', true);
												    if (empty($alt_text)) {
												        $alt_text = get_the_title();
												    }
												    echo wp_get_attachment_image(
												        $image['ID'],
												        'thumbnail',
												        false,
												        [
												            'alt' => $alt_text,
												            'srcset' => wp_get_attachment_image_srcset($image['ID'], 'thumbnail'),
												            'sizes' => '(max-width: 9999px) 100px', // Fixed maximum size for all devices
												            'class' => 'thumbnail-image',
												            'loading' => 'lazy', // Load priority lazy below-fold content
												        ]
												    );
												} ?>
												</figure>
											<?php }?> 
									<?php } ?>

								</div> <!-- / related-post -->					

							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
						</div> <!-- / aside-item -->
					<?php endif; ?>
				<?php } ?>

				<?php // TOPICS
                    if (has_tag()) :
                        ?>
						<div class="aside-item">
						<h4>Topics</h4>
						
						<?php
                        echo '<ul class="post-tags">';
                        $tags = get_the_tags();
                        if ($tags) {
                            foreach ($tags as $tag) {
                                echo '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
                            }
                        }
                        echo '</ul></div> <!-- / aside-item -->';
                    endif;
        ?>

				<?php // IMAGE CAPTION
            if (get_field('header_image_caption')) { ?>
					<div class="aside-item">
						<h4>Image</h4>
							<div class="image-caption"><?php echo wp_kses_post(get_field('header_image_caption'));?></div>
					</div> <!-- / aside-item -->
				<?php } ?>
				
			</aside>





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

 


<!-- ARTICLE FOOTER -->
<div class="container container-padding-top container-padding-bottom bg-color-white">
	<div class="row justify-center">
		<section class="article-footer col col-8">
	
		<!-- 1. Footnotes -->
		<?php
        ob_start();
        the_content(); // triggers Easy Footnotes to output final <ol> at the end
        $footnotes_output = ob_get_clean();

        if (strpos($footnotes_output, 'easy-footnote') !== false) : ?>
		<details class="accordion" open>
			<summary><h4>Footnotes <span></span></h4></summary>
			<?php echo $footnotes_output; ?>
		</details>
		<?php endif; ?>

		<!-- 2. Citation  -->
		<?php if (get_field('post_citation_toggle') != 'none') { // None?>	
			<details class="accordion">
			<summary><h4>Citation</h4></summary><div>
		<?php } ?>
		<?php if (get_field('post_citation_toggle') == 'auto') { // Harvard?>
			<?php $authors = get_field('post_authors');
		    if ($authors):
		        $citations = [];
		        foreach ($authors as $author) {
		            $citation = get_field('author_citation', $author->ID);
		            if ($citation) {
		                $citations[] = $citation;
		            }
		        }
		        echo implode(', ', $citations);
		    elseif (! $authors):
		        echo get_bloginfo('name');
		    endif; ?>

				(<?php the_time('Y'); ?>).
				'<?php the_title();?>'
				<em>Copim,</em> <?php the_time('d F'); ?>.					
				Available at: <?php the_permalink(); ?> 
				(<?php echo 'Accessed: ' . date('j F Y'); ?>)</div></details>
		<?php } elseif (get_field('post_citation_toggle') == 'manual') { // manual?>
			<div><?php if (get_field('post_citation_custom')) {
			    echo wp_kses_post(get_field('post_citation_custom'));
			}  ?></div></details>
		<?php } ?>


		<!-- 3. License  -->
    	<?php
        if (get_field('post_license_toggle')) {  ?>	
			<details class="accordion">
				<summary><h4>License</h4></summary>
				<p><?php if (get_field('post_license')) {
				    echo wp_kses_post(get_field('post_license'));
				}  ?></p>
			</details>
		<?php } ?>




		<!-- 4. Comments  -->
		<?php
        if (! post_password_required() && post_type_supports(get_post_type(), 'comments')) {
            $comments_open = comments_open();
            $comment_count = get_comments_number();

            if ($comments_open || $comment_count > 0) : ?>
			<details class="accordion">
				<summary>
				<h4>Comments <span>(<?php echo $comment_count; ?>)</span></h4>
				</summary>

				<?php comments_template();  ?>

			</details>
		<?php endif;
        } ?>


			



















	










	</section><!-- / article-footer -->
  </div><!-- / row -->
</div><!-- / container -->



		<?php endwhile; // End of the loop.
?>



<?php // Hidden author names for searchability
$author_names = get_field('author_names_hidden');
if (! empty($author_names)) : ?>
    <div style="display: none;" aria-hidden="true">
        <?php echo esc_html($author_names); ?>
    </div>
<?php endif; ?>


</main><!-- / main -->

<?php get_footer();
