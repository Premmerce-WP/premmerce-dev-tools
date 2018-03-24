<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator as Faker;
use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\Services\BulkInsertQuery;

class BrandGenerator
{

    /**
     * @var Faker
     */
    private $faker;


    public function __construct(Faker $faker) {
        $this->faker = $faker;
    }

    public function generate($number) {
        global $wpdb;

        $q = BulkInsertQuery::create();

        $terms = $this->createTerms($number);
        $q->insert($wpdb->terms, $terms);

        $termTaxonomies = $this->createTermTaxonomies($terms, DataGenerator::PREMMERCE_BRAND);
        $q->insert($wpdb->term_taxonomy, $termTaxonomies);

        return array_keys($termTaxonomies);
    }

    private function createTerms($num) {
        $lastId = $this->getLastTerm();

        $terms = [];
        for ($i = 1; $i <= $num; $i++) {
            $name = $this->faker->companyName;
            $id = $lastId + $i;

            $terms[$id] = [
                'term_id'    => $id,
                'name'       => $name,
                'slug'       => $name,
                'term_group' => 0,
            ];
        }

        return $terms;
    }

    private function createTermTaxonomies($terms, $taxonomy) {
        $lastId = $this->getLastTermTaxonomy();

        $termIds = array_keys($terms);

        $taxonomies = [];

        foreach ($termIds as $termId) {

            $termTaxonomyId = ++$lastId;

            $taxonomies[$termTaxonomyId] = [
                'term_taxonomy_id' => $termTaxonomyId,
                'term_id'          => $termId,
                'taxonomy'         => $taxonomy,
                'count'            => 1,
            ];
        }

        return $taxonomies;

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

        $query = implode(' ', $query);

        return (int)$wpdb->get_var($query);
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

        $query = implode(' ', $query);

        return (int)$wpdb->get_var($query);
    }

}