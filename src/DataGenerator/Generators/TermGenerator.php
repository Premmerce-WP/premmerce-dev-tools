<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator;
use Premmerce\DevTools\DataGenerator\Providers\TreeBuilder;
use Premmerce\DevTools\Services\Query;

class TermGenerator{


	/**
	 * @var array
	 */
	private $tree;


	/**
	 * @var array
	 */
	private $parents = [];

	/**
	 * @var int
	 */
	private $nestingLevel;

	/**
	 * @var int
	 */
	protected $lastTermId;

	/**
	 * @var int
	 */
	protected $lastTermTaxId;

	/**
	 * @var boolean
	 */
	protected $generateMeta = false;

	/**
	 * @var Generator
	 */
	protected $faker;

	/**
	 * @var array
	 */
	protected $unique = [];

	/**
	 * @var TreeBuilder
	 */
	private $treeBuilder;

	public function __construct(Generator $faker, TreeBuilder $treeBuilder = null){
		$this->faker       = $faker;
		$this->treeBuilder = $treeBuilder;
	}

	public function getTreeBuilder(){
		return $this->treeBuilder;
	}

	public function generate($num, $tax, $nestingLevel = 1, $returnIds = true){

		$this->nestingLevel = $nestingLevel;

		$this->lastTermId    = Query::create()->getLastTermId();
		$this->lastTermTaxId = Query::create()->getLastTermTaxonomyId();

		$this->unique = [];

		$terms = $this->createTerms($num);

		if($this->treeBuilder){
			$this->tree    = $this->treeBuilder->createTree(array_keys($terms), $nestingLevel);
			$this->parents = $this->treeBuilder->toItemParent($this->tree);
		}

		$taxonomies = $this->createTermTaxonomies($terms, $tax);


		Query::create()->insertTerms($terms);
		Query::create()->insertTermTaxonomies($taxonomies);

		if($this->generateMeta){
			$termMeta = $this->createTermMeta(array_keys($terms));
			Query::create()->insertTermMeta($termMeta);
		}


		return $returnIds? array_keys($taxonomies) : [$taxonomies, $terms];

	}

	protected function createTermMeta($terms){
		$meta       = [];
		$metaValues = [
			'order'        => 0,
			'display_type' => '',
			'thumbnail_id' => 0,
		];
		foreach($terms as $id){
			foreach($metaValues as $key => $value){
				$meta[] = [
					'term_id'    => $id,
					'meta_key'   => $key,
					'meta_value' => $value,
				];

			}

		}

		return $meta;
	}

	protected function createTerms($num){
		$lastId = $this->lastTermId;

		$terms = [];

		for($i = 0;$i < $num;$i ++){

			$name = $this->uniqueName();

			$id           = ++ $lastId;
			$terms[ $id ] = [
				'term_id'    => $id,
				'name'       => $name,
				'slug'       => $this->uniqueSlug($name),
				'term_group' => 0,
			];


		}

		return $terms;
	}


	protected function createTermTaxonomies($terms, $taxonomy){
		$lastId = $this->lastTermTaxId;

		$termIds = array_keys($terms);

		$taxonomies = [];

		foreach($termIds as $termId){

			$termTaxonomyId = ++ $lastId;

			$taxonomies[ $termTaxonomyId ] = [
				'term_taxonomy_id' => $termTaxonomyId,
				'term_id'          => $termId,
				'taxonomy'         => $taxonomy,
				'count'            => 1,
				'parent'           => $this->getParentTerm($termId),
			];
		}

		return $taxonomies;
	}

	public function getTree(){
		return $this->tree;
	}

	protected function getParentTerm($termId){
		return !empty($this->parents[ $termId ])? $this->parents[ $termId ] : 0;
	}

	protected function uniqueName(){
		$name = ucwords($this->faker->words($this->faker->numberBetween(1, 3), true));

		return $this->unique($name, 'name', 'ucwords');
	}

	protected function uniqueSlug($name){
		$slug = sanitize_title($name);
		$slug = $this->unique($slug, 'slug', 'sanitize_title', '-');

		return $slug;
	}

	protected function isUnique($value, $context = 'slug'){
		return !isset($this->unique[ $context ][ $value ]);
	}

	protected function unique($current, $context = 'slug', $callback = null, $separator = ' ', $provider = 'randomLetter'){

		while(!$this->isUnique($current, $context)){
			$current .= $separator . $this->faker->format($provider);

			if(is_callable($callback)){
				$current = call_user_func($callback, $current);
			}
		}

		$this->unique[ $context ][ $current ] = true;

		return $current;
	}


}