
<?php
/**
 * About Page Template
 */
get_header();

// Get about page settings
$about_sections = array();
if ( have_posts() ) {
    the_post();
    $about_sections = get_post_meta( get_the_ID(), '_about_sections', true );
    if ( !is_array( $about_sections ) ) {
        $about_sections = array();
    }
}

// Get banner settings
$banner_title = isset( $about_sections['banner_title'] ) ? $about_sections['banner_title'] : 'About Us';
$banner_image_id = isset( $about_sections['banner_image_id'] ) ? $about_sections['banner_image_id'] : '';
$banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : get_template_directory_uri() . '/img/pg1.jpg';
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

<?php

$about_sections = get_post_meta( get_the_ID(), '_about_sections', true );
if ( !is_array( $about_sections ) ) {
    $about_sections = array();
}
?>

<!-- ==================== About Section ==================== -->
<section class="about section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="numbers">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="item mb-50">
                                <h3><span class="nbr custom-font"><?php echo isset( $about_sections['projects_completed'] ) ? $about_sections['projects_completed'] : '352'; ?></span></h3>
                                <h6>Projects Completed</h6>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="item mb-50">
                                <h3><span class="nbr custom-font"><?php echo isset( $about_sections['clients_satisfied'] ) ? $about_sections['clients_satisfied'] : '567'; ?></span></h3>
                                <h6>Satisfied Clients</h6>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="item">
                                <h3><span class="nbr custom-font"><?php echo isset( $about_sections['monthly_revenue'] ) ? $about_sections['monthly_revenue'] : '656'; ?></span><i>M</i></h3>
                                <h6>Monthly Revenue</h6>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="item">
                                <h3><span class="nbr custom-font"><?php echo isset( $about_sections['awards_won'] ) ? $about_sections['awards_won'] : '17'; ?></span></h3>
                                <h6>Awards Won</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="txt-cont">
                    <?php if ( isset( $about_sections['about_intro_text'] ) && $about_sections['about_intro_text'] ) : ?>
                        <?php echo wp_kses_post( $about_sections['about_intro_text'] ); ?>
                    <?php else : ?>
                        <p class="mb-20">Maecenas imperdiet ante eget hendrerit posuere. Nunc urna libero, congue porta nibh a, semper feugiat sem. Sed auctor dui eleifend, scelerisque eros ut.</p>
                        <p>Curabitur sed iaculis dolor, non congue ligula. Maecenas imperdiet ante eget hendrerit posuere. Nunc urna libero, congue porta nibh a, semper feugiat sem. Sed auctor dui eleifend, scelerisque eros ut, pellentesque nibh. Nam lacinia suscipit accumsan. Donec sodales, neque vitae rutrum convallis, nulla tortor pharetra odio, in varius ante ante sed nisi.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== End About Section ==================== -->

<?php
$profile_title  = isset( $about_sections['pvm_profile_title'] ) ? $about_sections['pvm_profile_title'] : 'Profile';
$profile_desc   = isset( $about_sections['pvm_profile_desc'] ) ? $about_sections['pvm_profile_desc'] : '';
$vision_title   = isset( $about_sections['pvm_vision_title'] ) ? $about_sections['pvm_vision_title'] : 'Vision';
$vision_desc    = isset( $about_sections['pvm_vision_desc'] ) ? $about_sections['pvm_vision_desc'] : '';
$mission_title  = isset( $about_sections['pvm_mission_title'] ) ? $about_sections['pvm_mission_title'] : 'Mission';
$mission_desc   = isset( $about_sections['pvm_mission_desc'] ) ? $about_sections['pvm_mission_desc'] : '';

$has_pvm = ( $profile_desc || $vision_desc || $mission_desc );
?>

<?php if ( $has_pvm ) : ?>
<!-- ==================== Profile / Vision / Mission ==================== -->
<section class="services section-padding bg-gray">
    <div class="container">
        <div class="row">
            
        <!-- <div class="col-lg-4 col-md-6 mb-30">
                <div class="item-bx bg-img wow fadeInUp" data-wow-delay=".3s" data-background="img/01.jpg">
                    <h6 class="mb-20"><?php // echo esc_html( $profile_title ); ?></h6>
                    <?php // if ( $profile_desc ) : ?>
                        <p><?php //echo esc_html( $profile_desc ); ?></p>
                    <?php // endif; ?>
                </div>
            </div> -->

            <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item-bx bg-img wow fadeInUp" data-wow-delay=".3s" data-background="./img/01.jpg">
                        <span class="icon flaticon-houses"></span>
                        <h6 class="mb-20"><?php echo esc_html( $profile_title ); ?></h6>
                        <?php if ( $profile_desc ) : ?>
                        <p><?php echo esc_html( $profile_desc ); ?></p>
                        <?php endif; ?>
                    </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-30">
                <div class="item-bx bg-img wow fadeInUp" data-wow-delay=".3s" data-background="./img/01.jpg">
                    <span class="icon flaticon-sketch"></span>
                    <h6 class="mb-20"><?php echo esc_html( $vision_title ); ?></h6>
                    <?php if ( $vision_desc ) : ?>
                        <p><?php echo esc_html( $vision_desc ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-30">
               <div class="item-bx bg-img wow fadeInUp" data-wow-delay=".3s" data-background="./img/01.jpg">
                <span class="icon flaticon-decorating"></span>
                    <h6 class="mb-20"><?php echo esc_html( $mission_title ); ?></h6>
                    <?php if ( $mission_desc ) : ?>
                        <p><?php echo esc_html( $mission_desc ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== End Profile / Vision / Mission ==================== -->
<?php endif; ?>

<!-- ==================== Services Section ==================== -->
<?php
$services_bg_image_id = isset( $about_sections['services_bg_image_id'] ) ? intval( $about_sections['services_bg_image_id'] ) : 0;
if ( $services_bg_image_id ) {
    $services_bg_image_url = wp_get_attachment_url( $services_bg_image_id );
} else {
    $services_bg_image_url = get_template_directory_uri() . '/img/04.jpg';
}

$services_video_url = isset( $about_sections['services_video_url'] ) && $about_sections['services_video_url']
    ? $about_sections['services_video_url']
    : 'https://youtu.be/AzwC6umvd1s';
?>
<section class="services halfbg">
    <div class="background bg-img valign parallaxie" data-background="<?php echo esc_url( $services_bg_image_url ); ?>" data-overlay-dark="7">
        <a class="play-button vid" href="<?php echo esc_url( $services_video_url ); ?>">
            <svg class="circle-fill">
                <circle cx="43" cy="43" r="39" stroke="#fff" stroke-width=".5"></circle>
            </svg>
            <svg class="circle-track">
                <circle cx="43" cy="43" r="39" stroke="none" stroke-width="1" fill="none"></circle>
            </svg>
            <span class="polygon">
                <i class="pe-7s-play"></i>
            </span>
        </a>
    </div>
    <div class="container ontop">
        <div class="row">
            <?php
            $services_query = get_services( 4 );
            $service_index = 1;
            if ( $services_query->have_posts() ) :
                while ( $services_query->have_posts() ) :
                    $services_query->the_post();
                    $service_desc = get_post_meta( get_the_ID(), '_service_description', true );
                    ?>
                    <div class="col-lg-3 col-md-6 item-bx">
                        <h2 class="custom-font numb">0<?php echo $service_index; ?></h2>
                        <h6 class="mb-20"><?php the_title(); ?></h6>
                        <p><?php echo $service_desc ? wp_kses_post( wp_trim_words( $service_desc, 15, '...' ) ) : 'Service description'; ?></p>
                        <a href="<?php the_permalink(); ?>" class="more custom-font mt-30">Read More</a>
                    </div>
                    <?php
                    $service_index++;
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div class="col-12">
                    <p><?php esc_html_e( 'No services found. Please add services from wp-admin.', 'spaceengineers' ); ?></p>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>
<!-- ==================== End Services Section ==================== -->

<!-- ==================== Skills Section ==================== -->
<div class="skills-sec section-padding pt-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 valign">
                <div class="skills-box full-width">
                    <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                        <div class="skill-item">
                            <h6><?php echo isset( $about_sections['skill_' . $i . '_name'] ) ? esc_html( $about_sections['skill_' . $i . '_name'] ) : 'Skill ' . $i; ?></h6>
                            <div class="skill-progress">
                                <div class="progres custom-font" data-value="<?php echo isset( $about_sections['skill_' . $i . '_percent'] ) ? esc_attr( $about_sections['skill_' . $i . '_percent'] ) : '80%'; ?>"></div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="content">
                    <?php if ( isset( $about_sections['skills_title'] ) && $about_sections['skills_title'] ) : ?>
                        <h4 class="playfont line-height-50 mb-20"><?php echo esc_html( $about_sections['skills_title'] ); ?></h4>
                    <?php else : ?>
                        <h4 class="playfont line-height-50 mb-20">Providing Customized Design Solutions That Fits Every Space .</h4>
                    <?php endif; ?>
                    <?php if ( isset( $about_sections['skills_desc'] ) && $about_sections['skills_desc'] ) : ?>
                        <?php echo wp_kses_post( $about_sections['skills_desc'] ); ?>
                    <?php else : ?>
                        <p class="mb-10">Beyond more stoic this along goodness hey this this wow ipsum manate far impressive manifest farcrud opened inside.</p>
                        <p>Fustered impressive manifest crud opened inside owing punitively around forewent and after wasteful telling sprang coldly and spoke less clients.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ==================== End Skills Section ==================== -->

<!-- ==================== Testimonials Section ==================== -->
<?php if ( !isset( $about_sections['show_testimonials'] ) || $about_sections['show_testimonials'] ) : ?>
<?php
$testimonials_bg_image_id = isset( $about_sections['testimonials_bg_image_id'] ) ? intval( $about_sections['testimonials_bg_image_id'] ) : 0;
if ( $testimonials_bg_image_id ) {
    $testimonials_bg_image_url = wp_get_attachment_url( $testimonials_bg_image_id );
} else {
    $testimonials_bg_image_url = get_template_directory_uri() . '/img/001.jpg';
}
?>
<section class="testimonials grid section-padding bg-img parallaxie" data-background="<?php echo esc_url( $testimonials_bg_image_url ); ?>" data-overlay-dark="9">
    <div class="container">
        <div class="section-head text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <h6 class="custom-font">Testimonials</h6>
                    <h4 class="playfont">What People Says?</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testim">
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
                <div class="navs mt-30">
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
<?php endif; ?>
<!-- ==================== End Testimonials Section ==================== -->

<!-- ==================== Team Section ==================== -->
<?php
$employees_title = isset( $about_sections['employees_title'] ) && $about_sections['employees_title']
    ? $about_sections['employees_title']
    : 'Our Employees';
?>
<section class="team tmgrid section-padding">
    <div class="container">
        <div class="section-head text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <h6 class="custom-font">Creative Minds</h6>
                    <h4 class="playfont"><?php echo esc_html( $employees_title ); ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <?php for ( $i = 1; $i <= 4; $i++ ) :
                $name = isset( $about_sections[ 'employee_' . $i . '_name' ] ) ? trim( $about_sections[ 'employee_' . $i . '_name' ] ) : '';
                $role = isset( $about_sections[ 'employee_' . $i . '_role' ] ) ? trim( $about_sections[ 'employee_' . $i . '_role' ] ) : '';
                if ( ! $name ) {
                    continue;
                }

                $employee_image_id = isset( $about_sections[ 'employee_' . $i . '_image_id' ] ) ? intval( $about_sections[ 'employee_' . $i . '_image_id' ] ) : 0;
                if ( $employee_image_id ) {
                    $employee_image_url = wp_get_attachment_url( $employee_image_id );
                } else {
                    $employee_image_url = get_template_directory_uri() . '/img/team/' . $i . '.jpg';
                }
            ?>
                <div class="item col-lg-3 col-md-6">
                    <div class="img">
                        <img src="<?php echo esc_url( $employee_image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>">
                        <div class="social">
                            <a href="#0"><i class="fab fa-facebook-f"></i></a>
                            <a href="#0"><i class="fab fa-twitter"></i></a>
                            <a href="#0"><i class="fab fa-behance"></i></a>
                            <a href="#0"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="info">
                        <h5><?php echo esc_html( $name ); ?></h5>
                        <?php if ( $role ) : ?><span><?php echo esc_html( $role ); ?></span><?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<!-- ==================== End Team Section ==================== -->



<?php
get_footer();
?>
