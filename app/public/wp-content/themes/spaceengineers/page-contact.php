<?php
/**
 * Contact Page Template
 */

get_header();

$post_id  = get_queried_object_id();
$sections = get_post_meta( $post_id, '_contact_sections', true );
if ( ! is_array( $sections ) ) {
    $sections = array();
}

$banner_title    = ! empty( $sections['banner_title'] ) ? $sections['banner_title'] : 'Contact Us';
$banner_subtitle = ! empty( $sections['banner_subtitle'] ) ? $sections['banner_subtitle'] : "We'd love to hear from you. Send us a message and we'll respond as soon as possible.";

$banner_image_id  = ! empty( $sections['banner_image_id'] ) ? intval( $sections['banner_image_id'] ) : 0;
$banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';
if ( ! $banner_image_url ) {
    $banner_image_url = get_template_directory_uri() . '/img/contact_head.jpg';
}

$call_title   = ! empty( $sections['call_title'] ) ? $sections['call_title'] : 'Call Us';
$call_phone_1 = isset( $sections['call_phone_1'] ) && $sections['call_phone_1'] !== '' ? $sections['call_phone_1'] : '+7 (111) 1234 56789';
$call_phone_2 = isset( $sections['call_phone_2'] ) && $sections['call_phone_2'] !== '' ? $sections['call_phone_2'] : '+1 (000) 9876 54321';

$email_title = ! empty( $sections['email_title'] ) ? $sections['email_title'] : 'Email Us';
$email_1     = isset( $sections['email_1'] ) && $sections['email_1'] !== '' ? $sections['email_1'] : 'contact@Archo.com';
$email_2     = isset( $sections['email_2'] ) && $sections['email_2'] !== '' ? $sections['email_2'] : 'Username@website.com';

$address_title = ! empty( $sections['address_title'] ) ? $sections['address_title'] : 'Address';
$address_text  = isset( $sections['address_text'] ) && $sections['address_text'] !== '' ? $sections['address_text'] : 'B17 Princess Road, London, Greater London NW18JR, United Kingdom';

$form_title       = ! empty( $sections['form_title'] ) ? $sections['form_title'] : 'Send us a message';
$form_description = isset( $sections['form_description'] ) ? $sections['form_description'] : '';
$map_embed        = isset( $sections['map_embed'] ) ? $sections['map_embed'] : '';
$form_shortcode   = isset( $sections['form_shortcode'] ) ? $sections['form_shortcode'] : '';
?>

<!-- ==================== Start Header ==================== -->
<header class="pages-header bg-img valign parallaxie" data-background="<?php echo esc_url( $banner_image_url ); ?>" data-overlay-dark="5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cont text-center">
                    <h1><?php echo esc_html( $banner_title ); ?></h1>
                    <p style="max-width: 500px; margin: 15px auto 0;">
                        <?php echo esc_html( $banner_subtitle ); ?>
                    </p>
                    <div class="path">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                        <span>/</span>
                        <a href="#0" class="active"><?php echo esc_html( $banner_title ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ==================== End Header ==================== -->

<!-- ==================== Start Contact ==================== -->
<section class="contact">
    <div class="info bg-gray pt-80 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="item">
                        <span class="icon pe-7s-phone"></span>
                        <div class="cont">
                            <h6 class="custom-font"><?php echo esc_html( $call_title ); ?></h6>
                            <?php if ( $call_phone_1 ) : ?>
                                <p><?php echo esc_html( $call_phone_1 ); ?></p>
                            <?php endif; ?>
                            <?php if ( $call_phone_2 ) : ?>
                                <p><?php echo esc_html( $call_phone_2 ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item">
                        <span class="icon pe-7s-mail-open"></span>
                        <div class="cont">
                            <h6 class="custom-font"><?php echo esc_html( $email_title ); ?></h6>
                            <?php if ( $email_1 ) : ?>
                                <p><?php echo esc_html( $email_1 ); ?></p>
                            <?php endif; ?>
                            <?php if ( $email_2 ) : ?>
                                <p><?php echo esc_html( $email_2 ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="item">
                        <span class="icon pe-7s-map"></span>
                        <div class="cont">
                            <h6 class="custom-font"><?php echo esc_html( $address_title ); ?></h6>
                            <p><?php echo esc_html( $address_text ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 map-box">
                <div class="map">
                    <?php if ( ! empty( $map_embed ) ) : ?>
                        <?php echo wp_kses_post( $map_embed ); ?>
                    <?php else : ?>
                        <div id="ieatmaps"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 form">
                <div class="contact-form-inner section-padding">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="mb-30 playfont"><?php echo esc_html( $form_title ); ?></h3>
                                <?php if ( ! empty( $form_description ) ) : ?>
                                    <p class="mb-20"><?php echo esc_html( $form_description ); ?></p>
                                <?php endif; ?>
                                <?php
                                if ( ! empty( $form_shortcode ) ) {
                                    echo do_shortcode( $form_shortcode );
                                } else {
                                    if ( have_posts() ) {
                                        while ( have_posts() ) {
                                            the_post();
                                            the_content();
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== End Contact ==================== -->

<?php
get_footer();
?>
