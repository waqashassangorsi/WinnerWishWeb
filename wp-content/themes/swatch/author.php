<?php
/**
 * Author page template
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */
get_header();
//oxy_page_header();
// get the author name
if( get_query_var('author_name') ) {
    $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
}
else {
    $author = get_userdata( get_query_var( 'author' ) );
}
?>
<section class="section <?php echo oxy_get_option('author_bio_swatch'); ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="span4">
                <div class="box-round box-huge">
                    <div class="box-dummy"></div>
                    <figure class="box-inner">
                        <?php echo get_avatar( $author->ID, 300 ); ?>
                    </figure>
                </div>
            </div>
            <div class="span8">
                <h1>
                    <?php the_author_meta('display_name', $author->ID) ?>
                </h1>
                <p class="lead">
                    <?php the_author_meta('description', $author->ID); ?>
                </p>
            </div>
        </div>
    </div>
</section>
<section class="section <?php echo oxy_get_option('blog_swatch'); ?>">
    <h2 class="text-center"><?php echo __('Posts by ', 'swatch-td').$author->nickname; ?></h2>
    <div class="container">
        <div class="row-fluid">
            <?php get_template_part( 'partials/loop' ); ?>
        </div>
    </div>
</section>
<?php get_footer();
