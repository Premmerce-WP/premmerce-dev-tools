<?php


use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\Services\DataCleaner;

if(!defined('WP_CLI') || !WP_CLI){
	die;
}

$commands = [
	'clear'    => function(){

		$dc = new DataCleaner();
		$dc->all();
	},
	'generate' => function(){
		$c = new DataGenerator();

		$config = [
			DataGenerator::NAME_CATEGORIES                   => 100,
			DataGenerator::NAME_CATEGORIES_NESTING           => 3,
			DataGenerator::NAME_SHOP_MENU                    => true,
			DataGenerator::NAME_PRODUCTS                     => 10000,
			DataGenerator::NAME_PRODUCT_PHOTO                => false,
			DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 0,
			DataGenerator::NAME_BRANDS                       => 20,
			DataGenerator::NAME_ATTRIBUTES                   => 10,
			DataGenerator::NAME_ATTRIBUTE_TERMS              => 30,
			DataGenerator::NAME_PRODUCT_TYPE                 => 'simple',
		];


		$c->generate($config);

	},
];


foreach($args as $arg){
	$start = microtime(true);

	if(isset($commands[ $arg ])){
		call_user_func($commands[ $arg ]);
	}
	dump("{$arg} : " . (microtime(true) - $start) . ' SEC');

}
