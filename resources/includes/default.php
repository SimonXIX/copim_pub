<div class="alm-post-group" data-year="<?php echo esc_attr(get_the_date('Y')); ?>">
	<?php
    $year = get_the_date('Y');
$first = substr($year, 0, 1);
$rest = substr($year, 1);
?>
	<h4 class="accent-heading post-year-heading">
	<span class="accent-first-letter"><?php echo esc_html($first); ?></span><?php echo esc_html($rest); ?>
	</h4>
</div>
      



						<?php if (get_field('header_image_toggle')) { //do you require an image??>
							<?php if (get_field('header_image')) {
							    $image = get_field('header_image'); // Is an image selected?>				
								<article class="post-grid-item">
									<a href="<?php the_permalink(); ?>"  class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>
										<figure class="image-grid">				
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
													            'alt' => $alt_text, // Explicitly set alt text
													            'srcset' => wp_get_attachment_image_srcset($image['ID'], 'medium'),
													            'sizes' => '(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw',
													            'class' => 'grid-image',
													            'loading' => 'lazy',
													        ]
													    );
													} ?>
										</figure>

							<?php } ?> 
						<?php } else {  ?>
							<article class="post-grid-item no-image">
								<a href="<?php the_permalink(); ?>"  class="card-link" aria-label="<?php the_title_attribute(); ?>. Read more"></a>
					<?php } ?>

					
					<div class="post-text">
										<div class="post-date"><?php the_time('d F Y'); ?></div>

										
										
											<h5><?php the_title(); ?></h5> 
										
											

						<?php if (get_field('post_excerpt')) {
						    echo '<p class="post-excerpt">' . wp_kses_post(get_field('post_excerpt')) . '</p>';
						} else {
						    echo '<p class="post-excerpt post-introduction-excerpt">' . get_intro_excerpt() . '</p>';
						}  ?> 
					
						<?php // DISPLAY AUTHORS
						    $authors = get_field('post_authors');
if ($authors): ?>
								<div class="post-authors"> 
									<?php
        $author_count = count($authors);
    $author_names = [];

    foreach ($authors as $author) {
        $author_names[] = '<a href="' . esc_url(get_permalink($author->ID)) . '" aria-label="View all posts by ' . esc_attr(get_the_title($author->ID)) . '">' . esc_html(get_the_title($author->ID)) . '</a>';
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
						<?php endif; // end of author script?>

 
					
					</div>
  
  </article>