<?php namespace Premmerce\DevTools\Frontend;

/**
 * Class Frontend
 *
 * @package Premmerce\DevTools\Frontend
 */
class Frontend {

	private $directory;

	private $views = 'views/frontend/';

	public function __construct( $directory ) {
		$this->directory = $directory;
		$this->views     = $this->directory . $this->views;
	}
}