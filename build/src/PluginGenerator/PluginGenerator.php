<?php namespace Premmerce\DevTools\PluginGenerator;

/**
 * Class PluginGenerator
 * @package Premmerce\DevTools
 */
class PluginGenerator
{

    /**
     * @var PluginData
     */
    private $data;

    const DIR_ASSETS = 'assets';
    const DIR_LANGUAGES = 'languages';
    const DIR_SOURCE = 'src';
    const DIR_VIEWS = 'views';
    const DIR_FRONTEND = 'frontend';
    const DIR_ADMIN = 'admin';

    const STUB_AUTHOR_NAME = '___PLUGIN_AUTHOR___';
    const STUB_PLUGIN_NAME = '___PLUGIN_NAME___';
    const STUB_PLUGIN_NAMESPACE = '___PLUGIN_NAMESPACE___';
    const STUB_PLUGIN_NAMESPACE_JSON = '___PLUGIN_NAMESPACE_JSON___';
    const STUB_PLUGIN_NAME_HUMANIZED = '___PLUGIN_NAME_HUMANIZED___';
    const STUB_PLUGIN_VERSION = '___PLUGIN_VERSION___';
    const STUB_PLUGIN_DESCRIPTION = '___PLUGIN_DESCRIPTION___';
    const STUB_PLUGIN_CLASS = '___PLUGIN_CLASS___';
    const STUB_PREMMERCE_SDK_NAMESPACE = '___SDK_NAMESPACE___';
    const STUB_WP_VERSION = '___WP_VERSION___';
    const STUB_DATE = '___DATE___';

    private $pluginPath;

    public function generate($config)
    {
        $data = new PluginData();

        $data->setName($config['premmerce_plugin_name']);
        $data->setAuthor($config['premmerce_plugin_author']);
        $data->setNameHumanized($config['premmerce_plugin_name_humanized']);
        $data->setDescription($config['premmerce_plugin_description']);
        $data->setNameSpace($config['premmerce_plugin_namespace']);
        $data->setVersion($config['premmerce_plugin_version']);

        $this->data = $data;

        $this->pluginPath = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $data->getName() . DIRECTORY_SEPARATOR;

        if ($this->createPluginDirectories()) {
            $this->createFiles();
        }
    }


    private function createPluginDirectories()
    {
        $path = $this->pluginPath;

        $dirs = [
            $path,
            $path . self::DIR_ASSETS,
            $path . self::DIR_ASSETS . DIRECTORY_SEPARATOR . self::DIR_ADMIN,
            $path . self::DIR_ASSETS . DIRECTORY_SEPARATOR . self::DIR_FRONTEND,
            $path . self::DIR_LANGUAGES,
            $path . self::DIR_SOURCE,
            $path . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst(self::DIR_ADMIN),
            $path . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst(self::DIR_FRONTEND),
            $path . self::DIR_VIEWS,
            $path . self::DIR_VIEWS . DIRECTORY_SEPARATOR . self::DIR_ADMIN,
            $path . self::DIR_VIEWS . DIRECTORY_SEPARATOR . self::DIR_FRONTEND,
        ];

        $res = true;

        foreach ($dirs as $dir) {
            $res = $res && mkdir($dir);

            chmod($dir, 0777);
        }

        return $res;
    }

    private function createFiles()
    {
        $stubs = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;
        $files = [
            $stubs . 'index.php.stub'     => $this->pluginPath . 'index.php',
            $stubs . 'readme.txt.stub'    => $this->pluginPath . 'readme.txt',
            $stubs . 'license.txt.stub'   => $this->pluginPath . 'license.txt',
            $stubs . 'Admin.php.stub'     => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst(self::DIR_ADMIN) . DIRECTORY_SEPARATOR . 'Admin.php',
            $stubs . 'Frontend.php.stub'  => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst(self::DIR_FRONTEND) . DIRECTORY_SEPARATOR . 'Frontend.php',
            $stubs . 'Plugin.php.stub'    => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . $this->data->getClass() . '.php',
            $stubs . 'main.php.stub'      => $this->pluginPath . $this->data->getMainFileName(),
            $stubs . 'composer.json.stub' => $this->pluginPath . 'composer.json',
        ];

        foreach ($files as $from => $to) {
            $this->createFromStub($from, $to);
        }
    }

    private function createFromStub($stub, $file)
    {
        global $wp_version;

        $content = file_get_contents($stub);

        $vars = [
            self::STUB_AUTHOR_NAME             => $this->data->getAuthor(),
            self::STUB_PLUGIN_NAME             => $this->data->getName(),
            self::STUB_PLUGIN_NAMESPACE        => $this->data->getNameSpace(),
            self::STUB_PLUGIN_NAMESPACE_JSON   => $this->data->getNameSpaceJson(),
            self::STUB_PLUGIN_NAME_HUMANIZED   => $this->data->getNameHumanized(),
            self::STUB_PLUGIN_VERSION          => $this->data->getVersion(),
            self::STUB_PLUGIN_DESCRIPTION      => $this->data->getDescription(),
            self::STUB_PLUGIN_CLASS            => $this->data->getClass(),
            self::STUB_WP_VERSION              => $wp_version,
            self::STUB_PREMMERCE_SDK_NAMESPACE => 'Premmerce\SDK\V2',
            self::STUB_DATE                    => date('M d, Y'),
        ];

        file_put_contents($file, strtr($content, $vars));

        chmod($file, 0777);
    }
}
