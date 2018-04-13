<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator;
use Premmerce\DevTools\DataGenerator\Providers\CategoryProvider;
use Premmerce\DevTools\DataGenerator\Providers\TreeBuilder;

class CategoryGenerator extends TermGenerator{


	public function __construct(Generator $faker, TreeBuilder $treeBuilder){
		$faker->addProvider(new CategoryProvider($faker));
		parent::__construct($faker, $treeBuilder);
	}


	protected function uniqueName(){
		$name = $this->faker->format('categoryName');

		return $name;
	}


}
