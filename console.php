<?php


use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\Services\DataCleaner;

if (!defined('WP_CLI') || !WP_CLI) {
    die;
}

if ($args[0] === 'clear') {
    $dc = new DataCleaner();
    $dc->all();
}

if ($args[0] === 'generate') {
    $c = new DataGenerator();

    $config = [
//        DataGenerator::NAME_CATEGORIES                   => 10,
//        DataGenerator::NAME_CATEGORIES_NESTING           => 2,
        DataGenerator::NAME_PRODUCTS                     => 2,
//        DataGenerator::NAME_PRODUCT_PHOTO                => false,
//        DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 0,
//        DataGenerator::NAME_BRANDS                       => 20,
        DataGenerator::NAME_ATTRIBUTES      => 10,
        DataGenerator::NAME_ATTRIBUTE_TERMS => 10,
        DataGenerator::NAME_PRODUCT_TYPE                 => 'variable',

    ];

    $c->generate($config);

}
