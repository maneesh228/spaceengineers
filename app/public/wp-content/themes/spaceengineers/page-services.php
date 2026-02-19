<?php
/**
 * Services Page Template
 */
get_header();

// Get services page banner settings
$services_page_id = get_option( 'page_for_posts' ); // fallback
$args = array(
    'post_type' => 'page',
    'name' => 'services',
    'posts_per_page' => 1
);
$services_query = new WP_Query( $args );
if ( $services_query->have_posts() ) {
    $services_query->the_post();
    $services_page_id = get_the_ID();
    wp_reset_postdata();
}

$banner_title = get_post_meta( $services_page_id, '_services_banner_title', true );
if ( !$banner_title ) {
    $banner_title = 'Services';
}

$banner_image_id = get_post_meta( $services_page_id, '_services_banner_image_id', true );
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


    <!-- ==================== Start Services ==================== -->

    <section class="services section-padding bg-gray">
        <div class="container">
            <div class="section-head text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <?php
                        $section_subtitle = get_post_meta( $services_page_id, '_services_section_subtitle', true );
                        if ( !$section_subtitle ) {
                            $section_subtitle = 'Best Features';
                        }
                        
                        $section_title = get_post_meta( $services_page_id, '_services_section_title', true );
                        if ( !$section_title ) {
                            $section_title = 'Our Services';
                        }
                        ?>
                        <h6 class="custom-font wow fadeInDown" data-wow-delay=".3s"><?php echo esc_html( $section_subtitle ); ?></h6>
                        <h4 class="playfont wow flipInX" data-wow-delay=".5s"><?php echo esc_html( $section_title ); ?></h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $services = get_services();
                $delay = 0.3;
                
                if ( $services->have_posts() ) {
                    while ( $services->have_posts() ) {
                        $services->the_post();
                        $service_description = get_post_meta( get_the_ID(), '_service_description', true );
                        $service_image_id = get_post_meta( get_the_ID(), '_service_image_id', true );
                        $service_image_url = $service_image_id ? wp_get_attachment_url( $service_image_id ) : get_template_directory_uri() . '/img/01.jpg';
                        
                        // Get description from content if custom description not set
                        $description = !empty( $service_description ) ? $service_description : wp_trim_words( get_the_content(), 15 );
                        $description = wp_strip_all_tags( $description );
                        ?>

                <div class="col-lg-4">
                    <div class="item-bx bg-img wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s" data-background="<?php echo esc_url( $service_image_url ); ?>">
                        <h6 class="mb-20"><?php the_title(); ?></h6>
                        <p><?php echo esc_html( $description ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="more custom-font mt-30">Read More</a>
                    </div>
                </div>

                        <?php
                        $delay += 0.2;
                    }
                    wp_reset_postdata();
                } else {
                    echo '<div class="col-12" style="text-align: center; padding: 40px; background: #f5f5f5; border-radius: 4px;">';
                    echo '<p><strong>No services published yet.</strong></p>';
                    if ( current_user_can( 'manage_options' ) ) {
                        echo '<p><a href="' . esc_url( admin_url( 'post-new.php?post_type=service' ) ) . '" class="btn-curve btn-color mt-20"><span>Add First Service</span></a></p>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- ==================== End Services ==================== -->


<?php
get_footer();
?>