<?php namespace Premmerce\DevTools;

use Premmerce\DevTools\Admin\Admin;
use Premmerce\DevTools\Frontend\Frontend;


/**
 * Class PluginManager
 *
 * @package PremmercePluginBoilerplate
 */
class DevToolsPlugin {

	/**
	 * @var string
	 */
	private $pluginName;

	/**
	 * @var string
	 */
	private $pluginDirectory;

	/**
	 * PluginManager constructor.
	 *
	 * @param $mainFile
	 */
	public function __construct( $mainFile ) {
		$this->pluginDirectory = plugin_dir_path( $mainFile );
		$this->pluginName      = basename( $this->pluginDirectory );

		//	Load the plugin text domain for translation
		$languages = $this->pluginDirectory . '/languages/';

		add_action( 'plugins_loaded', function () use ( $languages ) {
			load_plugin_textdomain( $this->pluginName, false, $languages );
		} );

		$this->registerHooks();
	}

	/**
	 * Register activate, deactivate and uninstall hooks
	 */
	private function registerHooks() {
		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

		// If uninstall not called from WordPress, then exit.
		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			register_uninstall_hook( __FILE__, self::class . '::uninstall' );
		}


	}

	/**
	 * Run plugin part
	 */
	public function run() {
		if ( is_admin() ) {
			new Admin( $this->pluginDirectory );
		}
		new Frontend();
	}

	/**
	 * Fired when the plugin is activated
	 */
	public function activate() {
		// TODO: Implement activate() method.
	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate() {
		// TODO: Implement deactivate() method.
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall() {
		// TODO: Implement uninstall() method.
	}
}