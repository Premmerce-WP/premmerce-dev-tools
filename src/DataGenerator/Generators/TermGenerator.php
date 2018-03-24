<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator;
use Premmerce\DevTools\Services\BulkInsertQuery;

class TermGenerator
{

    private $lastTermId;

    private $lastTermTaxId;

    private $provider;

    private $faker;

    public function __construct(Generator $faker) {
        $this->faker = $faker;
    }

    public function generate($num, $tax, $provider = 'categoryName') {
        $term = $this->getLastTerm();

        $this->lastTermId = $term->term_id;
        $this->lastTermTaxId = $term->term_taxonomy_id;
        $this->provider = $provider;


        $terms = $this->createTerms($num);
        $taxonomies = $this->createTermTaxonomies($terms, $tax);

        global $wpdb;
        $q = BulkInsertQuery::create();

        $q->insert($wpdb->terms, $terms);
        $q->insert($wpdb->term_taxonomy, $taxonomies);


        return array_keys($taxonomies);

    }

    private function createTerms($num) {
        $lastId = $this->lastTermId;

        $terms = [];
        $names = $this->generateNames($num);

        foreach ($names as $name) {
            $id = ++$lastId;
            $terms[$id] = [
                'term_id'    => $id,
                'name'       => $name,
                'slug'       => sanitize_title($name),
                'term_group' => 0,
            ];

        }

        return $terms;
    }

    private function createTermTaxonomies($terms, $taxonomy) {
        $lastId = $this->lastTermTaxId;

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


    private function generateNames($num) {
        $names = [];
        for ($i = 0; $i <= $num; $i++) {
            $p = $this->provider;
            $name = $this->faker->{$p};
            while (in_array($name, $names)) {
                $name .= $this->faker->word;
            }
            $names[] = $name;
        }

        return $names;
    }


    private function getLastTerm() {
        global $wpdb;

        $query[] = 'SELECT term_id, term_taxonomy_id';
        $query[] = 'FROM ' . $wpdb->term_taxonomy;
        $query[] = 'ORDER BY term_taxonomy_id DESC';
        $query[] = 'LIMIT 1';

        $query = implode(' ', $query);

        return $wpdb->get_row($query);
    }


}