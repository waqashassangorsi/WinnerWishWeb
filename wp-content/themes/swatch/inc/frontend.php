<?php
/**
 * This is where all the themes frontend actions at
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

/******************************
 *
 * THEME SETUP
 *
 *****************************/

function create_image_sizes() {
    if( function_exists( 'add_image_size' ) ) {
        add_image_size( 'circle-image', 300, 300 );
        add_image_size( 'portfolio-thumb', oxy_get_option('portfolio_item_width'), oxy_get_option('portfolio_item_height'), oxy_get_option('portfolio_item_crop') === 'on' );
    }
}
add_action( 'init', 'create_image_sizes');

function oxy_detect_user_agent() {
    global $oxy_is_iphone, $oxy_is_ipad, $oxy_is_android;
    $oxy_is_iphone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $oxy_is_ipad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $oxy_is_android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
}

add_action( 'init', 'oxy_detect_user_agent');

/******************************
 *
 * HEAD
 *
 *****************************/

/**
 * Apple device icons
 *
 * @return echos html for apple icons
 **/
function oxy_add_apple_icons( $option_name, $sizes = '' ) {
    $icon = oxy_get_option( $option_name );
    if( false !== $icon ) {
        $rel = oxy_get_option( $option_name . '_pre', 'apple-touch-icon' );
        echo '<link rel="' . $rel . '" href="' . $icon . '" ' . $sizes  . ' />';
    }
}

/******************************
 *
 * HEADER
 *
 *****************************/

function oxy_create_logo() {
    if( function_exists( 'icl_get_home_url' ) ) {
        $home_link = icl_get_home_url();
    }
    else {
        $home_link = home_url();
    }
    $id = oxy_get_option( 'logo_image' );
    $brand_class = oxy_get_option('logo_type') == 'text_image'? 'brand text-image':'brand';
    $output = '<a href="'.$home_link.'" class="'.$brand_class.'">';
     
            $output.= '<img width="168" height="87" src="'. wp_get_attachment_url(get_theme_mod('mypanelsetting')).'" class="attachment-full size-full" alt="" loading="lazy">';
    $output.= '</a>';
    echo $output;
}

function oxy_output_extra_css() { ?>
    <style type="text/css" media="screen">
        <?php echo get_option( THEME_SHORT . '-header-css', '' ); ?>
        <?php echo get_option( THEME_SHORT . '-swatches' ); ?>
        <?php echo oxy_get_option( 'extra_css' ); ?>
    </style>
<?php
    echo get_option('oxy-typography-js');
    echo get_option('oxy-typography-css');
}
add_action('wp_head', 'oxy_output_extra_css');

// Register main menu
register_nav_menus( array(
    'primary' => __( 'Primary Navigation', 'swatch-admin-td' ),
    'account' => __( 'Account Navigation', 'swatch-admin-td' ),
));


/**
 * Gets a theme option
 *
 * @return theme option value or false if not set
 * @since 1.0
 **/
function oxy_get_option( $name ) {
    global $oxy_theme_options;
    if( isset( $oxy_theme_options[$name] ) ) {
        return $oxy_theme_options[$name];
    }
    else {
        return false;
    }
}


/**
 * Loads theme scripts
 *
 * @return void
 *
 **/
function oxy_load_scripts() {
    global $oxy_theme_options;
    global $oxy_is_iphone, $oxy_is_android, $oxy_is_ipad;

    global $is_IE;
    if( $is_IE ) {
        wp_enqueue_script( THEME_SHORT . '-ie', OXY_THEME_URI. 'javascripts/ie.min.js', array('jquery'), '1.0', true );
    }

    $assets_file_name = 'theme';
    $minified_assets = oxy_get_option('minified_assets');
    if ($minified_assets === 'on' || $minified_assets === false) {
        $assets_file_name = $assets_file_name . '.min';
    }

    wp_enqueue_script( THEME_SHORT . '-theme', OXY_THEME_URI . 'assets/js/' . $assets_file_name . '.js', array( 'jquery', 'wp-mediaelement' ), '1.0', true );


    // load styles
    wp_enqueue_style( THEME_SHORT.'-theme', OXY_THEME_URI . 'assets/css/' . $assets_file_name . '.css', array( 'wp-mediaelement' ), false, 'all' );

    // check if woo commerce is active
    if( oxy_is_woocommerce_active() ) {
        // woocommerce only CSS
        wp_enqueue_style( THEME_SHORT . '-woocommerce', OXY_THEME_URI . 'assets/css/woocommerce.min.css', array(), false, 'all' );
        // woocommerce only JS
        wp_enqueue_script( THEME_SHORT . '-woocommerce', OXY_THEME_URI . 'assets/js/woocommerce.min.js', array( THEME_SHORT . '-theme' ), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'oxy_load_scripts' );

function oxy_add_social_links() {
    // check for social links on single page
    if( is_single() ) {
        if( oxy_get_option( 'fb_show' ) == 'show' ) {
            add_action( 'wp_footer', 'oxy_add_facebook_like_js' );
        }

        if( oxy_get_option( 'twitter_show' ) == 'show' ) {
            add_action( 'wp_footer', 'oxy_add_twitter_js' );
        }

        if( oxy_get_option( 'google_show' ) == 'show' ) {
            add_action( 'wp_footer', 'oxy_add_google_js' );
        }
    }
}
add_action( 'init', 'oxy_add_social_links' );
/*************** SOCIAL LIKE BUTTONS ****************/
function oxy_add_facebook_like_js() { ?>
<div id="fb-root"></div>
<script>!function(a,b,c){var d,e=a.getElementsByTagName(b)[0];a.getElementById(c)||(d=a.createElement(b),d.id=c,d.src="//connect.facebook.net/en_GB/all.js#xfbml=1&status=0",e.parentNode.insertBefore(d,e))}(document,"script","facebook-jssdk");</script>
<?php
}

function oxy_add_twitter_js() { ?>
 <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php
}

function oxy_add_google_js() { ?>
<script>(function(){var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src="https://apis.google.com/js/plusone.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})();</script>
<?php
}

/*************** COMMENTS ***************************/

/** COMMENTS WALKER */
class OxyCommentWalker extends Walker_Comment {

    // init classwide variables
    var $tree_type = 'comment';
    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );


    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

        if ( !$element )
           return;

        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

        // If we're at the max depth, and the current element still has children, loop over those and display them at this level
        // This is to prevent them being orphaned to the end of the list.
        if ( $max_depth <= $depth + 1 && isset( $children_elements[$id]) ) {
            foreach ( $children_elements[ $id ] as $child )
                $this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );

            unset( $children_elements[ $id ] );
        }

    }

    /** CONSTRUCTOR
     * You'll have to use this if you plan to get to the top of the comments list, as
     * start_lvl() only goes as high as 1 deep nested comments */
    function __construct() { ?>



    <?php }

    /** START_LVL
     * Starts the list before the CHILD elements are added. Unlike most of the walkers,
     * the start_lvl function means the start of a nested comment. It applies to the first
     * new level under the comments that are not replies. Also, it appear that, by default,
     * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

                <!--<ul class="children">-->
    <?php }

    /** END_LVL
     * Ends the children list of after the elements are added. */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        <!--</ul>--><!-- /.children -->

    <?php }

    /** START_EL */
    function start_el( &$output, $comment, $depth=0, $args=array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>
        <?php
        switch ( $comment->comment_type ) :
             case 'pingback':
             case 'trackback':
             // Display trackbacks differently than normal comments.
        ?>
        <div>
            <p><?php _e( 'Pingback:', 'swatch-td' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'swatch-td' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
            break;
            default:
            // Proceed with normal comments.
            global $post;
        ?>

        <div <?php comment_class( 'media media-comment' ); ?> >
            <div class="box-round box-mini pull-left">
                <div class="box-dummy box-inner"></div>
                <?php echo get_avatar( $comment, 48 ); ?>
            </div>
            <div class="media-body">
                <div class="media-inner">
                    <div <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
                        <h5 class="media-heading">
                            <?php comment_author_link(); ?>
                            -
                            <?php comment_date(); ?>
                            <span class="comment-reply pull-right">
                                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'swatch-td' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            </span>
                        </h5>
                        <?php comment_text(); ?>
                    </div>
                </div>
    <?php endswitch; ?>

    <?php }

    function end_el(&$output, $comment, $depth = 0, $args = array() ) {
        switch ( $comment->comment_type ) :
            case 'pingback':
            case 'trackback':
             // Display trackbacks differently than normal comments.
        ?>
        </div>
        <?php
            break;
            default:
        ?>
            </div><!-- /media body -->
        </div><!-- /comment-->
        <?php endswitch;
    }

    /** DESTRUCTOR
     * I just using this since we needed to use the constructor to reach the top
     * of the comments list, just seems to balance out :) */
    function __destruct() { ?>

    <!-- /#comment-list -->

    <?php }
}


/**
 * Customize comments form
 *
 *@return void
 *@since 1.0
 **/
function oxy_comment_form( $args = array(), $post_id = null ) {
    global $user_identity, $id;

    if ( null === $post_id )
        $post_id = $id;
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();

    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<div class="control-group"><div class="controls"><input id="author" name="author" placeholder="' . __('YOUR NAME *', 'swatch-td') . '" type="text" class="input-block-level" value="' . esc_attr( $commenter['comment_author'] ) .  '"/></div></div>',
        'email'  => '<div class="control-group"><div class="controls"><input id="email" name="email" placeholder="' . __('YOUR EMAIL *', 'swatch-td') . '" type="text" class="input-block-level" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" /></div></div>',
        'url'    => '',
    );

    $required_text = sprintf( ' ' . __('Required fields are marked %s', 'swatch-td'), '<span class="required"><a>*</a></span>' );
    $defaults = array(
        'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'        => '<div class="control-group message"><div class="controls"><textarea id="comment" name="comment" placeholder="' . __('YOUR MESSAGE', 'swatch-td') . '" class="input-block-level" rows="3"></textarea></div></div>',
        'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'swatch-td' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'swatch-td' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',

        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'title_reply'          => __( 'Add your comment', 'swatch-td' ),
        'title_reply_to'       => __( 'Leave a Reply', 'swatch-td' ),
        'cancel_reply_link'    => __( 'Cancel reply', 'swatch-td' ),
        'label_submit'         => __( 'Add comment', 'swatch-td' ),
    );

    $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

    ?>
        <?php if ( comments_open() ) : ?>
            <?php do_action( 'comment_form_before' ); ?>
            <div class="comments-form"  id="respond">
                <h3 id="reply-title" class="comment-form small-screen-center"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small id="cancel-comment-reply"><?php cancel_comment_reply_link(__( 'Cancel', 'swatch-td' )) ?></small></h3>
                <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
                    <?php echo $args['must_log_in']; ?>
                    <?php do_action( 'comment_form_must_log_in_after' ); ?>
                <?php else : ?>
                    <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
                        <fieldset>
                        <?php do_action( 'comment_form_top' ); ?>
                        <?php if ( is_user_logged_in() ) : ?>
                            <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                            <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
                        <?php else : ?>
                            <?php echo $args['comment_notes_before']; ?>
                            <?php
                            do_action( 'comment_form_before_fields' );
                            foreach( (array) $args['fields'] as $name => $field ) {
                                echo apply_filters( 'comment_form_field_'.$name, $field ) . "\n";
                            }
                            do_action( 'comment_form_after_fields' );
                            ?>
                        <?php endif; ?>
                        <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                        <?php echo $args['comment_notes_after']; ?>
                        <div class="control-group">
                            <div class="controls small-screen-center">
                                <button name="submit" type="submit" class="btn btn-primary" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>"><?php echo esc_attr( $args['label_submit'] ); ?></button>
                                <?php comment_id_fields(); ?>
                            </div>
                        </div>


                        <?php do_action( 'comment_form', $post_id ); ?>
                        </fieldset>
                    </form>
                <?php endif; ?>
            </div><!-- #respond -->
            <?php do_action( 'comment_form_after' ); ?>
        <?php else : ?>
            <?php do_action( 'comment_form_comments_closed' ); ?>
        <?php endif; ?>
    <?php
}

/**
 * Enables threaded comments
 *
 *@return void
 *@since 1.0
 **/

function oxy_enable_threaded_comments(){
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script('comment-reply');
    }
}

add_action('get_header', 'oxy_enable_threaded_comments');


/**
 * Add theme support for automatic feed links. required by developer.
 *
 **/
add_theme_support( 'automatic-feed-links' );

/*
 * add theme support for post formats.
 **/
add_theme_support( 'post-formats', array( 'gallery', 'video', 'link', 'audio', 'quote' ) );

// add support for featured images
add_theme_support( 'post-thumbnails' );


/*
 * Set theme content width. Required
 *
 **/
if ( ! isset( $content_width ) )  {
    $content_width = 1170;
}


/**
 * Adds rounded class to avatars
 *
 * @return modified css
 * @since 1.0
 **/
function oxy_change_avatar_css($class , $id , $size) {
    // if it's the admin bar , don't touch it.
    if( $size == 150 || $size == 48 || $size == 300 ) {
        // comment walker sends an object
        if( is_object( $id ) ) {
            $author_url = $id->user_id == 0 ? '#' : get_author_posts_url( $id->user_id );
        }
        else {
            $author_url = get_author_posts_url( $id );
        }
        // show avatar option
        if( oxy_get_option('site_avatars') == 'on'){
            $class = str_replace("class='avatar", "class='media-object img-circle ", $class);
            return  '<a class="pull-left" href="' . $author_url . '">' . $class . '</a>';
        }
        //don't show anything
        return '';
    }
    return $class;

}
add_filter( 'get_avatar', 'oxy_change_avatar_css' ,10 , 5);


// override default tag cloud widget output
function oxy_custom_wp_tag_cloud_filter($content, $args) {
    $content = str_replace('<a' , '<li><a' , $content);
    $content = str_replace('</a>' , '</a></li>' , $content);
    return '<ul>'. $content . '</ul>';
}

add_filter('wp_tag_cloud','oxy_custom_wp_tag_cloud_filter', 10, 2);


/* function to return an icon depending the format of the post */

function oxy_post_icon( $post_id , $echo =true){
    $format = get_post_format( $post_id );
    switch ($format) {
        case 'gallery':
            $output = '<i class="fa fa-picture-o"></i>';
            break;
        case 'link':
            $output = '<i class="fa fa-link"></i>';
            break;
        case 'quote':
            $output = '<i class="fa fa-quote-left"></i>';
            break;
        case 'audio':
            $output = '<i class="fa fa-volume-up"></i>';
            break;
        case 'video':
            $output = '<i class="fa fa-play"></i>';
            break;
        default:
            $output = '<i class="fa fa-file-text"></i>';
            break;
    }
    if($echo)
        echo $output;
    else
        return $output;
}

// use option read more link
add_filter( 'the_content_more_link', 'oxy_filter_more_link', 10, 2 );

function oxy_filter_more_link( $more_link, $more_link_text ) {
    // remove #more
    $more_link = preg_replace( '|#more-[0-9]+|', '', $more_link );
    return str_replace( $more_link_text, oxy_get_option('blog_readmore'), $more_link );
}

function oxy_read_more_link( $echo = true){
    global $post;
    $output = "";
    if( isset( $post ) ) {
        $more_text = oxy_get_option('blog_readmore')? oxy_get_option('blog_readmore'): 'Read more';
        $output .= '<p><a href="'. get_permalink().'" class="more-link">'.$more_text.'</a></p>';
    }

    if($echo == true){
        echo $output;
    }
    else{
        return $output;
    }
}

function oxy_get_content_shortcode( $post, $shortcode_name ) {
    $pattern = get_shortcode_regex();
    // look for an embeded shortcode in the post content
    if( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( $shortcode_name, $matches[2] ) ) {
        return $matches;
    }
}

function oxy_get_content_gallery( $post ) {
    $pattern = get_shortcode_regex();
    $gallery_ids = null;
    if( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( 'gallery', $matches[2] ) ) {
        // gallery shortcode is being used

        // do we have some attribues?
        if( array_key_exists( 3, $matches ) ) {
            if( array_key_exists( 0, $matches[3] ) ) {
                $gallery_attrs = shortcode_parse_atts( $matches[3][0] );
                if( array_key_exists( 'ids', $gallery_attrs) ) {
                    $gallery_ids = explode( ',', $gallery_attrs['ids'] );
                    return $gallery_ids;
                }
            }
        }
    }
}


/**
 * Gets the url that a slide should link to
 *
 * @return url link
 * @since 1.2
 **/
function oxy_get_slide_link( $post ) {
    $link_type = get_post_meta( $post->ID, THEME_SHORT . '_link_type', true );
    switch( $link_type ) {
        case 'page':
            $id = get_post_meta( $post->ID, THEME_SHORT . '_page_link', true );
            return esc_url(get_permalink( $id ));
        break;
        case 'post':
            $id = get_post_meta( $post->ID, THEME_SHORT . '_post_link', true );
            return esc_url(get_permalink( $id ));
        break;
        case 'category':
            $slug = get_post_meta( $post->ID, THEME_SHORT . '_category_link', true );
            $cat = get_category_by_slug( $slug );
            return esc_url(get_category_link( $cat->term_id ));
        break;
        case 'portfolio':
            $id = get_post_meta( $post->ID, THEME_SHORT . '_portfolio_link', true );
            return esc_url(get_permalink( $id ));
        break;
        case 'url':
            return esc_url(get_post_meta( $post->ID, THEME_SHORT . '_url_link', true ));
        break;
        case 'none':
            return '';
        break;
        case 'default':
        default:
            return esc_url(get_permalink( $post ));
        break;
    }
}



/*----------------- CREATES A FLEXSLIDER -----------------*/
function oxy_create_flexslider( $slug_or_ids, $options = array(), $echo = true ) {
    global $oxy_theme_options;
    global $post;
    $tmp_post = $post;
    extract( shortcode_atts( array(
        'animation'          => $oxy_theme_options['animation'],
        'speed'              => $oxy_theme_options['speed'],
        'duration'           => $oxy_theme_options['duration'],
        'directionnav'       => $oxy_theme_options['directionnav'],
        'directionnavtype'   => $oxy_theme_options['directionnavtype'],
        'controlsposition'   => $oxy_theme_options['controlsposition'],
        'itemwidth'          => '',
        'showcontrols'       => $oxy_theme_options['showcontrols'],
        'controlsalign'      => $oxy_theme_options['controlsalign'],
        'captions'           => $oxy_theme_options['captions'],
        'captions_vertical'  => $oxy_theme_options['captions_vertical'],
        'captions_horizontal'=> $oxy_theme_options['captions_horizontal'],
        'captions_swatch'    => $oxy_theme_options['captions_swatch'],
        'autostart'          => $oxy_theme_options['autostart'],
        'tooltip'            => $oxy_theme_options['tooltip'],
    ), $options ) );

    if( is_array( $slug_or_ids ) ){
        $slides = get_posts( array( 'post_type' => 'attachment', 'post__in' => $slug_or_ids, 'orderby' => 'post__in', 'posts_per_page' => -1 ) );
        $captions = 'hide';
    }
    else {
        $slides = get_posts( array(
            'numberposts' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'oxy_slideshow_categories',
                    'field' => 'slug',
                    'terms' => $slug_or_ids
                )
            ),
            'post_type' => 'oxy_slideshow_image',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
    }
    $flex_itemwidth = ( $itemwidth!=='' )?' data-flex-itemwidth='.$itemwidth.'px':'';
    $id = 'flexslider-' . rand(1,100);
    $output = '';
    $output .= '<div id="' . $id . '" class="flexslider feature-slider"'.$flex_itemwidth.' data-flex-animation="'.$animation.'" data-flex-controlsalign="'.$controlsalign.'" data-flex-controlsposition="'.$controlsposition.'" data-flex-directions="'.$directionnav.'" data-flex-directions-type="'.$directionnavtype.'" data-flex-speed="'.$speed.'" data-flex-controls="'.$showcontrols.'" data-flex-slideshow="' . $autostart . '" data-flex-duration="'.$duration.'" data-flex-captionvertical="'.$captions_vertical.'" data-flex-captionhorizontal="'.$captions_horizontal.'">';
    $output .= '<ul class="slides">';

    global $post;
    foreach( $slides as $post ) {
        setup_postdata( $post );
        $output .= '<li><figure>';

        if( $post->post_type == 'attachment' ) {
            // Don't link anuwhere for now.
            //$output .= '<a class="magnific hover-animate" rel="' . $id . '" href="' . $post->guid . '">';
            $output .= '<img src="' . $post->guid . '"  alt="'. basename ( get_attached_file($post->ID) ).'"/>';
            //$output .= '</a>';
        }
        else {
            $link = oxy_get_slide_link( $post );
            if( '' !== $link ) {
                $output .= '<a href="' . $link . '">';
            }
            $tooltip_attrs = array();
            if( $tooltip == 'show'){
                $tooltip_attrs['data-original-title'] = get_the_title();
                $tooltip_attrs['data-toggle'] = 'tooltip';
            }
            $output .= get_the_post_thumbnail( $post->ID, 'full', $tooltip_attrs );
            if( '' !== $link ) {
                $output .= '</a>';
            }
        }
        if( $captions == 'show') {
            $output .= '<figcaption class="'.$captions_swatch.'"><h4>' . oxy_filter_title( get_the_title() ) . '</h4><p>'.get_the_content().'</p></figcaption>';
        }
        $output .= '</figure></li>';
    }
    $output .=  '</ul></div>';

    $post = $tmp_post;
    if( $post !== null ) {
        setup_postdata( $post );
    }
    if( $echo ) {
        echo $output;
    }
    else {
        return $output;
    }
}


/* --------------- add a wrapper for the embeded videos -------------*/
add_filter('embed_oembed_html', 'oxy_add_video_embed_note', 10, 3);

function oxy_add_video_embed_note( $html, $url, $attr ) {
    $parsed_url = parse_url( $url );
    if( strpos( $parsed_url['host'], 'youtube.com' ) !== false ||
        strpos( $parsed_url['host'], 'vimeo.com' ) !== false ||
        strpos( $parsed_url['host'], 'wordpress.tv' ) !== false ) {
        return '<div class="videoWrapper feature-video">'. $html .'</div>';
    }
    else {
        return $html;
    }
}



function oxy_create_hero_section( $image = null, $title = null ) {
    $image = $image === null ? get_header_image() : $image;
?>
<section class="section section-alt">
    <div class="row-fluid">
        <div class="super-hero-unit">
            <figure>
                <img alt="some image" src="<?php echo $image; ?>">
            </figure>
        </div>
    </div>
</section>
<?php
}

/* Function for replacing title contents including underscores with span tags*/
function oxy_filter_title( $title ) {
    $title = preg_replace("/_(.*)_\b/",'<span class="light">$1</span>' , $title);
    return $title;
}

/* function for limiting the excerpt */
function oxy_limit_excerpt($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if( count($words) > $word_limit ) {
        array_pop($words);
    }
    return implode(' ', $words).'...';
}

function oxy_remove_readmore_span($content) {
    global $post;
    if( isset( $post ) ) {
        $content = str_replace('<span id="more-' . $post->ID . '"></span><!--noteaser-->', '', $content);
        $content = str_replace('<span id="more-' . $post->ID . '"></span>', '', $content);
    }
    return $content;
}
add_filter('the_content', 'oxy_remove_readmore_span');


function oxy_fix_shortcodes($content) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'oxy_fix_shortcodes');


function change_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'change_excerpt_more');


// add custom active class in menu items
function custom_active_item_class($classes = array(), $menu_item = false){
    if(in_array('current-menu-item', $menu_item->classes)){
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'custom_active_item_class', 10, 2 );

/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * Roots_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 */
class OxyBoostrapNavWalker extends Walker_Nav_Menu {
    function check_current( $classes ) {
        return preg_match('/(current[-_])|active|dropdown/', $classes);
    }

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "\n<ul class=\"dropdown-menu datanew \">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $oxy_is_iphone, $oxy_is_android, $oxy_is_ipad;
        $item_html = '';
        parent::start_el($item_html, $item, $depth, $args);

        if( $item->is_dropdown && ($depth === 0) ) {
            $hover_attr = "";
            $disabled = "";
            if( oxy_get_option( 'menu' ) == 'hover' && !$oxy_is_iphone && !$oxy_is_android && !$oxy_is_ipad ){
                $hover_attr = 'data-hover="dropdown" data-delay="300"';
                $disabled = 'disabled';
            }
            $item_html = str_replace('<a', '<a class="dropdown-toggle '.$disabled.'" data-toggle="dropdown" '.$hover_attr.' data-target="#"', $item_html);
            //$item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);
        }
        elseif( stristr($item_html, 'li class="divider') ) {
            $item_html = preg_replace('/<a[^>]*>.*?<\/a>/iU', '', $item_html);
        }
        elseif( stristr($item_html, 'li class="nav-header') ) {
            $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html);
        }

        $output .= $item_html;
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        $element->is_dropdown = !empty( $children_elements[$element->ID] );

        if( $element->is_dropdown ) {
            if( $depth === 0 ) {
                $element->classes[] = 'dropdown';
            }
            elseif( $depth === 1 ) {
                $element->classes[] = 'dropdown-submenu';
            }
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}



// returns the hover color for each icon
function oxy_get_icon_color( $icon ) {
    $icon = str_replace('fa-', '', $icon);
    $icon = str_replace('icon-', '', $icon);
    switch( $icon ) {
        case 'adn':
            return '#003871 ';
        case 'android':
            return '#a4c639';
        case 'apple':
            return '#333333';
        case 'bitbucket':
        case 'bitbucket-sign':
            return '#205081';
        case 'bitcoin':
            return 'EE4000';
        case 'btc':
            return '#1d417a';
        case 'css3':
            return '#404040';
        case 'dribbble':
            return '#ea4c89';
        case 'dropbox':
            return '#3d9ae8';
        case 'facebook':
        case 'facebook-sign':
            return '#3b5998';
        case 'flickr':
            return '#0063dc';
        case 'foursquare':
            return '#25a0ca';
        case 'github':
        case 'github-alt':
        case 'github-sign':
            return '#4183c4';
        case 'gittip':
            return '#614C3E';
        case 'google-plus':
        case 'google-plus-sign':
            return '#E45135';
        case 'html5':
            return '#ec6231';
        case 'instagram':
            return '#634d40';
        case 'linkedin':
        case 'linkedin-sign':
            return '#5FB0D5';
        case 'linux':
        return '#294170';
        case 'maxcdn':
            return '#e47911';
        case 'pinterest':
        case 'pinterest-sign':
            return '#910101';
        case 'renren':
            return '#005eac';
        case 'skype':
            return '#00aff0';
        case 'stackexchange':
            return '#3a6da6';
        case 'trello':
            return '#00c6d4';
        case 'tumblr':
        case 'tumblr-sign':
            return '#34526f';
        case 'twitter':
        case 'twitter-sign':
            return '#00a0d1';
        case 'vk':
            return '#2B587A';
        case 'weibo':
            return '#e64141';
        case 'windows':
            return '#00CCFF';
        case 'xing':
        case 'xing-sign':
            return '#126567';
        case 'youtube':
        case 'youtube-play':
        case 'youtube-sign':
            return '#c4302b';
        default:
            return '#ff0000';
    }
}

/* Function that renders a header on pages*/
function oxy_page_header( $swatch = null, $title = null, $subtitle = null, $align = null) {
    global $post;
    $show_header = true;
    $capitalise = '';
    // single page view , get the page meta
    if($swatch == null){
        if( get_post_meta( $post->ID, THEME_SHORT . '_show_header', true ) == 'show'){
            $swatch   = get_post_meta( $post->ID, THEME_SHORT . '_header_swatch', true );
            $subtitle = get_post_meta( $post->ID, THEME_SHORT . '_header_subtitle', true );
            $align    = get_post_meta( $post->ID, THEME_SHORT . '_align_header', true );
            $title    = get_the_title($post->ID);
            $capitalise = get_post_meta( $post->ID, THEME_SHORT . '_header_capitalisation', true );
        }
        else{
            $show_header = false;
        }
    }
    if($show_header):?>
    <section class="section <?php echo $swatch; ?>">
        <div class="container">
            <h1 class="super text-<?php echo $align; ?> <?php echo $capitalise; ?>">
                <?php echo $title; ?>
                <small><?php echo $subtitle; ?> </small>
            </h1>
        </div>
    </section>
    <?php
    endif;
}

// Renders the Top bar header section
function oxy_top_bar_nav(){ ?>

<div id="top-bar" class="<?php echo oxy_get_option('top_bar_swatch'); ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <?php dynamic_sidebar( 'above-nav-left' ); ?>
            </div>
            <div class="span6">
                <?php dynamic_sidebar( 'above-nav-right' ); ?>
            </div>
        </div>
    </div>
</div>

<?php
}

function oxy_get_external_link(){
    global $post;
    $link_shortcode = oxy_get_content_shortcode( $post, 'link' );
    if( $link_shortcode !== null ) {
        if( isset( $link_shortcode[5] ) ) {
            $link_shortcode = $link_shortcode[5];
            if( isset( $link_shortcode[0] ) ) {
                return $link_shortcode[0] ;
            }
            else{
                return get_permalink();
            }
        }
    }
}



//Renders the middle header part when we don't have a combo menu with 3 sections
function oxy_standard_nav(){?>

<nav class="standard navbar navbar-<?php echo oxy_get_option('header_type') == 'standard'? oxy_get_option('header_position'):'static' ; ?>-top <?php echo oxy_get_option('header_type')=='combo'? oxy_get_option('header_swatch'): ""; ?>">
    <div class="navbar-inner newheaderdata">
        <div class="containe" style="padding:0px 14px;">
            <a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php oxy_create_logo(); ?>
            <nav class="nav-collapse collapse" role="navigation">
				
				
				<?php
                if( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav pull-right', 'depth' => 3, 'walker' => new OxyBoostrapNavWalker() ) );
                }
                ?>
				
                <div class="menu-sidebar hidden-phone pull-right">
                    <?php //dynamic_sidebar( 'menu-bar' ); ?>
                    <div class='mincart'>
                    <div class='cart_data'>
                    <a href="<?php echo site_url()?>/newcart/">
        <i class="fa fa-shopping-cart"></i>
						<?php
							//sesssion_destroy();
						  //print_r($_SESSION['cart']);
						if(isset($_SESSION['cart'])){
							$tot = count($_SESSION['cart']);
							$single_price = 0;
							foreach($_SESSION['cart'] as $key=>$val){
						     $single =  get_post_meta($key,'price_of_single_ticket',true);
							  $single_price += $single*$val['quantity'];
							}
						}else{
							$single_price = 0;$tot = 0;
						}	
						?>
						
        <span class='cart_counting'><?php echo $tot;?></span>
        -
        <span class="woocommerce-Price-amount amount "> £ <span class="total_amount" data-total="<?php echo $single_price;?>"><?php echo number_format( $single_price,2);?></span></span>    </a></div>
                    </div>

                </div>
				<?php
							
					if(is_user_logged_in()){
					global $wpdb;
					$userdetails = wp_get_current_user();

					 $user =  $userdetails->ID;
							
				  $balance = $wpdb->get_var("SELECT SUM(price) FROM `PQrlH_transactions` WHERE user_id = $user AND payment_type!='charity_fund' AND payment_type!='subscription'");
				  $balance;
				?>
				<ul id="menu-main-header" class="nav pull-right">
<li id="menu-item-1494" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1494"><a href="#">Balance  £  <?php echo number_format($balance,2);?></a></li>
</ul><?php } ?>
                <ul id="menu-main-header" class="nav pull-left"><li id="menu-item-1135" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1135"><a href="<?php echo site_url()?>/allcompetiton/">Competitions</a></li>
                    <li id="menu-item-1136" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1136"><a href="<?php echo site_url()?>/allwinners/">Winners</a></li>
					 <li id="menu-item-1136" class="menu-item visible-phone menu-item-type-custom menu-item-object-custom menu-item-1136"><a href="<?php echo site_url()?>/newcart/">
        <i class="fa fa-shopping-cart"></i>
						<?php
							//sesssion_destroy();
						  //print_r($_SESSION['cart']);
						if(isset($_SESSION['cart'])){
							$tot = count($_SESSION['cart']);
							$single_price = 0;
							foreach($_SESSION['cart'] as $key=>$val){
						     $single =  get_post_meta($key,'price_of_single_ticket',true);
							  $single_price += $single*$val['quantity'];
							}
						}else{
							$single_price = 0;$tot = 0;
						}	
						?>
						
        <span class='cart_counting'><?php echo $tot;?></span>
        -
        <span class="woocommerce-Price-amount amount "> £ <span class="total_amount" data-total="<?php echo $single_price;?>"><?php echo number_format( $single_price,2);?></span></span>    </a></li>
                    </ul>
                

            </nav>

        </div>
    </div>
</nav>

<?php
}

// Renders middle and bottom header section when we have a combo option
function oxy_combo_nav(){ ?>
<!-- render the alternate middle bar first -->
<div class="top-header <?php echo oxy_get_option('header_swatch'); ?>">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <?php oxy_create_logo(); ?>
            </div>
            <div class="span6">
                <?php dynamic_sidebar( 'middle-nav-right' ); ?>
            </div>
        </div>
    </div>
</div>
<!-- render the bottom nav if we have a combo type menu -->
<div class="<?php echo oxy_get_option('bottom_bar_swatch'); ?>">
    <nav class="navbar navbar-static-top navbar-topbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <nav class="nav-collapse collapse" role="navigation">
                    <div class="menu-sidebar pull-right">
                        <?php dynamic_sidebar( 'menu-bar' ); ?>
                    </div>
                    <?php
                    if( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav pull-left', 'depth' => 3, 'walker' => new OxyBoostrapNavWalker() ) );
                    }
                    ?>
                </nav>
            </div>
        </div>
    </nav>
</div>
<?php
}



// SEARCH WIDGET OUTPUT OVERRIDE

/* -------------------- OVERRIDE DEFAULT SEARCH WIDGET OUTPUT ------------------*/
function oxy_custom_search_form( $form ) {

    $output = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" ><div class="input-append row-fluid">';

    $output.= '<input type="text" value="' . get_search_query() . '" name="s" id="s" class="span12" placeholder="' . __('SEARCH', 'swatch-td') . '"/>';

    $output.= '<button type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" ><i class="fa fa-search"></i></button></div></form>';

    return $output;
}
add_filter( 'get_search_form', 'oxy_custom_search_form' );


// REMOVING DEFAULT CONTACT FORM 7 STYLES
add_action( 'wp_print_styles', 'oxy_remove_cf7_css', 100 );

function oxy_remove_cf7_css(){
    wp_deregister_style( 'contact-form-7' );
}

function oxy_pagination( $pages = '', $range = 2, $echo = true ) {
    switch( oxy_get_option( 'blog_pagination' ) ) {
        case 'next_prev':
            global $wp_query;
            $output = '';
            if( $wp_query->max_num_pages > 1 ) {
                $output .= '<nav id="nav-below" class="post-navigation">';
                $output .= '<ul class="pager">';
                $output .= '<li class="previous">' . get_next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'swatch-td' ) ) . '</li>';
                $output .= '<li class="next">' . get_previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'swatch-td' ) ) . '</li>';
                $output .= '</ul>';
                $output .= '</nav>';
            }
        break;
        case 'pages':
        default:
            $showitems = ($range * 2)+1;
            //$showitems =2;
            global $paged;
            if(empty($paged)) {
                $paged = 1;
            }

            if($pages == '') {
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if(!$pages) {
                    $pages = 1;
                }
            }

            $output = '';
            if(1 != $pages) {
                $output.= '<div class="pagination pagination-small pagination-centered '.oxy_get_option('pagination_swatch').'"><ul>';
                if($paged > 2 && $paged > $range+1 && $showitems < $pages)
                    $output.= "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
                if($paged > 1 && $showitems < $pages)
                    $output.= "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

                for($i=1; $i <= $pages; $i++) {
                    if(1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                        $output.= ($paged == $i) ? '<li class="active"><span class="current">' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link($i) . '" class="inactive">' . $i . '</a></li>';
                    }
                }

                if ($paged < $pages && $showitems < $pages)
                    $output.= "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
                if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages)
                    $output.= "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
                $output.= "</ul></div>\n";
            }
        break;
    }

    if($echo == true) {
        echo $output;
    }
    else {
        return $output;
    }
}

function oxy_portfolio_pagination() {
    global $wp_query;
    global $paged;
    $output = '';
    $range = 2;

    $paged = $wp_query->query_vars['paged'];

    // only show pages if we have more than 1
    if( $wp_query->max_num_pages > 1 ) :
        $output .= '<div class="pagination pagination-small pagination-centered '.oxy_get_option('pagination_swatch').'">';
        $output .= '<ul>';
        if ( $paged > 1 ) {
            $output .= '<li>';
        }
        else {
            $output .= '<li class="disabled">';
        }
        if( $paged > 1 ) {
            $output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '"><i class="fa fa-angle-left"></i></a>';
        }
        else {
            $output .= '<a><i class="fa fa-angle-left"></i></a>';
        }
        $output .= '</li>';

        for( $i = 1; $i <= $wp_query->max_num_pages; $i++ ) :
            if( $paged == $i ) {
                $output .= '<li class="active"><a class="current">' . $i . '</a></li>';
            }
            else {
                $output .= '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
            }
                $output .= '</li>';
        endfor;
            if ( $paged < $wp_query->max_num_pages ) {
                $output .= '<li>';
            }
            else {
                $output .= '<li class="disabled">';
            }
            if( $paged < $wp_query->max_num_pages ) {
                $output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '">
                                <i class="fa fa-angle-right"></i>
                            </a>';
            }
            else {
                $output .= '<a><i class="fa fa-angle-right"></i></a>';
            }
        $output .= '</li></ul></div>';
    endif;

    return $output;
}

/**
 * Bootstrap the page links under a post
 *
 * @return void
 * @author
 **/
function oxy_wp_link_pages($args = '') {
    $defaults = array(
        'before' => '' ,
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'next_or_number' => 'number',
        'nextpagelink' => __('Next page', 'swatch-td' ),
        'previouspagelink' => __('Previous page', 'swatch-td' ),
        'pagelink' => '%',
        'echo' => 1
    );

    $r = wp_parse_args( $args, $defaults );
    $r = apply_filters( 'wp_link_pages_args', $r );
    extract( $r, EXTR_SKIP );

    global $page, $numpages, $multipage, $more, $pagenow;

    $output = '';
    if ( $multipage ) {
        if ( 'number' == $next_or_number ) {
            $output .= $before . '<ul>';
            $laquo = $page == 1 ? 'class="disabled"' : '';
            $output .= '<li ' . $laquo .'>' . _wp_link_page($page -1) . '&laquo;</a></li>';
            for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
                $j = str_replace('%',$i,$pagelink);

                if ( ($i != $page) || ((!$more) && ($page==1)) ) {
                    $output .= '<li>';
                    $output .= _wp_link_page($i) ;
                }
                else{
                    $output .= '<li class="active">';
                    $output .= _wp_link_page($i) ;
                }
                $output .= $link_before . $j . $link_after ;
                $output .= '</a>';

                $output .= '</li>';
            }
            $raquo = $page == $numpages ? 'class="disabled"' : '';
            $output .= '<li ' . $raquo .'>' . _wp_link_page($page +1) . '&raquo;</a></li>';
            $output .= '</ul>' . $after;
        }
        else {
            if ( $more ) {
                $output .= $before . '<ul class="pager">';
                $i = $page - 1;
                if ( $i && $more ) {
                    $output .= '<li class="previous">' . _wp_link_page($i);
                    $output .= $link_before. $previouspagelink . $link_after . '</a></li>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
                    $output .= '<li class="next">' .  _wp_link_page($i);
                    $output .= $link_before. $nextpagelink . $link_after . '</a></li>';
                }
                $output .= '</ul>' . $after;
            }
        }
    }

    if ( $echo ) {
        echo $output;
    }

    return $output;
}

function oxy_post_thumbnail_name($post , $echo = false){
    $name = basename ( get_attached_file(  get_post_thumbnail_id($post->ID)) );
    if($echo == true){
        echo $name;
    }
    else{
        return $name;
    }
}

function oxy_remove_category_list_rel( $output ) {
    // make rel valid
    return str_replace( ' rel="category tag"', ' rel="tag"', $output );
}
add_filter( 'wp_list_categories', 'oxy_remove_category_list_rel' );
add_filter( 'the_category', 'oxy_remove_category_list_rel' );

// remove site header on pages with the site header turned off
function oxy_filter_body_class( $classes ) {
    if( is_page() ) {
        global $post;
        if( get_post_meta( $post->ID, THEME_SHORT . '_show_site_header', true ) === 'hide' ) {
            $classes[] = 'no-header';
        }
    }

    // current language code if wpml is installed
    if (function_exists('icl_get_home_url')) {
          $classes[] = ICL_LANGUAGE_CODE;
    }

    // add classes for mobile agents
    global $oxy_is_iphone, $oxy_is_android, $oxy_is_ipad;
    if($oxy_is_iphone){
        $classes[] = 'oxy-agent-iphone';
    }
    else if($oxy_is_ipad){
        $classes[] = 'oxy-agent-ipad';
    }
    else if($oxy_is_android){
        $classes[] = 'oxy-agent-android';
    }

    return $classes;
}
add_filter( 'body_class', 'oxy_filter_body_class');


function oxy_is_woocommerce_active() {
    // check if woo commerce is active
    return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

function oxy_woo_page_title( $echo = false ){
    if( is_search() ) {
        $page_title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
        if ( get_query_var( 'paged' ) ){
            $page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
        }
    }
    elseif( is_tax() ) {
        $page_title = single_term_title( "", false );

    }
    else {
        $shop_page_id = woocommerce_get_page_id( 'shop' );
        $page_title   = get_the_title( $shop_page_id );
    }
    if($echo){
        echo $page_title;
    }
    else{
        return $page_title;
    }
}

function oxy_woo_shop_header(){
    // get currenct category
    $category = get_queried_object();
    if (isset($category->term_id)){
        // options: text , none , slideshow
        $header_type = get_option( THEME_SHORT . '-tax-mtb-category_header_type'. $category->term_id);
        $description = get_option( THEME_SHORT . '-tax-mtb-category_header_subtitle'. $category->term_id);
        switch ($header_type) {
            case 'text':
                oxy_page_header( oxy_get_option('woocom_header_swatch'), oxy_woo_page_title(), $description , 'center');
                break;
            case 'slideshow':
                if( function_exists( 'putRevSlider' ) ) {
                    putRevSlider( get_option( THEME_SHORT . '-tax-mtb-category_revolution'. $category->term_id) );
                }
            default:
                break;
        }
     }
}

/**
 * Creates a font awesome tag
 *
 * @return HTML i tag
 **/
function oxy_font_awesome_icon($icon_name, $atts = array()) {
    $icon_class = strpos($icon_name, 'icon-') === false ? $icon_name : str_replace('icon-', '', $icon_name);
    $icon = '<i class="fa fa-' . $icon_class . '"';
    foreach ($atts as $attr => $value) {
        $icon .= ' ' . $attr . '="' . $value . '"';
    }
    $icon .= '></i>';
    return $icon;
}

function oxy_fix_paged_redirects( $redirect_url, $requested_url ) {
    if ( strpos( $requested_url, 'page/' ) !== false )
        return $requested_url;

    return $redirect_url;
}

add_filter( 'redirect_canonical', 'oxy_fix_paged_redirects', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function oxy_set_wp_title($title, $sep)
{
    if (is_feed()) {
        return $title;
    }

    global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo('name', 'display');

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title .= ' ' . $sep . ' ' . $site_description;
    }

    // Add a page number if necessary:
    if (($paged >= 2 || $page >= 2) && ! is_404()) {
        $title .= ' ' . $sep  . ' ' . sprintf(__('Page %s', 'swatch-td'), max($paged, $page));
    }

    return $title;
}
add_filter('wp_title', 'oxy_set_wp_title', 10, 2);
