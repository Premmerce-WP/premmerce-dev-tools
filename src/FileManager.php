<?php namespace Premmerce\DevTools;

class FileManager
{

    /**
     * @var string
     */
    private $mainFile;


    /**
     * @var string
     */
    private $pluginDirectory;


    /**
     * @var string
     */
    private $pluginName;


    /**
     * @var string
     */
    private $pluginUrl;

    /**
     * PluginManager constructor.
     *
     * @param string $mainFile
     */
    public function __construct($mainFile)
    {
        $this->mainFile        = $mainFile;
        $this->pluginDirectory = plugin_dir_path($this->mainFile);
        $this->pluginName      = basename($this->pluginDirectory);
        $this->pluginUrl       = plugin_dir_url($this->getMainFile());
    }


    /**
     * @return string
     */
    public function getPluginDirectory()
    {
        return $this->pluginDirectory;
    }

    /**
     * @return string
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * @return string
     */
    public function getMainFile()
    {
        return $this->mainFile;
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public function locateAsset($file)
    {
        return $this->pluginUrl . 'assets/' . $file;
    }

    /**
     * @param string $template
     * @param array $variables
     */
    public function includeTemplate($template, array $variables = [])
    {
        if ($templateFullPath = $this->locateTemplate($template)) {
            extract($variables);
            include $templateFullPath;
        }
    }

    /**
     * @param $template
     *
     * @return string
     */
    public function locateTemplate($template)
    {
        $frontendTemplate = $template;

        if (strpos($template, 'frontend/') === 0) {
            $frontendTemplate = str_replace('frontend/', '/', $template);
        }

        if ($file = locate_template($this->pluginName . '/' . $frontendTemplate)) {
            return $file;
        }

        return $this->pluginDirectory . 'views/' . $template;
    }
}
