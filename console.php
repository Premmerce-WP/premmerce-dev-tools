<?php


use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\DataGenerator\Storage;
use Premmerce\DevTools\Services\DataCleaner;

if(!defined('WP_CLI') || !WP_CLI){
	die;
}

$commands = [
	'clear'    => function(){
		(new DataCleaner())->all();
		(new Storage())->clear();
	},
	'generate' => function(){
		$c = new DataGenerator();

		$config = [
			DataGenerator::NAME_CATEGORIES                   => 10,
			DataGenerator::NAME_CATEGORIES_NESTING           => 2,
			DataGenerator::NAME_SHOP_MENU                    => true,
			DataGenerator::NAME_PRODUCTS                     => 100,
			DataGenerator::NAME_PRODUCT_PHOTO                => true,
			DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 2,
			DataGenerator::NAME_BRANDS                       => 5,
			DataGenerator::NAME_ATTRIBUTES                   => 5,
			DataGenerator::NAME_ATTRIBUTE_TERMS              => 5,
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
