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
	 * @var FileManager
	 */
	private $pluginManager;

	/**
	 * PluginManager constructor.
	 *
	 * @param FileManager $pluginManager
	 *
	 * @internal param $mainFile
	 */
	public function __construct( FileManager $pluginManager ) {

		$this->pluginManager = $pluginManager;

		add_action( 'plugins_loaded', function () {
			$name = $this->pluginManager->getPluginName();
			load_plugin_textdomain( $name, false, $name . '/languages/' );
		} );

	}

	/**
	 * Run plugin part
	 */
	public function run() {
		if ( is_admin() ) {
			new Admin( $this->pluginManager );
		} else {
			new Frontend( $this->pluginManager );
		}

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