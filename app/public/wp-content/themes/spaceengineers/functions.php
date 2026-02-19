<?php
/**
 * Space Engineers Theme Functions
 */

// Enqueue CSS and JS files
function spaceengineers_enqueue_assets() {
    $template_uri = get_template_directory_uri();
    
    // Google Fonts
    wp_enqueue_style( 'google-fonts-poppins', 'https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap' );
    wp_enqueue_style( 'google-fonts-teko', 'https://fonts.googleapis.com/css?family=Teko:300,400,500,600,700&display=swap' );
    wp_enqueue_style( 'google-fonts-playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,500,600,700,800,900&display=swap' );
    
    // Plugins CSS
    wp_enqueue_style( 'plugins-css', $template_uri . '/css/plugins.css' );
    
    // Main Style
    wp_enqueue_style( 'style-css', $template_uri . '/css/style.css' );
    
    // jQuery
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-migrate', $template_uri . '/js/jquery-migrate-3.0.0.min.js', array( 'jquery' ) );
    
    // Plugins JS
    wp_enqueue_script( 'plugins-js', $template_uri . '/js/plugins.js', array( 'jquery' ) );
    
    // Custom Scripts
    wp_enqueue_script( 'custom-js', $template_uri . '/js/scripts.js', array( 'jquery' ) );
    
    // Map JS
    wp_enqueue_script( 'map-js', $template_uri . '/js/map.js', array( 'jquery' ) );
    
    // Google Maps API
    wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDUU5FZiF5WLFFfgIC1n64Zr0zfpQZjBBg&callback=initMap', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'spaceengineers_enqueue_assets' );

// Add theme support
function spaceengineers_theme_support() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'spaceengineers_theme_support' );

// Add template URI to inline script for JavaScript access
function spaceengineers_template_uri_script() {
    ?>
    <script>
        var TEMPLATE_URI = "<?php echo get_template_directory_uri(); ?>";
    </script>
    <?php
}
add_action( 'wp_head', 'spaceengineers_template_uri_script', 0 );

// Ensure WordPress media library is available for admin upload buttons
function spaceengineers_admin_enqueue_media( $hook ) {
    // Load media scripts/styles on all admin pages that might use upload fields
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'spaceengineers_admin_enqueue_media' );

// Register Site Settings
function spaceengineers_register_settings() {
    register_setting( 'spaceengineers-settings', 'spaceengineers_phone' );
    register_setting( 'spaceengineers-settings', 'spaceengineers_email' );
    register_setting( 'spaceengineers-settings', 'spaceengineers_address' );
}
add_action( 'admin_init', 'spaceengineers_register_settings' );

// Add Admin Menu for Settings
function spaceengineers_add_admin_menu() {
    add_menu_page(
        'Space Engineers Settings',
        'SE Settings',
        'manage_options',
        'spaceengineers-settings',
        'spaceengineers_settings_page',
        'dashicons-cog'
    );
}
add_action( 'admin_menu', 'spaceengineers_add_admin_menu' );

// Settings Page
function spaceengineers_settings_page() {
    ?>
    <div class="wrap">
        <h1>Space Engineers Theme Settings</h1>
        <form action="options.php" method="post">
            <?php settings_fields( 'spaceengineers-settings' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="spaceengineers_phone">Phone</label></th>
                    <td><input type="text" id="spaceengineers_phone" name="spaceengineers_phone" value="<?php echo esc_attr( get_option( 'spaceengineers_phone' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="spaceengineers_email">Email</label></th>
                    <td><input type="email" id="spaceengineers_email" name="spaceengineers_email" value="<?php echo esc_attr( get_option( 'spaceengineers_email' ) ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="spaceengineers_address">Address</label></th>
                    <td><textarea id="spaceengineers_address" name="spaceengineers_address" rows="3" class="large-text"><?php echo esc_textarea( get_option( 'spaceengineers_address' ) ); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


// Metabox Callback
function spaceengineers_sections_metabox_callback( $post ) {
    $sections = get_post_meta( $post->ID, '_page_sections', true );
    if ( ! $sections ) {
        $sections = array();
    }
    
    wp_nonce_field( 'spaceengineers_sections_nonce', 'spaceengineers_nonce' );
    ?>
    <div class="spaceengineers-sections-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-section-1" role="tab">Section 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-section-2" role="tab">Section 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-section-3" role="tab">Section 3</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="tab-section-1" class="tab-pane fade show active" role="tabpanel">
                <label>Section 1 Title</label>
                <input type="text" name="section_1_title" value="<?php echo esc_attr( isset( $sections['section_1_title'] ) ? $sections['section_1_title'] : '' ); ?>" class="widefat" style="margin-bottom: 10px;" />
                <label>Section 1 Content</label>
                <?php 
                wp_editor( 
                    isset( $sections['section_1_content'] ) ? $sections['section_1_content'] : '', 
                    'section_1_content',
                    array( 'textarea_name' => 'section_1_content' )
                );
                ?>
            </div>

            <div id="tab-section-2" class="tab-pane fade" role="tabpanel">
                <label>Section 2 Title</label>
                <input type="text" name="section_2_title" value="<?php echo esc_attr( isset( $sections['section_2_title'] ) ? $sections['section_2_title'] : '' ); ?>" class="widefat" style="margin-bottom: 10px;" />
                <label>Section 2 Content</label>
                <?php 
                wp_editor( 
                    isset( $sections['section_2_content'] ) ? $sections['section_2_content'] : '', 
                    'section_2_content',
                    array( 'textarea_name' => 'section_2_content' )
                );
                ?>
            </div>

            <div id="tab-section-3" class="tab-pane fade" role="tabpanel">
                <label>Section 3 Title</label>
                <input type="text" name="section_3_title" value="<?php echo esc_attr( isset( $sections['section_3_title'] ) ? $sections['section_3_title'] : '' ); ?>" class="widefat" style="margin-bottom: 10px;" />
                <label>Section 3 Content</label>
                <?php 
                wp_editor( 
                    isset( $sections['section_3_content'] ) ? $sections['section_3_content'] : '', 
                    'section_3_content',
                    array( 'textarea_name' => 'section_3_content' )
                );
                ?>
            </div>
        </div>
    </div>

    <style>
        .spaceengineers-sections-tabs .nav-tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .spaceengineers-sections-tabs .nav-link {
            padding: 10px 15px;
            cursor: pointer;
            border: 1px solid transparent;
            border-bottom: 2px solid transparent;
            color: #666;
        }
        .spaceengineers-sections-tabs .nav-link.active {
            border-bottom: 2px solid #0073aa;
            color: #0073aa;
        }
        .spaceengineers-sections-tabs .tab-content {
            padding: 10px 0;
        }
        .spaceengineers-sections-tabs label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
    </style>
    <?php
}

// Save metabox data
function spaceengineers_save_sections_metabox( $post_id ) {
    if ( ! isset( $_POST['spaceengineers_nonce'] ) || ! wp_verify_nonce( $_POST['spaceengineers_nonce'], 'spaceengineers_sections_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $sections = array();
    
    for ( $i = 1; $i <= 3; $i++ ) {
        if ( isset( $_POST[ 'section_' . $i . '_title' ] ) ) {
            $sections[ 'section_' . $i . '_title' ] = sanitize_text_field( $_POST[ 'section_' . $i . '_title' ] );
        }
        if ( isset( $_POST[ 'section_' . $i . '_content' ] ) ) {
            $sections[ 'section_' . $i . '_content' ] = wp_kses_post( $_POST[ 'section_' . $i . '_content' ] );
        }
    }

    update_post_meta( $post_id, '_page_sections', $sections );
}
add_action( 'save_post', 'spaceengineers_save_sections_metabox' );

// Helper function to get section content
function get_page_section( $section_num, $field = 'content' ) {
    $sections = get_post_meta( get_the_ID(), '_page_sections', true );
    if ( ! $sections ) {
        return '';
    }
    
    $key = 'section_' . $section_num . '_' . $field;
    return isset( $sections[ $key ] ) ? $sections[ $key ] : '';
}

// ===================== HOME PAGE METABOX =====================

// Register Home Page metabox (only on the current front page)
function spaceengineers_register_home_metabox() {
    $post_id      = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    $front_page_id = intval( get_option( 'page_on_front' ) );

    if ( $post_id && $front_page_id && $post_id === $front_page_id ) {
        add_meta_box(
            'spaceengineers_home_sections',
            'Home Page Sections',
            'spaceengineers_home_metabox_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_home_metabox' );

// Metabox callback for Home page - tabs similar to About page
function spaceengineers_home_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_home_nonce', 'spaceengineers_home_nonce_field' );

    $sections = get_post_meta( $post->ID, '_home_sections', true );
    if ( ! is_array( $sections ) ) {
        $sections = array();
    }

    $defaults = array(
        // Slider
        'slide_1_subtitle' => 'interior',
        'slide_1_title'    => 'design agency',
        'slide_1_desc'     => 'Right design and right ideas matter a lot of in interior design business. <br> a style that makes a statement.',
        'slide_2_subtitle' => 'Innovative',
        'slide_2_title'    => 'Interior Design',
        'slide_2_desc'     => 'Right design and right ideas matter a lot of in interior design business. <br> a style that makes a statement.',
        'slide_3_subtitle' => 'Elegant &',
        'slide_3_title'    => 'Unique Design',
        'slide_3_desc'     => 'Right design and right ideas matter a lot of in interior design business. <br> a style that makes a statement.',

        // Services
        'service_1_title'  => 'Architecture',
        'service_1_desc'   => 'Cras mollis turpis a ipsum ultes, nec cond imentum ipsum consequat.',
        'service_2_title'  => 'Interior Design',
        'service_2_desc'   => 'Cras mollis turpis a ipsum ultes, nec cond imentum ipsum consequat.',
        'service_3_title'  => '3D Modeling',
        'service_3_desc'   => 'Cras mollis turpis a ipsum ultes, nec cond imentum ipsum consequat.',

        // About
        'about_title'            => 'Best Designers <br> Architectures for You.',
        'about_desc'             => 'Architecture bibendum pharetra eleifend. Suspendisse vel volutpat purus, sit amet bibendum nisl.',
        'about_list'             => array( 'Architecture', 'Interior Design', 'Furniture' ),
        'about_image_1_id'       => 0,
        'about_image_2_id'       => 0,
        'about_experience_years' => '21',
        'about_experience_label' => 'Years Of Experience',

        // Works (Start works section)
        'work_1_subtitle'      => 'Interior',
        'work_1_title'         => 'Exterior Designs',
        'work_1_bg_image_id'   => 0,
        'work_2_subtitle'      => 'Interior',
        'work_2_title'         => 'Maroon Beach Hotel',
        'work_2_bg_image_id'   => 0,
        'work_3_subtitle'      => 'Interior',
        'work_3_title'         => 'Apartment Renovation',
        'work_3_bg_image_id'   => 0,
        'work_4_subtitle'      => 'Interior',
        'work_4_title'         => 'Modern Minimalist House',
        'work_4_bg_image_id'   => 0,

        // Testimonials & Blog
        'testimonials_subtitle'    => 'Testimonials',
        'testimonials_title'       => 'What People Says?',
        'testimonials_bg_image_id' => 0,
        'blog_subtitle'            => 'Latest News',
        'blog_title'               => 'Our Blogs',
    );

    foreach ( $defaults as $key => $value ) {
        if ( ! isset( $sections[ $key ] ) ) {
            $sections[ $key ] = $value;
        }
    }

    // Prepare About list string
    $about_list_values = array();
    if ( isset( $sections['about_list'] ) ) {
        if ( is_array( $sections['about_list'] ) ) {
            $about_list_values = $sections['about_list'];
        } elseif ( is_string( $sections['about_list'] ) ) {
            $about_list_values = array_map( 'trim', explode( "\n", $sections['about_list'] ) );
        }
    }
    if ( empty( $about_list_values ) ) {
        $about_list_values = $defaults['about_list'];
    }
    $about_list_str = implode( "\n", $about_list_values );
    ?>
    <style>
        .home-tabs-container { margin-top: 20px; }
        .home-tabs-nav {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 20px;
        }
        .home-tabs-nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }
        .home-tabs-nav button.active {
            color: #333;
            border-bottom-color: #0066cc;
        }
        .home-tabs-content { display: none; }
        .home-tabs-content.active { display: block; }
        .home-section-field {
            margin-bottom: 20px;
        }
        .home-section-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .home-section-field input[type="text"],
        .home-section-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .home-section-field textarea { min-height: 80px; }
    </style>

    <div class="home-tabs-container">
        <div class="home-tabs-nav">
            <button type="button" class="home-tab-btn active" data-tab="home-slider">Slider</button>
            <button type="button" class="home-tab-btn" data-tab="home-services">Services</button>
            <button type="button" class="home-tab-btn" data-tab="home-about">About Section</button>
            <button type="button" class="home-tab-btn" data-tab="home-works">Works</button>
            <button type="button" class="home-tab-btn" data-tab="home-testimonials">Testimonials</button>
            <button type="button" class="home-tab-btn" data-tab="home-headings">Blog section</button>
        </div>

        <!-- Slider Tab -->
        <div class="home-tabs-content active" id="home-slider">
            <div class="home-section-field">
                <p>Slides are managed as a separate content type, similar to Testimonials.</p>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=slide' ) ); ?>" class="button button-primary" style="margin-right: 10px;">+ Add New Slide</a>
                    <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=slide' ) ); ?>" class="button">Manage Slides</a>
                </p>
                <p style="font-size: 12px; color: #666; margin-top: 10px;">The front page slider will automatically show your published slides.</p>
            </div>
        </div>

        <!-- Services Tab -->
        <div class="home-tabs-content" id="home-services">
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <div class="home-section-field" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <strong>Service <?php echo $i; ?></strong>
                </div>
                <div class="home-section-field">
                    <label>Title</label>
                    <input type="text" name="home_sections[service_<?php echo $i; ?>_title]" value="<?php echo esc_attr( $sections[ 'service_' . $i . '_title' ] ); ?>" placeholder="e.g., Architecture">
                </div>
                <div class="home-section-field">
                    <label>Description</label>
                    <textarea name="home_sections[service_<?php echo $i; ?>_desc]" placeholder="Service description..."><?php echo esc_textarea( $sections[ 'service_' . $i . '_desc' ] ); ?></textarea>
                </div>
            <?php endfor; ?>
        </div>

        <!-- About Tab -->
        <div class="home-tabs-content" id="home-about">
            <div class="home-section-field">
                <label>About Title</label>
                <input type="text" name="home_sections[about_title]" value="<?php echo esc_attr( $sections['about_title'] ); ?>" placeholder="Best Designers Architectures for You.">
            </div>
            <div class="home-section-field">
                <label>About Description</label>
                <textarea name="home_sections[about_desc]" placeholder="About section description..."><?php echo esc_textarea( $sections['about_desc'] ); ?></textarea>
            </div>
            <div class="home-section-field">
                <label>About List Items (one per line)</label>
                <textarea name="home_sections[about_list]" placeholder="Architecture&#10;Interior Design&#10;Furniture"><?php echo esc_textarea( $about_list_str ); ?></textarea>
            </div>
            <?php
            $about_image_1_id  = isset( $sections['about_image_1_id'] ) ? intval( $sections['about_image_1_id'] ) : 0;
            $about_image_1_url = $about_image_1_id ? wp_get_attachment_thumb_url( $about_image_1_id ) : '';
            $about_image_2_id  = isset( $sections['about_image_2_id'] ) ? intval( $sections['about_image_2_id'] ) : 0;
            $about_image_2_url = $about_image_2_id ? wp_get_attachment_thumb_url( $about_image_2_id ) : '';
            ?>
            <div class="home-section-field">
                <label>About Image 1</label>
                <div style="margin-bottom:10px;">
                    <img id="about_image_1_preview" src="<?php echo esc_url( $about_image_1_url ); ?>" style="max-width:100%; <?php echo $about_image_1_url ? '' : 'display:none;'; ?>" />
                </div>
                <input type="hidden" id="about_image_1_id" name="home_sections[about_image_1_id]" value="<?php echo esc_attr( $about_image_1_id ); ?>" />
                <button type="button" class="button" id="about_image_1_upload_btn">Select Image</button>
                <button type="button" class="button" id="about_image_1_remove_btn" style="<?php echo $about_image_1_id ? '' : 'display:none;'; ?>">Remove Image</button>
                <p class="description">This image appears on the left of the About section.</p>
            </div>

            <div class="home-section-field">
                <label>About Image 2</label>
                <div style="margin-bottom:10px;">
                    <img id="about_image_2_preview" src="<?php echo esc_url( $about_image_2_url ); ?>" style="max-width:100%; <?php echo $about_image_2_url ? '' : 'display:none;'; ?>" />
                </div>
                <input type="hidden" id="about_image_2_id" name="home_sections[about_image_2_id]" value="<?php echo esc_attr( $about_image_2_id ); ?>" />
                <button type="button" class="button" id="about_image_2_upload_btn">Select Image</button>
                <button type="button" class="button" id="about_image_2_remove_btn" style="<?php echo $about_image_2_id ? '' : 'display:none;'; ?>">Remove Image</button>
                <p class="description">This image appears on the right of the About section.</p>
            </div>

            <div class="home-section-field">
                <label>Experience Years</label>
                <input type="text" name="home_sections[about_experience_years]" value="<?php echo esc_attr( $sections['about_experience_years'] ); ?>" placeholder="21">
            </div>
            <div class="home-section-field">
                <label>Experience Label</label>
                <input type="text" name="home_sections[about_experience_label]" value="<?php echo esc_attr( $sections['about_experience_label'] ); ?>" placeholder="Years Of Experience">
            </div>
        </div>

        <!-- Works Tab (Start works section) -->
        <div class="home-tabs-content" id="home-works">
            <?php for ( $i = 1; $i <= 4; $i++ ) :
                $work_subtitle_key = 'work_' . $i . '_subtitle';
                $work_title_key    = 'work_' . $i . '_title';
                $work_bg_key       = 'work_' . $i . '_bg_image_id';

                $work_subtitle = isset( $sections[ $work_subtitle_key ] ) ? $sections[ $work_subtitle_key ] : '';
                $work_title    = isset( $sections[ $work_title_key ] ) ? $sections[ $work_title_key ] : '';
                $work_bg_id    = isset( $sections[ $work_bg_key ] ) ? intval( $sections[ $work_bg_key ] ) : 0;
                $work_bg_url   = $work_bg_id ? wp_get_attachment_thumb_url( $work_bg_id ) : '';
            ?>
                <div class="home-section-field" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <strong>Work <?php echo $i; ?></strong>
                </div>
                <div class="home-section-field">
                    <label>Subtitle</label>
                    <input type="text" name="home_sections[<?php echo esc_attr( $work_subtitle_key ); ?>]" value="<?php echo esc_attr( $work_subtitle ); ?>" placeholder="e.g., Interior">
                </div>
                <div class="home-section-field">
                    <label>Title</label>
                    <input type="text" name="home_sections[<?php echo esc_attr( $work_title_key ); ?>]" value="<?php echo esc_attr( $work_title ); ?>" placeholder="Work title">
                </div>
                <div class="home-section-field">
                    <label>Background Image</label>
                    <div style="margin-bottom:10px;">
                        <img id="work_<?php echo $i; ?>_bg_preview" src="<?php echo esc_url( $work_bg_url ); ?>" style="max-width:100%; <?php echo $work_bg_url ? '' : 'display:none;'; ?>" />
                    </div>
                    <input type="hidden" id="work_<?php echo $i; ?>_bg_image_id" name="home_sections[<?php echo esc_attr( $work_bg_key ); ?>]" value="<?php echo esc_attr( $work_bg_id ); ?>" />
                    <button type="button" class="button work-bg-upload-btn" data-index="<?php echo $i; ?>">Select Image</button>
                    <button type="button" class="button work-bg-remove-btn" data-index="<?php echo $i; ?>" style="<?php echo $work_bg_id ? '' : 'display:none;'; ?>">Remove Image</button>
                    <p class="description">Used as the background for Work <?php echo $i; ?> in the Start works section.</p>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Testimonials Tab -->
        <div class="home-tabs-content" id="home-testimonials">
            <div class="home-section-field">
                <h4>Testimonials Items</h4>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=testimonial' ) ); ?>" class="button button-primary" style="margin-right:10px;">+ Add New Testimonial</a>
                    <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=testimonial' ) ); ?>" class="button">Manage Testimonials</a>
                </p>
                <p class="description">Use these links to add or edit testimonial entries shown on the homepage.</p>
            </div>

            <div class="home-section-field">
                <h4>Testimonials Headings</h4>
                <label>Subtitle</label>
                <input type="text" name="home_sections[testimonials_subtitle]" value="<?php echo esc_attr( $sections['testimonials_subtitle'] ); ?>" placeholder="e.g., Testimonials">
            </div>
            <div class="home-section-field">
                <label>Title</label>
                <input type="text" name="home_sections[testimonials_title]" value="<?php echo esc_attr( $sections['testimonials_title'] ); ?>" placeholder="e.g., What People Says?">
            </div>

            <div class="home-section-field">
                <h4>Background Image</h4>
                <label>Testimonials Background Image</label>
                <?php
                $testimonials_bg_id  = isset( $sections['testimonials_bg_image_id'] ) ? intval( $sections['testimonials_bg_image_id'] ) : 0;
                $testimonials_bg_url = $testimonials_bg_id ? wp_get_attachment_thumb_url( $testimonials_bg_id ) : '';
                ?>
                <div style="margin-bottom:10px;">
                    <img id="testimonials_bg_preview" src="<?php echo esc_url( $testimonials_bg_url ); ?>" style="max-width:100%; <?php echo $testimonials_bg_url ? '' : 'display:none;'; ?>" />
                </div>
                <input type="hidden" id="testimonials_bg_image_id" name="home_sections[testimonials_bg_image_id]" value="<?php echo esc_attr( $testimonials_bg_id ); ?>" />
                <button type="button" class="button" id="testimonials_bg_upload_btn">Select Image</button>
                <button type="button" class="button" id="testimonials_bg_remove_btn" style="<?php echo $testimonials_bg_id ? '' : 'display:none;'; ?>">Remove Image</button>
                <p class="description">This image will be used as the background for the testimonials section on the homepage.</p>
            </div>
        </div>

        <!-- Headings Tab -->
        <div class="home-tabs-content" id="home-headings">
            <div class="home-section-field">
                <h4>Blog Section</h4>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=post' ) ); ?>" class="button button-primary" style="margin-right:10px;">+ Add New Blog Post</a>
                    <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=post' ) ); ?>" class="button">Manage Blog Posts</a>
                </p>
                <p class="description">Use these links to add or edit blog posts that appear in the homepage blog section.</p>
                <label>Subtitle</label>
                <input type="text" name="home_sections[blog_subtitle]" value="<?php echo esc_attr( $sections['blog_subtitle'] ); ?>" placeholder="e.g., Latest News">
            </div>
            <div class="home-section-field">
                <label>Title</label>
                <input type="text" name="home_sections[blog_title]" value="<?php echo esc_attr( $sections['blog_title'] ); ?>" placeholder="e.g., Our Blogs">
            </div>
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.home-tab-btn');
            const contents = document.querySelectorAll('.home-tabs-content');

            buttons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');

                    buttons.forEach(function(b) { b.classList.remove('active'); });
                    contents.forEach(function(c) { c.classList.remove('active'); });

                    this.classList.add('active');
                    document.getElementById(tabName).classList.add('active');
                });
            });
        })();

        // Testimonials background image uploader (uses wp.media)
        (function($) {
            $(document).ready(function() {
                var testimonialsBgFrame;
                var aboutImage1Frame;
                var aboutImage2Frame;

                $('#testimonials_bg_upload_btn').on('click', function(e) {
                    e.preventDefault();

                    if (testimonialsBgFrame) {
                        testimonialsBgFrame.open();
                        return;
                    }

                    testimonialsBgFrame = wp.media({
                        title: 'Select Testimonials Background',
                        button: { text: 'Use this image' },
                        multiple: false
                    });

                    testimonialsBgFrame.on('select', function() {
                        var attachment = testimonialsBgFrame.state().get('selection').first().toJSON();
                        $('#testimonials_bg_image_id').val(attachment.id);
                        $('#testimonials_bg_preview').attr('src', attachment.url).show();
                        $('#testimonials_bg_remove_btn').show();
                    });

                    testimonialsBgFrame.open();
                });

                $('#testimonials_bg_remove_btn').on('click', function(e) {
                    e.preventDefault();
                    $('#testimonials_bg_image_id').val('');
                    $('#testimonials_bg_preview').hide().attr('src', '');
                    $(this).hide();
                });

                // About images
                $('#about_image_1_upload_btn').on('click', function(e) {
                    e.preventDefault();

                    if (aboutImage1Frame) {
                        aboutImage1Frame.open();
                        return;
                    }

                    aboutImage1Frame = wp.media({
                        title: 'Select About Image 1',
                        button: { text: 'Use this image' },
                        multiple: false
                    });

                    aboutImage1Frame.on('select', function() {
                        var attachment = aboutImage1Frame.state().get('selection').first().toJSON();
                        $('#about_image_1_id').val(attachment.id);
                        $('#about_image_1_preview').attr('src', attachment.url).show();
                        $('#about_image_1_remove_btn').show();
                    });

                    aboutImage1Frame.open();
                });

                $('#about_image_1_remove_btn').on('click', function(e) {
                    e.preventDefault();
                    $('#about_image_1_id').val('');
                    $('#about_image_1_preview').hide().attr('src', '');
                    $(this).hide();
                });

                $('#about_image_2_upload_btn').on('click', function(e) {
                    e.preventDefault();

                    if (aboutImage2Frame) {
                        aboutImage2Frame.open();
                        return;
                    }

                    aboutImage2Frame = wp.media({
                        title: 'Select About Image 2',
                        button: { text: 'Use this image' },
                        multiple: false
                    });

                    aboutImage2Frame.on('select', function() {
                        var attachment = aboutImage2Frame.state().get('selection').first().toJSON();
                        $('#about_image_2_id').val(attachment.id);
                        $('#about_image_2_preview').attr('src', attachment.url).show();
                        $('#about_image_2_remove_btn').show();
                    });

                    aboutImage2Frame.open();
                });

                $('#about_image_2_remove_btn').on('click', function(e) {
                    e.preventDefault();
                    $('#about_image_2_id').val('');
                    $('#about_image_2_preview').hide().attr('src', '');
                    $(this).hide();
                });

                // Works backgrounds (Start works section)
                $('.work-bg-upload-btn').on('click', function(e) {
                    e.preventDefault();

                    var index = $(this).data('index');

                    var frame = wp.media({
                        title: 'Select Work Background',
                        button: { text: 'Use this image' },
                        multiple: false
                    });

                    frame.on('select', function() {
                        var attachment = frame.state().get('selection').first().toJSON();
                        $('#work_' + index + '_bg_image_id').val(attachment.id);
                        $('#work_' + index + '_bg_preview').attr('src', attachment.url).show();
                        $('.work-bg-remove-btn[data-index="' + index + '"]').show();
                    });

                    frame.open();
                });

                $('.work-bg-remove-btn').on('click', function(e) {
                    e.preventDefault();
                    var index = $(this).data('index');
                    $('#work_' + index + '_bg_image_id').val('');
                    $('#work_' + index + '_bg_preview').hide().attr('src', '');
                    $(this).hide();
                });
            });
        })(jQuery);
    </script>
    <?php
}

// Save Home page metabox
function spaceengineers_save_home_metabox( $post_id ) {
    $front_page_id = intval( get_option( 'page_on_front' ) );
    if ( ! $front_page_id || $post_id !== $front_page_id ) {
        return;
    }

    if ( ! isset( $_POST['spaceengineers_home_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_home_nonce_field'], 'spaceengineers_home_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['home_sections'] ) && is_array( $_POST['home_sections'] ) ) {
        $raw      = $_POST['home_sections'];
        $sections = array();

        foreach ( $raw as $key => $value ) {
            if ( $key === 'about_list' ) {
                if ( is_string( $value ) ) {
                    $items = array_filter( array_map( 'trim', explode( "\n", $value ) ) );
                    $sections[ $key ] = array_map( 'sanitize_text_field', $items );
                } elseif ( is_array( $value ) ) {
                    $sections[ $key ] = array_map( 'sanitize_text_field', $value );
                }
            } elseif ( $key === 'about_desc' ) {
                $sections[ $key ] = wp_kses_post( $value );
            } elseif ( in_array( $key, array( 'about_image_1_id', 'about_image_2_id', 'testimonials_bg_image_id', 'work_1_bg_image_id', 'work_2_bg_image_id', 'work_3_bg_image_id', 'work_4_bg_image_id' ), true ) ) {
                $sections[ $key ] = intval( $value );
            } else {
                $sections[ $key ] = sanitize_text_field( $value );
            }
        }

        update_post_meta( $post_id, '_home_sections', $sections );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_home_metabox' );

// ===================== HEADER SETTINGS METABOX =====================

// Register Header metabox for a dedicated "Header" page
function spaceengineers_register_header_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'header' && $post->post_type === 'page' ) {
            add_meta_box(
                'spaceengineers_header_sections',
                'Header Sections',
                'spaceengineers_header_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_header_metabox' );

// Header metabox callback - tabs to manage logo, navigation, social links
function spaceengineers_header_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_header_nonce', 'spaceengineers_header_nonce_field' );

    $sections = get_post_meta( $post->ID, '_header_sections', true );
    if ( ! is_array( $sections ) ) {
        $sections = array();
    }

    $defaults = array(
        'logo_image_id'    => 0,

        'nav_1_label'      => 'Home',
        'nav_1_url'        => home_url( '/' ),
        'nav_2_label'      => 'About',
        'nav_2_url'        => home_url( '/about' ),
        'nav_3_label'      => 'Services',
        'nav_3_url'        => home_url( '/services' ),
        'nav_4_label'      => 'Products',
        'nav_4_url'        => home_url( '/products' ),
        'nav_5_label'      => 'Blog',
        'nav_5_url'        => home_url( '/blog' ),
        'nav_6_label'      => 'Contact',
        'nav_6_url'        => home_url( '/contact' ),

        'social_facebook'  => '#0',
        'social_twitter'   => '#0',
        'social_behance'   => '#0',
    );

    foreach ( $defaults as $key => $value ) {
        if ( ! isset( $sections[ $key ] ) ) {
            $sections[ $key ] = $value;
        }
    }

    $logo_id  = intval( $sections['logo_image_id'] );
    $logo_url = $logo_id ? wp_get_attachment_thumb_url( $logo_id ) : '';

    // Find Contact page edit link for the Visit tab button
    $contact_page      = get_page_by_path( 'contact' );
    $contact_edit_link = $contact_page ? get_edit_post_link( $contact_page->ID, '' ) : '';
    ?>
    <style>
        .header-tabs-container { margin-top: 20px; }
        .header-tabs-nav {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 20px;
        }
        .header-tabs-nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }
        .header-tabs-nav button.active {
            color: #333;
            border-bottom-color: #0066cc;
        }
        .header-tabs-content { display: none; }
        .header-tabs-content.active { display: block; }
        .header-section-field { margin-bottom: 20px; }
        .header-section-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .header-section-field input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
    </style>

    <div class="header-tabs-container">
        <div class="header-tabs-nav">
            <button type="button" class="header-tab-btn active" data-tab="header-logo">Logo</button>
            <button type="button" class="header-tab-btn" data-tab="header-nav">Navigation</button>
            <button type="button" class="header-tab-btn" data-tab="header-social">Social Links</button>
        </div>

        <!-- Logo Tab -->
        <div class="header-tabs-content active" id="header-logo">
            <div class="header-section-field">
                <label>Header Logo</label>
                <div style="margin-bottom:10px;">
                    <img id="header_logo_preview" src="<?php echo esc_url( $logo_url ); ?>" style="max-width:100%; <?php echo $logo_url ? '' : 'display:none;'; ?>" />
                </div>
                <input type="hidden" id="header_logo_image_id" name="header_sections[logo_image_id]" value="<?php echo esc_attr( $logo_id ); ?>" />
                <button type="button" class="button" id="header_logo_upload_btn">Select Logo</button>
                <button type="button" class="button" id="header_logo_remove_btn" style="<?php echo $logo_id ? '' : 'display:none;'; ?>">Remove Logo</button>
                <p class="description">This logo appears in the site header. Recommended transparent PNG.</p>
            </div>
        </div>

        <!-- Navigation Tab -->
        <div class="header-tabs-content" id="header-nav">
            <?php for ( $i = 1; $i <= 6; $i++ ) :
                $label_key = 'nav_' . $i . '_label';
                $url_key   = 'nav_' . $i . '_url';
                $label     = isset( $sections[ $label_key ] ) ? $sections[ $label_key ] : '';
                $url       = isset( $sections[ $url_key ] ) ? $sections[ $url_key ] : '';
            ?>
                <div class="header-section-field" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <strong>Menu Item <?php echo $i; ?></strong>
                </div>
                <div class="header-section-field">
                    <label>Label</label>
                    <input type="text" name="header_sections[<?php echo esc_attr( $label_key ); ?>]" value="<?php echo esc_attr( $label ); ?>" placeholder="Menu label">
                </div>
                <div class="header-section-field">
                    <label>URL</label>
                    <input type="text" name="header_sections[<?php echo esc_attr( $url_key ); ?>]" value="<?php echo esc_attr( $url ); ?>" placeholder="https:// or relative URL">
                </div>
            <?php endfor; ?>
        </div>

        <!-- Social Tab -->
        <div class="header-tabs-content" id="header-social">
            <div class="header-section-field">
                <label>Facebook URL</label>
                <input type="text" name="header_sections[social_facebook]" value="<?php echo esc_attr( $sections['social_facebook'] ); ?>" placeholder="https://facebook.com/yourpage">
            </div>
            <div class="header-section-field">
                <label>Twitter URL</label>
                <input type="text" name="header_sections[social_twitter]" value="<?php echo esc_attr( $sections['social_twitter'] ); ?>" placeholder="https://twitter.com/yourhandle">
            </div>
            <div class="header-section-field">
                <label>Behance URL</label>
                <input type="text" name="header_sections[social_behance]" value="<?php echo esc_attr( $sections['social_behance'] ); ?>" placeholder="https://behance.net/yourprofile">
            </div>
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.header-tab-btn');
            const contents = document.querySelectorAll('.header-tabs-content');

            buttons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');

                    buttons.forEach(function(b) { b.classList.remove('active'); });
                    contents.forEach(function(c) { c.classList.remove('active'); });

                    this.classList.add('active');
                    document.getElementById(tabName).classList.add('active');
                });
            });
        })();

        (function($) {
            $(document).ready(function() {
                var headerLogoFrame;

                $('#header_logo_upload_btn').on('click', function(e) {
                    e.preventDefault();

                    if (headerLogoFrame) {
                        headerLogoFrame.open();
                        return;
                    }

                    headerLogoFrame = wp.media({
                        title: 'Select Header Logo',
                        button: { text: 'Use this logo' },
                        multiple: false
                    });

                    headerLogoFrame.on('select', function() {
                        var attachment = headerLogoFrame.state().get('selection').first().toJSON();
                        $('#header_logo_image_id').val(attachment.id);
                        $('#header_logo_preview').attr('src', attachment.url).show();
                        $('#header_logo_remove_btn').show();
                    });

                    headerLogoFrame.open();
                });

                $('#header_logo_remove_btn').on('click', function(e) {
                    e.preventDefault();
                    $('#header_logo_image_id').val('');
                    $('#header_logo_preview').hide().attr('src', '');
                    $(this).hide();
                });
            });
        })(jQuery);
    </script>
    <?php
}

// Save Header metabox
function spaceengineers_save_header_metabox( $post_id ) {
    if ( ! isset( $_POST['spaceengineers_header_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_header_nonce_field'], 'spaceengineers_header_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['header_sections'] ) && is_array( $_POST['header_sections'] ) ) {
        $raw      = $_POST['header_sections'];
        $sections = array();

        foreach ( $raw as $key => $value ) {
            if ( 'logo_image_id' === $key ) {
                $sections[ $key ] = intval( $value );
            } elseif ( strpos( $key, '_url' ) !== false || strpos( $key, 'social_' ) === 0 ) {
                $sections[ $key ] = esc_url_raw( $value );
            } else {
                $sections[ $key ] = sanitize_text_field( $value );
            }
        }

        update_post_meta( $post_id, '_header_sections', $sections );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_header_metabox' );

// ===================== FOOTER SETTINGS METABOX =====================

// Register Footer metabox for a dedicated "Footer" page
function spaceengineers_register_footer_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'footer' && $post->post_type === 'page' ) {
            add_meta_box(
                'spaceengineers_footer_sections',
                'Footer Sections',
                'spaceengineers_footer_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_footer_metabox' );

// Footer metabox callback - tabs to manage logo/text, links, contact, visit, and bottom bar
function spaceengineers_footer_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_footer_nonce', 'spaceengineers_footer_nonce_field' );

    $sections = get_post_meta( $post->ID, '_footer_sections', true );
    if ( ! is_array( $sections ) ) {
        $sections = array();
    }

    $defaults = array(
        // About / logo column
        'logo_image_id'        => 0,
        'about_text'           => get_bloginfo( 'description' ),
        'social_facebook'      => '#0',
        'social_twitter'       => '#0',
        'social_behance'       => '#0',
        'social_pinterest'     => '#0',

        // Links column
        'links_title'          => 'Links',
        'link_1_label'         => 'Home',
        'link_1_url'           => home_url( '/' ),
        'link_2_label'         => 'About',
        'link_2_url'           => home_url( '/about' ),
        'link_3_label'         => 'Blog',
        'link_3_url'           => home_url( '/blog' ),
        'link_4_label'         => 'Contact',
        'link_4_url'           => home_url( '/contact' ),

        // Contact column
        'contact_title'        => 'Get in Touch',
        'contact_phone'        => get_option( 'spaceengineers_phone', '+1 234 567 8900' ),
        'contact_email'        => get_option( 'spaceengineers_email', 'info@example.com' ),

        // Visit column
        'visit_title'          => 'Visit',
        'visit_address'        => get_option( 'spaceengineers_address', 'B17 Princess Road, London, Greater London NW18JR, United Kingdom' ),

        // Bottom bar
        'bottom_left_text'     => '© ' . date( 'Y' ) . ', ' . get_bloginfo( 'name' ) . '. All rights reserved.',
        'bottom_right_text'    => get_bloginfo( 'description' ),
    );

    foreach ( $defaults as $key => $value ) {
        if ( ! isset( $sections[ $key ] ) ) {
            $sections[ $key ] = $value;
        }
    }

    $logo_id  = intval( $sections['logo_image_id'] );
    $logo_url = $logo_id ? wp_get_attachment_thumb_url( $logo_id ) : '';

    // Find Contact page edit link for the Visit tab button
    $contact_page      = get_page_by_path( 'contact' );
    $contact_edit_link = $contact_page ? get_edit_post_link( $contact_page->ID, '' ) : '';
    ?>
    <style>
        .footer-tabs-container { margin-top: 20px; }
        .footer-tabs-nav {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 20px;
        }
        .footer-tabs-nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }
        .footer-tabs-nav button.active {
            color: #333;
            border-bottom-color: #0066cc;
        }
        .footer-tabs-content { display: none; }
        .footer-tabs-content.active { display: block; }
        .footer-section-field { margin-bottom: 20px; }
        .footer-section-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .footer-section-field input[type="text"],
        .footer-section-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .footer-section-field textarea { min-height: 80px; }
    </style>

    <div class="footer-tabs-container">
        <div class="footer-tabs-nav">
            <button type="button" class="footer-tab-btn active" data-tab="footer-about">About & Logo</button>
            <button type="button" class="footer-tab-btn" data-tab="footer-links">Links</button>
            <button type="button" class="footer-tab-btn" data-tab="footer-contact">Contact</button>
            <button type="button" class="footer-tab-btn" data-tab="footer-visit">Visit</button>
            <button type="button" class="footer-tab-btn" data-tab="footer-bottom">Bottom Bar</button>
        </div>

        <!-- About & Logo Tab -->
        <div class="footer-tabs-content active" id="footer-about">
            <div class="footer-section-field">
                <label>Footer Logo</label>
                <div style="margin-bottom:10px;">
                    <img id="footer_logo_preview" src="<?php echo esc_url( $logo_url ); ?>" style="max-width:100%; <?php echo $logo_url ? '' : 'display:none;'; ?>" />
                </div>
                <input type="hidden" id="footer_logo_image_id" name="footer_sections[logo_image_id]" value="<?php echo esc_attr( $logo_id ); ?>" />
                <button type="button" class="button" id="footer_logo_upload_btn">Select Logo</button>
                <button type="button" class="button" id="footer_logo_remove_btn" style="<?php echo $logo_id ? '' : 'display:none;'; ?>">Remove Logo</button>
                <p class="description">This logo appears in the footer. Recommended transparent PNG.</p>
            </div>
            <div class="footer-section-field">
                <label>About Text</label>
                <textarea name="footer_sections[about_text]" placeholder="Footer about text...">&lt;?php echo esc_textarea( $sections['about_text'] ); ?&gt;</textarea>
            </div>
            <div class="footer-section-field">
                <label>Social Links</label>
                <label>Facebook URL</label>
                <input type="text" name="footer_sections[social_facebook]" value="<?php echo esc_attr( $sections['social_facebook'] ); ?>" placeholder="https://facebook.com/yourpage">
                <label>Twitter URL</label>
                <input type="text" name="footer_sections[social_twitter]" value="<?php echo esc_attr( $sections['social_twitter'] ); ?>" placeholder="https://twitter.com/yourhandle">
                <label>Behance URL</label>
                <input type="text" name="footer_sections[social_behance]" value="<?php echo esc_attr( $sections['social_behance'] ); ?>" placeholder="https://behance.net/yourprofile">
                <label>Pinterest URL</label>
                <input type="text" name="footer_sections[social_pinterest]" value="<?php echo esc_attr( $sections['social_pinterest'] ); ?>" placeholder="https://pinterest.com/yourprofile">
            </div>
        </div>

        <!-- Links Tab -->
        <div class="footer-tabs-content" id="footer-links">
            <div class="footer-section-field">
                <label>Links Column Title</label>
                <input type="text" name="footer_sections[links_title]" value="<?php echo esc_attr( $sections['links_title'] ); ?>" placeholder="Links">
            </div>
            <?php for ( $i = 1; $i <= 4; $i++ ) :
                $label_key = 'link_' . $i . '_label';
                $url_key   = 'link_' . $i . '_url';
                $label     = isset( $sections[ $label_key ] ) ? $sections[ $label_key ] : '';
                $url       = isset( $sections[ $url_key ] ) ? $sections[ $url_key ] : '';
            ?>
                <div class="footer-section-field" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <strong>Link <?php echo $i; ?></strong>
                </div>
                <div class="footer-section-field">
                    <label>Label</label>
                    <input type="text" name="footer_sections[<?php echo esc_attr( $label_key ); ?>]" value="<?php echo esc_attr( $label ); ?>" placeholder="Link label">
                </div>
                <div class="footer-section-field">
                    <label>URL</label>
                    <input type="text" name="footer_sections[<?php echo esc_attr( $url_key ); ?>]" value="<?php echo esc_attr( $url ); ?>" placeholder="https:// or relative URL">
                </div>
            <?php endfor; ?>
        </div>

        <!-- Contact Tab -->
        <div class="footer-tabs-content" id="footer-contact">
            <div class="footer-section-field">
                <label>Contact Title</label>
                <input type="text" name="footer_sections[contact_title]" value="<?php echo esc_attr( $sections['contact_title'] ); ?>" placeholder="Get in Touch">
            </div>
            <div class="footer-section-field">
                <label>Phone</label>
                <input type="text" name="footer_sections[contact_phone]" value="<?php echo esc_attr( $sections['contact_phone'] ); ?>" placeholder="Phone number">
            </div>
            <div class="footer-section-field">
                <label>Email</label>
                <input type="text" name="footer_sections[contact_email]" value="<?php echo esc_attr( $sections['contact_email'] ); ?>" placeholder="Email address">
            </div>
        </div>

        <!-- Visit Tab -->
        <div class="footer-tabs-content" id="footer-visit">
            <div class="footer-section-field">
                <label>Visit Title</label>
                <input type="text" name="footer_sections[visit_title]" value="<?php echo esc_attr( $sections['visit_title'] ); ?>" placeholder="Visit">
            </div>
            <div class="footer-section-field">
                <label>Address</label>
                <?php if ( $contact_edit_link ) : ?>
                    <p style="margin-bottom:8px;">The footer address is managed on the Contact page.</p>
                    <a href="<?php echo esc_url( $contact_edit_link ); ?>" class="button button-primary">Update Address on Contact Page</a>
                <?php else : ?>
                    <p>No Contact page with slug "contact" was found. Please create one to manage the address.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bottom Bar Tab -->
        <div class="footer-tabs-content" id="footer-bottom">
            <div class="footer-section-field">
                <label>Bottom Left Text</label>
                <input type="text" name="footer_sections[bottom_left_text]" value="<?php echo esc_attr( $sections['bottom_left_text'] ); ?>" placeholder="© YEAR, Site Name. All rights reserved.">
            </div>
            <!-- <div class="footer-section-field">
                <label>Bottom Right Text</label>
                <input type="text" name="footer_sections[bottom_right_text]" value="<?php echo esc_attr( $sections['bottom_right_text'] ); ?>" placeholder="Small tagline or description">
            </div> -->
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.footer-tab-btn');
            const contents = document.querySelectorAll('.footer-tabs-content');

            buttons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');

                    buttons.forEach(function(b) { b.classList.remove('active'); });
                    contents.forEach(function(c) { c.classList.remove('active'); });

                    this.classList.add('active');
                    document.getElementById(tabName).classList.add('active');
                });
            });
        })();

        (function($) {
            $(document).ready(function() {
                var footerLogoFrame;

                $('#footer_logo_upload_btn').on('click', function(e) {
                    e.preventDefault();

                    if (footerLogoFrame) {
                        footerLogoFrame.open();
                        return;
                    }

                    footerLogoFrame = wp.media({
                        title: 'Select Footer Logo',
                        button: { text: 'Use this logo' },
                        multiple: false
                    });

                    footerLogoFrame.on('select', function() {
                        var attachment = footerLogoFrame.state().get('selection').first().toJSON();
                        $('#footer_logo_image_id').val(attachment.id);
                        $('#footer_logo_preview').attr('src', attachment.url).show();
                        $('#footer_logo_remove_btn').show();
                    });

                    footerLogoFrame.open();
                });

                $('#footer_logo_remove_btn').on('click', function(e) {
                    e.preventDefault();
                    $('#footer_logo_image_id').val('');
                    $('#footer_logo_preview').hide().attr('src', '');
                    $(this).hide();
                });
            });
        })(jQuery);
    </script>
    <?php
}

// Save Footer metabox
function spaceengineers_save_footer_metabox( $post_id ) {
    if ( ! isset( $_POST['spaceengineers_footer_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_footer_nonce_field'], 'spaceengineers_footer_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['footer_sections'] ) && is_array( $_POST['footer_sections'] ) ) {
        $raw      = $_POST['footer_sections'];
        $sections = array();

        foreach ( $raw as $key => $value ) {
            if ( 'logo_image_id' === $key ) {
                $sections[ $key ] = intval( $value );
            } elseif ( strpos( $key, '_url' ) !== false || strpos( $key, 'social_' ) === 0 ) {
                $sections[ $key ] = esc_url_raw( $value );
            } elseif ( in_array( $key, array( 'about_text', 'visit_address' ), true ) ) {
                $sections[ $key ] = sanitize_textarea_field( $value );
            } else {
                $sections[ $key ] = sanitize_text_field( $value );
            }
        }

        update_post_meta( $post_id, '_footer_sections', $sections );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_footer_metabox' );

// ===================== SLIDER POST TYPE =====================

// Register Slide Custom Post Type
function spaceengineers_register_slide_post_type() {
    $labels = array(
        'name'               => 'Slides',
        'singular_name'      => 'Slide',
        'menu_name'          => 'Slides',
        'add_new'            => 'Add New Slide',
        'add_new_item'       => 'Add New Slide',
        'edit_item'          => 'Edit Slide',
        'new_item'           => 'New Slide',
        'view_item'          => 'View Slide',
        'search_items'       => 'Search Slides',
        'not_found'          => 'No Slides Found',
        'not_found_in_trash' => 'No Slides Found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'hierarchical'       => false,
        'has_archive'        => false,
        'supports'           => array( 'title' ),
        'menu_icon'          => 'dashicons-images-alt2',
        'show_in_menu'       => true,
        'show_in_rest'       => false,
    );

    register_post_type( 'slide', $args );
}
add_action( 'init', 'spaceengineers_register_slide_post_type' );

// Add Slide Metabox
function spaceengineers_add_slide_metabox() {
    add_meta_box(
        'spaceengineers_slide_details',
        'Slide Details',
        'spaceengineers_slide_metabox_callback',
        'slide',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_slide', 'spaceengineers_add_slide_metabox' );

// Slide Metabox Callback
function spaceengineers_slide_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_slide_nonce', 'spaceengineers_slide_nonce_field' );

    $subtitle      = get_post_meta( $post->ID, '_slide_subtitle', true );
    $description   = get_post_meta( $post->ID, '_slide_description', true );
    $button_text   = get_post_meta( $post->ID, '_slide_button_text', true );
    $button_url    = get_post_meta( $post->ID, '_slide_button_url', true );
    $background_id = get_post_meta( $post->ID, '_slide_background_id', true );
    $background_url = $background_id ? wp_get_attachment_url( $background_id ) : '';
    ?>
    <style>
        .slide-field { margin-bottom: 20px; }
        .slide-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .slide-field input[type="text"],
        .slide-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .slide-field textarea { min-height: 80px; }
        .slide-image-preview { margin-top: 10px; margin-bottom: 10px; }
        .slide-image-preview img {
            max-width: 300px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>

    <div class="slide-field">
        <label>Subtitle</label>
        <input type="text" name="slide_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" placeholder="e.g., interior">
    </div>
    <div class="slide-field">
        <label>Description (supports basic HTML)</label>
        <textarea name="slide_description" placeholder="Slide description text..."><?php echo esc_textarea( $description ); ?></textarea>
    </div>
    <div class="slide-field">
        <label>Button Text</label>
        <input type="text" name="slide_button_text" value="<?php echo esc_attr( $button_text ); ?>" placeholder="e.g., Discover Work">
    </div>
    <div class="slide-field">
        <label>Button URL</label>
        <input type="text" name="slide_button_url" value="<?php echo esc_attr( $button_url ); ?>" placeholder="https:// or relative URL">
    </div>
    <div class="slide-field">
        <label>Background Image</label>
        <input type="hidden" id="slide_background_id" name="slide_background_id" value="<?php echo esc_attr( $background_id ); ?>">

        <?php if ( $background_url ) : ?>
            <div class="slide-image-preview" id="slide_background_preview_container">
                <img id="slide_background_preview" src="<?php echo esc_url( $background_url ); ?>" alt="Slide Background">
            </div>
        <?php else : ?>
            <div class="slide-image-preview" id="slide_background_preview_container" style="display:none;">
                <img id="slide_background_preview" src="" alt="Slide Background">
            </div>
        <?php endif; ?>

        <p>
            <button type="button" id="upload_slide_background" class="button button-primary" style="margin-right:10px;">Upload Background Image</button>
            <button type="button" id="remove_slide_background" class="button" style="background:#dc3545;color:#fff;border:none;<?php echo $background_url ? '' : ' display:none;'; ?>">Remove Image</button>
        </p>
    </div>

    <script>
        (function($) {
            $('#upload_slide_background').on('click', function(e) {
                e.preventDefault();

                var frame = wp.media({
                    title: 'Select Slide Background Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#slide_background_id').val(attachment.id);
                    $('#slide_background_preview').attr('src', attachment.url);
                    $('#slide_background_preview_container').show();
                    $('#remove_slide_background').show();
                });

                frame.open();
            });

            $('#remove_slide_background').on('click', function(e) {
                e.preventDefault();
                $('#slide_background_id').val('');
                $('#slide_background_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Slide Metabox
function spaceengineers_save_slide_metabox( $post_id ) {
    if ( ! isset( $_POST['spaceengineers_slide_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_slide_nonce_field'], 'spaceengineers_slide_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['slide_subtitle'] ) ) {
        update_post_meta( $post_id, '_slide_subtitle', sanitize_text_field( $_POST['slide_subtitle'] ) );
    }

    if ( isset( $_POST['slide_description'] ) ) {
        update_post_meta( $post_id, '_slide_description', wp_kses_post( $_POST['slide_description'] ) );
    }

    if ( isset( $_POST['slide_button_text'] ) ) {
        update_post_meta( $post_id, '_slide_button_text', sanitize_text_field( $_POST['slide_button_text'] ) );
    }

    if ( isset( $_POST['slide_button_url'] ) ) {
        update_post_meta( $post_id, '_slide_button_url', esc_url_raw( $_POST['slide_button_url'] ) );
    }

    if ( isset( $_POST['slide_background_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['slide_background_id'] );
        if ( ! empty( $image_id ) ) {
            update_post_meta( $post_id, '_slide_background_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_slide_background_id' );
        }
    }
}
add_action( 'save_post_slide', 'spaceengineers_save_slide_metabox' );

// Helper: get slides for front page
function spaceengineers_get_slides( $limit = -1 ) {
    $args = array(
        'post_type'      => 'slide',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );

    return new WP_Query( $args );
}

// Register metabox for About page with 4 tabs
function spaceengineers_register_about_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'about' ) {
            add_meta_box(
                'spaceengineers_about_sections',
                'About Page Sections',
                'spaceengineers_about_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_about_metabox' );

// Metabox callback for About page - 4 tabs
function spaceengineers_about_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_about_nonce', 'spaceengineers_about_nonce_field' );
    $sections = get_post_meta( $post->ID, '_about_sections', true );
    if ( !is_array( $sections ) ) {
        $sections = array();
    }
    ?>
    <style>
        .about-tabs-container {
            margin-top: 20px;
        }
        .about-tabs-nav {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 20px;
        }
        .about-tabs-nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }
        .about-tabs-nav button.active {
            color: #333;
            border-bottom-color: #0066cc;
        }
        .about-tabs-content {
            display: none;
        }
        .about-tabs-content.active {
            display: block;
        }
        .about-section-field {
            margin-bottom: 20px;
        }
        .about-section-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .about-section-field input[type="text"],
        .about-section-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI';
        }
    </style>

    <div class="about-tabs-container">
        <div class="about-tabs-nav">
            <button type="button" class="about-tab-btn active" data-tab="about-intro">About - Intro & Stats</button>
            <button type="button" class="about-tab-btn" data-tab="about-pvm">Profile / Vision / Mission</button>
            <button type="button" class="about-tab-btn" data-tab="about-services">Services</button>
            <button type="button" class="about-tab-btn" data-tab="about-skills">Skills</button>
            <button type="button" class="about-tab-btn" data-tab="about-testimonials">Testimonials</button>
            <button type="button" class="about-tab-btn" data-tab="about-employees">Our Employees</button>
        </div>

        <!-- Tab 1: About Intro -->
        <div class="about-tabs-content active" id="about-intro">
            <div class="about-section-field">
                <label>Banner Title</label>
                <input type="text" name="about_sections[banner_title]" value="<?php echo isset( $sections['banner_title'] ) ? esc_attr( $sections['banner_title'] ) : 'About Us'; ?>" placeholder="Banner Title">
            </div>
            
            <div class="about-section-field">
                <label>Banner Image</label>
                <input type="hidden" id="about_banner_image_id" name="about_sections[banner_image_id]" value="<?php echo isset( $sections['banner_image_id'] ) ? esc_attr( $sections['banner_image_id'] ) : ''; ?>">
                
                <?php 
                $banner_image_id = isset( $sections['banner_image_id'] ) ? $sections['banner_image_id'] : '';
                $banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';
                ?>
                
                <?php if ( $banner_image_url ) : ?>
                    <div class="about-banner-image-preview">
                        <img id="about_banner_image_preview" src="<?php echo esc_url( $banner_image_url ); ?>" alt="Banner Image" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php else : ?>
                    <div class="about-banner-image-preview" id="about_banner_image_preview_container" style="display: none;">
                        <img id="about_banner_image_preview" src="" alt="Banner Image" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php endif; ?>
                
                <div style="margin-top: 10px;">
                    <button type="button" id="upload_about_banner_image" class="button button-primary" style="padding: 8px 15px; margin-right: 10px;">Upload Banner Image</button>
                    <?php if ( $banner_image_url ) : ?>
                        <button type="button" id="remove_about_banner_image" class="button" style="padding: 8px 15px; background: #dc3545; color: white; border: none;">Remove Image</button>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="about-section-field">
                <label>About Section - Main Text (Right Column)</label>
                <?php wp_editor( isset( $sections['about_intro_text'] ) ? $sections['about_intro_text'] : '<p class="mb-20">Maecenas imperdiet ante eget hendrerit posuere. Nunc urna libero, congue porta nibh a, semper feugiat sem. Sed auctor dui eleifend, scelerisque eros ut.</p><p>Curabitur sed iaculis dolor, non congue ligula. Maecenas imperdiet ante eget hendrerit posuere. Nunc urna libero, congue porta nibh a, semper feugiat sem. Sed auctor dui eleifend, scelerisque eros ut, pellentesque nibh. Nam lacinia suscipit accumsan. Donec sodales, neque vitae rutrum convallis, nulla tortor pharetra odio, in varius ante ante sed nisi.</p>', 'about_intro_text', array( 'textarea_name' => 'about_sections[about_intro_text]', 'media_buttons' => false, 'textarea_rows' => 5 ) ); ?>
            </div>
            <div class="about-section-field">
                <label>Projects Completed (Number)</label>
                <input type="text" name="about_sections[projects_completed]" value="<?php echo isset( $sections['projects_completed'] ) ? esc_attr( $sections['projects_completed'] ) : '352'; ?>" placeholder="352">
            </div>
            <div class="about-section-field">
                <label>Satisfied Clients (Number)</label>
                <input type="text" name="about_sections[clients_satisfied]" value="<?php echo isset( $sections['clients_satisfied'] ) ? esc_attr( $sections['clients_satisfied'] ) : '567'; ?>" placeholder="567">
            </div>
            <div class="about-section-field">
                <label>Monthly Revenue (Number with M suffix)</label>
                <input type="text" name="about_sections[monthly_revenue]" value="<?php echo isset( $sections['monthly_revenue'] ) ? esc_attr( $sections['monthly_revenue'] ) : '656'; ?>" placeholder="656">
            </div>
            <div class="about-section-field">
                <label>Awards Won (Number)</label>
                <input type="text" name="about_sections[awards_won]" value="<?php echo isset( $sections['awards_won'] ) ? esc_attr( $sections['awards_won'] ) : '17'; ?>" placeholder="17">
            </div>
        </div>

        <!-- Tab 1b: Profile / Vision / Mission -->
        <div class="about-tabs-content" id="about-pvm">
            <div class="about-section-field">
                <label>Profile Box Title</label>
                <input type="text" name="about_sections[pvm_profile_title]" value="<?php echo isset( $sections['pvm_profile_title'] ) ? esc_attr( $sections['pvm_profile_title'] ) : 'Profile'; ?>" placeholder="Profile">
            </div>
            <div class="about-section-field">
                <label>Profile Box Description</label>
                <textarea name="about_sections[pvm_profile_desc]" rows="3" placeholder="Short description for the Profile box."><?php echo isset( $sections['pvm_profile_desc'] ) ? esc_textarea( $sections['pvm_profile_desc'] ) : ''; ?></textarea>
            </div>

            <div class="about-section-field">
                <label>Vision Box Title</label>
                <input type="text" name="about_sections[pvm_vision_title]" value="<?php echo isset( $sections['pvm_vision_title'] ) ? esc_attr( $sections['pvm_vision_title'] ) : 'Vision'; ?>" placeholder="Vision">
            </div>
            <div class="about-section-field">
                <label>Vision Box Description</label>
                <textarea name="about_sections[pvm_vision_desc]" rows="3" placeholder="Short description for the Vision box."><?php echo isset( $sections['pvm_vision_desc'] ) ? esc_textarea( $sections['pvm_vision_desc'] ) : ''; ?></textarea>
            </div>

            <div class="about-section-field">
                <label>Mission Box Title</label>
                <input type="text" name="about_sections[pvm_mission_title]" value="<?php echo isset( $sections['pvm_mission_title'] ) ? esc_attr( $sections['pvm_mission_title'] ) : 'Mission'; ?>" placeholder="Mission">
            </div>
            <div class="about-section-field">
                <label>Mission Box Description</label>
                <textarea name="about_sections[pvm_mission_desc]" rows="3" placeholder="Short description for the Mission box."><?php echo isset( $sections['pvm_mission_desc'] ) ? esc_textarea( $sections['pvm_mission_desc'] ) : ''; ?></textarea>
            </div>
        </div>

        <!-- Tab 2: Services -->
        <div class="about-tabs-content" id="about-services">
            <div class="about-section-field">
                <a href="<?php echo admin_url( 'post-new.php?post_type=service' ); ?>" class="button button-primary" style="display: inline-block; padding: 10px 20px; text-decoration: none; background: #0073aa; color: white; border-radius: 4px; margin-bottom: 20px;">+ Add New Service</a>
            </div>
            <?php 
            $services_bg_image_id  = isset( $sections['services_bg_image_id'] ) ? intval( $sections['services_bg_image_id'] ) : 0;
            $services_bg_image_url = $services_bg_image_id ? wp_get_attachment_url( $services_bg_image_id ) : '';
            ?>
            <div class="about-section-field">
                <label>Services Section Background Image</label>
                <input type="hidden" id="services_bg_image_id" name="about_sections[services_bg_image_id]" value="<?php echo esc_attr( $services_bg_image_id ); ?>">

                <?php if ( $services_bg_image_url ) : ?>
                    <div class="about-banner-image-preview" id="services_bg_image_preview_container">
                        <img id="services_bg_image_preview" src="<?php echo esc_url( $services_bg_image_url ); ?>" alt="Services Background" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php else : ?>
                    <div class="about-banner-image-preview" id="services_bg_image_preview_container" style="display: none;">
                        <img id="services_bg_image_preview" src="" alt="Services Background" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php endif; ?>

                <div style="margin-top: 10px;">
                    <button type="button" id="upload_services_bg_image" class="button button-primary" style="padding: 8px 15px; margin-right: 10px;">Upload Background Image</button>
                    <button type="button" id="remove_services_bg_image" class="button" style="padding: 8px 15px; background: #dc3545; color: white; border: none;<?php echo $services_bg_image_url ? '' : ' display:none;'; ?>">Remove Image</button>
                </div>
            </div>

            <div class="about-section-field">
                <label>Services Video URL</label>
                <input type="text" name="about_sections[services_video_url]" value="<?php echo isset( $sections['services_video_url'] ) ? esc_attr( $sections['services_video_url'] ) : 'https://youtu.be/AzwC6umvd1s'; ?>" placeholder="https://"> 
            </div>
        </div>

        <!-- Tab 3: Skills -->
        <div class="about-tabs-content" id="about-skills">
            <div class="about-section-field">
                <label>Skills Section - Title</label>
                <input type="text" name="about_sections[skills_title]" value="<?php echo isset( $sections['skills_title'] ) ? esc_attr( $sections['skills_title'] ) : 'Providing Customized Design Solutions That Fits Every Space .'; ?>" placeholder="Skills Title">
            </div>
            <div class="about-section-field">
                <label>Skills Section - Description</label>
                <?php wp_editor( isset( $sections['skills_desc'] ) ? $sections['skills_desc'] : 'Beyond more stoic this along goodness hey this this wow ipsum manate far impressive manifest farcrud opened inside. Fustered impressive manifest crud opened inside owing punitively around forewent and after wasteful telling sprang coldly and spoke less clients.', 'skills_desc', array( 'textarea_name' => 'about_sections[skills_desc]', 'media_buttons' => false, 'textarea_rows' => 5 ) ); ?>
            </div>
            <?php 
            $default_skills = array(
                1 => array( 'name' => 'Architecture', 'percent' => '90%' ),
                2 => array( 'name' => 'Interior Design', 'percent' => '75%' ),
                3 => array( 'name' => '3D Modeling', 'percent' => '80%' ),
            );
            for ( $i = 1; $i <= 3; $i++ ) : 
            $default = isset( $default_skills[ $i ] ) ? $default_skills[ $i ] : array( 'name' => '', 'percent' => '' );
            ?>
                <div class="about-section-field">
                    <label>Skill <?php echo $i; ?> - Name</label>
                    <input type="text" name="about_sections[skill_<?php echo $i; ?>_name]" value="<?php echo isset( $sections['skill_' . $i . '_name'] ) ? esc_attr( $sections['skill_' . $i . '_name'] ) : esc_attr( $default['name'] ); ?>" placeholder="<?php echo esc_attr( $default['name'] ); ?>">
                </div>
                <div class="about-section-field">
                    <label>Skill <?php echo $i; ?> - Percentage</label>
                    <input type="text" name="about_sections[skill_<?php echo $i; ?>_percent]" value="<?php echo isset( $sections['skill_' . $i . '_percent'] ) ? esc_attr( $sections['skill_' . $i . '_percent'] ) : esc_attr( $default['percent'] ); ?>" placeholder="<?php echo esc_attr( $default['percent'] ); ?>">
                </div>
            <?php endfor; ?>
        </div>

        <!-- Tab 4: Testimonials -->
        <div class="about-tabs-content" id="about-testimonials">
            <div class="about-section-field">
                <label>Testimonials Section - Show/Hide</label>
                <input type="checkbox" name="about_sections[show_testimonials]" value="1" <?php echo ( !isset( $sections['show_testimonials'] ) || $sections['show_testimonials'] ) ? 'checked' : ''; ?>> Show Testimonials Section
            </div>
            <?php 
            $testimonials_bg_image_id  = isset( $sections['testimonials_bg_image_id'] ) ? intval( $sections['testimonials_bg_image_id'] ) : 0;
            $testimonials_bg_image_url = $testimonials_bg_image_id ? wp_get_attachment_url( $testimonials_bg_image_id ) : '';
            ?>
            <div class="about-section-field">
                <label>Testimonials Background Image</label>
                <input type="hidden" id="testimonials_bg_image_id" name="about_sections[testimonials_bg_image_id]" value="<?php echo esc_attr( $testimonials_bg_image_id ); ?>">

                <?php if ( $testimonials_bg_image_url ) : ?>
                    <div class="about-banner-image-preview" id="testimonials_bg_image_preview_container">
                        <img id="testimonials_bg_image_preview" src="<?php echo esc_url( $testimonials_bg_image_url ); ?>" alt="Testimonials Background" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php else : ?>
                    <div class="about-banner-image-preview" id="testimonials_bg_image_preview_container" style="display: none;">
                        <img id="testimonials_bg_image_preview" src="" alt="Testimonials Background" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php endif; ?>

                <div style="margin-top: 10px;">
                    <button type="button" id="upload_testimonials_bg_image" class="button button-primary" style="padding: 8px 15px; margin-right: 10px;">Upload Background Image</button>
                    <button type="button" id="remove_testimonials_bg_image" class="button" style="padding: 8px 15px; background: #dc3545; color: white; border: none;<?php echo $testimonials_bg_image_url ? '' : ' display:none;'; ?>">Remove Image</button>
                </div>
            </div>
            <div class="about-section-field">
                <a href="<?php echo admin_url( 'post-new.php?post_type=testimonial' ); ?>" class="button button-primary" style="display: inline-block; padding: 8px 16px; text-decoration: none; background: #0073aa; color: white; border-radius: 4px;">+ Add New Testimonial</a>
            </div>
        </div>
        
        <!-- Tab 5: Our Employees -->
        <div class="about-tabs-content" id="about-employees">
            <div class="about-section-field">
                <label>Section Title</label>
                <input type="text" name="about_sections[employees_title]" value="<?php echo isset( $sections['employees_title'] ) ? esc_attr( $sections['employees_title'] ) : 'Our Employees'; ?>" placeholder="Our Employees">
            </div>
            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <?php 
                $employee_image_id  = isset( $sections['employee_' . $i . '_image_id'] ) ? intval( $sections['employee_' . $i . '_image_id'] ) : 0;
                $employee_image_url = $employee_image_id ? wp_get_attachment_url( $employee_image_id ) : '';
                ?>
                <div class="about-section-field" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <strong>Employee <?php echo $i; ?></strong>
                </div>
                <div class="about-section-field">
                    <label>Name</label>
                    <input type="text" name="about_sections[employee_<?php echo $i; ?>_name]" value="<?php echo isset( $sections['employee_' . $i . '_name'] ) ? esc_attr( $sections['employee_' . $i . '_name'] ) : ''; ?>" placeholder="Employee name">
                </div>
                <div class="about-section-field">
                    <label>Position / Role</label>
                    <input type="text" name="about_sections[employee_<?php echo $i; ?>_role]" value="<?php echo isset( $sections['employee_' . $i . '_role'] ) ? esc_attr( $sections['employee_' . $i . '_role'] ) : ''; ?>" placeholder="e.g., General Manager">
                </div>
                <div class="about-section-field">
                    <label>Photo</label>
                    <input type="hidden" id="employee_<?php echo $i; ?>_image_id" name="about_sections[employee_<?php echo $i; ?>_image_id]" value="<?php echo esc_attr( $employee_image_id ); ?>">

                    <?php if ( $employee_image_url ) : ?>
                        <div class="about-banner-image-preview" id="employee_<?php echo $i; ?>_image_preview_container">
                            <img id="employee_<?php echo $i; ?>_image_preview" src="<?php echo esc_url( $employee_image_url ); ?>" alt="Employee <?php echo $i; ?>" style="max-width: 150px; height: auto; border-radius: 4px; margin-top: 10px;">
                        </div>
                    <?php else : ?>
                        <div class="about-banner-image-preview" id="employee_<?php echo $i; ?>_image_preview_container" style="display: none;">
                            <img id="employee_<?php echo $i; ?>_image_preview" src="" alt="Employee <?php echo $i; ?>" style="max-width: 150px; height: auto; border-radius: 4px; margin-top: 10px;">
                        </div>
                    <?php endif; ?>

                    <div style="margin-top: 10px;">
                        <button type="button" class="button button-secondary upload-employee-image" data-employee="<?php echo $i; ?>" style="padding: 6px 12px;">Upload Photo</button>
                        <button type="button" class="button remove-employee-image" id="remove_employee_<?php echo $i; ?>_image" data-employee="<?php echo $i; ?>" style="padding: 6px 12px; background: #dc3545; color: white; border: none; margin-left: 5px;<?php echo $employee_image_url ? '' : ' display:none;'; ?>">Remove Photo</button>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.about-tab-btn');
            const contents = document.querySelectorAll('.about-tabs-content');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');
                    
                    buttons.forEach(b => b.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));
                    
                    this.classList.add('active');
                    document.getElementById(tabName).classList.add('active');
                });
            });
        })();
        
        // Banner & other image uploads for About page
        (function($) {
            var mediaUploader;
            
            $('#upload_about_banner_image').click(function(e) {
                e.preventDefault();
                
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Banner Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#about_banner_image_id').val(attachment.id);
                    $('#about_banner_image_preview').attr('src', attachment.url);
                    $('#about_banner_image_preview_container').show();
                    if (!$('#remove_about_banner_image').length) {
                        $('#upload_about_banner_image').after('<button type="button" id="remove_about_banner_image" class="button" style="padding: 8px 15px; background: #dc3545; color: white; border: none; margin-left: 10px;">Remove Image</button>');
                    }
                    $('#remove_about_banner_image').show();
                });
                
                mediaUploader.open();
            });
            
            $(document).on('click', '#remove_about_banner_image', function(e) {
                e.preventDefault();
                $('#about_banner_image_id').val('');
                $('#about_banner_image_preview_container').hide();
                $(this).hide();
            });

            // Testimonials background image upload
            $('#upload_testimonials_bg_image').click(function(e) {
                e.preventDefault();

                var frame = wp.media({
                    title: 'Select Testimonials Background Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#testimonials_bg_image_id').val(attachment.id);
                    $('#testimonials_bg_image_preview').attr('src', attachment.url);
                    $('#testimonials_bg_image_preview_container').show();
                    $('#remove_testimonials_bg_image').show();
                });

                frame.open();
            });

            $('#remove_testimonials_bg_image').click(function(e) {
                e.preventDefault();
                $('#testimonials_bg_image_id').val('');
                $('#testimonials_bg_image_preview_container').hide();
                $(this).hide();
            });

            // Services background image upload
            $('#upload_services_bg_image').click(function(e) {
                e.preventDefault();

                var frame = wp.media({
                    title: 'Select Services Background Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#services_bg_image_id').val(attachment.id);
                    $('#services_bg_image_preview').attr('src', attachment.url);
                    $('#services_bg_image_preview_container').show();
                    $('#remove_services_bg_image').show();
                });

                frame.open();
            });

            $('#remove_services_bg_image').click(function(e) {
                e.preventDefault();
                $('#services_bg_image_id').val('');
                $('#services_bg_image_preview_container').hide();
                $(this).hide();
            });

            // Employee photos upload
            $(document).on('click', '.upload-employee-image', function(e) {
                e.preventDefault();

                var employeeIndex = $(this).data('employee');
                var imageField    = $('#employee_' + employeeIndex + '_image_id');
                var previewImg    = $('#employee_' + employeeIndex + '_image_preview');
                var previewWrap   = $('#employee_' + employeeIndex + '_image_preview_container');
                var removeBtn     = $('#remove_employee_' + employeeIndex + '_image');

                var frame = wp.media({
                    title: 'Select Employee Photo',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    imageField.val(attachment.id);
                    previewImg.attr('src', attachment.url);
                    previewWrap.show();
                    removeBtn.show();
                });

                frame.open();
            });

            $(document).on('click', '.remove-employee-image', function(e) {
                e.preventDefault();
                var employeeIndex = $(this).data('employee');
                $('#employee_' + employeeIndex + '_image_id').val('');
                $('#employee_' + employeeIndex + '_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save About page metabox
function spaceengineers_save_about_metabox( $post_id ) {
    if ( !isset( $_POST['spaceengineers_about_nonce_field'] ) || 
         !wp_verify_nonce( $_POST['spaceengineers_about_nonce_field'], 'spaceengineers_about_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['about_sections'] ) ) {
        $sections = array();
        foreach ( $_POST['about_sections'] as $key => $value ) {
            if ( $key === 'banner_image_id' || $key === 'testimonials_bg_image_id' || $key === 'services_bg_image_id' || preg_match( '/^employee_\\d+_image_id$/', $key ) ) {
                // Sanitize image IDs as integers
                $sections[ $key ] = ! empty( $value ) ? intval( $value ) : '';
            } elseif ( is_array( $value ) ) {
                $sections[ $key ] = array_map( 'sanitize_text_field', $value );
            } else {
                $sections[ $key ] = sanitize_text_field( $value );
            }
        }
        update_post_meta( $post_id, '_about_sections', $sections );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_about_metabox' );

// ===================== BLOG PAGE METABOX =====================

// Add Blog Page Metabox
function spaceengineers_register_blog_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'blog' ) {
            add_meta_box(
                'spaceengineers_blog_banner',
                'Blog Page Banner',
                'spaceengineers_blog_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_blog_metabox' );

// Blog Page Metabox Callback
function spaceengineers_blog_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_blog_nonce', 'spaceengineers_blog_nonce_field' );

    $banner_title = get_post_meta( $post->ID, '_blog_banner_title', true );
    if ( ! $banner_title ) {
        $banner_title = 'Our Blog';
    }

    $banner_image_id  = get_post_meta( $post->ID, '_blog_banner_image_id', true );
    $banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';
    ?>
    <style>
        .blog-banner-field {
            margin-bottom: 20px;
        }
        .blog-banner-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .blog-banner-field input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .blog-banner-note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }
        .blog-banner-image-preview {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .blog-banner-image-preview img {
            max-width: 300px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .blog-banner-image-buttons {
            margin-top: 10px;
        }
        .blog-banner-image-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .blog-banner-image-buttons button:hover {
            background: #005a87;
        }
        .blog-banner-image-buttons .remove-btn {
            background: #dc3545;
        }
        .blog-banner-image-buttons .remove-btn:hover {
            background: #c82333;
        }
    </style>

    <div class="blog-banner-note">
        <strong>Note:</strong> Customize the blog page banner title and image below. Use the button at the bottom to quickly add a new blog post.
    </div>

    <div class="blog-banner-field">
        <label for="blog_banner_title">Banner Title</label>
        <input type="text" id="blog_banner_title" name="blog_banner_title" value="<?php echo esc_attr( $banner_title ); ?>" placeholder="e.g., Our Blog">
    </div>

    <div class="blog-banner-field">
        <label>Banner Image</label>
        <input type="hidden" id="blog_banner_image_id" name="blog_banner_image_id" value="<?php echo esc_attr( $banner_image_id ); ?>">

        <?php if ( $banner_image_url ) : ?>
            <div class="blog-banner-image-preview">
                <img id="blog_banner_image_preview" src="<?php echo esc_url( $banner_image_url ); ?>" alt="Banner Image">
            </div>
        <?php else : ?>
            <div class="blog-banner-image-preview" id="blog_banner_image_preview_container" style="display: none;">
                <img id="blog_banner_image_preview" src="" alt="Banner Image">
            </div>
        <?php endif; ?>

        <div class="blog-banner-image-buttons">
            <button type="button" id="upload_blog_banner_image">Upload Banner Image</button>
            <?php if ( $banner_image_url ) : ?>
                <button type="button" id="remove_blog_banner_image" class="remove-btn">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="blog-banner-field" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="button button-primary" style="display: inline-block; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
            + Add New Blog Post
        </a>
    </div>

    <script>
        (function($) {
            var mediaUploader;

            $('#upload_blog_banner_image').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Banner Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#blog_banner_image_id').val(attachment.id);
                    $('#blog_banner_image_preview').attr('src', attachment.url);
                    $('#blog_banner_image_preview_container').show();
                    $('#remove_blog_banner_image').show();
                });

                mediaUploader.open();
            });

            $('#remove_blog_banner_image').click(function(e) {
                e.preventDefault();
                $('#blog_banner_image_id').val('');
                $('#blog_banner_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Blog Page Metabox
function spaceengineers_save_blog_metabox( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'page' || $post->post_name !== 'blog' ) {
        return;
    }

    if ( ! isset( $_POST['spaceengineers_blog_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_blog_nonce_field'], 'spaceengineers_blog_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['blog_banner_title'] ) ) {
        update_post_meta( $post_id, '_blog_banner_title', sanitize_text_field( $_POST['blog_banner_title'] ) );
    }

    if ( isset( $_POST['blog_banner_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['blog_banner_image_id'] );
        if ( ! empty( $image_id ) ) {
            update_post_meta( $post_id, '_blog_banner_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_blog_banner_image_id' );
        }
    }
}
add_action( 'save_post_page', 'spaceengineers_save_blog_metabox' );

// ===================== CONTACT PAGE METABOX (TABS) =====================

// Add Contact Page Metabox
function spaceengineers_register_contact_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'contact' ) {
            add_meta_box(
                'spaceengineers_contact_sections',
                'Contact Page Sections',
                'spaceengineers_contact_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_contact_metabox' );

// Metabox callback for Contact page - Tabs for sections
function spaceengineers_contact_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_contact_nonce', 'spaceengineers_contact_nonce_field' );

    $sections = get_post_meta( $post->ID, '_contact_sections', true );
    if ( ! is_array( $sections ) ) {
        $sections = array();
    }

    $default_banner_title   = 'Contact Us';
    $default_banner_subtext = "We'd love to hear from you. Send us a message and we'll respond as soon as possible.";

    $banner_image_id  = isset( $sections['banner_image_id'] ) ? intval( $sections['banner_image_id'] ) : 0;
    $banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';
    ?>
    <style>
        .contact-tabs-container {
            margin-top: 20px;
        }
        .contact-tabs-nav {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 20px;
        }
        .contact-tabs-nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }
        .contact-tabs-nav button.active {
            color: #333;
            border-bottom-color: #0066cc;
        }
        .contact-tabs-content {
            display: none;
        }
        .contact-tabs-content.active {
            display: block;
        }
        .contact-section-field {
            margin-bottom: 20px;
        }
        .contact-section-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .contact-section-field input[type="text"],
        .contact-section-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .contact-section-field textarea {
            min-height: 80px;
        }
    </style>

    <div class="contact-tabs-container">
        <div class="contact-tabs-nav">
            <button type="button" class="contact-tab-btn active" data-tab="contact-header">Header</button>
            <button type="button" class="contact-tab-btn" data-tab="contact-info">Contact Info</button>
            <button type="button" class="contact-tab-btn" data-tab="contact-form-map">Form &amp; Map</button>
        </div>

        <!-- Header Tab -->
        <div class="contact-tabs-content active" id="contact-header">
            <div class="contact-section-field">
                <label>Banner Title</label>
                <input type="text" name="contact_sections[banner_title]" value="<?php echo isset( $sections['banner_title'] ) ? esc_attr( $sections['banner_title'] ) : esc_attr( $default_banner_title ); ?>" placeholder="Contact Us">
            </div>

            <div class="contact-section-field">
                <label>Banner Subtitle / Description</label>
                <input type="text" name="contact_sections[banner_subtitle]" value="<?php echo isset( $sections['banner_subtitle'] ) ? esc_attr( $sections['banner_subtitle'] ) : esc_attr( $default_banner_subtext ); ?>" placeholder="Short description under the title">
            </div>

            <div class="contact-section-field">
                <label>Banner Background Image</label>
                <input type="hidden" id="contact_banner_image_id" name="contact_sections[banner_image_id]" value="<?php echo esc_attr( $banner_image_id ); ?>">

                <?php if ( $banner_image_url ) : ?>
                    <div class="contact-banner-image-preview" id="contact_banner_image_preview_container">
                        <img id="contact_banner_image_preview" src="<?php echo esc_url( $banner_image_url ); ?>" alt="Banner Image" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php else : ?>
                    <div class="contact-banner-image-preview" id="contact_banner_image_preview_container" style="display: none;">
                        <img id="contact_banner_image_preview" src="" alt="Banner Image" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px;">
                    </div>
                <?php endif; ?>

                <div style="margin-top: 10px;">
                    <button type="button" id="upload_contact_banner_image" class="button button-primary" style="padding: 8px 15px; margin-right: 10px;">Upload Banner Image</button>
                    <button type="button" id="remove_contact_banner_image" class="button" style="padding: 8px 15px; background: #dc3545; color: white; border: none;<?php echo $banner_image_url ? '' : ' display:none;'; ?>">Remove Image</button>
                </div>
            </div>
        </div>

        <!-- Contact Info Tab -->
        <div class="contact-tabs-content" id="contact-info">
            <div class="contact-section-field">
                <label>Call Box Title</label>
                <input type="text" name="contact_sections[call_title]" value="<?php echo isset( $sections['call_title'] ) ? esc_attr( $sections['call_title'] ) : 'Call Us'; ?>" placeholder="Call Us">
            </div>
            <div class="contact-section-field">
                <label>Phone 1</label>
                <input type="text" name="contact_sections[call_phone_1]" value="<?php echo isset( $sections['call_phone_1'] ) ? esc_attr( $sections['call_phone_1'] ) : '+7 (111) 1234 56789'; ?>" placeholder="+7 (111) 1234 56789">
            </div>
            <div class="contact-section-field">
                <label>Phone 2</label>
                <input type="text" name="contact_sections[call_phone_2]" value="<?php echo isset( $sections['call_phone_2'] ) ? esc_attr( $sections['call_phone_2'] ) : '+1 (000) 9876 54321'; ?>" placeholder="+1 (000) 9876 54321">
            </div>

            <hr />

            <div class="contact-section-field">
                <label>Email Box Title</label>
                <input type="text" name="contact_sections[email_title]" value="<?php echo isset( $sections['email_title'] ) ? esc_attr( $sections['email_title'] ) : 'Email Us'; ?>" placeholder="Email Us">
            </div>
            <div class="contact-section-field">
                <label>Email 1</label>
                <input type="text" name="contact_sections[email_1]" value="<?php echo isset( $sections['email_1'] ) ? esc_attr( $sections['email_1'] ) : 'contact@Archo.com'; ?>" placeholder="contact@example.com">
            </div>
            <div class="contact-section-field">
                <label>Email 2</label>
                <input type="text" name="contact_sections[email_2]" value="<?php echo isset( $sections['email_2'] ) ? esc_attr( $sections['email_2'] ) : 'Username@website.com'; ?>" placeholder="second@example.com">
            </div>

            <hr />

            <div class="contact-section-field">
                <label>Address Box Title</label>
                <input type="text" name="contact_sections[address_title]" value="<?php echo isset( $sections['address_title'] ) ? esc_attr( $sections['address_title'] ) : 'Address'; ?>" placeholder="Address">
            </div>
            <div class="contact-section-field">
                <label>Address Text</label>
                <textarea name="contact_sections[address_text]" placeholder="Full address"><?php echo isset( $sections['address_text'] ) ? esc_textarea( $sections['address_text'] ) : 'B17 Princess Road, London, Greater London NW18JR, United Kingdom'; ?></textarea>
            </div>
        </div>

        <!-- Form & Map Tab -->
        <div class="contact-tabs-content" id="contact-form-map">
            <div class="contact-section-field">
                <label>Form Section Title</label>
                <input type="text" name="contact_sections[form_title]" value="<?php echo isset( $sections['form_title'] ) ? esc_attr( $sections['form_title'] ) : 'Send us a message'; ?>" placeholder="Send us a message">
            </div>
            <div class="contact-section-field">
                <label>Form Section Description (optional)</label>
                <textarea name="contact_sections[form_description]" placeholder="Short text above the form"><?php echo isset( $sections['form_description'] ) ? esc_textarea( $sections['form_description'] ) : ''; ?></textarea>
            </div>
            <div class="contact-section-field">
                <label>Contact Form 7 Shortcode (optional)</label>
                <input type="text" name="contact_sections[form_shortcode]" value="<?php echo isset( $sections['form_shortcode'] ) ? esc_attr( $sections['form_shortcode'] ) : ''; ?>" placeholder="[contact-form-7 id=&quot;123&quot; title=&quot;Contact form 1&quot;]">
                <p style="font-size: 12px; color: #666; margin-top: 5px;">Paste your Contact Form 7 shortcode here. If empty, the page content will be shown instead.</p>
            </div>
            <div class="contact-section-field">
                <label>Map Embed Code (optional)</label>
                <textarea name="contact_sections[map_embed]" placeholder="Paste Google Maps iframe or embed code here"><?php echo isset( $sections['map_embed'] ) ? esc_textarea( $sections['map_embed'] ) : ''; ?></textarea>
                <p style="font-size: 12px; color: #666; margin-top: 5px;">If left empty, the default theme map container (with ID <code>ieatmaps</code>) will be used.</p>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.contact-tab-btn');
            const contents = document.querySelectorAll('.contact-tabs-content');

            buttons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');

                    buttons.forEach(function(b) { b.classList.remove('active'); });
                    contents.forEach(function(c) { c.classList.remove('active'); });

                    this.classList.add('active');
                    document.getElementById(tabName).classList.add('active');
                });
            });
        })();

        (function($) {
            // Contact banner image upload
            $('#upload_contact_banner_image').on('click', function(e) {
                e.preventDefault();

                var frame = wp.media({
                    title: 'Select Banner Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#contact_banner_image_id').val(attachment.id);
                    $('#contact_banner_image_preview').attr('src', attachment.url);
                    $('#contact_banner_image_preview_container').show();
                    $('#remove_contact_banner_image').show();
                });

                frame.open();
            });

            $('#remove_contact_banner_image').on('click', function(e) {
                e.preventDefault();
                $('#contact_banner_image_id').val('');
                $('#contact_banner_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Contact page metabox
function spaceengineers_save_contact_metabox( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'page' || $post->post_name !== 'contact' ) {
        return;
    }

    if ( ! isset( $_POST['spaceengineers_contact_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_contact_nonce_field'], 'spaceengineers_contact_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['contact_sections'] ) && is_array( $_POST['contact_sections'] ) ) {
        $sections = array();

        foreach ( $_POST['contact_sections'] as $key => $value ) {
            if ( $key === 'banner_image_id' ) {
                $sections[ $key ] = ! empty( $value ) ? intval( $value ) : '';
            } elseif ( $key === 'map_embed' ) {
                $sections[ $key ] = wp_kses_post( $value );
            } elseif ( is_array( $value ) ) {
                $sections[ $key ] = array_map( 'sanitize_text_field', $value );
            } else {
                $sections[ $key ] = sanitize_text_field( $value );
            }
        }

        update_post_meta( $post_id, '_contact_sections', $sections );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_contact_metabox' );

// ===================== SINGLE BLOG IMAGE METABOX =====================

// Add Single Blog Image Metabox for posts
function spaceengineers_add_post_image_metabox() {
    add_meta_box(
        'spaceengineers_post_image',
        'Single Blog Image',
        'spaceengineers_post_image_metabox_callback',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes_post', 'spaceengineers_add_post_image_metabox' );

function spaceengineers_post_image_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_post_image_nonce', 'spaceengineers_post_image_nonce_field' );

    $image_id  = get_post_meta( $post->ID, '_blog_single_image_id', true );
    $image_url = $image_id ? wp_get_attachment_url( $image_id ) : '';
    ?>
    <style>
        .se-post-image-field {
            margin-bottom: 15px;
        }
        .se-post-image-preview {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .se-post-image-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .se-post-image-buttons button {
            margin-right: 8px;
        }
    </style>

    <div class="se-post-image-field">
        <p>Upload an image to use on the single blog page. This is separate from the Featured image.</p>
        <input type="hidden" id="se_post_image_id" name="se_post_image_id" value="<?php echo esc_attr( $image_id ); ?>">

        <?php if ( $image_url ) : ?>
            <div class="se-post-image-preview">
                <img id="se_post_image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="Single Blog Image">
            </div>
        <?php else : ?>
            <div class="se-post-image-preview" id="se_post_image_preview_container" style="display: none;">
                <img id="se_post_image_preview" src="" alt="Single Blog Image">
            </div>
        <?php endif; ?>

        <div class="se-post-image-buttons">
            <button type="button" class="button" id="se_upload_post_image">Upload Image</button>
            <?php if ( $image_url ) : ?>
                <button type="button" class="button" id="se_remove_post_image">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        (function($) {
            var mediaUploader;

            $('#se_upload_post_image').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#se_post_image_id').val(attachment.id);
                    $('#se_post_image_preview').attr('src', attachment.url);
                    $('#se_post_image_preview_container').show();
                    $('#se_remove_post_image').show();
                });

                mediaUploader.open();
            });

            $('#se_remove_post_image').click(function(e) {
                e.preventDefault();
                $('#se_post_image_id').val('');
                $('#se_post_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

function spaceengineers_save_post_image_metabox( $post_id ) {
    if ( ! isset( $_POST['spaceengineers_post_image_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_post_image_nonce_field'], 'spaceengineers_post_image_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['se_post_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['se_post_image_id'] );
        if ( ! empty( $image_id ) ) {
            update_post_meta( $post_id, '_blog_single_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_blog_single_image_id' );
        }
    }
}
add_action( 'save_post_post', 'spaceengineers_save_post_image_metabox' );

// ===================== SERVICES PAGE METABOX =====================

// Add Services Page Metabox
function spaceengineers_register_services_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'services' ) {
            add_meta_box(
                'spaceengineers_services_banner',
                'Services Page Banner',
                'spaceengineers_services_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_services_metabox' );

// Services Page Metabox Callback
function spaceengineers_services_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_services_nonce', 'spaceengineers_services_nonce_field' );
    
    $banner_title = get_post_meta( $post->ID, '_services_banner_title', true );
    if ( !$banner_title ) {
        $banner_title = 'Services';
    }
    
    $banner_image_id = get_post_meta( $post->ID, '_services_banner_image_id', true );
    $banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';
    
    $section_subtitle = get_post_meta( $post->ID, '_services_section_subtitle', true );
    if ( !$section_subtitle ) {
        $section_subtitle = 'Best Features';
    }
    
    $section_title = get_post_meta( $post->ID, '_services_section_title', true );
    if ( !$section_title ) {
        $section_title = 'Our Services';
    }
    ?>
    <style>
        .services-banner-field {
            margin-bottom: 20px;
        }
        .services-banner-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .services-banner-field input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .services-banner-note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }
        .services-banner-image-preview {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .services-banner-image-preview img {
            max-width: 300px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .services-banner-image-buttons {
            margin-top: 10px;
        }
        .services-banner-image-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .services-banner-image-buttons button:hover {
            background: #005a87;
        }
        .services-banner-image-buttons .remove-btn {
            background: #dc3545;
        }
        .services-banner-image-buttons .remove-btn:hover {
            background: #c82333;
        }
    </style>

    <div class="services-banner-note">
        <strong>Note:</strong> Customize the banner title, image, and services section headings.
    </div>

    <div class="services-banner-field">
        <label for="services_banner_title">Banner Title</label>
        <input type="text" id="services_banner_title" name="services_banner_title" value="<?php echo esc_attr( $banner_title ); ?>" placeholder="e.g., Services">
    </div>

    <div class="services-banner-field">
        <label>Banner Image</label>
        <input type="hidden" id="services_banner_image_id" name="services_banner_image_id" value="<?php echo esc_attr( $banner_image_id ); ?>">
        
        <?php if ( $banner_image_url ) : ?>
            <div class="services-banner-image-preview">
                <img id="services_banner_image_preview" src="<?php echo esc_url( $banner_image_url ); ?>" alt="Banner Image">
            </div>
        <?php else : ?>
            <div class="services-banner-image-preview" id="services_banner_image_preview_container" style="display: none;">
                <img id="services_banner_image_preview" src="" alt="Banner Image">
            </div>
        <?php endif; ?>
        
        <div class="services-banner-image-buttons">
            <button type="button" id="upload_services_banner_image">Upload Banner Image</button>
            <?php if ( $banner_image_url ) : ?>
                <button type="button" id="remove_services_banner_image" class="remove-btn">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="services-banner-field">
        <label for="services_section_subtitle">Section Subtitle</label>
        <input type="text" id="services_section_subtitle" name="services_section_subtitle" value="<?php echo esc_attr( $section_subtitle ); ?>" placeholder="e.g., Best Features">
    </div>

    <div class="services-banner-field">
        <label for="services_section_title">Section Title</label>
        <input type="text" id="services_section_title" name="services_section_title" value="<?php echo esc_attr( $section_title ); ?>" placeholder="e.g., Our Services">
    </div>

    <div class="services-banner-field" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=service' ) ); ?>" class="button button-primary" style="display: inline-block; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
            + Add New Service
        </a>
    </div>

    <script>
        (function($) {
            var mediaUploader;
            
            $('#upload_services_banner_image').click(function(e) {
                e.preventDefault();
                
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Banner Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#services_banner_image_id').val(attachment.id);
                    $('#services_banner_image_preview').attr('src', attachment.url);
                    $('#services_banner_image_preview_container').show();
                    $('#remove_services_banner_image').show();
                });
                
                mediaUploader.open();
            });
            
            $('#remove_services_banner_image').click(function(e) {
                e.preventDefault();
                $('#services_banner_image_id').val('');
                $('#services_banner_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Services Page Metabox
function spaceengineers_save_services_metabox( $post_id ) {
    $post = get_post( $post_id );
    if ( !$post || $post->post_name !== 'services' ) {
        return;
    }

    if ( !isset( $_POST['spaceengineers_services_nonce_field'] ) || 
         !wp_verify_nonce( $_POST['spaceengineers_services_nonce_field'], 'spaceengineers_services_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['services_banner_title'] ) ) {
        update_post_meta( $post_id, '_services_banner_title', sanitize_text_field( $_POST['services_banner_title'] ) );
    }

    if ( isset( $_POST['services_banner_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['services_banner_image_id'] );
        if ( !empty( $image_id ) ) {
            update_post_meta( $post_id, '_services_banner_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_services_banner_image_id' );
        }
    }

    if ( isset( $_POST['services_section_subtitle'] ) ) {
        update_post_meta( $post_id, '_services_section_subtitle', sanitize_text_field( $_POST['services_section_subtitle'] ) );
    }

    if ( isset( $_POST['services_section_title'] ) ) {
        update_post_meta( $post_id, '_services_section_title', sanitize_text_field( $_POST['services_section_title'] ) );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_services_metabox' );

// ===================== PROJECTS PAGE METABOX =====================

// Add Projects Page Metabox
function spaceengineers_register_projects_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'projects' ) {
            add_meta_box(
                'spaceengineers_projects_banner',
                'Projects Page Banner',
                'spaceengineers_projects_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_projects_metabox' );

// Projects Page Metabox Callback
function spaceengineers_projects_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_projects_nonce', 'spaceengineers_projects_nonce_field' );

    $banner_title = get_post_meta( $post->ID, '_projects_banner_title', true );
    if ( ! $banner_title ) {
        $banner_title = 'Projects';
    }

    $banner_image_id  = get_post_meta( $post->ID, '_projects_banner_image_id', true );
    $banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';

    $section_subtitle = get_post_meta( $post->ID, '_projects_section_subtitle', true );
    if ( ! $section_subtitle ) {
        $section_subtitle = 'Our Work';
    }

    $section_title = get_post_meta( $post->ID, '_projects_section_title', true );
    if ( ! $section_title ) {
        $section_title = 'Featured Projects';
    }
    ?>
    <style>
        .projects-banner-field {
            margin-bottom: 20px;
        }
        .projects-banner-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .projects-banner-field input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .projects-banner-note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }
        .projects-banner-image-preview {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .projects-banner-image-preview img {
            max-width: 300px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .projects-banner-image-buttons {
            margin-top: 10px;
        }
        .projects-banner-image-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .projects-banner-image-buttons button:hover {
            background: #005a87;
        }
        .projects-banner-image-buttons .remove-btn {
            background: #dc3545;
        }
        .projects-banner-image-buttons .remove-btn:hover {
            background: #c82333;
        }
    </style>

    <div class="projects-banner-note">
        <strong>Note:</strong> Customize the banner title, image, and projects section headings.
    </div>

    <div class="projects-banner-field">
        <label for="projects_banner_title">Banner Title</label>
        <input type="text" id="projects_banner_title" name="projects_banner_title" value="<?php echo esc_attr( $banner_title ); ?>" placeholder="e.g., Projects">
    </div>

    <div class="projects-banner-field">
        <label>Banner Image</label>
        <input type="hidden" id="projects_banner_image_id" name="projects_banner_image_id" value="<?php echo esc_attr( $banner_image_id ); ?>">

        <?php if ( $banner_image_url ) : ?>
            <div class="projects-banner-image-preview">
                <img id="projects_banner_image_preview" src="<?php echo esc_url( $banner_image_url ); ?>" alt="Banner Image">
            </div>
        <?php else : ?>
            <div class="projects-banner-image-preview" id="projects_banner_image_preview_container" style="display: none;">
                <img id="projects_banner_image_preview" src="" alt="Banner Image">
            </div>
        <?php endif; ?>

        <div class="projects-banner-image-buttons">
            <button type="button" id="upload_projects_banner_image">Upload Banner Image</button>
            <?php if ( $banner_image_url ) : ?>
                <button type="button" id="remove_projects_banner_image" class="remove-btn">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="projects-banner-field">
        <label for="projects_section_subtitle">Section Subtitle</label>
        <input type="text" id="projects_section_subtitle" name="projects_section_subtitle" value="<?php echo esc_attr( $section_subtitle ); ?>" placeholder="e.g., Our Work">
    </div>

    <div class="projects-banner-field">
        <label for="projects_section_title">Section Title</label>
        <input type="text" id="projects_section_title" name="projects_section_title" value="<?php echo esc_attr( $section_title ); ?>" placeholder="e.g., Featured Projects">
    </div>

    <div class="projects-banner-field" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=project' ) ); ?>" class="button button-primary" style="display: inline-block; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
            + Add New Project
        </a>
    </div>

    <script>
        (function($) {
            var mediaUploader;

            $('#upload_projects_banner_image').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Banner Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#projects_banner_image_id').val(attachment.id);
                    $('#projects_banner_image_preview').attr('src', attachment.url);
                    $('#projects_banner_image_preview_container').show();
                    $('#remove_projects_banner_image').show();
                });

                mediaUploader.open();
            });

            $('#remove_projects_banner_image').click(function(e) {
                e.preventDefault();
                $('#projects_banner_image_id').val('');
                $('#projects_banner_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Projects Page Metabox
function spaceengineers_save_projects_metabox( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_name !== 'projects' ) {
        return;
    }

    if ( ! isset( $_POST['spaceengineers_projects_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_projects_nonce_field'], 'spaceengineers_projects_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['projects_banner_title'] ) ) {
        update_post_meta( $post_id, '_projects_banner_title', sanitize_text_field( $_POST['projects_banner_title'] ) );
    }

    if ( isset( $_POST['projects_banner_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['projects_banner_image_id'] );
        if ( ! empty( $image_id ) ) {
            update_post_meta( $post_id, '_projects_banner_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_projects_banner_image_id' );
        }
    }

    if ( isset( $_POST['projects_section_subtitle'] ) ) {
        update_post_meta( $post_id, '_projects_section_subtitle', sanitize_text_field( $_POST['projects_section_subtitle'] ) );
    }

    if ( isset( $_POST['projects_section_title'] ) ) {
        update_post_meta( $post_id, '_projects_section_title', sanitize_text_field( $_POST['projects_section_title'] ) );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_projects_metabox' );


// ===================== MEDIA PAGE METABOX =====================

// Add Media Page Metabox
function spaceengineers_register_media_metabox() {
    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : 0;
    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_name === 'media' ) {
            add_meta_box(
                'spaceengineers_media_sections',
                'Media Page Settings',
                'spaceengineers_media_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action( 'add_meta_boxes', 'spaceengineers_register_media_metabox' );

// Media Page Metabox Callback (banner, gallery, video URLs)
function spaceengineers_media_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_media_nonce', 'spaceengineers_media_nonce_field' );

    $banner_title   = get_post_meta( $post->ID, '_media_banner_title', true );
    $banner_text    = get_post_meta( $post->ID, '_media_banner_text', true );
    $banner_image_id  = get_post_meta( $post->ID, '_media_banner_image_id', true );
    $banner_image_url = $banner_image_id ? wp_get_attachment_url( $banner_image_id ) : '';

    $gallery_ids_raw = get_post_meta( $post->ID, '_media_gallery_ids', true );
    $gallery_ids     = is_array( $gallery_ids_raw ) ? $gallery_ids_raw : array_filter( array_map( 'intval', explode( ',', (string) $gallery_ids_raw ) ) );

    $video_urls = get_post_meta( $post->ID, '_media_video_urls', true );
    ?>
    <style>
        .media-tabs-container { margin-top: 20px; }
        .media-tabs-nav { display: flex; border-bottom: 2px solid #e0e0e0; margin-bottom: 20px; }
        .media-tabs-nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }
        .media-tabs-nav button.active { color: #333; border-bottom-color: #0066cc; }
        .media-tabs-content { display: none; }
        .media-tabs-content.active { display: block; }
        .media-section-field { margin-bottom: 20px; }
        .media-section-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .media-section-field input[type="text"],
        .media-section-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .media-section-field textarea { min-height: 80px; }
        .media-gallery-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .media-gallery-grid img { max-width: 120px; height: auto; border-radius: 4px; border: 1px solid #ddd; }
        .media-note { background: #f5f5f5; padding: 10px; border-radius: 4px; font-size: 12px; color: #666; margin-bottom: 10px; }
    </style>

    <div class="media-tabs-container">
        <div class="media-tabs-nav">
            <button type="button" class="media-tab-btn active" data-tab="media-banner">Banner</button>
            <button type="button" class="media-tab-btn" data-tab="media-gallery">Image Gallery</button>
            <button type="button" class="media-tab-btn" data-tab="media-videos">Video URLs</button>
        </div>

        <!-- Banner Tab -->
        <div class="media-tabs-content active" id="media-banner">
            <div class="media-section-field">
                <label>Banner Title</label>
                <input type="text" name="media_banner_title" value="<?php echo esc_attr( $banner_title ? $banner_title : 'Media'); ?>" placeholder="Media">
            </div>
            <div class="media-section-field">
                <label>Banner Text</label>
                <textarea name="media_banner_text" placeholder="Short description shown under the title."><?php echo esc_textarea( $banner_text ); ?></textarea>
            </div>
            <div class="media-section-field">
                <label>Banner Background Image</label>
                <input type="hidden" id="media_banner_image_id" name="media_banner_image_id" value="<?php echo esc_attr( $banner_image_id ); ?>">

                <?php if ( $banner_image_url ) : ?>
                    <div class="media-banner-image-preview" id="media_banner_image_preview_container">
                        <img id="media_banner_image_preview" src="<?php echo esc_url( $banner_image_url ); ?>" alt="Banner Image" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px; border:1px solid #ddd;">
                    </div>
                <?php else : ?>
                    <div class="media-banner-image-preview" id="media_banner_image_preview_container" style="display:none;">
                        <img id="media_banner_image_preview" src="" alt="Banner Image" style="max-width: 300px; height: auto; border-radius: 4px; margin-top: 10px; border:1px solid #ddd;">
                    </div>
                <?php endif; ?>

                <div style="margin-top: 10px;">
                    <button type="button" id="upload_media_banner_image" class="button button-primary" style="margin-right:10px;">Upload Banner Image</button>
                    <button type="button" id="remove_media_banner_image" class="button" style="background:#dc3545;color:#fff;border:none;<?php echo $banner_image_url ? '' : ' display:none;'; ?>">Remove Image</button>
                </div>
            </div>
        </div>

        <!-- Image Gallery Tab -->
        <div class="media-tabs-content" id="media-gallery">
            <div class="media-note">Use this gallery to upload multiple images. These will appear in a grid on the Media page.</div>
            <div class="media-section-field">
                <input type="hidden" id="media_gallery_ids" name="media_gallery_ids" value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>">
                <button type="button" id="upload_media_gallery" class="button button-primary">Select / Upload Images</button>
                <button type="button" id="clear_media_gallery" class="button" style="margin-left:10px;<?php echo ! empty( $gallery_ids ) ? '' : ' display:none;'; ?>">Clear Gallery</button>
            </div>
            <div class="media-gallery-grid" id="media_gallery_preview">
                <?php
                if ( ! empty( $gallery_ids ) ) {
                    foreach ( $gallery_ids as $image_id ) {
                        $thumb = wp_get_attachment_thumb_url( $image_id );
                        if ( $thumb ) {
                            echo '<img src="' . esc_url( $thumb ) . '" alt="" />';
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Video URLs Tab -->
        <div class="media-tabs-content" id="media-videos">
            <div class="media-note">Add one video URL per line (YouTube, Vimeo, or other embeddable links).</div>
            <div class="media-section-field">
                <label>Video URLs</label>
                <textarea name="media_video_urls" placeholder="https://www.youtube.com/watch?v=...&#10;https://vimeo.com/..."><?php echo esc_textarea( $video_urls ); ?></textarea>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.media-tab-btn');
            const contents = document.querySelectorAll('.media-tabs-content');

            buttons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.getAttribute('data-tab');

                    buttons.forEach(function(b) { b.classList.remove('active'); });
                    contents.forEach(function(c) { c.classList.remove('active'); });

                    this.classList.add('active');
                    document.getElementById(tabName).classList.add('active');
                });
            });
        })();

        (function($) {
            // Banner image
            $('#upload_media_banner_image').on('click', function(e) {
                e.preventDefault();
                var frame = wp.media({
                    title: 'Select Banner Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#media_banner_image_id').val(attachment.id);
                    $('#media_banner_image_preview').attr('src', attachment.url);
                    $('#media_banner_image_preview_container').show();
                    $('#remove_media_banner_image').show();
                });

                frame.open();
            });

            $('#remove_media_banner_image').on('click', function(e) {
                e.preventDefault();
                $('#media_banner_image_id').val('');
                $('#media_banner_image_preview_container').hide();
                $(this).hide();
            });

            // Gallery images (multiple)
            $('#upload_media_gallery').on('click', function(e) {
                e.preventDefault();

                var galleryFrame = wp.media({
                    title: 'Select Gallery Images',
                    button: { text: 'Use these images' },
                    multiple: true
                });

                galleryFrame.on('select', function() {
                    var selection = galleryFrame.state().get('selection');
                    var ids = [];
                    var preview = $('#media_gallery_preview');
                    preview.empty();

                    selection.each(function(attachment) {
                        var att = attachment.toJSON();
                        ids.push(att.id);
                        if (att.sizes && att.sizes.thumbnail) {
                            preview.append('<img src="' + att.sizes.thumbnail.url + '" alt="" />');
                        } else {
                            preview.append('<img src="' + att.url + '" alt="" />');
                        }
                    });

                    $('#media_gallery_ids').val(ids.join(','));
                    $('#clear_media_gallery').show();
                });

                galleryFrame.open();
            });

            $('#clear_media_gallery').on('click', function(e) {
                e.preventDefault();
                $('#media_gallery_ids').val('');
                $('#media_gallery_preview').empty();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Media Page Metabox
function spaceengineers_save_media_metabox( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'page' || $post->post_name !== 'media' ) {
        return;
    }

    if ( ! isset( $_POST['spaceengineers_media_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_media_nonce_field'], 'spaceengineers_media_nonce' ) ) {
        return;
    }

    if ( isset( $_POST['media_banner_title'] ) ) {
        update_post_meta( $post_id, '_media_banner_title', sanitize_text_field( $_POST['media_banner_title'] ) );
    }

    if ( isset( $_POST['media_banner_text'] ) ) {
        update_post_meta( $post_id, '_media_banner_text', sanitize_textarea_field( $_POST['media_banner_text'] ) );
    }

    if ( isset( $_POST['media_banner_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['media_banner_image_id'] );
        if ( ! empty( $image_id ) ) {
            update_post_meta( $post_id, '_media_banner_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_media_banner_image_id' );
        }
    }

    if ( isset( $_POST['media_gallery_ids'] ) ) {
        $ids_raw = sanitize_text_field( $_POST['media_gallery_ids'] );
        $ids     = array_filter( array_map( 'intval', explode( ',', $ids_raw ) ) );
        update_post_meta( $post_id, '_media_gallery_ids', $ids );
    }

    if ( isset( $_POST['media_video_urls'] ) ) {
        update_post_meta( $post_id, '_media_video_urls', sanitize_textarea_field( $_POST['media_video_urls'] ) );
    }
}
add_action( 'save_post_page', 'spaceengineers_save_media_metabox' );



// ===================== CUSTOM TESTIMONIAL POST TYPE =====================

// Register Testimonial Custom Post Type
function spaceengineers_register_testimonial_post_type() {
    $args = array(
        'labels' => array(
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'menu_name'          => 'Testimonials',
            'add_new'            => 'Add New Testimonial',
            'add_new_item'       => 'Add New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New Testimonial',
            'view_item'          => 'View Testimonial',
            'search_items'       => 'Search Testimonials',
            'not_found'          => 'No Testimonials Found',
            'not_found_in_trash' => 'No Testimonials Found in Trash',
        ),
        'public'              => true,
        'hierarchical'        => false,
        'has_archive'         => true,
        'supports'            => array( 'title', 'thumbnail' ),
        'menu_icon'           => 'dashicons-format-quote',
        'show_in_menu'        => true,
        'show_in_rest'        => true,
    );

    register_post_type( 'testimonial', $args );
}
add_action( 'init', 'spaceengineers_register_testimonial_post_type' );

// Add Testimonial Metabox
function spaceengineers_add_testimonial_metabox() {
    add_meta_box(
        'testimonial_details',
        'Testimonial Details',
        'spaceengineers_testimonial_metabox_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'spaceengineers_add_testimonial_metabox' );

// Testimonial Metabox Callback
function spaceengineers_testimonial_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_testimonial_nonce', 'spaceengineers_testimonial_nonce_field' );
    
    $client_name = get_post_meta( $post->ID, '_testimonial_client_name', true );
    $client_position = get_post_meta( $post->ID, '_testimonial_client_position', true );
    $client_content = get_post_meta( $post->ID, '_testimonial_client_content', true );
    $client_image_id = get_post_meta( $post->ID, '_testimonial_client_image_id', true );
    $client_image_url = $client_image_id ? wp_get_attachment_url( $client_image_id ) : '';
    ?>
    <style>
        .testimonial-field {
            margin-bottom: 20px;
        }
        .testimonial-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .testimonial-field input[type="text"],
        .testimonial-field textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI';
            font-size: 14px;
        }
        .testimonial-field textarea {
            resize: vertical;
            min-height: 120px;
        }
        .testimonial-note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }
        .testimonial-image-preview {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .testimonial-image-preview img {
            max-width: 150px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .testimonial-image-buttons {
            margin-top: 10px;
        }
        .testimonial-image-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .testimonial-image-buttons button:hover {
            background: #005a87;
        }
        .testimonial-image-buttons .remove-btn {
            background: #dc3545;
        }
        .testimonial-image-buttons .remove-btn:hover {
            background: #c82333;
        }
    </style>

    <div class="testimonial-note">
        <strong>Note:</strong> The post title will be used as the testimonial quote/feedback. Use the fields below for client details.
    </div>

    <div class="testimonial-field">
        <label for="testimonial_client_name">Client Name</label>
        <input type="text" id="testimonial_client_name" name="testimonial_client_name" value="<?php echo esc_attr( $client_name ); ?>" placeholder="e.g., John Smith">
    </div>

    <div class="testimonial-field">
        <label for="testimonial_client_position">Position / Company</label>
        <input type="text" id="testimonial_client_position" name="testimonial_client_position" value="<?php echo esc_attr( $client_position ); ?>" placeholder="e.g., CEO, Acme Corp">
    </div>

    <div class="testimonial-field">
        <label>Testimonial Content / Quote</label>
        <?php
        wp_editor( $client_content, 'testimonial_client_content', array(
            'media_buttons' => false,
            'textarea_name' => 'testimonial_client_content',
            'textarea_rows' => 5,
            'teeny' => true,
            'quicktags' => true
        ) );
        ?>
    </div>

    <div class="testimonial-field">
        <label>Client Photo</label>
        <input type="hidden" id="testimonial_client_image_id" name="testimonial_client_image_id" value="<?php echo esc_attr( $client_image_id ); ?>">
        
        <?php if ( $client_image_url ) : ?>
            <div class="testimonial-image-preview">
                <img id="testimonial_image_preview" src="<?php echo esc_url( $client_image_url ); ?>" alt="Client Photo">
            </div>
        <?php else : ?>
            <div class="testimonial-image-preview" id="testimonial_image_preview_container" style="display: none;">
                <img id="testimonial_image_preview" src="" alt="Client Photo">
            </div>
        <?php endif; ?>
        
        <div class="testimonial-image-buttons">
            <button type="button" id="upload_testimonial_image">Upload Image</button>
            <?php if ( $client_image_url ) : ?>
                <button type="button" id="remove_testimonial_image" class="remove-btn">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        (function($) {
            var mediaUploader;
            
            $('#upload_testimonial_image').click(function(e) {
                e.preventDefault();
                
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Client Photo',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#testimonial_client_image_id').val(attachment.id);
                    $('#testimonial_image_preview').attr('src', attachment.url);
                    $('#testimonial_image_preview_container').show();
                    $('#remove_testimonial_image').show();
                });
                
                mediaUploader.open();
            });
            
            $('#remove_testimonial_image').click(function(e) {
                e.preventDefault();
                $('#testimonial_client_image_id').val('');
                $('#testimonial_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Testimonial Metabox
function spaceengineers_save_testimonial_metabox( $post_id ) {
    if ( !isset( $_POST['spaceengineers_testimonial_nonce_field'] ) || 
         !wp_verify_nonce( $_POST['spaceengineers_testimonial_nonce_field'], 'spaceengineers_testimonial_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['testimonial_client_name'] ) ) {
        update_post_meta( $post_id, '_testimonial_client_name', sanitize_text_field( $_POST['testimonial_client_name'] ) );
    }

    if ( isset( $_POST['testimonial_client_position'] ) ) {
        update_post_meta( $post_id, '_testimonial_client_position', sanitize_text_field( $_POST['testimonial_client_position'] ) );
    }

    if ( isset( $_POST['testimonial_client_content'] ) ) {
        update_post_meta( $post_id, '_testimonial_client_content', wp_kses_post( $_POST['testimonial_client_content'] ) );
    }

    if ( isset( $_POST['testimonial_client_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['testimonial_client_image_id'] );
        if ( !empty( $image_id ) ) {
            update_post_meta( $post_id, '_testimonial_client_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_testimonial_client_image_id' );
        }
    }
}
add_action( 'save_post_testimonial', 'spaceengineers_save_testimonial_metabox' );

// Helper function to get testimonials
function get_testimonials( $limit = -1 ) {
    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );

    return new WP_Query( $args );
}

// ===================== CUSTOM SERVICES POST TYPE =====================

// Register Service Custom Post Type
function spaceengineers_register_service_post_type() {
    $args = array(
        'label'              => 'Services',
        'singular_label'     => 'Service',
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'supports'           => array( 'title', 'thumbnail' ),
        'menu_icon'          => 'dashicons-layout',
        'menu_position'      => 6,
    );
    register_post_type( 'service', $args );
}
add_action( 'init', 'spaceengineers_register_service_post_type' );

// Add Service Metabox
function spaceengineers_add_service_metabox() {
    add_meta_box(
        'spaceengineers_service_metabox',
        'Service Details',
        'spaceengineers_service_metabox_callback',
        'service',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_service', 'spaceengineers_add_service_metabox' );

// Service Metabox Callback
function spaceengineers_service_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_service_nonce', 'spaceengineers_service_nonce_field' );
    
    $service_description = get_post_meta( $post->ID, '_service_description', true );
    $service_image_id = get_post_meta( $post->ID, '_service_image_id', true );
    $service_image_url = $service_image_id ? wp_get_attachment_url( $service_image_id ) : '';
    ?>
    <style>
        .service-field {
            margin-bottom: 20px;
        }
        .service-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .service-field textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI';
            font-size: 14px;
            resize: vertical;
            min-height: 120px;
        }
        .service-note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }
        .service-image-preview {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .service-image-preview img {
            max-width: 150px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .service-image-buttons {
            margin-top: 10px;
        }
        .service-image-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .service-image-buttons button:hover {
            background: #005a87;
        }
        .service-image-buttons .remove-btn {
            background: #dc3545;
        }
        .service-image-buttons .remove-btn:hover {
            background: #c82333;
        }
    </style>

    <div class="service-note">
        <strong>Note:</strong> The post title will be used as the service name. Use the fields below for additional details.
    </div>

    <div class="service-field">
        <label>Service Description</label>
        <?php
        wp_editor( $service_description, 'service_description', array(
            'media_buttons' => false,
            'textarea_name' => 'service_description',
            'textarea_rows' => 5,
            'teeny' => true,
            'quicktags' => true
        ) );
        ?>
    </div>

    <div class="service-field">
        <label>Service Image</label>
        <input type="hidden" id="service_image_id" name="service_image_id" value="<?php echo esc_attr( $service_image_id ); ?>">
        
        <?php if ( $service_image_url ) : ?>
            <div class="service-image-preview">
                <img id="service_image_preview" src="<?php echo esc_url( $service_image_url ); ?>" alt="Service Image">
            </div>
        <?php else : ?>
            <div class="service-image-preview" id="service_image_preview_container" style="display: none;">
                <img id="service_image_preview" src="" alt="Service Image">
            </div>
        <?php endif; ?>
        
        <div class="service-image-buttons">
            <button type="button" id="upload_service_image">Upload Image</button>
            <?php if ( $service_image_url ) : ?>
                <button type="button" id="remove_service_image" class="remove-btn">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        (function($) {
            var mediaUploader;
            
            $('#upload_service_image').click(function(e) {
                e.preventDefault();
                
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Service Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#service_image_id').val(attachment.id);
                    $('#service_image_preview').attr('src', attachment.url);
                    $('#service_image_preview_container').show();
                    $('#remove_service_image').show();
                });
                
                mediaUploader.open();
            });
            
            $('#remove_service_image').click(function(e) {
                e.preventDefault();
                $('#service_image_id').val('');
                $('#service_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Service Metabox
function spaceengineers_save_service_metabox( $post_id ) {
    if ( !isset( $_POST['spaceengineers_service_nonce_field'] ) || 
         !wp_verify_nonce( $_POST['spaceengineers_service_nonce_field'], 'spaceengineers_service_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['service_description'] ) ) {
        update_post_meta( $post_id, '_service_description', wp_kses_post( $_POST['service_description'] ) );
    }

    if ( isset( $_POST['service_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['service_image_id'] );
        if ( !empty( $image_id ) ) {
            update_post_meta( $post_id, '_service_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_service_image_id' );
        }
    }
}
add_action( 'save_post_service', 'spaceengineers_save_service_metabox' );

// Helper function to get services
function get_services( $limit = -1 ) {
    $args = array(
        'post_type'      => 'service',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );

    return new WP_Query( $args );
}

// ===================== CUSTOM PROJECTS POST TYPE =====================

// Register Project Custom Post Type
function spaceengineers_register_project_post_type() {
    $args = array(
        'label'          => 'Projects',
        'singular_label' => 'Project',
        'public'         => true,
        'show_in_rest'   => true,
        'has_archive'    => true,
        'supports'       => array( 'title', 'thumbnail' ),
        'menu_icon'      => 'dashicons-portfolio',
        'menu_position'  => 8,
    );
    register_post_type( 'project', $args );
}
add_action( 'init', 'spaceengineers_register_project_post_type' );

// Add Project Metabox
function spaceengineers_add_project_metabox() {
    add_meta_box(
        'spaceengineers_project_metabox',
        'Project Details',
        'spaceengineers_project_metabox_callback',
        'project',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_project', 'spaceengineers_add_project_metabox' );

// Project Metabox Callback
function spaceengineers_project_metabox_callback( $post ) {
    wp_nonce_field( 'spaceengineers_project_nonce', 'spaceengineers_project_nonce_field' );

    $project_description = get_post_meta( $post->ID, '_project_description', true );
    $project_image_id    = get_post_meta( $post->ID, '_project_image_id', true );
    $project_image_url   = $project_image_id ? wp_get_attachment_url( $project_image_id ) : '';
    $project_status      = get_post_meta( $post->ID, '_project_status', true );
    if ( $project_status !== 'completed' ) {
        $project_status = 'ongoing';
    }
    ?>
    <style>
        .project-field {
            margin-bottom: 20px;
        }
        .project-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .project-field textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI';
            font-size: 14px;
            resize: vertical;
            min-height: 120px;
        }
        .project-note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }
        .project-image-preview {
            margin-top: 10px;
            margin-bottom: 15px;
        }
        .project-image-preview img {
            max-width: 150px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .project-image-buttons {
            margin-top: 10px;
        }
        .project-image-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .project-image-buttons button:hover {
            background: #005a87;
        }
        .project-image-buttons .remove-btn {
            background: #dc3545;
        }
        .project-image-buttons .remove-btn:hover {
            background: #c82333;
        }
    </style>

    <div class="project-note">
        <strong>Note:</strong> The post title will be used as the project name. Use the fields below for additional details.
    </div>

    <div class="project-field">
        <label>Project Status</label>
        <select name="project_status">
            <option value="ongoing" <?php selected( $project_status, 'ongoing' ); ?>>Ongoing</option>
            <option value="completed" <?php selected( $project_status, 'completed' ); ?>>Completed</option>
        </select>
    </div>

    <div class="project-field">
        <label>Project Description</label>
        <?php
        wp_editor( $project_description, 'project_description', array(
            'media_buttons' => false,
            'textarea_name' => 'project_description',
            'textarea_rows' => 5,
            'teeny'         => true,
            'quicktags'     => true,
        ) );
        ?>
    </div>

    <div class="project-field">
        <label>Project Image</label>
        <input type="hidden" id="project_image_id" name="project_image_id" value="<?php echo esc_attr( $project_image_id ); ?>">

        <?php if ( $project_image_url ) : ?>
            <div class="project-image-preview">
                <img id="project_image_preview" src="<?php echo esc_url( $project_image_url ); ?>" alt="Project Image">
            </div>
        <?php else : ?>
            <div class="project-image-preview" id="project_image_preview_container" style="display: none;">
                <img id="project_image_preview" src="" alt="Project Image">
            </div>
        <?php endif; ?>

        <div class="project-image-buttons">
            <button type="button" id="upload_project_image">Upload Image</button>
            <?php if ( $project_image_url ) : ?>
                <button type="button" id="remove_project_image" class="remove-btn">Remove Image</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        (function($) {
            var mediaUploader;

            $('#upload_project_image').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Project Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#project_image_id').val(attachment.id);
                    $('#project_image_preview').attr('src', attachment.url);
                    $('#project_image_preview_container').show();
                    $('#remove_project_image').show();
                });

                mediaUploader.open();
            });

            $('#remove_project_image').click(function(e) {
                e.preventDefault();
                $('#project_image_id').val('');
                $('#project_image_preview_container').hide();
                $(this).hide();
            });
        })(jQuery);
    </script>
    <?php
}

// Save Project Metabox
function spaceengineers_save_project_metabox( $post_id ) {
    if ( ! isset( $_POST['spaceengineers_project_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['spaceengineers_project_nonce_field'], 'spaceengineers_project_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['project_description'] ) ) {
        update_post_meta( $post_id, '_project_description', wp_kses_post( $_POST['project_description'] ) );
    }

    if ( isset( $_POST['project_image_id'] ) ) {
        $image_id = sanitize_text_field( $_POST['project_image_id'] );
        if ( ! empty( $image_id ) ) {
            update_post_meta( $post_id, '_project_image_id', intval( $image_id ) );
        } else {
            delete_post_meta( $post_id, '_project_image_id' );
        }
    }

    if ( isset( $_POST['project_status'] ) ) {
        $status = $_POST['project_status'] === 'completed' ? 'completed' : 'ongoing';
        update_post_meta( $post_id, '_project_status', $status );
    }
}
add_action( 'save_post_project', 'spaceengineers_save_project_metabox' );

// Helper function to get projects
function get_projects( $limit = -1 ) {
    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );

    return new WP_Query( $args );
}


