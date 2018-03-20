<?php namespace Premmerce\DevTools\Services;

class BulkInsertQuery
{
    private $data = [];

    /**
     * @return BulkInsertQuery
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function table($table)
    {
        $this->data['table'] = $table;

        return $this;
    }

    /**
     * @param $values
     *
     * @return $this
     */
    public function values($values)
    {
        $this->data['values'] = $values;

        return $this;
    }

    public function insert($table, $values)
    {
        if ($table && count($values)) {
            return $this->table($table)->values($values)->query();
        }
    }

    /**
     * @return false|int
     */
    public function query()
    {
        global $wpdb;


        $result = 0;

        $dataValues = $this->data['values'];
        $table      = $this->data['table'];

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
                $values[] = "('" . implode("','", $currentValues) . "')";
            }

            $query  = $insert . ' VALUES' . implode(',', $values) . ';';
            $result = $result + $wpdb->query($query);
        }

        $this->data = [];

        return $result;
    }
}
