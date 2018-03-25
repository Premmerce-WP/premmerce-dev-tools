<?php


if (!defined('WP_CLI') || !WP_CLI) {
    die;
}

use Premmerce\DevTools\DataGenerator\Providers\AttributeProvider;
use Premmerce\DevTools\DataGenerator\Providers\MixProvider;

$faker = \Faker\Factory::create();
$faker->addProvider(new AttributeProvider($faker));
$faker->addProvider(new MixProvider($faker));

function iterate($num, $callback) {
    for ($i = 0; $i < $num; $i++) {
        $callback();
    }
}

iterate(100, function () use ($faker) {
    dump($faker->attributeValue('Rotational Speed'));
});


