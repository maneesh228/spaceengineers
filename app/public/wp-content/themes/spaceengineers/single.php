<?php
/**
 * Single Post Template
 */
get_header();

// Get Blog page banner settings (same as page-blog.php)
$blog_page_id = 0;
$args         = array(
    'post_type'      => 'page',
    'name'           => 'blog',
    'posts_per_page' => 1,
);
$blog_query = new WP_Query( $args );
if ( $blog_query->have_posts() ) {
    $blog_query->the_post();
    $blog_page_id = get_the_ID();
    wp_reset_postdata();
}

$banner_title = get_post_meta( $blog_page_id, '_blog_banner_title', true );
if ( ! $banner_title ) {
    $banner_title = 'Our Blog';
}
$banner_image_id  = get_post_meta( $blog_page_id, '_blog_banner_image_id', true );
$banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : get_template_directory_uri() . '/img/blog_head.jpg';
?>

<!-- ==================== Page Title ==================== -->
<header class="pages-header bg-img valign parallaxie" data-background="<?php echo esc_url( $banner_image_url ); ?>" data-overlay-dark="5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cont text-center">
                    <!-- <h1><?php // the_title(); ?></h1> -->
                    <div class="path">
                        <a href="<?php echo home_url(); ?>">Home</a><span>/</span><a href="<?php echo esc_url( get_permalink( $blog_page_id ) ); ?>">Blog</a><span>/</span><a href="#" class="active"><?php the_title(); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ==================== End Page Title ==================== -->

<!-- ==================== Blog Details ==================== -->
<section class="blog-details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <?php
                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        ?>
                        <article class="blog-article">
                            <div class="blog-header mb-40">
                                <h1 class="playfont"><?php the_title(); ?></h1>
                                <div class="blog-meta">
                                    <span class="author">By <a href="<?php the_author_meta( 'user_url' ); ?>"><?php the_author(); ?></a></span>
                                    <span class="date"><?php echo get_the_date( 'F j, Y' ); ?></span>
                                </div>
                            </div>

                            <?php
                            $single_image_id = get_post_meta( get_the_ID(), '_blog_single_image_id', true );
                            if ( $single_image_id ) {
                                $single_image_html = wp_get_attachment_image( $single_image_id, 'large', false, array( 'class' => 'attachment-large size-large' ) );
                                if ( $single_image_html ) {
                                    ?>
                                    <div class="blog-thumbnail mb-40">
                                        <?php echo $single_image_html; ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <div class="blog-content">
                                <?php the_content(); ?>
                            </div>

                            <div class="blog-footer mt-40">
                                <div class="blog-tags">
                                    <?php the_tags( '<span class="tag">', '</span><span class="tag">', '</span>' ); ?>
                                </div>
                                <!-- <div class="blog-share">
                                    <span>Share:</span>
                                    <a href="#" class="share-btn"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="share-btn"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="share-btn"><i class="fab fa-linkedin-in"></i></a>
                                </div> -->
                            </div>
                        </article>

                        <!-- Navigation -->
                        <div class="blog-navigation mt-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                    $prev_post = get_previous_post();
                                    if ( $prev_post ) {
                                        ?>
                                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="prev-post">
                                            <span>← Previous Post</span>
                                            <h6><?php echo esc_html( $prev_post->post_title ); ?></h6>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <?php 
                                    $next_post = get_next_post();
                                    if ( $next_post ) {
                                        ?>
                                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="next-post">
                                            <span>Next Post →</span>
                                            <h6><?php echo esc_html( $next_post->post_title ); ?></h6>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Comments -->
                        <?php
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                        ?>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- ==================== End Blog Details ==================== -->

<!-- ==================== Related Posts ==================== -->
<section class="related-posts section-padding bg-gray">
    <div class="container">
        <h3 class="text-center mb-40 playfont">Related Posts</h3>
        <div class="row">
            <?php
            $categories = get_the_category();
            if ( $categories ) {
                $category_ids = wp_list_pluck( $categories, 'term_id' );
                $args = array(
                    'category__in'   => $category_ids,
                    'post__not_in'   => array( get_the_ID() ),
                    'posts_per_page' => 3,
                );
                $related_query = new WP_Query( $args );

                if ( $related_query->have_posts() ) {
                    while ( $related_query->have_posts() ) {
                        $related_query->the_post();
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
                                    <h5 class="playfont"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <a href="<?php the_permalink(); ?>" class="more">
                                        <span class="custom-font">Read More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                }
            }
            ?>
        </div>
    </div>
</section>
<!-- ==================== End Related Posts ==================== -->

<?php
get_footer();
?>
