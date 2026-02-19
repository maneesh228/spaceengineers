<?php
/**
 * Projects Page Template
 */
get_header();

// Get projects page banner settings
$args = array(
    'post_type'      => 'page',
    'name'           => 'projects',
    'posts_per_page' => 1,
);
$projects_query   = new WP_Query( $args );
$projects_page_id = 0;
if ( $projects_query->have_posts() ) {
    $projects_query->the_post();
    $projects_page_id = get_the_ID();
    wp_reset_postdata();
}

$banner_title = $projects_page_id ? get_post_meta( $projects_page_id, '_projects_banner_title', true ) : '';
if ( ! $banner_title ) {
    $banner_title = 'Projects';
}

$banner_image_id  = $projects_page_id ? get_post_meta( $projects_page_id, '_projects_banner_image_id', true ) : 0;
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

<!-- ==================== Start Projects ==================== -->
<section class="services section-padding bg-gray">
    <div class="container">
        <div class="section-head text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <?php
                    $section_subtitle = $projects_page_id ? get_post_meta( $projects_page_id, '_projects_section_subtitle', true ) : '';
                    if ( ! $section_subtitle ) {
                        $section_subtitle = 'Our Work';
                    }

                    $section_title = $projects_page_id ? get_post_meta( $projects_page_id, '_projects_section_title', true ) : '';
                    if ( ! $section_title ) {
                        $section_title = 'Featured Projects';
                    }
                    ?>
                    <h6 class="custom-font wow fadeInDown" data-wow-delay=".3s"><?php echo esc_html( $section_subtitle ); ?></h6>
                    <h4 class="playfont wow flipInX" data-wow-delay=".5s"><?php echo esc_html( $section_title ); ?></h4>
                </div>
            </div>
        </div>
        <?php
        $projects = get_projects();
        $ongoing  = array();
        $completed = array();

        if ( $projects->have_posts() ) {
            while ( $projects->have_posts() ) {
                $projects->the_post();

                $project_description = get_post_meta( get_the_ID(), '_project_description', true );
                $project_image_id    = get_post_meta( get_the_ID(), '_project_image_id', true );
                $project_image_url   = $project_image_id ? wp_get_attachment_url( $project_image_id ) : get_template_directory_uri() . '/img/01.jpg';
                $status              = get_post_meta( get_the_ID(), '_project_status', true );
                if ( $status !== 'completed' ) {
                    $status = 'ongoing';
                }

                $description = ! empty( $project_description ) ? $project_description : 'Project description';
                $description = wp_strip_all_tags( wp_trim_words( $description, 15 ) );

                $item = array(
                    'title'       => get_the_title(),
                    'permalink'   => get_permalink(),
                    'image_url'   => $project_image_url,
                    'description' => $description,
                );

                if ( $status === 'completed' ) {
                    $completed[] = $item;
                } else {
                    $ongoing[] = $item;
                }
            }
            wp_reset_postdata();
        }
        ?>

        <?php if ( empty( $ongoing ) && empty( $completed ) ) : ?>
            <div class="row">
                <div class="col-12" style="text-align: center; padding: 40px; background: #f5f5f5; border-radius: 4px;">
                    <p><strong>No projects published yet.</strong></p>
                    <?php if ( current_user_can( 'manage_options' ) ) : ?>
                        <p><a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=project' ) ); ?>" class="btn-curve btn-color mt-20"><span>Add First Project</span></a></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <?php if ( ! empty( $ongoing ) ) : ?>
                <div class="row mb-40">
                    <div class="col-12 mb-30">
                        <h4 class="playfont">Ongoing Projects</h4>
                    </div>
                    <?php
                    $delay = 0.3;
                    foreach ( $ongoing as $item ) :
                        ?>
                        <div class="col-lg-4">
                            <div class="item-bx bg-img wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s" data-background="<?php echo esc_url( $item['image_url'] ); ?>">
                                <h6 class="mb-20"><?php echo esc_html( $item['title'] ); ?></h6>
                                <p><?php echo esc_html( $item['description'] ); ?></p>
                                <a href="<?php echo esc_url( $item['permalink'] ); ?>" class="more custom-font mt-30">Read More</a>
                            </div>
                        </div>
                        <?php
                        $delay += 0.2;
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $completed ) ) : ?>
                <div class="row">
                    <div class="col-12 mb-30">
                        <h4 class="playfont">Completed Projects</h4>
                    </div>
                    <?php
                    $delay = 0.3;
                    foreach ( $completed as $item ) :
                        ?>
                        <div class="col-lg-4">
                            <div class="item-bx bg-img wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s" data-background="<?php echo esc_url( $item['image_url'] ); ?>">
                                <h6 class="mb-20"><?php echo esc_html( $item['title'] ); ?></h6>
                                <p><?php echo esc_html( $item['description'] ); ?></p>
                                <a href="<?php echo esc_url( $item['permalink'] ); ?>" class="more custom-font mt-30">Read More</a>
                            </div>
                        </div>
                        <?php
                        $delay += 0.2;
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<!-- ==================== End Projects ==================== -->

<?php
get_footer();
?>
