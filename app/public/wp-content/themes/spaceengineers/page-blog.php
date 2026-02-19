<?php
/**
 * Blog Page Template
 */
get_header();
?>


<?php
$blog_page_id = 0;
$args = array(
    'post_type' => 'page',
    'name' => 'blog',
    'posts_per_page' => 1
);
$blog_query = new WP_Query( $args );
if ( $blog_query->have_posts() ) {
    $blog_query->the_post();
    $blog_page_id = get_the_ID();
    wp_reset_postdata();
}
$banner_title = get_post_meta( $blog_page_id, '_blog_banner_title', true );
if ( !$banner_title ) {
    $banner_title = 'Our Blog';
}
$banner_image_id = get_post_meta( $blog_page_id, '_blog_banner_image_id', true );
$banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : get_template_directory_uri() . '/img/blog_head.jpg';
?>
<!-- ==================== Page Title ==================== -->
<header class="pages-header bg-img valign parallaxie" data-background="<?php echo esc_url( $banner_image_url ); ?>" data-overlay-dark="5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cont text-center">
                    <h1><?php echo esc_html( $banner_title ); ?></h1>
                    <div class="path">
                        <a href="<?php echo home_url(); ?>">Home</a><span>/</span><a href="#" class="active"><?php echo esc_html( $banner_title ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ==================== End Page Title ==================== -->

<!-- ==================== Blog Listing ==================== -->
<section class="blog-grid section-padding">
    <div class="container">
        <div class="row">
            <?php
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'paged'          => $paged,
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="item wow fadeInUp" data-wow-delay=".3s">
                            <div class="post-img">
                                <div class="img">
                                    <?php
                                    $single_image_id = get_post_meta( get_the_ID(), '_blog_single_image_id', true );
                                    if ( $single_image_id ) {
                                        echo wp_get_attachment_image( $single_image_id, 'medium' );
                                    } elseif ( has_post_thumbnail() ) {
                                        the_post_thumbnail( 'medium' );
                                    } else {
                                        echo '<img src="' . esc_url( get_template_directory_uri() ) . '/img/blog/1.jpg" alt="' . the_title_attribute( 'echo=0' ) . '">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="cont">
                                <div class="info">
                                    <a href="<?php the_author_meta('user_url'); ?>"><?php the_author(); ?></a>
                                    <a href="#"><?php echo get_the_date(); ?></a>
                                </div>
                                <h5 class="playfont"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="more">
                                    <span class="custom-font">Read More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                // Pagination
                echo '<div class="col-12 mt-40">';
                echo paginate_links( array(
                    'total'   => $query->max_num_pages,
                    'current' => max( 1, $paged ),
                    'type'    => 'list',
                ) );
                echo '</div>';

                wp_reset_postdata();
            } else {
                echo '<div class="col-12"><p>No posts found.</p></div>';
            }
            ?>
        </div>
    </div>
</section>
<!-- ==================== End Blog Listing ==================== -->

<?php
get_footer();
?>
