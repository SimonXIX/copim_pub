<?php
get_header();
?>
<main id="main-content" class="site-main" role="main">

<!-- HEADER -->
<section class="container-wrapper bg-color-warm-gray-800 " >
    <div class="container article-header no-hero-image">
        <div class="row justify-center" >

                        <div class="section-header col  col-12">
                            <div class="section-header-title">


                                    <?php
                                        // Get the total number of results
                                        global $wp_query;
$total_results = $wp_query->found_posts;
?>
                                        
                                        <h1 class="page-title">
                                            <?php
    printf(
        _n(
            '%d result for ',
            '%d results for ',
            $total_results,
            'copim'
        ),
        $total_results
    );
printf(esc_html__('%s', 'copim'), '<em>"' . esc_attr(get_search_query()) . '"</em>'); ?>

                                        </h1>

                            </div><!-- / section-header-title -->
                        </div><!-- / section-header -->

        </div><!-- / row -->
    </div><!-- / container -->
</section><!-- / container-wrapper -->

       

<!-- RESULTS -->
<div class="container-wrapper container-padding-top container-padding-bottom bg-color-warm-gray-100" >
 <div class="container ">
    <div class="row  justify-center">
        <div class="col col-12 even-columns">


             
                    <?php
                    // Ajax Load More shortcode
                    echo do_shortcode('[ajax_load_more 
                        search="'. esc_attr(get_search_query()) .'" 
                        post_type="post" 
                        posts_per_page="8" 
                        button_label="More Articles"
                        container_type="div" 
                        scroll="true" pause="false" loading_style="infinite fading-squares" scroll_distance="50"
                       ]');
?>
            
 
        </div><!-- / col -->
  </div><!-- / row -->
</div><!-- / container -->
</div><!-- / container wrapper -->



</main><!-- / main -->

<?php
    get_footer();
