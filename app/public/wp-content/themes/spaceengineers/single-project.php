<?php
/**
 * Single Project Template
 */
get_header();

if ( have_posts() ) {
    the_post();

    $project_image_id  = get_post_meta( get_the_ID(), '_project_image_id', true );
    $project_image_url = $project_image_id ? wp_get_attachment_url( $project_image_id ) : get_template_directory_uri() . '/img/01.jpg';
    $project_description = get_post_meta( get_the_ID(), '_project_description', true );
    ?>

    <!-- ==================== Page Title ==================== -->
    <header class="pages-header bg-img valign parallaxie" data-background="<?php echo esc_url( $project_image_url ); ?>" data-overlay-dark="5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cont text-center">
                        <h1><?php the_title(); ?></h1>
                        <div class="path">
                            <a href="<?php echo home_url(); ?>">Home</a><span>/</span>
                            <a href="<?php echo home_url( '/projects' ); ?>">Projects</a><span>/</span>
                            <a href="#" class="active"><?php the_title(); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ==================== End Page Title ==================== -->

    <!-- ==================== Project Details ==================== -->
    <section class="product-details section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Project Image -->
                    <div class="product-image mb-50 wow fadeInUp">
                        <img src="<?php echo esc_url( $project_image_url ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid" style="border-radius: 4px; max-width: 100%; height: auto;">
                    </div>

                    <!-- Project Description -->
                    <div class="product-content wow fadeInUp">
                        <div class="content-text">
                            <?php
                            if ( $project_description ) {
                                echo wp_kses_post( $project_description );
                            } else {
                                the_content();
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Back to Projects Link -->
                    <div class="back-link mt-50 wow fadeInUp">
                        <a href="<?php echo home_url( '/projects' ); ?>" class="btn-curve btn-color">
                            <span>← Back to Projects</span>
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Related Projects Widget -->
                        <div class="sidebar-widget mb-50 wow fadeInUp">
                            <h5 class="widget-title mb-30">Other Projects</h5>
                            <ul class="products-list">
                                <?php
                                $current_project_id = get_the_ID();
                                $related_projects   = get_projects( 5 );

                                if ( $related_projects->have_posts() ) {
                                    $count = 0;
                                    while ( $related_projects->have_posts() ) {
                                        $related_projects->the_post();
                                        if ( get_the_ID() !== $current_project_id && $count < 4 ) {
                                            ?>
                                            <li>
                                                <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none; display: block; padding: 10px 0; border-bottom: 1px solid #eee; transition: color 0.3s;">
                                                    <span style="display: inline-block; margin-right: 10px;">→</span><?php the_title(); ?>
                                                </a>
                                            </li>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    wp_reset_postdata();
                                }
                                ?>
                            </ul>
                        </div>

                        <!-- Quick Contact Widget -->
                        <div class="sidebar-widget mb-50 wow fadeInUp">
                            <h5 class="widget-title mb-30">Interested?</h5>
                            <p>Contact us to learn more about this project or discuss your own.</p>
                            <a href="<?php echo home_url( '/contact' ); ?>" class="btn-curve btn-color mt-20" style="display: inline-block;">
                                <span>Get in Touch</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== End Project Details ==================== -->

    <!-- ==================== Related Projects Section ==================== -->
    <section class="products section-padding bg-gray">
        <div class="container">
            <div class="section-head text-center mb-50">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <h6 class="custom-font wow FadeInDown" data-wow-delay=".3s">Explore More</h6>
                        <h4 class="playfont wow flipInX" data-wow-delay=".5s">Other Projects</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                $current_project_id = get_the_ID();
                $other_projects     = get_projects( 3 );
                $delay              = 0.3;

                if ( $other_projects->have_posts() ) {
                    while ( $other_projects->have_posts() ) {
                        $other_projects->the_post();
                        if ( get_the_ID() !== $current_project_id ) {
                            $proj_image_id  = get_post_meta( get_the_ID(), '_project_image_id', true );
                            $proj_image_url = $proj_image_id ? wp_get_attachment_url( $proj_image_id ) : get_template_directory_uri() . '/img/01.jpg';
                            $proj_desc      = get_post_meta( get_the_ID(), '_project_description', true );
                            $description    = wp_strip_all_tags( wp_trim_words( $proj_desc, 12 ) );
                            ?>

                            <div class="col-lg-4">
                                <div class="item-bx bg-img wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s" data-background="<?php echo esc_url( $proj_image_url ); ?>">
                                    <h6 class="mb-20"><?php the_title(); ?></h6>
                                    <p><?php echo esc_html( $description ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="more custom-font mt-30">Read More</a>
                                </div>
                            </div>

                            <?php
                            $delay += 0.2;
                        }
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    </section>
    <!-- ==================== End Related Projects ==================== -->

    <?php
}

get_footer();
?>
