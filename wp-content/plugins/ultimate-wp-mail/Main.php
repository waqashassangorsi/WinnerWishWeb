<?php

/*
Plugin Name: Ultimate WP Mail
Plugin URI: http://www.EtoileWebDesign.com/plugins/
Description: Create and send custom HTML emails to segments of users registered on your site
Author: Etoile Web Design
Author URI: http://www.EtoileWebDesign.com/
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: ultimate-wp-mail
Version: 0.26
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( function_exists( 'activate_plugin' ) and function_exists( 'deactivate_plugins' ) ) {

	activate_plugin( 'ultimate-wp-mail/ultimate-wp-mail.php' );

	deactivate_plugins( 'ultimate-wp-mail/Main.php' );
}

?>