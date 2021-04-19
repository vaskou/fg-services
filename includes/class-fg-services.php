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

		FG_Services_Post_Type::instance();
	}

	public function on_plugins_loaded() {
		load_plugin_textdomain( 'fg-services', false, FG_SERVICES_PLUGIN_DIR_NAME . '/languages/' );
	}
}