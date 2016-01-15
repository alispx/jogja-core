<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://woo.ninja
 * @since             1.0
 * @package           Jogja_Core
 *
 * @wordpress-plugin
 * Plugin Name:       Jogja Core
 * Plugin URI:        http://jogjatheme.ninja
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0
 * Author:            jogjathemes
 * Author URI:        http://jogjathemes.ninja
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jogja-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'JOGJA_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'JOGJA_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jogja-core-activator.php
 */
function activate_jogja_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jogja-core-activator.php';
	Jogja_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jogja-core-deactivator.php
 */
function deactivate_jogja_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jogja-core-deactivator.php';
	Jogja_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jogja_core' );
register_deactivation_hook( __FILE__, 'deactivate_jogja_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jogja-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jogja_core() {

	$plugin = new Jogja_Core();
	$plugin->run();

}
run_jogja_core();
