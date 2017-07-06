<?php namespace Premmerce\DevTools\Admin;

use Premmerce\DevTools\Generator\PluginData;
use Premmerce\DevTools\Generator\PluginGenerator;


/**
 * Class Admin
 *
 * @package Boilerplate
 */
class Admin {

	private $directory;

	private $views = 'views/admin/';

	public function __construct( $directory ) {
		add_action( 'admin_menu', function () {
			add_menu_page( 'DevTools', 'DevTools', 8, __FILE__, [ $this, 'options' ], 'dashicons-hammer' );
			add_submenu_page( __FILE__, 'New plugin', 'Create plugin', 10, __FILE__ . 'create_plugin', [
				$this,
				'createPlugin'
			] );
		} );

		add_action( 'admin_post_create_plugin', [ $this, 'createPluginHandler' ] );

		$this->directory = $directory;
		$this->views     = $this->directory . $this->views;
	}

	public function options() {
		include $this->views . 'options.php';
	}

	public function createPlugin() {
		include $this->views . 'create_plugin.php';
	}

	public function createPluginHandler() {

		$data = new PluginData();
		$gen  = new PluginGenerator();

		$data->setName( $_POST['premmerce_plugin_name'] );
		$data->setAuthor( $_POST['premmerce_plugin_author'] );
		$data->setNameHumanized( $_POST['premmerce_plugin_name_humanized'] );
		$data->setDescription( $_POST['premmerce_plugin_description'] );
		$data->setNameSpace( $_POST['premmerce_plugin_namespace'] );
		$data->setVersion( $_POST['premmerce_plugin_version'] );
		$data->setUseComposer( $_POST['premmerce_plugin_use_composer'] );

		$gen->generate( $data );

		wp_redirect( $_SERVER['HTTP_REFERER'] );

	}

}