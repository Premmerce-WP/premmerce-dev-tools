<?php namespace Premmerce\DevTools\Admin;

use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\FileManager;


/**
 * Class Admin
 *
 * @package Boilerplate
 */
class Admin {

	const MENU_SLUG = 'premmerce-dev-tools';
	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * Admin constructor.
	 *
	 * Register menu items and handlers
	 *
	 * @param FileManager $fileManager
	 */
	public function __construct( FileManager $fileManager ) {
		$this->fileManager = $fileManager;

		add_action( 'admin_menu', function () {
			add_menu_page( __( 'DevTools', 'premmerce-dev-tools' ), __( 'DevTools', 'premmerce-dev-tools' ), 'manage_options', self::MENU_SLUG,
				null, 'dashicons-hammer' );

			add_submenu_page( self::MENU_SLUG, __( 'New plugin', 'premmerce-dev-tools' ), __( 'New plugin', 'premmerce-dev-tools' ), 'manage_options', self::MENU_SLUG . 'create_plugin', [
				$this,
				'createPlugin'
			] );

			add_submenu_page( self::MENU_SLUG, __( 'Data generator', 'premmerce-dev-tools' ), __( 'Data generator', 'premmerce-dev-tools' ), 'manage_options', self::MENU_SLUG . 'generate_data', [
				$this,
				'generateData'
			] );

			add_submenu_page( self::MENU_SLUG, __( 'Clean up', 'premmerce-dev-tools' ), __( 'Clean up', 'premmerce-dev-tools' ), 'manage_options', self::MENU_SLUG . 'clean_database', [
				$this,
				'cleanUp'
			] );


			global $submenu;
			unset( $submenu[ self::MENU_SLUG ][0] );

		} );

		add_action( 'admin_post_create_plugin', [ $this, 'createPluginHandler' ] );
		add_action( 'admin_post_generate_data', [ $this, 'generateDataHandler' ] );
		add_action( 'admin_post_clean_up', [ $this, 'cleanUpHandler' ] );

	}

	public function createPlugin() {
		$this->fileManager->includeTemplate( 'admin/create-plugin.php' );
	}

	public function generateData() {
		$this->fileManager->includeTemplate( 'admin/generate-data.php' );
	}

	public function cleanUp() {
		wp_enqueue_script( 'premmerce_cleanup', $this->fileManager->locateAsset( 'admin/js/clean-up.js' ) );

		$this->fileManager->includeTemplate( 'admin/clean-up.php' );
	}

	public function generateDataHandler() {
		$gen = new DataGenerator();
		$gen->generate( $_POST );
		$this->redirectBack();
	}

	public function createPluginHandler() {

		$generator = new CreatePluginHandler();
		$generator->handle( $_POST );
		$this->redirectBack();

	}

	public function cleanUpHandler() {
		$cleaner = new CleanUpHandler();

		$cleaner->handle( $_POST );
		$this->redirectBack();
	}

	private function redirectBack() {
		wp_redirect( $_SERVER['HTTP_REFERER'] );
	}

}