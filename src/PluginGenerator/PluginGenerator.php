<?php namespace Premmerce\DevTools\PluginGenerator;

/**
 * Class PluginGenerator
 * @package Premmerce\DevTools
 */
class PluginGenerator {

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
	const STUB_AUTOLOAD = '___AUTOLOAD_PATH___';

	private $stubsPath;
	private $pluginPath;

	public function generate( $config ) {
		$data = new PluginData();

		$data->setName( $config['premmerce_plugin_name'] );
		$data->setAuthor( $config['premmerce_plugin_author'] );
		$data->setNameHumanized( $config['premmerce_plugin_name_humanized'] );
		$data->setDescription( $config['premmerce_plugin_description'] );
		$data->setNameSpace( $config['premmerce_plugin_namespace'] );
		$data->setVersion( $config['premmerce_plugin_version'] );
		$data->setUseComposer( $config['premmerce_plugin_use_composer'] );

		$this->data = $data;

		$this->stubsPath  = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;
		$this->pluginPath = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $data->getName() . DIRECTORY_SEPARATOR;

		if ( $res = $this->createPluginDirectories() ) {
			$this->createFiles();

		}
	}


	private function createPluginDirectories() {
		$path = $this->pluginPath;

		$dirs = [
			$path,
			$path . self::DIR_ASSETS,
			$path . self::DIR_ASSETS . DIRECTORY_SEPARATOR . self::DIR_ADMIN,
			$path . self::DIR_ASSETS . DIRECTORY_SEPARATOR . self::DIR_FRONTEND,
			$path . self::DIR_LANGUAGES,
			$path . self::DIR_SOURCE,
			$path . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst( self::DIR_ADMIN ),
			$path . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst( self::DIR_FRONTEND ),
			$path . self::DIR_VIEWS,
			$path . self::DIR_VIEWS . DIRECTORY_SEPARATOR . self::DIR_ADMIN,
			$path . self::DIR_VIEWS . DIRECTORY_SEPARATOR . self::DIR_FRONTEND
		];

		$res = true;

		foreach ( $dirs as $dir ) {
			$res = $res && mkdir( $dir );

			chmod( $dir, 0777 );
		}

		return $res;
	}

	private function createFiles() {

		$stubs = __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;
		$files = [
			$stubs . 'index.php.stub'       => $this->pluginPath . 'index.php',
			$stubs . 'README.txt.stub'      => $this->pluginPath . 'README.txt',
			$stubs . 'LICENSE.txt.stub'     => $this->pluginPath . 'LICENSE.txt',
			$stubs . 'Admin.php.stub'       => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst( self::DIR_ADMIN ) . DIRECTORY_SEPARATOR . 'Admin.php',
			$stubs . 'Frontend.php.stub'    => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . ucfirst( self::DIR_FRONTEND ) . DIRECTORY_SEPARATOR . 'Frontend.php',
			$stubs . 'options.php.stub'     => $this->pluginPath . self::DIR_VIEWS . DIRECTORY_SEPARATOR . self::DIR_ADMIN . DIRECTORY_SEPARATOR . 'options.php',
			$stubs . 'Plugin.php.stub'      => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . $this->data->getClass() . '.php',
			$stubs . 'FileManager.php.stub' => $this->pluginPath . self::DIR_SOURCE . DIRECTORY_SEPARATOR . 'FileManager.php',
			$stubs . 'main.php.stub'        => $this->pluginPath . $this->data->getMainFileName(),
		];

		if ( $this->data->isUseComposer() ) {
			$files[ $stubs . 'composer.json.stub' ] = $this->pluginPath . 'composer.json';
		} else {
			$files[ $stubs . 'autoload.php.stub' ] = $this->pluginPath . 'autoload.php';
		}


		foreach ( $files as $from => $to ) {
			$this->createFromStub( $from, $to );
		}
	}

	private function createFromStub( $stub, $file ) {

		$content = file_get_contents( $stub );

		$vars = [
			self::STUB_AUTHOR_NAME           => $this->data->getAuthor(),
			self::STUB_PLUGIN_NAME           => $this->data->getName(),
			self::STUB_PLUGIN_NAMESPACE      => $this->data->getNameSpace(),
			self::STUB_PLUGIN_NAMESPACE_JSON => $this->data->getNameSpaceJson(),
			self::STUB_PLUGIN_NAME_HUMANIZED => $this->data->getNameHumanized(),
			self::STUB_PLUGIN_VERSION        => $this->data->getVersion(),
			self::STUB_PLUGIN_DESCRIPTION    => $this->data->getDescription(),
			self::STUB_PLUGIN_CLASS          => $this->data->getClass(),
			self::STUB_AUTOLOAD              => $this->data->isUseComposer() ? 'vendor/autoload.php' : 'autoload.php',
		];

		file_put_contents( $file, strtr( $content, $vars ) );

		chmod( $file, 0777 );

	}

}