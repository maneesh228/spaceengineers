<?php
/**
 * Template Name: Media
 */

get_header();

// Get the Media page by slug to read its meta (in case template is used elsewhere)
$media_page = get_page_by_path( 'media' );
if ( $media_page ) {
    $media_id = $media_page->ID;
} else {
    $media_id = get_the_ID();
}

$banner_title      = get_post_meta( $media_id, '_media_banner_title', true );
$banner_text       = get_post_meta( $media_id, '_media_banner_text', true );
$banner_image_id   = get_post_meta( $media_id, '_media_banner_image_id', true );
$banner_image_url  = $banner_image_id ? wp_get_attachment_image_url( $banner_image_id, 'full' ) : '';

$gallery_ids       = get_post_meta( $media_id, '_media_gallery_ids', true );
$gallery_ids       = is_array( $gallery_ids ) ? $gallery_ids : array();

$video_urls_raw    = get_post_meta( $media_id, '_media_video_urls', true );
$video_urls        = array_filter( array_map( 'trim', preg_split( '/\r?\n/', (string) $video_urls_raw ) ) );

if ( ! $banner_title ) {
    $banner_title = 'Media';
}

$default_banner_image = get_template_directory_uri() . '/img/pg1.jpg';

?>

<!-- Page Header -->
<header class="pages-header bg-img valign parallaxie" data-background="<?php echo esc_url( $banner_image_url ? $banner_image_url : $default_banner_image ); ?>" data-overlay-dark="5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="cont text-center">
                    <h1 class="mb-10 color-font"><?php echo esc_html( $banner_title ); ?></h1>
                    <?php if ( $banner_text ) : ?>
                        <p class="mb-20"><?php echo esc_html( $banner_text ); ?></p>
                    <?php endif; ?>
                    <div class="path">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                        <span>/</span>
                        <a class="active">Media</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Media Content -->
<section class="services section-padding bg-gray">
    <div class="container">
        <div class="row justify-content-center mb-60">
            <div class="col-lg-8 text-center">
                <h6 class="stit mb-15">Our Media</h6>
                <h4 class="mb-20">Gallery &amp; Videos</h4>
                <?php if ( $banner_text ) : ?>
                    <p><?php echo esc_html( $banner_text ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( ! empty( $gallery_ids ) ) : ?>
            <div class="row">
                <?php foreach ( $gallery_ids as $image_id ) :
                    $image_url = wp_get_attachment_image_url( $image_id, 'large' );
                    if ( ! $image_url ) {
                        continue;
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 mb-30">
                        <a href="javascript:void(0);" class="media-lightbox-trigger" data-full="<?php echo esc_url( $image_url ); ?>">
                            <div class="item-bx bg-img" data-background="<?php echo esc_url( $image_url ); ?>" data-overlay-dark="2">
                                <div class="cont valign">
                                    <div class="full-width text-center">
                                        <span class="fsz-14 opacity-7">View Image</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $video_urls ) ) : ?>
            <div class="row mt-60">
                <div class="col-12 mb-30 text-center">
                    <h4 class="mb-20">Videos</h4>
                </div>

                <?php foreach ( $video_urls as $url ) :
                    $embed_url = $url;

                    // Basic YouTube short forms to embed URL conversion
                    if ( preg_match( '#https?://(?:www\.)?youtu\.be/([\w-]+)#i', $url, $matches ) ) {
                        $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                    } elseif ( preg_match( '#https?://(?:www\.)?youtube\.com/watch\?v=([\w-]+)#i', $url, $matches ) ) {
                        $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                    }
                    ?>
                    <div class="col-lg-6 mb-30">
                        <div class="vid" style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;">
                            <iframe src="<?php echo esc_url( $embed_url ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( empty( $gallery_ids ) && empty( $video_urls ) ) : ?>
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <p>No media items have been added yet.</p>
                    <?php if ( current_user_can( 'edit_pages' ) && $media_id ) : ?>
                        <a href="<?php echo esc_url( get_edit_post_link( $media_id ) ); ?>" class="butn butn-md butn-bord mt-20"><span>Edit Media Page</span></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .media-lightbox-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    .media-lightbox-overlay.active { display: flex; }
    .media-lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }
    .media-lightbox-content img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 6px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }
    .media-lightbox-close {
        position: absolute;
        top: -15px;
        right: -15px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        color: #000;
        font-size: 20px;
        line-height: 32px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
    }
    .media-lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        font-size: 20px;
        user-select: none;
    }
    .media-lightbox-prev { left: -60px; }
    .media-lightbox-next { right: -60px; }
</style>

<div class="media-lightbox-overlay" id="media-lightbox">
    <div class="media-lightbox-content">
        <span class="media-lightbox-close" id="media-lightbox-close">&times;</span>
        <span class="media-lightbox-nav media-lightbox-prev" id="media-lightbox-prev">&#10094;</span>
        <span class="media-lightbox-nav media-lightbox-next" id="media-lightbox-next">&#10095;</span>
        <img id="media-lightbox-image" src="" alt="Media image" />
    </div>
</div>

<script>
    (function() {
        var overlay = document.getElementById('media-lightbox');
        var overlayImg = document.getElementById('media-lightbox-image');
        var closeBtn = document.getElementById('media-lightbox-close');
        var prevBtn = document.getElementById('media-lightbox-prev');
        var nextBtn = document.getElementById('media-lightbox-next');
        if (!overlay || !overlayImg || !closeBtn) return;

        var triggers = Array.prototype.slice.call(document.querySelectorAll('.media-lightbox-trigger'));
        var currentIndex = -1;

        function openLightbox(src) {
            overlayImg.src = src;
            overlay.classList.add('active');
        }

        function closeLightbox() {
            overlay.classList.remove('active');
            overlayImg.src = '';
        }

        function openLightboxByIndex(index) {
            if (!triggers.length) return;
            if (index < 0) {
                index = triggers.length - 1;
            } else if (index >= triggers.length) {
                index = 0;
            }
            currentIndex = index;
            var src = triggers[currentIndex].getAttribute('data-full');
            if (src) {
                openLightbox(src);
            }
        }

        triggers.forEach(function(el, idx) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                openLightboxByIndex(idx);
            });
        });

        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeLightbox();
        });

        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeLightbox();
            }
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentIndex !== -1) {
                    openLightboxByIndex(currentIndex - 1);
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentIndex !== -1) {
                    openLightboxByIndex(currentIndex + 1);
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft' && currentIndex !== -1) {
                openLightboxByIndex(currentIndex - 1);
            } else if (e.key === 'ArrowRight' && currentIndex !== -1) {
                openLightboxByIndex(currentIndex + 1);
            }
        });
    })();
</script>

<?php
get_footer();
