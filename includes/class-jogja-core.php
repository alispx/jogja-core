<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://woo.ninja
 * @since      1.0.0
 *
 * @package    Jogja_Core
 * @subpackage Jogja_Core/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Jogja_Core
 * @subpackage Jogja_Core/includes
 * @author     joglothemes <joglothemes@gmail.com>
 */
class Jogja_Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Jogja_Core_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name 	= 'jogja-core';
		$this->version 		= '1.0';

		$this->load_dependencies();
		$this->load_addons();
		$this->load_extensions();
		$this->load_widgets();
		$this->load_functions();
		$this->set_locale();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Jogja_Core_Loader. Orchestrates the hooks of the plugin.
	 * - Jogja_Core_i18n. Defines internationalization functionality.
	 * - Jogja_Core_Admin. Defines all hooks for the admin area.
	 * - Jogja_Core_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jogja-core-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jogja-core-i18n.php';

		$this->loader = new Jogja_Core_Loader();

	}

	/**
	 * Load addons
	 *
	 * @return void
	 **/
	private function load_addons() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'addons/metabox/bootstrap.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'addons/carbon-fields/carbon-fields-plugin.php';
		new jogja_Mie_Customizer();
	}

	/**
	 * Load Widgets
	 *
	 * @return void
	 **/
	private function load_widgets() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'addons/widgets/widget-instagram-gallery.php';
	}


	/**
	 * Load Extensions
	 *
	 * @return void
	 **/
	private function load_extensions() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/extensions/extended-post-types.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/extensions/extended-taxonomies.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/extensions/widget-factory.php';
	}

	/**
	 * Load Functions
	 *
	 * @return void
	 **/
	private function load_functions() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/function-post-types.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Jogja_Core_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Jogja_Core_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Jogja_Core_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
