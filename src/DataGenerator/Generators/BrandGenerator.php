<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator;
use Premmerce\DevTools\DataGenerator\Providers\BrandProvider;

class BrandGenerator extends TermGenerator
{

    public function __construct(Generator $faker) {
        $faker->addProvider(new BrandProvider($faker));
        parent::__construct($faker);
    }


    protected function uniqueName() {
        $name = $this->faker->format('brandName');

        return $this->unique($name, 'name', null, ' ', 'brandNameSingle');
    }

}