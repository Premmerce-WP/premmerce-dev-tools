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
	private $fileManager;

	/**
	 * PluginManager constructor.
	 *
	 * @param FileManager $fileManager
	 *
	 * @internal param $mainFile
	 */
	public function __construct( FileManager $fileManager ) {

		$this->fileManager = $fileManager;

		add_action( 'plugins_loaded', function () {
			$name = $this->fileManager->getPluginName();
			load_plugin_textdomain( $name, false, $name . '/languages/' );
		} );

	}

	/**
	 * Run plugin part
	 */
	public function run() {
		if ( is_admin() ) {
			new Admin( $this->fileManager );
		} else {
			new Frontend( $this->fileManager );
		}

	}

	/**
	 * Fired when the plugin is activated
	 */
	public function activate() {
	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate() {
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall() {
	}
}