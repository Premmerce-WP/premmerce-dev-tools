<?php namespace Premmerce\DevTools;

use Premmerce\DevTools\Admin\Admin;

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
     * @param FileManager $fileManager
     *
     * @internal param $mainFile
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;

        add_action('plugins_loaded', function () {
            $name = $this->fileManager->getPluginName();
            load_plugin_textdomain($name, false, $name . '/languages/');
        });
    }

    /**
     * Run plugin part
     */
    public function run()
    {
        if (is_admin()) {
            new Admin($this->fileManager);
        }
    }
}
