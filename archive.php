<?php
get_header();
?>
<main id="main-content" class="site-main all-posts"role="main">


<?php if (have_posts()) : ?>
 

        <!-- HEADER -->
        <section class="container-wrapper bg-color-warm-gray-800 header-bg" >
            <div class="container article-header no-hero-image">
                <div class="row justify-center"  >

                            <div class="section-header col  col-12">
                                <div class="section-header-title">

                                    <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
                                    <div class="header-subtitle"><?php echo term_description(); ?></div>

                                </div><!-- / section-header-title -->
                            </div><!-- / section-header -->

        </div><!-- / row -->
        </div><!-- / container -->
        </section><!-- / container-wrapper -->


        <!-- ARTICLE -->
        <div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-200" >
        <div class="container ">
        <div class="row justify-center">
            <div  class="col col-10   cms-content"  >



        <?php
        $queried_object = get_queried_object();

    if (is_category()) {
        // Category archive
        $category_id = $queried_object->term_id;
        echo do_shortcode('[ajax_load_more 
                post_type="post" 
                category="' .  esc_attr($queried_object->slug) . '" 
                posts_per_page="8" 
            scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
			container_type="div" 
           button_label="More Articles"]');

    } elseif (is_tag()) {
        // Tag archive
        $tag_id = $queried_object->term_id;
        echo do_shortcode('[ajax_load_more
                post_type="post"
                tag="' .  esc_attr($queried_object->slug) . '"
                posts_per_page="8"
            scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
			container_type="div" 
           button_label="More Articles"]');

    } elseif (is_tax()) {
        // Custom taxonomy archive
        $tax_slug = $queried_object->taxonomy;
        $term_slug = esc_attr($queried_object->slug);
        echo do_shortcode('[ajax_load_more
                post_type="post"
                taxonomy="' . $tax_slug . '"
                taxonomy_terms="' . $term_slug . '"
                taxonomy_operator="IN"
                posts_per_page="8"
            scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
			container_type="div" 
           button_label="More Articles"]');

    } elseif (is_author()) {
        // Author archive
        $author_id = get_queried_object_id();
        echo do_shortcode('[ajax_load_more
                author="' . $author_id . '"
                posts_per_page="8"
            scroll="false" 
			container_type="div" 
           button_label="More Articles"]');

    } elseif (is_date()) {
        // Date archive
        echo do_shortcode('[ajax_load_more
                year="' . get_query_var('year') . '"
                month="' . get_query_var('monthnum') . '"
                day="' . get_query_var('day') . '"
                posts_per_page="8"
            scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
			container_type="div" 
           button_label="More Articles"]');

    } else {
        // Default archive fallback
        echo do_shortcode('[ajax_load_more
            posts_per_page="8"
            scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
			container_type="div" 
           button_label="More Articles"]');
    }
?>



<?php else : ?>


        <!-- HEADER -->
        <section class="container-wrapper bg-color-warm-gray-800 header-bg" >
            <div class="container article-header no-hero-image">
                <div class="row justify-center"  >

                            <div class="section-header col  col-12">
                                <div class="section-header-title">

							<h1>Nothing Found</h1>
							<div class="header-subtitle">Use the search tool above, or <a href="<?php echo home_url(); ?>">visit our homepage</a></div>

                                </div><!-- / section-header-title -->
                            </div><!-- / section-header -->

        </div><!-- / row -->
        </div><!-- / container -->
        </section><!-- / container-wrapper -->


        <!-- ARTICLE -->
        <div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-200" >
        <div class="container ">
        <div class="row justify-center">
            <div  class="col col-10  all-posts cms-content" >


            
<?php endif; ?>




    </div><!-- / col -->
  </div><!-- / row -->
</div><!-- / container -->
</div><!-- / container wrapper -->


</main><!-- / main -->

<?php
get_footer();
