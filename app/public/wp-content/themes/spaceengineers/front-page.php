<?php
/**
 * Front Page Template
 */
get_header();

// Get home page settings
$front_page_id = get_option( 'page_on_front' );
$home_sections = get_post_meta( $front_page_id, '_home_sections', true );
if ( !is_array( $home_sections ) ) {
    $home_sections = array();
}
?>

<!-- ==================== Start Slider ==================== -->

<header class="slid-half">
    <div id="js-cta-slider" class="cta__slider-wrapper nofull swiper-container">
        <div class="swiper-wrapper cta__slider">
            <?php
            $slides = function_exists( 'spaceengineers_get_slides' ) ? spaceengineers_get_slides() : null;

            if ( $slides && $slides->have_posts() ) :
                while ( $slides->have_posts() ) :
                    $slides->the_post();

                    $slide_subtitle   = get_post_meta( get_the_ID(), '_slide_subtitle', true );
                    $slide_desc       = get_post_meta( get_the_ID(), '_slide_description', true );
                    $slide_button_txt = get_post_meta( get_the_ID(), '_slide_button_text', true );
                    $slide_button_url = get_post_meta( get_the_ID(), '_slide_button_url', true );
                    $bg_id            = get_post_meta( get_the_ID(), '_slide_background_id', true );
                    $bg_url           = $bg_id ? wp_get_attachment_url( $bg_id ) : '';

                    if ( ! $bg_url ) {
                        $bg_url = get_template_directory_uri() . '/img/slid/01.jpg';
                    }
            ?>
            <!-- SLIDER ITEM -->
            <div class="cta__slider-item swiper-slide">
                <div class="media-wrapper slide-inner valign">
                    <div class="bg-img" data-background="<?php echo esc_url( $bg_url ); ?>" data-overlay-dark="5"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 offset-lg-1">
                                <div class="caption">
                                    <span class="top-corn"></span>
                                    <span class="bottom-corn"></span>
                                    <div class="custom-font">
                                        <?php if ( $slide_subtitle ) : ?>
                                            <h5 class="thin custom-font"><?php echo esc_html( $slide_subtitle ); ?></h5>
                                        <?php endif; ?>
                                        <h1 data-splitting><a href="#0"><?php the_title(); ?></a></h1>
                                    </div>
                                    <?php if ( $slide_desc ) : ?>
                                        <p><?php echo wp_kses_post( $slide_desc ); ?></p>
                                    <?php endif; ?>
                                    <?php
                                    $btn_text = $slide_button_txt ? $slide_button_txt : '';
                                    $btn_url  = $slide_button_url ? $slide_button_url : '#';
                                    if(!empty($btn_url) && !empty($btn_text)){
                                    ?>
                                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn-curve btn-color mt-30">
                                        <span><?php echo esc_html( $btn_text ); ?></span>
                                    </a>
                                    <?php
                                 }
                                 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SLIDER ITEM -->
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback: no slides created yet, show one default slide
                ?>
                <div class="cta__slider-item swiper-slide">
                    <div class="media-wrapper slide-inner valign">
                        <div class="bg-img" data-background="<?php echo get_template_directory_uri(); ?>/img/slid/01.jpg" data-overlay-dark="5"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 offset-lg-1">
                                    <div class="caption">
                                        <span class="top-corn"></span>
                                        <span class="bottom-corn"></span>
                                        <div class="custom-font">
                                            <h5 class="thin custom-font">interior</h5>
                                            <h1 data-splitting><a href="#0">design agency</a></h1>
                                        </div>
                                        <p>Right design and right ideas matter a lot of in interior design business. <br> a style that makes a statement.</p>
                                        <a href="<?php echo home_url( '/portfolio' ); ?>" class="btn-curve btn-color mt-30">
                                            <span>Discover Work</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="cta__slider-arrows">
            <i id="js-cta-slider-next" class="cta__slider-arrow cta__slider-arrow--next">
                <i class="fas fa-chevron-up"></i>
            </i>
            <i id="js-cta-slider-previous" class="cta__slider-arrow cta__slider-arrow--previous">
                <i class="fas fa-chevron-down"></i>
            </i>
        </div>
    </div>
    <div class="swiper-pagination top custom-font"></div>
</header>

<!-- ==================== End Slider ==================== -->

<!-- ==================== Start Services ==================== -->

<section class="services">
    <div class="feat-top">
        <div class="notfull bg-gray wow"></div>
        <div class="container-fluid">
            <div class="row">
                <?php for ( $i = 1; $i <= 3; $i++ ) :
                    $service_title = isset( $home_sections['service_' . $i . '_title'] ) ? $home_sections['service_' . $i . '_title'] : '';
                    $service_desc = isset( $home_sections['service_' . $i . '_desc'] ) ? $home_sections['service_' . $i . '_desc'] : '';
                ?>
                <div class="col-lg-4">
                    <div class="item-sm wow fadeInUp" data-wow-delay="<?php echo 1 + ( $i - 1 ) * 0.1; ?>s">
                        <div class="box">
                            <h6 class="mb-20"><span class="custom-font numb">0<?php echo $i; ?></span> <?php echo esc_html( $service_title ); ?></h6>
                            <p><?php echo esc_html( $service_desc ); ?></p>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==================== End Services ==================== -->

<!-- ==================== Start about ==================== -->

<section class="about section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 valign">
                <div class="exp-content nopat wow fadeInUp" data-wow-delay=".3s">
                    <h6 class="sub-title">About Us</h6>
                    <h2 class="mb-20 playfont"><?php echo wp_kses_post( isset( $home_sections['about_title'] ) ? $home_sections['about_title'] : 'Best Designers <br> Architectures for You.' ); ?></h2>
                    <p><?php echo wp_kses_post( isset( $home_sections['about_desc'] ) ? $home_sections['about_desc'] : 'Architecture bibendum pharetra eleifend. Suspendisse vel volutpat purus, sit amet bibendum nisl.' ); ?></p>
                    <ul>
                        <?php
                        $about_list = isset( $home_sections['about_list'] ) ? $home_sections['about_list'] : array( 'Architecture', 'Interior Design', 'Furniture' );
                        if ( is_array( $about_list ) ) {
                            foreach ( $about_list as $item ) {
                                echo '<li>' . esc_html( $item ) . '</li>';
                            }
                        }
                        ?>
                    </ul>
                    <a href="<?php echo home_url( '/about' ); ?>" class="btn-curve btn-color mt-30">
                        <span>Read More</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <?php
                $about_image_1_id  = isset( $home_sections['about_image_1_id'] ) ? intval( $home_sections['about_image_1_id'] ) : 0;
                $about_image_2_id  = isset( $home_sections['about_image_2_id'] ) ? intval( $home_sections['about_image_2_id'] ) : 0;
                $about_image_1_url = $about_image_1_id ? wp_get_attachment_url( $about_image_1_id ) : get_template_directory_uri() . '/img/ab1.jpg';
                $about_image_2_url = $about_image_2_id ? wp_get_attachment_url( $about_image_2_id ) : get_template_directory_uri() . '/img/ab2.jpg';

                $about_exp_years = isset( $home_sections['about_experience_years'] ) && $home_sections['about_experience_years'] !== ''
                    ? $home_sections['about_experience_years']
                    : '21';
                $about_exp_label = isset( $home_sections['about_experience_label'] ) && $home_sections['about_experience_label'] !== ''
                    ? $home_sections['about_experience_label']
                    : 'Years Of Experience';
                ?>
                <div class="ab-exp">
                    <div class="row">
                        <div class="col-md-4 mb-20">
                            <div class="pattern bg-img bg-repeat" data-background="<?php echo get_template_directory_uri(); ?>/img/line-pattern.png">
                            </div>
                        </div>
                        <div class="col-md-8 wow fadeInUp" data-wow-delay=".3s">
                            <div class="img mb-20 wow imago">
                                <img src="<?php echo esc_url( $about_image_1_url ); ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-7 wow fadeInUp" data-wow-delay=".3s">
                            <div class="img wow imago">
                                <img src="<?php echo esc_url( $about_image_2_url ); ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="years-exp">
                                <div class="exp-text">
                                    <h2 class="custom-font"><?php echo esc_html( $about_exp_years ); ?></h2>
                                    <h6><?php echo esc_html( $about_exp_label ); ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== End about ==================== -->

    <!-- ==================== Start works ==================== -->

    <?php
    $default_work_titles = array(
        1 => 'Exterior Designs',
        2 => 'Maroon Beach Hotel',
        3 => 'Apartment Renovation',
        4 => 'Modern Minimalist House',
    );

    $works_bg = array();
    for ( $i = 1; $i <= 4; $i++ ) {
        $subtitle_key = 'work_' . $i . '_subtitle';
        $title_key    = 'work_' . $i . '_title';
        $bg_key       = 'work_' . $i . '_bg_image_id';

        $work_subtitle = isset( $home_sections[ $subtitle_key ] ) && $home_sections[ $subtitle_key ] !== ''
            ? $home_sections[ $subtitle_key ]
            : 'Interior';

        $work_title = isset( $home_sections[ $title_key ] ) && $home_sections[ $title_key ] !== ''
            ? $home_sections[ $title_key ]
            : ( isset( $default_work_titles[ $i ] ) ? $default_work_titles[ $i ] : '' );

        $bg_id  = isset( $home_sections[ $bg_key ] ) ? intval( $home_sections[ $bg_key ] ) : 0;
        $bg_url = $bg_id ? wp_get_attachment_url( $bg_id ) : '';
        if ( ! $bg_url ) {
            $bg_url = get_template_directory_uri() . '/img/portfolio/full/0' . $i . '.jpg';
        }

        $works_bg[ $i ] = array(
            'subtitle' => $work_subtitle,
            'title'    => $work_title,
            'bg_url'   => $bg_url,
        );
    }
    ?>

    <section class="portfolio full-bg">
        <div class="container-fluid">
            <div class="row">
                <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                    <div class="col-lg-3 col-md-6 cluom <?php echo $i === 1 ? 'current' : ''; ?>" data-tab="tab-<?php echo $i; ?>">
                        <div class="info">
                            <h6 class="custom-font"><?php echo esc_html( $works_bg[ $i ]['subtitle'] ); ?></h6>
                            <h5><?php echo esc_html( $works_bg[ $i ]['title'] ); ?></h5>
                        </div>
                        <div class="more">
                            <a href="#0">View Project <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="glry-img">
            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <div id="tab-<?php echo $i; ?>" class="bg-img tab-img <?php echo $i === 1 ? 'current' : ''; ?>" data-background="<?php echo esc_url( $works_bg[ $i ]['bg_url'] ); ?>" data-overlay-dark="2"></div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- ==================== End works ==================== -->

<!-- ==================== Start Testimonials ==================== -->

<?php
$testimonials_bg_id  = isset( $home_sections['testimonials_bg_image_id'] ) ? intval( $home_sections['testimonials_bg_image_id'] ) : 0;
$testimonials_bg_url = $testimonials_bg_id ? wp_get_attachment_url( $testimonials_bg_id ) : '';
if ( ! $testimonials_bg_url ) {
    $testimonials_bg_url = get_template_directory_uri() . '/img/001.jpg';
}
?>

<section class="testimonials grid section-padding bg-img parallaxie" data-background="<?php echo esc_url( $testimonials_bg_url ); ?>" data-overlay-dark="9">
    <div class="container">
        <div class="section-head text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <h6 class="custom-font wow fadeInDown" data-wow-delay=".3s"><?php echo esc_html( isset( $home_sections['testimonials_subtitle'] ) ? $home_sections['testimonials_subtitle'] : 'Testimonials' ); ?></h6>
                    <h4 class="playfont wow flipInX" data-wow-delay=".5s"><?php echo esc_html( isset( $home_sections['testimonials_title'] ) ? $home_sections['testimonials_title'] : 'What People Says?' ); ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testim wow fadeInUp" data-wow-delay=".3s">
                    <?php
                    $testimonials = get_testimonials( 4 );
                    
                    if ( $testimonials->have_posts() ) {
                        while ( $testimonials->have_posts() ) {
                            $testimonials->the_post();
                            $client_name = get_post_meta( get_the_ID(), '_testimonial_client_name', true );
                            $client_position = get_post_meta( get_the_ID(), '_testimonial_client_position', true );
                            $client_content = get_post_meta( get_the_ID(), '_testimonial_client_content', true );
                            $client_content = $client_content ? $client_content : get_the_title();
                            $client_image_id = get_post_meta( get_the_ID(), '_testimonial_client_image_id', true );
                            $testimonial_image = $client_image_id ? wp_get_attachment_url( $client_image_id ) : get_template_directory_uri() . '/img/clients/1.jpg';
                            ?>
                            <div class="item">
                                <span class="quote-icon"><img src="<?php echo get_template_directory_uri(); ?>/img/clients/quote.svg" alt=""></span>
                                <div class="cont">
                                    <p class="playfont">"<?php echo wp_kses_post( $client_content ); ?>"</p>
                                </div>
                                <div class="info">
                                    <div class="author">
                                        <img src="<?php echo esc_url( $testimonial_image ); ?>" alt="<?php echo esc_attr( $client_name ); ?>">
                                    </div>
                                    <h6><?php echo esc_html( $client_name ); ?> <?php if ( $client_position ) : ?><span><?php echo esc_html( $client_position ); ?></span><?php endif; ?></h6>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<p style="text-align: center; color: #fff;">No testimonials available yet.</p>';
                    }
                    ?>
                </div>
                <div class="navs mt-30 wow fadeInUp" data-wow-delay=".3s">
                    <span class="prev">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </span>
                    <span class="next">
                        <i class="fas fa-long-arrow-alt-right"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== End Testimonials ==================== -->

<!-- ==================== Start Blog ==================== -->

<section class="blog-grid center bg-gray section-padding">
    <div class="container">
        <div class="section-head text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <h6 class="custom-font wow fadeInDown" data-wow-delay=".3s"><?php echo esc_html( isset( $home_sections['blog_subtitle'] ) ? $home_sections['blog_subtitle'] : 'Latest News' ); ?></h6>
                    <h4 class="playfont wow flipInX" data-wow-delay=".5s"><?php echo esc_html( isset( $home_sections['blog_title'] ) ? $home_sections['blog_title'] : 'Our Blogs' ); ?></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $blog_query = new WP_Query( array(
                'post_type'           => 'post',
                'posts_per_page'      => 2,
                'ignore_sticky_posts' => 1,
            ) );

            if ( $blog_query->have_posts() ) :
                $index = 0;
                while ( $blog_query->have_posts() ) :
                    $blog_query->the_post();
                    $index++;

                    $delay = $index === 1 ? '.3s' : '.1s';

                    $single_image_id = get_post_meta( get_the_ID(), '_blog_single_image_id', true );
                    if ( $single_image_id ) {
                        $image_url = wp_get_attachment_url( $single_image_id );
                    } elseif ( has_post_thumbnail() ) {
                        $thumb_id  = get_post_thumbnail_id( get_the_ID() );
                        $image_url = $thumb_id ? wp_get_attachment_url( $thumb_id ) : '';
                    } else {
                        $fallback_index = $index === 1 ? '1' : '2';
                        $image_url      = get_template_directory_uri() . '/img/blog/' . $fallback_index . '.jpg';
                    }
            ?>
            <div class="col-md-6">
                <div class="item wow fadeInUp md-mb50" data-wow-delay="<?php echo esc_attr( $delay ); ?>">
                    <div class="post-img">
                        <div class="img">
                            <?php if ( ! empty( $image_url ) ) : ?>
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="cont">
                        <div class="info">
                            <a href="<?php the_permalink(); ?>"><?php the_author(); ?></a>
                            <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_date( 'M d Y' ) ); ?></a>
                        </div>
                        <h5 class="playfont"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <a href="<?php the_permalink(); ?>" class="more">
                            <span class="custom-font">Read More</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<div class="col-12"><p style="text-align:center;">No blog posts available yet.</p></div>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ==================== End Blog ==================== -->

<?php
get_footer();
?>
