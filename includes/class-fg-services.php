<?php

defined( 'ABSPATH' ) or die();

class FG_Services {

	private static $_instance;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
		add_filter( 'fremediti_guitars_single_content_show_posted_on', array( $this, 'single_content_show_posted_on' ) );
		add_filter( 'fremediti_guitars_has_sidebar', array( $this, 'has_sidebar' ) );

		FG_Services_Post_Type::instance();
		FG_Services_Settings::instance();
		FG_Services_Shortcodes::instance();
	}

	public function on_plugins_loaded() {
		load_plugin_textdomain( 'fg-services', false, FG_SERVICES_PLUGIN_DIR_NAME . '/languages/' );
	}

	/**
	 * @param array $post_types
	 */
	public function single_content_show_posted_on( $post_types ) {

		$post_types[] = FG_Services_Post_Type::POST_TYPE_NAME;

		return $post_types;
	}

	public function has_sidebar( $has_sidebar ) {

		if ( is_singular( FG_Services_Post_Type::POST_TYPE_NAME ) ) {
			$has_sidebar = true;
		}

		if ( is_post_type_archive( FG_Services_Post_Type::POST_TYPE_NAME ) ) {
			$has_sidebar = true;
		}

		return $has_sidebar;
	}
}