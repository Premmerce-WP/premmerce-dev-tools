<?php
/**
 * Created by PhpStorm.
 * User: cray
 * Date: 28.03.18
 * Time: 18:07
 */

namespace Premmerce\DevTools\DataGenerator\Generators;

use Premmerce\DevTools\DataGenerator\DataGenerator;

class ShopMenuGenerator
{

    public function generate() {
        /** @var \WP_Term[] $terms */
        $terms = get_terms([
            'taxonomy'   => DataGenerator::WOO_CATEGORY,
            'hide_empty' => true,
        ]);

        $menu_name = 'Shop Category Menu';

        wp_delete_nav_menu($menu_name);


        $menu_id = wp_create_nav_menu($menu_name);

        $termMenu = [];
        foreach ($terms as $category) {
            $id = wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-object-id' => $category->term_id,
                    'menu-item-object'    => DataGenerator::WOO_CATEGORY,
                    'menu-item-type'      => 'taxonomy',
                    'menu-item-status'    => 'publish',
                ]
            );
            $termMenu[$category->term_id] = $id;
        }

        //update parents
        foreach ($terms as $term) {
            $menuItemId = isset($termMenu[$term->term_id]) ? $termMenu[$term->term_id] : null;
            $menuItemParentId = isset($termMenu[$term->parent]) ? $termMenu[$term->parent] : null;
            if ($menuItemId && $menuItemParentId) {
                wp_update_nav_menu_item($menu_id, $menuItemId, [
                    'menu-item-object-id' => $term->term_id,
                    'menu-item-object'    => DataGenerator::WOO_CATEGORY,
                    'menu-item-parent-id' => $menuItemParentId,
                    'menu-item-type'      => 'taxonomy',
                    'menu-item-status'    => 'publish',
                ]);
            }
        }
    }
}