<?php

use WordpressCustomSettings\SettingsSetup;
use WordpressCustomSettings\SettingSection;
use WordpressCustomSettings\SettingField;

class FG_Services_Settings extends SettingsSetup {

	private static $_instance;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	protected function __construct() {

		$this->set_submenu_parent_slug( 'edit.php?post_type=fg_services' );

		$this->set_page_title( __( 'FG Services Settings', 'fg-services' ) );
		$this->set_menu_title( __( 'FG Services Settings', 'fg-services' ) );
		$this->set_menu_slug( 'fg-services' );
		$this->add_settings_link( FG_SERVICES_PLUGIN_BASENAME );

		$this->add_section( new SettingSection( 'general', __( 'General', 'fg-services' ) ) );

		$settings = array(
			new SettingField( 'fg_services_page_slug', __( 'FG Services Page Slug', 'fg-services' ), 'text', 'general' ),
			new SettingField( 'fg_services_page_title', __( 'FG Services Page Title', 'fg-services' ), 'text', 'general' ),
		);

		foreach ( $settings as $setting ) {
			$this->add_setting_field( $setting );
		}

		parent::__construct();

	}

	public static function get_services_page_slug() {
		return self::instance()->get_setting( 'fg_services_page_slug' );
	}

	public static function get_services_page_title() {
		return self::instance()->get_setting( 'fg_services_page_title' );
	}
}