<?php namespace Premmerce\DevTools\Services;


class Query
{
    private $data = [];

    /**
     * @return Query
     */
    public static function create() {
        return new self();
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function table($table) {
        $this->data['table'] = $table;

        return $this;
    }

    /**
     * @param $values
     *
     * @return $this
     */
    public function values($values) {
        $this->data['values'] = $values;

        return $this;
    }

    public function insertWoocommerceAttributeTaxonomies($data) {
        global $wpdb;

        return $this->insert($wpdb->prefix . 'woocommerce_attribute_taxonomies', $data);
    }

    public function insertTerms($data) {
        global $wpdb;

        return $this->insert($wpdb->terms, $data);
    }

    public function insertTermTaxonomies($data) {
        global $wpdb;

        return $this->insert($wpdb->term_taxonomy, $data);
    }

    public function insertTermMeta($data) {
        global $wpdb;

        return $this->insert($wpdb->termmeta, $data);
    }

    public function insertTermRelationships($data) {
        global $wpdb;

        return $this->insert($wpdb->term_relationships, $data);
    }

    public function insertPosts($data) {
        global $wpdb;

        return $this->insert($wpdb->posts, $data);
    }

    public function insertPostMeta($data) {
        global $wpdb;

        return $this->insert($wpdb->postmeta, $data);
    }

    public function insert($table, $values) {
        if ($table && count($values)) {
            return $this->table($table)->values($values)->query();
        }
    }

    /**
     * @return false|int
     */
    public function query() {
        global $wpdb;


        $result = 0;

        $dataValues = $this->data['values'];
        $table = $this->data['table'];

        if ($dataValues instanceof \Generator) {
            $dataValues = iterator_to_array($dataValues);
        }


        $keys = array_keys(reset($dataValues));
        $keys = implode(",", $keys);


        $insert = sprintf("INSERT INTO %s (%s)", $table, $keys);

        $chunks = array_chunk($dataValues, 1000);

        foreach ($chunks as $chunk) {
            $values = [];
            foreach ($chunk as $currentValues) {
                $values[] = "('" . implode("','", esc_sql($currentValues)) . "')";
            }

            $query = $insert . ' VALUES' . implode(',', $values) . ';';
            $result = $result + $wpdb->query($query);
        }

        $this->data = [];

        return $result;
    }

    /**
     * @return int
     */
    public function getLastTermTaxonomyId() {
        global $wpdb;

        $query[] = 'SELECT term_taxonomy_id';
        $query[] = 'FROM ' . $wpdb->term_taxonomy;
        $query[] = 'ORDER BY term_taxonomy_id DESC';
        $query[] = 'LIMIT 1';

        $query = implode(' ', $query);

        return $wpdb->get_var($query);
    }

    /**
     * @return int
     */
    public function getLastTermId() {
        global $wpdb;

        $query[] = 'SELECT term_id';
        $query[] = 'FROM ' . $wpdb->term_taxonomy;
        $query[] = 'ORDER BY term_id DESC';
        $query[] = 'LIMIT 1';

        $query = implode(' ', $query);

        return $wpdb->get_var($query);
    }


    /**
     * @return int
     */
    public function getLastPostId() {
        global $wpdb;

        $query[] = 'SELECT ID';
        $query[] = 'FROM ' . $wpdb->posts;
        $query[] = 'ORDER BY ID DESC';
        $query[] = 'LIMIT 1';

        $query = implode(' ', $query);

        return (int)$wpdb->get_var($query);
    }
}
