<?php namespace Premmerce\DevTools\FakeData\Generators;

use Faker\Generator;
use Premmerce\DevTools\Services\BulkInsertQuery;

class CategoryGenerator {

	/**
	 * @var Generator
	 */
	private $faker;

	const WOO_CATEGORY = 'product_cat';

	/**
	 * CategoryGenerator constructor.
	 *
	 * @param Generator $faker
	 */
	public function __construct( Generator $faker ) {
		$this->faker = $faker;
	}

	/**
	 * @param $num
	 *
	 * @return array ids
	 */
	public function generate( $num ) {

		if ( $num < 1 ) {
			return null;
		}

		global $wpdb;

		$termTaxonomies = [];
		$terms          = [];

		$term = $this->getLastTerm();

		for ( $i = 1; $i <= $num; $i ++ ) {
			$termId           = $term->term_id + $i;
			$taxonomyId       = $term->term_taxonomy_id + $i;
			$termTaxonomies[] = $this->generateTermTaxonomyData( $termId, $taxonomyId );
			$terms[ $termId ] = $this->generateTermData( $termId );
		}

		$q = BulkInsertQuery::create();

		$taxRows  = $q->insert( $wpdb->term_taxonomy, $termTaxonomies );
		$termRows = $q->insert( $wpdb->terms, $terms );

		$result = $termRows === (int) $num && $taxRows === $termRows;

		if ( $result ) {
			return array_keys( $terms );
		}
	}

	private function generateTermData( $termId ) {

		$name = ucfirst( $this->faker->word );

		return [
			'term_id' => $termId,
			'name'    => $name,
			'slug'    => sanitize_title( $name ) . '-' . $termId
		];
	}

	private function generateTermTaxonomyData( $termId, $taxonomyId ) {
		return [
			'term_id'          => $termId,
			'term_taxonomy_id' => $taxonomyId,
			'taxonomy'         => self::WOO_CATEGORY,
			'description'      => $this->faker->paragraph,
		];
	}

	private function getLastTerm() {
		global $wpdb;

		$query[] = 'SELECT term_id, term_taxonomy_id';
		$query[] = 'FROM ' . $wpdb->term_taxonomy;
		$query[] = 'ORDER BY term_taxonomy_id DESC';
		$query[] = 'LIMIT 1';

		$query = implode( ' ', $query );

		return $wpdb->get_row( $query );

	}
}