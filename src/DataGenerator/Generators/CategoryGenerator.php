<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator;
use Premmerce\DevTools\DataGenerator\Providers\CategoryProvider;

class CategoryGenerator extends TermGenerator
{


    public function __construct(Generator $faker) {
        $faker->addProvider(new CategoryProvider($faker));
        parent::__construct($faker);
    }


    protected function uniqueName() {
        $name = $this->faker->format('categoryName');

        return $name;
    }


}
