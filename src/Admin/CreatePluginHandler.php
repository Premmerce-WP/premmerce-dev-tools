<?php
/**
 * Created by PhpStorm.
 * User: cray
 * Date: 31.07.17
 * Time: 16:54
 */

namespace Premmerce\DevTools\Admin;


use Premmerce\DevTools\Generator\PluginData;
use Premmerce\DevTools\Generator\PluginGenerator;

class CreatePluginHandler {

	public function handle($config){
		$data = new PluginData();
		$gen  = new PluginGenerator();

		$data->setName( $config['premmerce_plugin_name'] );
		$data->setAuthor( $config['premmerce_plugin_author'] );
		$data->setNameHumanized( $config['premmerce_plugin_name_humanized'] );
		$data->setDescription( $config['premmerce_plugin_description'] );
		$data->setNameSpace( $config['premmerce_plugin_namespace'] );
		$data->setVersion( $config['premmerce_plugin_version'] );
		$data->setUseComposer( $config['premmerce_plugin_use_composer'] );

		$gen->generate( $data );
	}
}