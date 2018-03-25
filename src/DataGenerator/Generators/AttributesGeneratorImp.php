<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator as Faker;
use Generator;
use Premmerce\DevTools\DataGenerator\Providers\AttributeProvider;
use Premmerce\DevTools\Services\BulkInsertQuery;

class AttributesGeneratorImp extends TermGenerator
{


    private $currentName = '';

    public function __construct(Faker $faker) {
        $faker->addProvider(new AttributeProvider($faker));
        parent::__construct($faker);
    }


    public function generateAttributes($number, $numberTerms) {
        global $wpdb;
        $q = BulkInsertQuery::create();

        $attributes = $this->createAttributes($number);
        $q->insert($wpdb->prefix . 'woocommerce_attribute_taxonomies', $attributes);
        foreach ($attributes as $taxonomy => $attribute) {
            $this->currentName = $attribute['attribute_label'];
            $tt = $this->generate($numberTerms, $taxonomy, 1, false);

            $tt = $this->mergeTermTaxonomy($tt[0], $tt[1]);

            $attributes[$taxonomy] = $tt;
        }


        return $attributes;
    }

    protected function mergeTermTaxonomy($termTaxonomies, $terms) {

        foreach ($termTaxonomies as $id => $taxonomy) {
            $term = $terms[$taxonomy['term_id']];
            $termTaxonomies[$id] = [
                'term_id'          => $taxonomy['term_id'],
                'name'             => $term['name'],
                'term_taxonomy_id' => $id,
            ];
        }

        return $termTaxonomies;

    }

    protected function uniqueName() {
        $name = $this->faker->attributeValue($this->currentName);

        return $this->unique($name, 'name', 'ucwords');
    }

    /**
     * @param int $number
     *
     * @return Generator
     */
    public function createAttributes($number) {
        $attributes = [];

        for ($i = 1; $i <= $number; $i++) {
            $attrName = $this->faker->attributeName;
            $attrName = substr($attrName, 0, 32);
            $slug = $this->uniqueSlug($attrName);

            $attributes['pa_' . $slug] = [
                'attribute_label'   => $attrName,
                'attribute_name'    => $slug,
                'attribute_type'    => 'select',
                'attribute_orderby' => 'menu_order',
                'attribute_public'  => 0,

            ];
        }

        return $attributes;
    }


}
