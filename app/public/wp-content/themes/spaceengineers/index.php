<?php
/**
 * Main Template File - Fallback
 */
get_header();
?>

<section class="blog-list center section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php
                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        ?>
                        <div class="item-blog">
                            <div class="img">
                                <?php 
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'large' );
                                } else {
                                    echo '<img src="' . esc_url( get_template_directory_uri() ) . '/img/blog/1.jpg" alt="' . esc_attr( get_the_title() ) . '">';
                                }
                                ?>
                            </div>
                            <div class="content">
                                <div class="info">
                                    <a href="<?php the_author_meta( 'user_url' ); ?>"><?php the_author(); ?></a>
                                    <a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
                                </div>
                                <h5 class="playfont"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="more">
                                    <span class="custom-font">Read More</span>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="col-12"><p>No posts found.</p></div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
