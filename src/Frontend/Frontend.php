<?php namespace Premmerce\DevTools\Frontend;

use Premmerce\DevTools\FileManager;

/**
 * Class Frontend
 *
 * @package Premmerce\DevTools\Frontend
 */
class Frontend
{


    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }
}
