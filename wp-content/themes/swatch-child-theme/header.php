<?php
/**
 * Displays the head section of the theme
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */
?><!DOCTYPE html>
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if gt IE 9]> <html <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]> <!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title> Winnerwish <?php //wp_title( '|', true, 'right' ); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link href="<?php echo oxy_get_option( 'favicon' ); ?>" rel="shortcut icon" />
        <meta name="google-site-verification" content="<?php echo oxy_get_option('google_webmaster'); ?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <?php oxy_add_apple_icons( 'iphone_icon' ); ?>
        <?php oxy_add_apple_icons( 'iphone_retina_icon', 'sizes="114x114"' ); ?>
        <?php oxy_add_apple_icons( 'ipad_icon', 'sizes="72x72"' ); ?>
        <?php oxy_add_apple_icons( 'ipad_retina_icon', 'sizes="144x144"' ); ?>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="<?php echo OXY_THEME_URI .'javascripts/excanvas.min.js'; ?>"></script>
        <script src="<?php echo OXY_THEME_URI .'javascripts/PIE.js'; ?>"></script>
        <![endif]-->
		
		
         <?php wp_head(); ?>
         
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo  get_stylesheet_directory_uri()."/js/slick.css"; ?>" />
			<link rel="stylesheet" type="text/css" href="<?php echo  get_stylesheet_directory_uri()."/js/slick-theme.css"; ?>" />
    </head>
    <body <?php body_class(); ?>>
        <?php if (  ( is_active_sidebar( 'above-nav-right' ) || is_active_sidebar( 'above-nav-left' ) ) && (oxy_get_option('header_type') == 'top_bar' || oxy_get_option('header_type') == 'combo') ) : ?>
        <?php oxy_top_bar_nav(); ?>
        <?php endif; ?>
        <!-- Page Header -->
        <header id="masthead" class="<?php echo oxy_get_option('header_type')!='combo'? oxy_get_option('header_swatch'): ""; ?>">
            <?php  if( oxy_get_option('header_type')!='combo' ): ?>
            <?php   oxy_standard_nav(); ?>
            <?php  else: ?>
            <?php  oxy_combo_nav() ?>
            <?php  endif; ?>
			
			<!--<button class="btn btn-primary signupbtn" data-toggle="modal" data-target="#myModalsignup"> Register</button>-->
			
        </header>
		

        <div class='header-category hien-phone'>
            <div class='contain croll_nav_menu'>
            <nav id="menu-container">
                <div class="menu-inner-box">
					<div id="left-arrow"></div>
                    <div class="scroll-men slider">
            <?php
                $taxonomy     = 'raffle-category';
                $orderby      = 'name';  
                $show_count   = 0;      // 1 for yes, 0 for no
                $pad_counts   = 0;      // 1 for yes, 0 for no
                $hierarchical = 1;      // 1 for yes, 0 for no  
                $title        = '';  
                $empty        = 0;

                $args = array(
                    'taxonomy'     => $taxonomy,
                    'orderby'      => $orderby,
                    'show_count'   => $show_count,
                    'pad_counts'   => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li'     => $title,
                    'hide_empty'   => $empty
                );
                $all_categories = get_categories( $args );
                
                	
                $i  = 1 ; 
                foreach ($all_categories as $cat) {
                
                
               // $dtat=get_option( "taxonomy_$cat->term_id");
                
                //echo $dtat[custom_term_meta];
				
              if($cat->category_parent == 0 ) {
                    $category_id = $cat->term_id;  
                    
                    	$dtat=get_option( "taxonomy_$cat->term_id");
                
                         $newdataresultr=$dtat['custom_term_meta'];
                    
                           if($newdataresultr!="WINNER KID"){   
                     echo '<a  href="https://ranaentp.net/winnerwish/allcompetiton/?&category='.$category_id.'">'. $cat->name .'</a>';
                    }
                    //if($cat->slug != 'uncategorized'){   
                
                    //}
                    $i++;
               }       
                }
                ?>
            </div>
					<div id="right-arrow"></div>
					
                </div>        
        </nav>
       
         </div>
         </div>
        <div id="content" role="main">

