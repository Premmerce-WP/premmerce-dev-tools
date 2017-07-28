<?php namespace Premmerce\DevTools\FakeData\Generators;


use Faker\Generator as Faker;
use Generator;
use Premmerce\DevTools\Services\BulkInsertQuery;


class AttributesGenerator {

	/**
	 * @var Faker
	 */
	private $faker;

	/**
	 * @var array
	 */
	private $attributes = [];

	/**
	 * @var array
	 */
	private $terms = [];

	/**
	 * AttributesGenerator constructor.
	 *
	 * @param Faker $faker
	 */
	public function __construct( Faker $faker ) {
		$this->faker = $faker;
	}

	/**
	 * @param int $number
	 *
	 * @param int $numberTerms
	 *
	 * @return array
	 */
	public function generate( $number, $numberTerms ) {

		global $wpdb;

		$q = BulkInsertQuery::create();

		if ( $number ) {
			$attributes = $this->getAttributesGenerator( $number );
			$q->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attributes );
		}


		if ( $numberTerms ) {

			$lastTermId       = $this->getLastTerm();
			$lastTermTaxonomy = $this->getLastTermTaxonomy();

			$terms = $this->createTermsGenerator( $number * $numberTerms, $lastTermId );
			$q->insert( $wpdb->terms, $terms );

			$termTaxonomies = $this->createTermsTaxonomyGenerator( $numberTerms, $lastTermTaxonomy );
			$q->insert( $wpdb->term_taxonomy, $termTaxonomies );
		}

		return $this->attributes;

	}


	/**
	 * @param int $number
	 *
	 * @return Generator
	 */
	public function getAttributesGenerator( $number ) {
		$attributes = [];

		for ( $i = 1; $i <= $number; $i ++ ) {
			$attrName = strtolower( $this->faker->word ) . '-' . $i;

			$this->attributes[ 'pa_' . $attrName ] = null;
			$attributes[]                          = [
				'attribute_label'   => ucfirst( $attrName ),
				'attribute_name'    => $attrName,
				'attribute_type'    => 'select',
				'attribute_orderby' => 'menu_order',
				'attribute_public'  => 0,

			];
		}

		return $attributes;

	}

	/**
	 * @param int $num
	 * @param int $lastId
	 *
	 * @return Generator
	 */
	public function createTermsGenerator( $num, $lastId ) {

		for ( $i = 1; $i <= $num; $i ++ ) {
			$name = $this->faker->word;
			$id   = $lastId + $i;

			$this->terms[ $id ] = $name;

			yield [
				'term_id'    => $id,
				'name'       => $name,
				'slug'       => $name,
				'term_group' => 0
			];
		}
	}

	/**
	 * @param $num
	 * @param $lastId
	 *
	 * @return Generator
	 */
	public function createTermsTaxonomyGenerator( $num, $lastId ) {

		$termIds = array_keys( $this->terms );

		$termTaxonomyIdCounter = 1;

		foreach ( array_keys( $this->attributes ) as $attribute ) {
			$termsNumber = $num;

			for ( $i = 1; $i <= $termsNumber; $i ++ ) {

				$termId = array_shift( $termIds );

				$termTaxonomyId = $lastId + $termTaxonomyIdCounter;

				$termTaxonomyIdCounter ++;

				$this->attributes[ $attribute ][ $termId ]['term_id']          = $termId;
				$this->attributes[ $attribute ][ $termId ]['name']             = $this->terms[ $termId ];
				$this->attributes[ $attribute ][ $termId ]['term_taxonomy_id'] = $termTaxonomyId;
				yield [
					'term_taxonomy_id' => $termTaxonomyId,
					'term_id'          => $termId,
					'taxonomy'         => $attribute,
					'count'            => 0
				];
			}
		}
	}


	/**
	 * @return int
	 */
	private function getLastTermTaxonomy() {
		global $wpdb;

		$query[] = 'SELECT term_taxonomy_id';
		$query[] = 'FROM ' . $wpdb->term_taxonomy;
		$query[] = 'ORDER BY term_taxonomy_id DESC';
		$query[] = 'LIMIT 1';

		$query = implode( ' ', $query );

		return (int) $wpdb->get_var( $query );

	}

	/**
	 * @return int
	 */
	private function getLastTerm() {
		global $wpdb;

		$query[] = 'SELECT term_id';
		$query[] = 'FROM ' . $wpdb->terms;
		$query[] = 'ORDER BY term_id DESC';
		$query[] = 'LIMIT 1';

		$query = implode( ' ', $query );

		return (int) $wpdb->get_var( $query );

	}


}