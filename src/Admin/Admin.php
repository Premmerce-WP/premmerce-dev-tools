<?php namespace Premmerce\DevTools\Admin;

use Premmerce\DevTools\FakeData\DataGenerator;
use Premmerce\DevTools\Generator\PluginData;
use Premmerce\DevTools\Generator\PluginGenerator;
use Premmerce\DevTools\PluginManager;


/**
 * Class Admin
 *
 * @package Boilerplate
 */
class Admin {

	/**
	 * @var PluginManager
	 */
	private $pluginManager;

	public function __construct( PluginManager $pluginManager ) {
		$this->pluginManager = $pluginManager;

		add_action( 'admin_menu', function () {
			add_menu_page( 'DevTools', 'DevTools', 'manage_options', __FILE__, [
				$this,
				'options'
			], 'dashicons-hammer' );

			add_submenu_page( __FILE__, 'New plugin', 'Create plugin', 'manage_options', __FILE__ . 'create_plugin', [
				$this,
				'createPlugin'
			] );

			add_submenu_page( __FILE__, 'Data generator', 'Data generator', 'manage_options', __FILE__ . 'generate_data', [
				$this,
				'generateData'
			] );
		} );

		add_action( 'admin_post_create_plugin', [ $this, 'createPluginHandler' ] );
		add_action( 'admin_post_generate_data', [ $this, 'generateDataHandler' ] );

	}

	public function options() {
		$this->pluginManager->includeTemplate( 'admin/options.php' );
	}

	public function createPlugin() {
		$this->pluginManager->includeTemplate( 'admin/create-plugin.php' );
	}

	public function generateData() {


		$this->pluginManager->includeTemplate( 'admin/generate-data.php' );
	}

	public function generateDataHandler() {
		$gen = new DataGenerator();
		$gen->generate( $_POST );
		$this->redirectBack();
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

		$this->redirectBack();

	}

	private function redirectBack() {
		wp_redirect( $_SERVER['HTTP_REFERER'] );
	}

}