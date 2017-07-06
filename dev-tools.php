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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

call_user_func( function () {
	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

	( new Premmerce\DevTools\DevToolsPlugin( __FILE__ ) )->run();
} );