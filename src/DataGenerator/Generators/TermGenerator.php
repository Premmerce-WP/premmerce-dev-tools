<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator;
use Premmerce\DevTools\Services\BulkInsertQuery;

class TermGenerator
{

    /**
     * @var int
     */
    private $currentLevel;

    /**
     * @var int
     */
    private $nestingLevel;

    /**
     * @var int
     */
    private $itemsInParent;

    /**
     * @var array
     */
    private $itemsByLevel = [];
    /**
     * @var int
     */
    protected $lastTermId;

    /**
     * @var int
     */
    protected $lastTermTaxId;

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var array
     */
    protected $unique = [];

    public function __construct(Generator $faker) {
        $this->faker = $faker;
    }

    public function generate($num, $tax, $nestingLevel = 1) {

        $this->nestingLevel = $nestingLevel;
        $this->itemsInParent = floor(pow($num, 1 / ($nestingLevel)));
        $this->itemsByLevel = [];
        $this->currentLevel = 1;

        $term = $this->getLastTerm();
        $this->lastTermId = $term->term_id;
        $this->lastTermTaxId = $term->term_taxonomy_id;

        $this->unique = [];

        $terms = $this->createTerms($num);

        $taxonomies = $this->createTermTaxonomies($terms, $tax);


        global $wpdb;
        $q = BulkInsertQuery::create();

        $q->insert($wpdb->terms, $terms);
        $q->insert($wpdb->term_taxonomy, $taxonomies);

//        $termMeta = $this->createTermMeta(array_keys($terms));
//        $q->insert($wpdb->termmeta, $termMeta);


        return array_keys($taxonomies);

    }

    public function createTermMeta($terms) {
        $meta = [];
        $metaValues = [
            'order'        => 0,
            'display_type' => '',
            'thumbnail_id' => 0,
        ];
        foreach ($terms as $id) {
            foreach ($metaValues as $key => $value) {
                $meta[] = [
                    'term_id'    => $id,
                    'meta_key'   => $key,
                    'meta_value' => $value,
                ];

            }

        }

        return $meta;
    }

    protected function createTerms($num) {
        $lastId = $this->lastTermId;

        $terms = [];

        for ($i = 0; $i < $num; $i++) {

            $name = $this->uniqueName();

            $id = ++$lastId;
            $terms[$id] = [
                'term_id'    => $id,
                'name'       => $name,
                'slug'       => $this->uniqueSlug($name),
                'term_group' => 0,
            ];


        }

        return $terms;
    }


    protected function createTermTaxonomies($terms, $taxonomy) {
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
                'parent'           => $this->getParentTerm($termId),
            ];
        }

        return $taxonomies;
    }

    protected function getParentTerm($termId) {

        if ($this->nestingLevel < 2) {
            return 0;
        }
        $parentLevel = $this->currentLevel - 1;
        $parents = isset($this->itemsByLevel[$parentLevel]) ? $this->itemsByLevel[$parentLevel] : null;

        $parent = 0;
        if ($parents) {
            $parent = $this->faker->randomElement($parents);
        }

        $this->itemsByLevel[$this->currentLevel][] = $termId;

        $numParents = $this->currentLevel === 1 ? 1 : count($parents);

        $catsInCurrentLevel = count($this->itemsByLevel[$this->currentLevel]);
        $maxInCurrentLevel = $this->itemsInParent * $numParents;

        if ($maxInCurrentLevel && $catsInCurrentLevel >= $maxInCurrentLevel) {
            $this->currentLevel++;
        }

        return $parent;
    }

    protected function uniqueName() {
        $name = ucwords($this->faker->words($this->faker->numberBetween(1, 3), true));

        return $this->unique($name, 'name', 'ucwords');
    }

    protected function uniqueSlug($name) {
        $slug = sanitize_title($name);
        $slug = $this->unique($slug, 'slug', 'sanitize_title', '-');

        return $slug;
    }

    protected function isUnique($value, $context = 'slug') {
        return !isset($this->unique[$context][$value]);
    }

    protected function unique($current, $context = 'slug', $callback = null, $separator = ' ', $provider = 'word') {

        while (!$this->isUnique($current, $context)) {
            $current .= $separator . $this->faker->format($provider);

            if (is_callable($callback)) {
                $current = call_user_func($callback, $current);
            }
        }

        $this->unique[$context][$current] = true;

        return $current;
    }

    protected function getLastTerm() {
        global $wpdb;

        $query[] = 'SELECT term_id, term_taxonomy_id';
        $query[] = 'FROM ' . $wpdb->term_taxonomy;
        $query[] = 'ORDER BY term_taxonomy_id DESC';
        $query[] = 'LIMIT 1';

        $query = implode(' ', $query);

        return $wpdb->get_row($query);
    }


}