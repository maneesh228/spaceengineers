<?php
/**
 * Custom Comments Template
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if ( have_comments() ) : ?>
                    <h3 class="comments-title playfont mb-40">
                        <?php
                        $comments_number = get_comments_number();
                        if ( '1' === $comments_number ) {
                            echo '1 Comment';
                        } else {
                            echo esc_html( $comments_number ) . ' Comments';
                        }
                        ?>
                    </h3>

                    <ol class="comment-list">
                        <?php
                        wp_list_comments( array(
                            'style'       => 'ol',
                            'short_ping'  => true,
                            'avatar_size' => 40,
                            'callback'    => function( $comment, $args, $depth ) {
                                $tag       = ( 'div' === $args['style'] ) ? 'div' : 'li';
                                $author_id = $comment->user_id;
                                ?>
                                <<?php echo $tag; ?> <?php comment_class( 'comment-item clearfix' ); ?> id="comment-<?php comment_ID(); ?>">
                                    <div class="comment-body d-flex align-items-start">
                                        <div class="comment-avatar mr-3">
                                            <?php echo get_avatar( $comment, 40 ); ?>
                                        </div>
                                        <div class="comment-content">
                                            <div class="comment-meta">
                                                <h6 class="comment-author playfont"><?php comment_author(); ?></h6>
                                                <span class="comment-date"><?php printf( '%1$s at %2$s', get_comment_date(), get_comment_time() ); ?></span>
                                            </div>
                                            <div class="comment-text">
                                                <?php comment_text(); ?>
                                            </div>
                                            <div class="comment-actions">
                                                <?php
                                                comment_reply_link( array_merge( $args, array(
                                                    'reply_text' => 'Reply',
                                                    'depth'      => $depth,
                                                    'max_depth'  => $args['max_depth'],
                                                ) ) );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </<?php echo $tag; ?>>
                                <?php
                            },
                        ) );
                        ?>
                    </ol>

                    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                        <nav class="comment-navigation" role="navigation">
                            <div class="nav-links d-flex justify-content-between">
                                <div class="nav-previous"><?php previous_comments_link( '&larr; Older Comments' ); ?></div>
                                <div class="nav-next"><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
                            </div>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ( comments_open() ) : ?>
                    <div class="comment-form-wrapper mt-40">
                        <h3 class="playfont mb-30">Leave a Comment</h3>
                        <?php
                        comment_form( array(
                            'class_form'         => 'comment-form row',
                            'class_submit'       => 'butn butn-bg mt-20 btn-curve btn-color disabled',
                            'title_reply'        => '',
                            'title_reply_before' => '',
                            'title_reply_after'  => '',
                            'comment_field'      => '<div class="col-12"><textarea id="comment" name="comment" class="form-control" rows="5" placeholder="Your Comment" required></textarea></div>',
                            'fields'             => array(
                                'author' => '<div class="col-md-6"><input id="author" name="author" type="text" class="form-control" placeholder="Name" required></div>',
                                'email'  => '<div class="col-md-6"><input id="email" name="email" type="email" class="form-control" placeholder="Email" required></div>',
                                'url'    => '',
                            ),
                            'submit_field'       => '<div class="col-12 text-center mt-20 ">%1$s %2$s</div>',
                        ) );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
