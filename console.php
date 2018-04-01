<?php


use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\Services\DataCleaner;

if (!defined('WP_CLI') || !WP_CLI) {
    die;
}

$commands = [
    'test'     => function () {
        $p = \Faker\Factory::create();
        $p->addProvider(new \Premmerce\DevTools\DataGenerator\Providers\AttributesProviderRand($p));
        $m = $p->mod;

        dump($p->nm($m));
        dump($p->val($m, 10, true));
    },
    'clear'    => function () {

        $dc = new DataCleaner();
        $dc->all();
    },
    'generate' => function () {
        $c = new DataGenerator();


        $config = [
            DataGenerator::NAME_CATEGORIES         => 100,
            DataGenerator::NAME_CATEGORIES_NESTING => 3,
            DataGenerator::NAME_SHOP_MENU          => true,
//            DataGenerator::NAME_PRODUCTS                     => 50000,
//            DataGenerator::NAME_PRODUCT_PHOTO                => true,
//            DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 3,
//            DataGenerator::NAME_BRANDS                       => 10,
//            DataGenerator::NAME_ATTRIBUTES                   => 20,
//            DataGenerator::NAME_ATTRIBUTE_TERMS              => 10,
//            DataGenerator::NAME_PRODUCT_TYPE                 => 'simple',
        ];
//        $c->generate($config);

//        $config = [DataGenerator::NAME_SHOP_MENU => true,];

        $c->generate($config);


    },
];


foreach ($args as $arg) {
    $start = microtime(true);

    if (isset($commands[$arg])) {
        call_user_func($commands[$arg]);
    }
    dump("{$arg} : " . (microtime(true) - $start) . ' SEC');

}
