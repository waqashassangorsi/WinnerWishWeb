<?php
/**
 * Main functions file
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

if ( post_password_required() )
    return;
?>
<?php if ( have_comments() ) : ?>
<div class="comments" id="comments">

    <h3 class="small-screen-center">
        <?php
             printf( _n( '1 comment', '%1$s comments', get_comments_number(), 'swatch-td' ), number_format_i18n( get_comments_number() ) );
        ?>
    </h3>

    <?php wp_list_comments( array( 'walker' => new OxyCommentWalker, ) ); ?>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-below" class="navigation" role="navigation">
        <ul class="pager">
        <li class="previous"><?php previous_comments_link( __( '&larr; Older', 'swatch-td' ) ); ?></li>
        <li class="next"><?php next_comments_link( __( 'Newer &rarr;', 'swatch-td' ) ); ?></li>
        </ul>
    </nav>
    <?php endif; // check for comment navigation ?>

    <?php
    /* If there are no comments and comments are closed, let's leave a note.
     * But we only want the note on posts and pages that had comments in the first place.
     */
    if ( ! comments_open() && get_comments_number() ) : ?>
    <br>
    <h3 class="nocomments text-center"><?php _e( 'Comments are closed.', 'swatch-td' ); ?></h3>
    <?php endif; ?>

</div>
<?php endif; ?>

<?php oxy_comment_form(); ?>
