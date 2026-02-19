    <!-- ==================== Start Footer ==================== -->

    <?php
    // Load footer settings from a dedicated "Footer" page (slug: footer)
    $footer_sections = array();
    $footer_page     = get_page_by_path( 'footer' );

    if ( $footer_page ) {
        $stored = get_post_meta( $footer_page->ID, '_footer_sections', true );
        if ( is_array( $stored ) ) {
            $footer_sections = $stored;
        }
    }

    // About / logo
    $footer_logo_id  = isset( $footer_sections['logo_image_id'] ) ? intval( $footer_sections['logo_image_id'] ) : 0;
    $footer_logo_url = $footer_logo_id ? wp_get_attachment_url( $footer_logo_id ) : get_template_directory_uri() . '/img/logo-light.png';

    $footer_about_text = isset( $footer_sections['about_text'] ) && $footer_sections['about_text'] !== ''
        ? $footer_sections['about_text']
        : get_bloginfo( 'description' );

    $footer_social_facebook = isset( $footer_sections['social_facebook'] ) && $footer_sections['social_facebook'] !== '' ? $footer_sections['social_facebook'] : '#0';
    $footer_social_twitter  = isset( $footer_sections['social_twitter'] ) && $footer_sections['social_twitter'] !== '' ? $footer_sections['social_twitter'] : '#0';
    $footer_social_behance  = isset( $footer_sections['social_behance'] ) && $footer_sections['social_behance'] !== '' ? $footer_sections['social_behance'] : '#0';
    $footer_social_pin      = isset( $footer_sections['social_pinterest'] ) && $footer_sections['social_pinterest'] !== '' ? $footer_sections['social_pinterest'] : '#0';

    // Links
    $footer_links_title = isset( $footer_sections['links_title'] ) && $footer_sections['links_title'] !== '' ? $footer_sections['links_title'] : 'Links';
    $footer_links = array();
    for ( $i = 1; $i <= 4; $i++ ) {
        $label_key = 'link_' . $i . '_label';
        $url_key   = 'link_' . $i . '_url';

        $label = isset( $footer_sections[ $label_key ] ) && $footer_sections[ $label_key ] !== '' ? $footer_sections[ $label_key ] : '';
        $url   = isset( $footer_sections[ $url_key ] ) && $footer_sections[ $url_key ] !== '' ? $footer_sections[ $url_key ] : '';

        if ( $label && $url ) {
            $footer_links[] = array(
                'label' => $label,
                'url'   => $url,
            );
        }
    }
    if ( empty( $footer_links ) ) {
        $footer_links = array(
            array( 'label' => 'Home',   'url' => home_url( '/' ) ),
            array( 'label' => 'About',  'url' => home_url( '/about' ) ),
            array( 'label' => 'Blog',   'url' => home_url( '/blog' ) ),
            array( 'label' => 'Contact','url' => home_url( '/contact' ) ),
        );
    }

    // Contact
    $footer_contact_title = isset( $footer_sections['contact_title'] ) && $footer_sections['contact_title'] !== '' ? $footer_sections['contact_title'] : 'Get in Touch';
    $footer_contact_phone = isset( $footer_sections['contact_phone'] ) && $footer_sections['contact_phone'] !== '' ? $footer_sections['contact_phone'] : get_option( 'spaceengineers_phone', '+1 234 567 8900' );
    $footer_contact_email = isset( $footer_sections['contact_email'] ) && $footer_sections['contact_email'] !== '' ? $footer_sections['contact_email'] : get_option( 'spaceengineers_email', 'info@example.com' );

    // Visit
    $footer_visit_title = isset( $footer_sections['visit_title'] ) && $footer_sections['visit_title'] !== ''
        ? $footer_sections['visit_title']
        : 'Visit';

    // Primary source: Contact page "Address Text" field
    $footer_visit_address = '';
    $contact_page         = get_page_by_path( 'contact' );

    if ( $contact_page ) {
        $contact_sections = get_post_meta( $contact_page->ID, '_contact_sections', true );
        if ( is_array( $contact_sections ) && ! empty( $contact_sections['address_text'] ) ) {
            $footer_visit_address = $contact_sections['address_text'];
        }
    }

    // Fallback: global theme option if contact address is not set
    if ( $footer_visit_address === '' ) {
        $footer_visit_address = get_option(
            'spaceengineers_address',
            'B17 Princess Road, London, Greater London NW18JR, United Kingdom'
        );
    }

    // Bottom bar
    $footer_bottom_left  = isset( $footer_sections['bottom_left_text'] ) && $footer_sections['bottom_left_text'] !== ''
        ? $footer_sections['bottom_left_text']
        : '© ' . date( 'Y' ) . ', ' . get_bloginfo( 'name' ) . '. All rights reserved.';
    $footer_bottom_right = isset( $footer_sections['bottom_right_text'] ) && $footer_sections['bottom_right_text'] !== ''
        ? $footer_sections['bottom_right_text']
        : get_bloginfo( 'description' );
    ?>

    <footer class="main-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="item abot">
                        <div class="logo-footer mb-20">
                            <a href="<?php echo home_url(); ?>" class="logo">
                                <img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                        <p><?php echo esc_html( $footer_about_text ); ?></p>
                        <div class="social-icon">
                            <a href="<?php echo esc_url( $footer_social_facebook ); ?>"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php echo esc_url( $footer_social_twitter ); ?>"><i class="fab fa-twitter"></i></a>
                            <a href="<?php echo esc_url( $footer_social_behance ); ?>"><i class="fab fa-behance"></i></a>
                            <a href="<?php echo esc_url( $footer_social_pin ); ?>"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <div class="item fotcont">
                        <div class="fothead">
                            <h6><?php echo esc_html( $footer_links_title ); ?></h6>
                        </div>
                        <ul class="fotlist">
                            <?php foreach ( $footer_links as $link ) : ?>
                                <li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="item fotcont">
                        <div class="fothead">
                            <h6><?php echo esc_html( $footer_contact_title ); ?></h6>
                        </div>
                        <p><?php echo esc_html( $footer_contact_phone ); ?></p>
                        <p><?php echo esc_html( $footer_contact_email ); ?></p>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="item fotcont">
                        <div class="fothead">
                            <h6><?php echo esc_html( $footer_visit_title ); ?></h6>
                        </div>
                        <p><?php echo esc_html( $footer_visit_address ); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="text-left">
                            <p><?php echo esc_html( $footer_bottom_left ); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-right">
                            <p><?php // echo esc_html( $footer_bottom_right ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== End Footer ==================== -->

    <?php wp_footer(); ?>
</body>

</html>
