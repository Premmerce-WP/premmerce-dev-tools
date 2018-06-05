<?php namespace Premmerce\DevTools;

use Premmerce\DevTools\Admin\Admin;
use Premmerce\SDK\V2\FileManager\FileManager;

/**
 * Class PluginManager
 *
 * @package PremmercePluginBoilerplate
 */
class DevToolsPlugin
{

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * PluginManager constructor.
     *
     * @param string $mainFile
     */
    public function __construct($mainFile) {
        $this->fileManager = new FileManager($mainFile);

        add_action('plugins_loaded', function () {
            $name = $this->fileManager->getPluginName();
            load_plugin_textdomain('premmerce-dev-tools', false, $name . '/languages/');
        });
    }

    /**
     * Run plugin part
     */
    public function run() {
        if (is_admin()) {
            new Admin($this->fileManager);
        }
    }
}
