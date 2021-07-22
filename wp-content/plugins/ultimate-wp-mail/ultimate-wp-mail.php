<?php
/*
Plugin Name: Ultimate WP Mail
Plugin URI: http://www.EtoileWebDesign.com/plugins/
Description: Create and send custom HTML emails to segments of users registered on your site
Author: Etoile Web Design
Author URI: https://www.etoilewebdesign.com/
Terms and Conditions: https://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: ultimate-wp-mail
Version: 1.0.2
*/


if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'ewduwpmInit' ) ) {
class ewduwpmInit {

	/**
	 * Initialize the plugin and register hooks
	 */
	public function __construct() {

		self::constants();
		self::includes();
		self::instantiate();
		self::wp_hooks();
	}

	/**
	 * Define plugin constants.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function constants() {

		define( 'EWD_UWPM_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'EWD_UWPM_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'EWD_UWPM_PLUGIN_FNAME', plugin_basename( __FILE__ ) );
		define( 'EWD_UWPM_TEMPLATE_DIR', 'ewd-uwpm-templates' );
		define( 'EWD_UWPM_VERSION', '1.0.0' );

		define( 'EWD_UWPM_EMAIL_POST_TYPE', 'uwpm_mail_template' );
		define( 'EWD_UWPM_EMAIL_CATEGORY_TAXONOMY', 'uwpm-category' );
	}

	/**
	 * Include necessary classes.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function includes() {

		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/AdminEmailLists.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/AdminUserStats.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/Ajax.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/Blocks.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/CustomElement.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/CustomElementManager.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/CustomElementSection.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/CustomPostTypes.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/Dashboard.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/DatabaseManager.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/DeactivationSurvey.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/InstallationWalkthrough.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/Notifications.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/ReviewAsk.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/Settings.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/template-functions.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/UserManager.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/Widgets.class.php' );
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/WooCommerce.class.php' );
	}

	/**
	 * Spin up instances of our plugin classes.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function instantiate() {

		new ewduwpmDashboard();
		new ewduwpmDeactivationSurvey();
		new ewduwpmInstallationWalkthrough();
		new ewduwpmReviewAsk();

		$this->admin_email_lists 		= new ewduwpmAdminEmailLists();
		$this->admin_user_stats 		= new ewduwpmAdminUserStats();
		$this->cpts 					= new ewduwpmCustomPostTypes();
		$this->custom_element_manager 	= new ewduwpmCustomElementManager();
		$this->database_manager 		= new ewduwpmDatabaseManager();
		$this->notifications 			= new ewduwpmNotifications();
		$this->settings 				= new ewduwpmSettings(); 
		$this->woocommerce 				= new ewduwpmWooCommerce();

		new ewduwpmAJAX();
		new ewduwpmBlocks();
		new ewduwpmUserManager();
		new ewduwpmWidgetManager();
	}

	/**
	 * Run walk-through, load assets, add links to plugin listing, etc.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function wp_hooks() {

		register_activation_hook( __FILE__, 	array( $this, 'run_walkthrough' ) );
		register_activation_hook( __FILE__, 	array( $this, 'convert_options' ) );
		register_activation_hook( __FILE__, 	array( $this, 'create_tables' ) );

		add_action( 'init',			        	array( $this, 'load_view_files' ) );

		add_action( 'plugins_loaded',        	array( $this, 'load_textdomain' ) );

		add_action( 'admin_notices', 			array( $this, 'display_header_area' ) );

		add_action( 'admin_enqueue_scripts', 	array( $this, 'enqueue_admin_assets' ), 10, 1 );
		add_action( 'admin_head', 				array( $this, 'output_tinymce_vars' ) );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'register_assets' ) );
		add_action( 'wp_enqueue_scripts', 		array( $this, 'register_assets' ) );
		add_action( 'wp_head',					'ewd_add_frontend_ajax_url' );


		add_filter( 'mce_external_plugins', 	array( $this, 'register_tinymce_javascript' ) );
		add_filter( 'mce_buttons', 				array( $this, 'register_tinymce_buttons' ) );

		add_filter( 'plugin_action_links',		array( $this, 'plugin_action_links' ), 10, 2);
	}

	/**
	 * Run the options conversion function on update if necessary
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	public function convert_options() {
		
		require_once( EWD_UWPM_PLUGIN_DIR . '/includes/BackwardsCompatibility.class.php' );
		new ewduwpmBackwardsCompatibility();
	}

	/**
	 * Creates the tables where statistics and user information are stored
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	public function create_tables() {

		$this->database_manager->create_tables();
	}

	/**
	 * Load files needed for views
	 * @since 1.0.0
	 * @note Can be filtered to add new classes as needed
	 */
	public function load_view_files() {
	
		$files = array(
			EWD_UWPM_PLUGIN_DIR . '/views/Base.class.php' // This will load all default classes
		);
	
		$files = apply_filters( 'ewd_uwpm_load_view_files', $files );
	
		foreach( $files as $file ) {
			require_once( $file );
		}
	
	}

	/**
	 * Load the plugin textdomain for localisation
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		
		load_plugin_textdomain( 'ultimate-wp-mail', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Set a transient so that the walk-through gets run
	 * @since 1.0.0
	 */
	public function run_walkthrough() {

		set_transient( 'ewd-uwpm-getting-started', true, 30 );
	} 

	/**
	 * Enqueue the admin-only CSS and Javascript
	 * @since 1.0.0
	 */
	public function enqueue_admin_assets( $hook ) {
		global $post;

		$post_type = is_object( $post ) ? $post->post_type : ( isset( $_GET['post_type'] ) ? $_GET['post_type'] : '' );

		$screen = get_current_screen();

   		// Return if not one of the UASP post types, we're not on a post-type page, or we're not on the settings or widget pages
   		if ( ( $post_type != EWD_UWPM_EMAIL_POST_TYPE or ( $hook != 'edit.php' and $hook != 'post-new.php' and $hook != 'post.php' ) ) and $hook != 'admin_page_ewd-uwpm-settings' and $screen->id != 'uwpm_mail_template_page_ewd-uwpm-user-stats' and $screen->id != 'uwpm_mail_template_page_ewd-uwpm-email-lists' and $screen->id != 'uwpm_mail_template_page_ewd-uwpm-settings' and $screen->id != 'edit-uwpm-category' ) { return; }

		wp_enqueue_style( 'ewd-uwpm-spectrum-css', EWD_UWPM_PLUGIN_URL . '/assets/css/spectrum.css', array(), EWD_UWPM_VERSION );
		wp_enqueue_script( 'ewd-uwpm-spectrum-js', EWD_UWPM_PLUGIN_URL . '/assets/js/spectrum.js', array( 'jquery' ), EWD_UWPM_VERSION, true );
		wp_enqueue_style( 'ewd-uwpm-admin-css', EWD_UWPM_PLUGIN_URL . '/assets/css/ewd-uwpm-admin.css', array(), EWD_UWPM_VERSION );
		wp_enqueue_script( 'ewd-uwpm-admin-js', EWD_UWPM_PLUGIN_URL . '/assets/js/ewd-uwpm-admin.js', array( 'jquery', 'jquery-ui-sortable' ), EWD_UWPM_VERSION, true );
	}

	/**
	 * Register the front-end CSS and Javascript for the FAQs
	 * @since 1.0.0
	 */
	function register_assets() {
		global $ewd_uwpm_controller;

		wp_register_style( 'ewd-uwpm-css', EWD_UWPM_PLUGIN_URL . '/assets/css/ewd-uwpm.css', EWD_UWPM_VERSION );
		
		wp_register_script( 'ewd-uwpm-js', EWD_UWPM_PLUGIN_URL . '/assets/js/ewd-uwpm.js', array( 'jquery' ), EWD_UWPM_VERSION, true );
	}

	/**
	 * Add links to the plugin listing on the installed plugins page
	 * @since 1.0.0
	 */
	public function plugin_action_links( $links, $plugin ) {

		if ( $plugin == EWD_UWPM_PLUGIN_FNAME ) {

			$links['settings'] = '<a href="admin.php?page=ewd-uwpm-settings" title="' . __( 'Head to the settings page for Ultimate WP Mail', 'ultimate-wp-mail' ) . '">' . __( 'Settings', 'ultimate-wp-mail' ) . '</a>';
		}

		return $links;
	}

	/**
	 * Add the plugin's tiny MCE plugin, so that tags can be easily used in emails
	 * @since 1.0.0
	 */
	public function register_tinymce_javascript( $plugin_array ) {

	   $plugin_array['UWPM_Tags'] = EWD_UWPM_PLUGIN_URL . '/assets/js/tinymce-plugin.js';
	
	   return $plugin_array;
	}

	/**
	 * Output the usable email tags on the admin email builder page
	 * @since 1.0.0
	 */
	public function output_tinymce_vars() {
		global $post;
		global $ewd_uwpm_controller;

		if ( ! isset($post) or $post->post_type != EWD_UWPM_EMAIL_POST_TYPE ) { return; }
	
		$fields_data = array(
			'uwpm_user_tags'		=> $ewd_uwpm_controller->custom_element_manager->get_user_fields(),
			'uwpm_custom_elements'	=> $ewd_uwpm_controller->custom_element_manager->get_custom_elements(),
			'uwpm_custom_element_sections'		=> $ewd_uwpm_controller->custom_element_manager->get_custom_element_sections(),
			'uwpm_post_tags'		=> $post_fields = array(
				array( 'slug' => 'post_title', 'name' => 'Post Title' ),
				array( 'slug' => 'post_content', 'name' => 'Post Content' ),
				array( 'slug' => 'post_date', 'name' => 'Post Date' ),
				array( 'slug' => 'post_status', 'name' => 'Post Status' ),
				array( 'slug' => 'post_type', 'name' => 'Post Type' ),
			)
		);
	
		if ( empty( $fields_data['custom_elements'] ) ) { $fields_data['custom_elements'] = array( array( 'slug' => -1, 'name' => 'No Elements Registered', 'attributes' => array() ) ); }

		wp_localize_script( 'ewd-uwpm-admin-js', 'ewd_uwpm_php_data', $fields_data );
	}

	/**
	 * Adds in the tinyMCE that lets the email tags be accessed
	 * @since 1.0.0
	 */
	public function register_tinymce_buttons( $buttons ) {

	   array_push( $buttons, 'separator', 'UWPM_Tags' );

	   return $buttons;
	}

	/**
	 * Adds in a menu bar for the plugin
	 * @since 1.0.0
	 */
	public function display_header_area() {
		global $ewd_uwpm_controller;

		$screen = get_current_screen();
		
		if ( ( empty( $screen->parent_file ) or $screen->parent_file != 'edit.php?post_type=uwpm_mail_template' ) and $screen->id != 'admin_page_ewd-uwpm-settings' ) { return; }
		
		?>

		<div class="ewd-uwpm-admin-header-menu">
			<h2 class="nav-tab-wrapper">
			<a id="ewd-uwpm-dash-mobile-menu-open" href="#" class="menu-tab nav-tab"><?php _e("MENU", 'ultimate-wp-mail'); ?><span id="ewd-uwpm-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-uwpm-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
			<a id="dashboard-menu" href='admin.php?page=ewd-uwpm-dashboard' class="menu-tab nav-tab <?php if ( $screen->id == 'uwpm_mail_template_ewd-ufaq-dashboard' ) {echo 'nav-tab-active';}?>"><?php _e("Dashboard", 'ultimate-wp-mail'); ?></a>
			<a id="emails-menu" href='edit.php?post_type=uwpm_mail_template' class="menu-tab nav-tab <?php if ( $screen->id == 'edit-uwpm_mail_template' ) {echo 'nav-tab-active';}?>"><?php _e("Emails", 'ultimate-wp-mail'); ?></a>
			<a id="add-email-menu" href='post-new.php?post_type=uwpm_mail_template' class="menu-tab nav-tab"><?php _e("Add New", 'ultimate-wp-mail'); ?></a>
			<a id="categories-menu" href='edit-tags.php?taxonomy=uwpm-category&post_type=uwpm_mail_template' class="menu-tab nav-tab <?php if ( $screen->id == 'toplevel_page_uwpm-category' ) {echo 'nav-tab-active';}?>"><?php _e("Categories", 'ultimate-wp-mail'); ?></a>
			<a id="lists-menu" href='admin.php?page=ewd-uwpm-email-lists' class="menu-tab nav-tab <?php if ( $screen->id == 'toplevel_page_ewd-uwpm-lists' ) {echo 'nav-tab-active';}?>"><?php _e("Lists", 'ultimate-wp-mail'); ?></a>
			<a id="stats-menu" href='admin.php?page=ewd-uwpm-user-stats' class="menu-tab nav-tab <?php if ( $screen->id == 'toplevel_page_ewd-uwpm-stats' ) {echo 'nav-tab-active';}?>"><?php _e("Stats", 'ultimate-wp-mail'); ?></a>
			<a id="options-menu" href='admin.php?page=ewd-uwpm-settings' class="menu-tab nav-tab <?php if ( $screen->id == 'ewd_uwpm_page_ewd-uwpm-settings' ) {echo 'nav-tab-active';}?>"><?php _e("Settings", 'ultimate-wp-mail'); ?></a>
			</h2>
		</div>

		<?php
	}

}
} // endif;

global $ewd_uwpm_controller;
$ewd_uwpm_controller = new ewduwpmInit();

