<?php namespace Premmerce\DevTools\Frontend;

use Premmerce\DevTools\PluginManager;

/**
 * Class Frontend
 *
 * @package Premmerce\DevTools\Frontend
 */
class Frontend {


	/**
	 * @var PluginManager
	 */
	private $pluginManager;

	public function __construct( PluginManager $pluginManager ) {
		$this->pluginManager = $pluginManager;
	}
}