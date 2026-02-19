<?php
/**
 * Single Testimonial Template
 */
get_header();

if ( have_posts() ) {
    the_post();
    
    $client_name = get_post_meta( get_the_ID(), '_testimonial_client_name', true );
    $client_position = get_post_meta( get_the_ID(), '_testimonial_client_position', true );
    $client_image_id = get_post_meta( get_the_ID(), '_testimonial_client_image_id', true );
    $client_image_url = $client_image_id ? wp_get_attachment_url( $client_image_id ) : get_template_directory_uri() . '/img/clients/1.jpg';
    $testimonial_content = get_post_meta( get_the_ID(), '_testimonial_client_content', true );
    ?>

    <!-- ==================== Page Title ==================== -->
    <header class="pages-header bg-img valign parallaxie" data-background="<?php echo get_template_directory_uri(); ?>/img/pg1.jpg" data-overlay-dark="5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cont text-center">
                        <h1>Client Testimonial</h1>
                        <div class="path">
                            <a href="<?php echo home_url(); ?>">Home</a><span>/</span>
                            <a href="#" class="active">Testimonial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ==================== End Page Title ==================== -->

    <!-- ==================== Testimonial Details ==================== -->
    <section class="testimonial-details section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Client Image -->
                    <div class="testimonial-image text-center mb-50 wow fadeInUp">
                        <img src="<?php echo esc_url( $client_image_url ); ?>" alt="<?php echo esc_attr( $client_name ); ?>" class="img-fluid" style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover; border: 4px solid #f0f0f0;">
                    </div>

                    <!-- Quote -->
                    <div class="testimonial-quote text-center mb-50 wow fadeInUp">
                        <span class="quote-icon" style="font-size: 40px; color: #ccc;">❝</span>
                        <p class="playfont" style="font-size: 18px; line-height: 1.8; margin: 20px 0;">
                            "<?php echo wp_kses_post( $testimonial_content ); ?>"
                        </p>
                        <span class="quote-icon" style="font-size: 40px; color: #ccc;">❞</span>
                    </div>

                    <!-- Client Info -->
                    <div class="testimonial-client text-center mb-50 wow fadeInUp">
                        <h4 class="playfont" style="margin-bottom: 5px;"><?php echo esc_html( $client_name ); ?></h4>
                        <?php if ( $client_position ) : ?>
                            <p style="color: #999; margin: 0;"><?php echo esc_html( $client_position ); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Back to Testimonials Button -->
                    <div class="back-link text-center mt-50 wow fadeInUp">
                        <a href="<?php echo home_url(); ?>" class="btn-curve btn-color">
                            <span>← Back to Home</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== End Testimonial Details ==================== -->

    <!-- ==================== Other Testimonials Section ==================== -->
    <section class="testimonials grid section-padding bg-img parallaxie" data-background="<?php echo get_template_directory_uri(); ?>/img/001.jpg" data-overlay-dark="9">
        <div class="container">
            <div class="section-head text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <h6 class="custom-font wow fadeInDown" data-wow-delay=".3s">Client Stories</h6>
                        <h4 class="playfont wow flipInX" data-wow-delay=".5s">More Testimonials</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="testim wow fadeInUp" data-wow-delay=".3s">
                        <?php
                        $current_testimonial_id = get_the_ID();
                        $testimonials = get_testimonials( 4 );
                        
                        if ( $testimonials->have_posts() ) {
                            while ( $testimonials->have_posts() ) {
                                $testimonials->the_post();
                                if ( get_the_ID() !== $current_testimonial_id ) {
                                    $name = get_post_meta( get_the_ID(), '_testimonial_client_name', true );
                                    $position = get_post_meta( get_the_ID(), '_testimonial_client_position', true );
                                    $content = get_post_meta( get_the_ID(), '_testimonial_client_content', true );
                                    $image_id = get_post_meta( get_the_ID(), '_testimonial_client_image_id', true );
                                    $image_url = $image_id ? wp_get_attachment_url( $image_id ) : get_template_directory_uri() . '/img/clients/1.jpg';
                                    ?>
                                    <div class="item">
                                        <span class="quote-icon"><img src="<?php echo get_template_directory_uri(); ?>/img/clients/quote.svg" alt=""></span>
                                        <div class="cont">
                                            <p class="playfont">"<?php echo wp_kses_post( wp_trim_words( $content, 20 ) ); ?>..."</p>
                                        </div>
                                        <div class="info">
                                            <div class="author">
                                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>">
                                            </div>
                                            <h6><?php echo esc_html( $name ); ?> <?php if ( $position ) : ?><span><?php echo esc_html( $position ); ?></span><?php endif; ?></h6>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== End Other Testimonials ==================== -->

    <?php
}

get_footer();
?>
