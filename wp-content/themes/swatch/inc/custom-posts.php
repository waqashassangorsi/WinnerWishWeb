<?php
/**
 * Oxygenna.com
 *
 * :: *(TEMPLATE_NAME)*
 * :: *(COPYRIGHT)*
 * :: *(LICENCE)*
 */

function oxy_fetch_custom_columns($column)
{
    global $post;
    switch($column) {
        case 'menu_order':
            echo $post->menu_order;
            echo '<input id="qe_slide_order_"' . $post->ID . '" type="hidden" value="' . $post->menu_order . '" />';
            break;

        case 'featured-image':
            $editlink = get_edit_post_link($post->ID);
            echo '<a href="' . $editlink . '">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</a>';
            break;

        case 'slideshows-category':
            echo get_the_term_list($post->ID, 'oxy_slideshow_categories', '', ', ');
            break;

        case 'service-category':
            echo get_the_term_list($post->ID, 'oxy_service_category', '', ', ');
            break;

        case 'departments-category':
            echo get_the_term_list($post->ID, 'oxy_staff_department', '', ', ');
            break;

        case 'job-title':
            echo get_post_meta($post->ID, THEME_SHORT . '_position', true);
            break;

        case 'portfolio-category':
            echo get_the_term_list($post->ID, 'oxy_portfolio_categories', '', ', ');
            break;

        case 'testimonial-group':
            echo get_the_term_list($post->ID, 'oxy_testimonial_group', '', ', ');
            break;
        case 'testimonial-citation':
            echo get_post_meta($post->ID, THEME_SHORT . '_citation', true);
            break;

        default:
            // do nothing
            break;
    }
}
add_action('manage_posts_custom_column', 'oxy_fetch_custom_columns');

/**
 * Slideshow Custom Post
 */

$labels = array(
    'name'               => __( 'Slideshow Images', 'swatch-admin-td' ),
    'singular_name'      => __( 'Slideshow Image', 'swatch-admin-td' ),
    'add_new'            => __( 'Add New', 'swatch-admin-td' ),
    'add_new_item'       => __( 'Add New Image', 'swatch-admin-td' ),
    'edit_item'          => __( 'Edit Image', 'swatch-admin-td' ),
    'new_item'           => __( 'New Image', 'swatch-admin-td' ),
    'view_item'          => __( 'View Image', 'swatch-admin-td' ),
    'search_items'       => __( 'Search Images', 'swatch-admin-td' ),
    'not_found'          => __( 'No images found', 'swatch-admin-td' ),
    'not_found_in_trash' => __( 'No images found in Trash', 'swatch-admin-td' ),
    'menu_name'          => __( 'Slider Images', 'swatch-admin-td' )
);

$args = array(
    'labels'    => $labels,
    'public'    => false,
    'show_ui'   => true,
    'query_var' => false,
    'rewrite'   => false,
    'supports'  => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' )
);

// create custom post
register_post_type( 'oxy_slideshow_image', $args );

// Register slideshow taxonomy
$labels = array(
    'name'          => __( 'Slideshows', 'swatch-admin-td' ),
    'singular_name' => __( 'Slideshow', 'swatch-admin-td' ),
    'search_items'  => __( 'Search Slideshows', 'swatch-admin-td' ),
    'all_items'     => __( 'All Slideshows', 'swatch-admin-td' ),
    'edit_item'     => __( 'Edit Slideshow', 'swatch-admin-td'),
    'update_item'   => __( 'Update Slideshow', 'swatch-admin-td'),
    'add_new_item'  => __( 'Add New Slideshow', 'swatch-admin-td'),
    'new_item_name' => __( 'New Slideshow Name', 'swatch-admin-td')
);

register_taxonomy(
    'oxy_slideshow_categories',
    'oxy_slideshow_image',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => false,
        'rewrite'      => false
    )
);

// move featured image box on slideshow
function oxy_move_slideshow_meta_box() {
    remove_meta_box( 'postimagediv', 'oxy_slideshow_image', 'side' );
    add_meta_box('postimagediv', __('Slideshow Image', 'swatch-admin-td'), 'post_thumbnail_meta_box', 'oxy_slideshow_image', 'advanced', 'low');
}
add_action('do_meta_boxes', 'oxy_move_slideshow_meta_box');


function oxy_edit_columns_slideshow($columns)
{
    $columns = array(
        'cb'                  => '<input type="checkbox" />',
        'title'               => __('Image Title', 'swatch-admin-td'),
        'featured-image'      => __('Image', 'swatch-admin-td'),
        'menu_order'          => __('Order', 'swatch-admin-td'),
        'slideshows-category' => __('Slideshows', 'swatch-admin-td'),
    );
    return $columns;
}
add_filter('manage_edit-oxy_slideshow_image_columns', 'oxy_edit_columns_slideshow');


function edit_columns($columns) {
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Image Title', 'swatch-admin-td'),
        'slide-thumb' => __('Image', 'swatch-admin-td'),
        'menu_order' => __('Order', 'swatch-admin-td'),
        'slideshows' => __('Slideshows', 'swatch-admin-td'),
    );
    return $columns;
}

add_filter( 'manage_edit-slideshow_image_columns', 'edit_columns' );
add_action( 'manage_posts_custom_column', 'oxy_fetch_custom_columns' );

/* --------------------- SERVICES ------------------------*/

$labels = array(
    'name'               => __('Services', 'swatch-admin-td'),
    'singular_name'      => __('Service', 'swatch-admin-td'),
    'add_new'            => __('Add New', 'swatch-admin-td'),
    'add_new_item'       => __('Add New Service', 'swatch-admin-td'),
    'edit_item'          => __('Edit Service', 'swatch-admin-td'),
    'new_item'           => __('New Service', 'swatch-admin-td'),
    'all_items'          => __('All Services', 'swatch-admin-td'),
    'view_item'          => __('View Service', 'swatch-admin-td'),
    'search_items'       => __('Search Services', 'swatch-admin-td'),
    'not_found'          => __('No Service found', 'swatch-admin-td'),
    'not_found_in_trash' => __('No Service found in Trash', 'swatch-admin-td'),
    'menu_name'          => __('Services', 'swatch-admin-td')
);

// fetch service slug
$service_slug = trim( oxy_get_option( 'services_slug' ) );
if( empty($service_slug) ) {
    $service_slug = 'our-services';
}

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-flag',
    'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
    'rewrite'            => array( 'slug' => $service_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
);
register_post_type( 'oxy_service', $args );

function oxy_edit_columns_services($columns)
{
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'             => '<input type="checkbox" />',
        'title'          => __('Service', 'swatch-admin-td'),
        'featured-image' => __('Image', 'swatch-admin-td'),
        'menu_order'         => __('Order', 'swatch-admin-td'),
        'service-category'     => __('Category', 'swatch-admin-td')
    );
    return $columns;
}
add_filter('manage_edit-oxy_service_columns', 'oxy_edit_columns_services');

$labels = array(
    'name'          => __( 'Categories', 'swatch-admin-td' ),
    'singular_name' => __( 'Category', 'swatch-admin-td' ),
    'search_items'  => __( 'Search Categories', 'swatch-admin-td' ),
    'all_items'     => __( 'All Categories', 'swatch-admin-td' ),
    'edit_item'     => __( 'Edit Category', 'swatch-admin-td'),
    'update_item'   => __( 'Update Category', 'swatch-admin-td'),
    'add_new_item'  => __( 'Add New Category', 'swatch-admin-td'),
    'new_item_name' => __( 'New Category Name', 'swatch-admin-td')
);

register_taxonomy(
    'oxy_service_category',
    'oxy_service',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
    )
);


/* ------------------ TESTIMONIALS -----------------------*/

$labels = array(
    'name'               => __('Testimonial', 'swatch-admin-td'),
    'singular_name'      => __('Testimonial', 'swatch-admin-td'),
    'add_new'            => __('Add New', 'swatch-admin-td'),
    'add_new_item'       => __('Add New Testimonial', 'swatch-admin-td'),
    'edit_item'          => __('Edit Testimonial', 'swatch-admin-td'),
    'new_item'           => __('New Testimonial', 'swatch-admin-td'),
    'all_items'          => __('All Testimonial', 'swatch-admin-td'),
    'view_item'          => __('View Testimonial', 'swatch-admin-td'),
    'search_items'       => __('Search Testimonial', 'swatch-admin-td'),
    'not_found'          => __('No Testimonial found', 'swatch-admin-td'),
    'not_found_in_trash' => __('No Testimonial found in Trash', 'swatch-admin-td'),
    'menu_name'          => __('Testimonials', 'swatch-admin-td')
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-format-quote',
    'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' )
);
register_post_type('oxy_testimonial', $args);

$labels = array(
    'name'          => __( 'Groups', 'swatch-admin-td' ),
    'singular_name' => __( 'Group', 'swatch-admin-td' ),
    'search_items'  => __( 'Search Groups', 'swatch-admin-td' ),
    'all_items'     => __( 'All Groups', 'swatch-admin-td' ),
    'edit_item'     => __( 'Edit Group', 'swatch-admin-td'),
    'update_item'   => __( 'Update Group', 'swatch-admin-td'),
    'add_new_item'  => __( 'Add New Group', 'swatch-admin-td'),
    'new_item_name' => __( 'New Group Name', 'swatch-admin-td')
);

register_taxonomy(
    'oxy_testimonial_group',
    'oxy_testimonial',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => true,
    )
);

function oxy_edit_columns_testimonial($columns)
{
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'                   => '<input type="checkbox" />',
        'title'                => __('Author', 'swatch-admin-td'),
        'featured-image'       => __('Image', 'swatch-admin-td'),
        'testimonial-citation' => __('Citation', 'swatch-admin-td'),
        'menu_order'         => __('Order', 'swatch-admin-td'),
        'testimonial-group'    => __('Group', 'swatch-admin-td')
    );
    return $columns;
}
add_filter('manage_edit-oxy_testimonial_columns', 'oxy_edit_columns_testimonial');


/* --------------------- STAFF ------------------------*/

$labels = array(
    'name'               => __('Staff', 'swatch-admin-td'),
    'singular_name'      => __('Staff', 'swatch-admin-td'),
    'add_new'            => __('Add New', 'swatch-admin-td'),
    'add_new_item'       => __('Add New Staff', 'swatch-admin-td'),
    'edit_item'          => __('Edit Staff', 'swatch-admin-td'),
    'new_item'           => __('New Staff', 'swatch-admin-td'),
    'all_items'          => __('All Staff', 'swatch-admin-td'),
    'view_item'          => __('View Staff', 'swatch-admin-td'),
    'search_items'       => __('Search Staff', 'swatch-admin-td'),
    'not_found'          => __('No Staff found', 'swatch-admin-td'),
    'not_found_in_trash' => __('No Staff found in Trash', 'swatch-admin-td'),
    'menu_name'          => __('Staff', 'swatch-admin-td')
);

// fetch portfolio slug
$staff_slug = trim( oxy_get_option( 'staff_slug' ) );
if( empty($staff_slug) ) {
    $staff_slug = 'staff';
}

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-businessman',
    'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
    'rewrite' => array( 'slug' => $staff_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
);
register_post_type('oxy_staff', $args);

$labels = array(
    'name'          => __( 'Departments', 'swatch-admin-td' ),
    'singular_name' => __( 'Department', 'swatch-admin-td' ),
    'search_items'  =>  __( 'Search Departments', 'swatch-admin-td' ),
    'all_items'     => __( 'All Departments', 'swatch-admin-td' ),
    'edit_item'     => __( 'Edit Department', 'swatch-admin-td'),
    'update_item'   => __( 'Update Department', 'swatch-admin-td'),
    'add_new_item'  => __( 'Add New Department', 'swatch-admin-td'),
    'new_item_name' => __( 'New Department Name', 'swatch-admin-td')
);

register_taxonomy(
    'oxy_staff_department',
    'oxy_staff',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
    )
);

function oxy_edit_columns_staff($columns)
{
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'                   => '<input type="checkbox" />',
        'title'                => __('Name', 'swatch-admin-td'),
        'featured-image'       => __('Image', 'swatch-admin-td'),
        'job-title'            => __('Job Title', 'swatch-admin-td'),
        'menu_order'         => __('Order', 'swatch-admin-td'),
        'departments-category' => __('Department', 'swatch-admin-td')
    );
    return $columns;
}
add_filter('manage_edit-oxy_staff_columns', 'oxy_edit_columns_staff');


/***************** PORTFOLIO *******************/

$labels = array(
    'name'               => __('Portfolio Items', 'swatch-admin-td'),
    'singular_name'      => __('Portfolio Item', 'swatch-admin-td'),
    'add_new'            => __('Add New', 'swatch-admin-td'),
    'add_new_item'       => __('Add New Portfolio Item', 'swatch-admin-td'),
    'edit_item'          => __('Edit Portfolio Item', 'swatch-admin-td'),
    'new_item'           => __('New Portfolio Item', 'swatch-admin-td'),
    'view_item'          => __('View Portfolio Item', 'swatch-admin-td'),
    'search_items'       => __('Search Portfolio Items', 'swatch-admin-td'),
    'not_found'          =>  __('No images found', 'swatch-admin-td'),
    'not_found_in_trash' => __('No images found in Trash', 'swatch-admin-td'),
    'parent_item_colon'  => '',
    'menu_name'          => __('Portfolio Items', 'swatch-admin-td')
);

// fetch portfolio slug
$permalink_slug = trim( oxy_get_option( 'portfolio_slug' ) );
if( empty($permalink_slug) ) {
    $permalink_slug = 'portfolio';
}

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'query_var'          => true,
    'has_archive'        => true,
    'capability_type'    => 'post',
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-portfolio',
    'supports'           => array('title', 'editor', 'thumbnail', 'page-attributes', 'post-formats', 'revisions' ),
    'rewrite' => array( 'slug' => $permalink_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
);

// create custom post
register_post_type( 'oxy_portfolio_image', $args );

// Register portfolio taxonomy
$labels = array(
    'name'          => __( 'Categories', 'swatch-admin-td' ),
    'singular_name' => __( 'Category', 'swatch-admin-td' ),
    'search_items'  =>  __( 'Search Categories', 'swatch-admin-td' ),
    'all_items'     => __( 'All Categories', 'swatch-admin-td' ),
    'edit_item'     => __( 'Edit Category', 'swatch-admin-td'),
    'update_item'   => __( 'Update Category', 'swatch-admin-td'),
    'add_new_item'  => __( 'Add New Category', 'swatch-admin-td'),
    'new_item_name' => __( 'New Category Name', 'swatch-admin-td')
);

register_taxonomy(
    'oxy_portfolio_categories',
    'oxy_portfolio_image',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => true,
    )
);
function oxy_edit_columns_portfolio($columns)
{
   // $columns['featured_image']= 'Featured Image';
    $columns = array(
        'cb'                 => '<input type="checkbox" />',
        'title'              => __('Item', 'swatch-admin-td'),
        'featured-image'     => __('Image', 'swatch-admin-td'),
        'menu_order'         => __('Order', 'swatch-admin-td'),
        'portfolio-category' => __('Categories', 'swatch-admin-td')
    );
    return $columns;
}
add_filter('manage_edit-oxy_portfolio_image_columns', 'oxy_edit_columns_portfolio');

$labels = array(
    'name'          => __( 'Skills', 'swatch-admin-td' ),
    'singular_name' => __( 'Skill', 'swatch-admin-td' ),
    'search_items'  =>  __( 'Search Skills', 'swatch-admin-td' ),
    'all_items'     => __( 'All Skills', 'swatch-admin-td' ),
    'edit_item'     => __( 'Edit Skill', 'swatch-admin-td' ),
    'update_item'   => __( 'Update Skill', 'swatch-admin-td' ),
    'add_new_item'  => __( 'Add New Skill', 'swatch-admin-td' ),
    'new_item_name' => __( 'New Skill Name', 'swatch-admin-td' )
);

register_taxonomy(
    'oxy_portfolio_skills',
    'oxy_portfolio_image',
    array(
        'hierarchical' => true,
        'labels'       => $labels,
        'show_ui'      => true,
        'query_var'    => true,
    )
);

/* --------------------- SWATCHES ------------------------*/

$labels = array(
    'name'               => __('Swatches', 'swatch-admin-td'),
    'singular_name'      => __('Swatch', 'swatch-admin-td'),
    'add_new'            => __('Add New', 'swatch-admin-td'),
    'add_new_item'       => __('Add New Swatch', 'swatch-admin-td'),
    'edit_item'          => __('Edit Swatch', 'swatch-admin-td'),
    'new_item'           => __('New Swatch', 'swatch-admin-td'),
    'all_items'          => __('All Swatches', 'swatch-admin-td'),
    'view_item'          => __('View Swatch', 'swatch-admin-td'),
    'search_items'       => __('Search Swatch', 'swatch-admin-td'),
    'not_found'          => __('No Swatch found', 'swatch-admin-td'),
    'not_found_in_trash' => __('No Swatch found in Trash', 'swatch-admin-td'),
    'menu_name'          => __('Swatches', 'swatch-admin-td')
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-art',
    'supports'           => array( 'title' )
);
register_post_type('oxy_swatch', $args);