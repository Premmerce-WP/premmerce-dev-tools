<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Premmerce\DevTools\DataGenerator\DataGenerator;
use Premmerce\DevTools\Services\Query;

class ShopMenuGenerator
{

    public function generate() {
        /** @var \WP_Term[] $terms */
        $ids = get_terms([
            'taxonomy'   => DataGenerator::WOO_CATEGORY,
            'hide_empty' => true,
            'fields'     => 'id=>parent',
        ]);

        $menu_name = 'GENERATED Catalog menu';

        wp_delete_nav_menu($menu_name);

        $menu_id = wp_create_nav_menu($menu_name);

        $term = get_term($menu_id);

        $this->createItems($ids, $term->term_taxonomy_id);
    }


    public function createItems($categories, $menuId) {

        $id = $this->getLastPost();


        $order = 1;
        $temp = [];
        $meta = [];
        $data = [];
        $rel = [];

        foreach ($categories as $category => $parent) {
            $id++;
            $temp[$id] = $category;
            $data[$id] = [
                'ID'           => $id,
                'post_author'  => 1,
                'post_title'   => '',
                'menu_order'   => ++$order,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'nav_menu_item',
                'post_parent'  => 0,
                'post_name'    => $id,
            ];

            $meta[] = [
                'post_id'    => $id,
                'meta_key'   => '_menu_item_type',
                'meta_value' => 'taxonomy',
            ];

            $meta[] = [
                'post_id'    => $id,
                'meta_key'   => '_menu_item_object_id',
                'meta_value' => $category,
            ];
            $meta[] = [
                'post_id'    => $id,
                'meta_key'   => '_menu_item_object',
                'meta_value' => 'product_cat',
            ];
        }

        foreach ($data as $id => $item) {
            $parentCategory = $categories[$temp[$id]];

            $parent = $parentCategory ? array_flip($temp)[$parentCategory] : 0;


            $data[$id]['post_parent'] = $parent;
            $meta[] = [
                'post_id'    => $id,
                'meta_key'   => '_menu_item_menu_item_parent',
                'meta_value' => $parent,
            ];
            $rel[] = [
                'object_id'        => $id,
                'term_taxonomy_id' => $menuId,
                'term_order'       => 0,
            ];
        }

        Query::create()->insertPosts($data);
        Query::create()->insertPostMeta($meta);
        Query::create()->insertTermRelationships($rel);

    }


    /**
     * @return int
     */
    private function getLastPost() {
        global $wpdb;

        $query[] = 'SELECT ID';
        $query[] = 'FROM ' . $wpdb->posts;
        $query[] = 'ORDER BY ID DESC';
        $query[] = 'LIMIT 1';

        $query = implode(' ', $query);

        return (int)$wpdb->get_var($query);
    }

}