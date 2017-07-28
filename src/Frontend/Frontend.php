<?php namespace Premmerce\DevTools\Frontend;

use Premmerce\DevTools\FileManager;

/**
 * Class Frontend
 *
 * @package Premmerce\DevTools\Frontend
 */
class Frontend {


	/**
	 * @var FileManager
	 */
	private $pluginManager;

	public function __construct( FileManager $pluginManager ) {
		$this->pluginManager = $pluginManager;
	}

}