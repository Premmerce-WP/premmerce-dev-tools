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

		add_action( 'plugins_loaded', function () {
			load_plugin_textdomain( $this->pluginName, false, $this->pluginName . '/languages/' );
		} );
	}

	/**
	 * Run plugin part
	 */
	public function run() {
		if ( is_admin() ) {
			new Admin( $this->pluginDirectory );
		}else{
			new Frontend($this->pluginDirectory);
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