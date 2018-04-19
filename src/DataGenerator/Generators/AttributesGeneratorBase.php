<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Premmerce\DevTools\Services\Query;

class AttributesGeneratorBase extends TermGenerator
{


    public function generateAttributes($number, $numberTerms) {
        $attributes = $this->createAttributes($number);

        Query::create()->insertWoocommerceAttributeTaxonomies($attributes);

        foreach ($attributes as $taxonomy => $attribute) {
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
        $name = $this->faker->word;

        return $this->unique($name, 'name', 'ucwords');
    }

    /**
     * @param int $number
     *
     * @return array
     */
    public function createAttributes($number) {
        $attributes = [];

        for ($i = 1; $i <= $number; $i++) {
            $attrName = $this->faker->word;
            $attrName = substr($attrName, 0, 28);
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
