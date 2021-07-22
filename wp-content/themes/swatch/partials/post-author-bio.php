<?php
/**
 * Shows tags, categories and comment count for posts
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.3
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */
$author_id = get_the_author_meta('ID'); ?>
<div class="author-info media small-screen-center <?php echo oxy_get_option('author_bio_swatch'); ?>">
    <?php echo get_avatar( $author_id, 150 ); ?>
    <div class="media-body">
        <h4 class="media-heading">
            <?php the_author_meta('display_name') ?>
        </h4>
        <div class="media">
            <?php the_author_meta('description'); ?>
        </div>
    </div>
</div>