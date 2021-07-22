<?php
/**
 * Displays a tag archive
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

get_header();
if( is_day() ) {
    $title = __( 'Day', 'swatch-td' );
    $sub = get_the_date( 'j M Y' );
}
elseif( is_month() ) {
    $title = __( 'Month', 'swatch-td' );
    $sub = get_the_date( 'F Y' );
}
elseif( is_year() ) {
    $title = __( 'Year', 'swatch-td' );
    $sub = get_the_date( 'Y' );
}
else {
    $title = __( 'Blog', 'swatch-td' );
    $sub = 'Archives';
}
?>
<?php oxy_page_header( oxy_get_option('blog_header_swatch'), $title, $sub, 'left'); ?>
<section class="section <?php echo oxy_get_option('blog_swatch'); ?>">
    <div class="container">
        <div class="row-fluid">
            <?php get_template_part( 'partials/loop' ); ?>
        </div>
    </div>
</section>
<?php get_footer();