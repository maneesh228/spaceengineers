<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>

    <!-- Metas -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="HTML5 Template Archo onepage themeforest" />
    <meta name="description" content="<?php bloginfo( 'description' ); ?>" />

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
// Load header settings from a dedicated "Header" page (slug: header)
$header_sections = array();
$header_page     = get_page_by_path( 'header' );

if ( $header_page ) {
    $stored = get_post_meta( $header_page->ID, '_header_sections', true );
    if ( is_array( $stored ) ) {
        $header_sections = $stored;
    }
}

// Prepare logo URL
$logo_id  = isset( $header_sections['logo_image_id'] ) ? intval( $header_sections['logo_image_id'] ) : 0;
$logo_url = $logo_id ? wp_get_attachment_url( $logo_id ) : get_template_directory_uri() . '/img/logo-light.png';

// Prepare navigation items with fallbacks
$default_nav = array(
    1 => array( 'label' => 'Home',     'url' => home_url( '/' ) ),
    2 => array( 'label' => 'About',    'url' => home_url( '/about' ) ),
    3 => array( 'label' => 'Services', 'url' => home_url( '/services' ) ),
    4 => array( 'label' => 'Projects', 'url' => home_url( '/projects' ) ),
    5 => array( 'label' => 'Blog',     'url' => home_url( '/blog' ) ),
    6 => array( 'label' => 'Contact',  'url' => home_url( '/contact' ) ),
);

$nav_items = array();
for ( $i = 1; $i <= 6; $i++ ) {
    $label_key = 'nav_' . $i . '_label';
    $url_key   = 'nav_' . $i . '_url';

    $label = isset( $header_sections[ $label_key ] ) && $header_sections[ $label_key ] !== ''
        ? $header_sections[ $label_key ]
        : $default_nav[ $i ]['label'];

    $url = isset( $header_sections[ $url_key ] ) && $header_sections[ $url_key ] !== ''
        ? $header_sections[ $url_key ]
        : $default_nav[ $i ]['url'];

    $nav_items[ $i ] = array(
        'label' => $label,
        'url'   => $url,
    );
}

// Social links
$social_facebook = isset( $header_sections['social_facebook'] ) && $header_sections['social_facebook'] !== ''
    ? $header_sections['social_facebook']
    : '#0';
$social_twitter  = isset( $header_sections['social_twitter'] ) && $header_sections['social_twitter'] !== ''
    ? $header_sections['social_twitter']
    : '#0';
$social_behance  = isset( $header_sections['social_behance'] ) && $header_sections['social_behance'] !== ''
    ? $header_sections['social_behance']
    : '#0';
?>


    <!-- ==================== Start Loading ==================== -->

    <div id="preloader">
        <div class="loading-text">Loading</div>
    </div>

    <!-- ==================== End Loading ==================== -->


    <!-- ==================== Start progress-scroll-button ==================== -->

    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- ==================== End progress-scroll-button ==================== -->


    <!-- ==================== Start cursor ==================== -->

    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>

    <!-- ==================== End cursor ==================== -->


    <!-- ==================== Start Navbar ==================== -->

    <nav class="navbar change navbar-expand-lg">
        <div class="container">

            <!-- Logo -->
            <a class="logo" href="<?php echo home_url(); ?>">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"><i class="fas fa-bars"></i></span>
            </button>

            <!-- navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php foreach ( $nav_items as $item ) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="social-icon">
                    <a href="<?php echo esc_url( $social_facebook ); ?>"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo esc_url( $social_twitter ); ?>"><i class="fab fa-twitter"></i></a>
                    <a href="<?php echo esc_url( $social_behance ); ?>"><i class="fab fa-behance"></i></a>
                </div>
                <!-- <div class="search">
                    <span class="icon pe-7s-search cursor-pointer"></span>
                    <div class="search-form text-center custom-font">
                        <form method="get" action="<?php // echo home_url( '/' ); ?>">
                            <input type="text" name="s" placeholder="Search">
                        </form>
                        <span class="close pe-7s-close cursor-pointer"></span>
                    </div>
                </div> -->
            </div>
        </div>
    </nav>

    <!-- ==================== End Navbar ==================== -->
