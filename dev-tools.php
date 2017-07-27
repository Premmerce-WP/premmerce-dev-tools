<?php
/**
 * Premmerce plugin
 *
 *
 * @link              http://premmerce.com
 * @since             1.0.0
 * @package           Dev tools
 *
 * @wordpress-plugin
 * Plugin Name:       DevTools
 * Plugin URI:        http://premmerce.com
 * Description:       Allow to do everything
 * Version:           1.0.0
 * Author:            Premmerce
 * Author URI:        http://premmerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       premmerce-sandbox
 * Domain Path:       /languages
 */

use Premmerce\DevTools\DevToolsPlugin;
use Premmerce\DevTools\PluginManager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

call_user_func( function () {

	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

	$manager = new PluginManager( __FILE__ );

	$main = new DevToolsPlugin( $manager );

	register_activation_hook( __FILE__, [ $main, 'activate' ] );

	register_deactivation_hook( __FILE__, [ $main, 'activate' ] );

	register_uninstall_hook( __FILE__, [ DevToolsPlugin::class, 'uninstall' ] );

	$main->run();
} );