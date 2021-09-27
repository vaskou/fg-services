<?php

/**
 * @wordpress-plugin
 * Plugin Name:       FremeditiGuitars - Services
 * Description:       FremeditiGuitars - Services Post Type
 * Version:           1.0.0
 * Author:            Vasilis Koutsopoulos
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fg-services
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die();

define( 'FG_SERVICES_VERSION', '1.0.0' );
define( 'FG_SERVICES_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FG_SERVICES_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'FG_SERVICES_PLUGIN_DIR_NAME', basename( FG_SERVICES_PLUGIN_DIR_PATH ) );
define( 'FG_SERVICES_PLUGIN_URL', plugins_url( FG_SERVICES_PLUGIN_DIR_NAME ) );

include 'vendor/autoload.php';

include 'includes/class-fg-services.php';
include 'includes/class-fg-services-post-type.php';
include 'includes/class-fg-services-settings.php';
include 'includes/class-fg-services-shortcodes.php';

FG_Services::instance();