<?php

if ( ! defined('WPINC')) {
    die;
}

use Premmerce\DevTools\DataGenerator\DataGenerator;

?>
<div class="wrap">
    <h1><?php _e('Generate data', 'premmerce-dev-tools') ?></h1>

    <?php if (is_plugin_active('woocommerce/woocommerce.php')): ?>
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>">
            <input type="hidden" name="action" value="generate_data">
            <h2 class="title"><?php _e('Categories', 'premmerce-dev-tools') ?></h2>
            <table class="form-table">
                <tr>
                    <th>
                        <label><?php _e('Categories number', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="number" min="0" max="10000" name="<?php echo DataGenerator::NAME_CATEGORIES ?>"
                               value="<?php ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php _e('Categories nesting level', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="number" min="1" max="10"
                               name="<?php echo DataGenerator::NAME_CATEGORIES_NESTING ?>"
                               value="<?= 1 ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php _e('Generate menu from categories tree', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo DataGenerator::NAME_SHOP_MENU ?>">
                    </td>
                </tr>
            </table>
            <h2 class="title"><?php _e('Products', 'premmerce-dev-tools') ?></h2>

            <table class="form-table">

                <tr>
                    <th>
                        <label><?php _e('Products number', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="number" min="0" max="100000" name="<?php echo DataGenerator::NAME_PRODUCTS ?>"
                               value="<?php ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php _e('Generate product photo', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php _e('Product gallery photos number', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="number" min="0" max="100"
                               name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER ?>"
                               value="<?php ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php _e('Product type', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <select name="<?php echo DataGenerator::NAME_PRODUCT_TYPE ?>" id="">
                            <?php foreach (wc_get_product_types() as $name => $title) : ?>
                                <option value="<?php echo $name ?>"><?php echo $title ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>

            <h2 class="title"><?php _e('Attributes', 'premmerce-dev-tools') ?></h2>
            <table class="form-table">

                <?php if (taxonomy_exists(DataGenerator::PREMMERCE_BRAND)): ?>
                    <tr>
                        <th>
                            <label><?php _e('Brands number', 'premmerce-dev-tools') ?></label>
                        </th>
                        <td>
                            <input type="number" min="0" max="10000" name="<?php echo DataGenerator::NAME_BRANDS ?>"
                                   value="<?php ?>">
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th>
                        <label><?php _e('Attributes number', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="number" min="0" max="1000" name="<?php echo DataGenerator::NAME_ATTRIBUTES ?>"
                               value="<?php ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label><?php _e('Each attribute terms number', 'premmerce-dev-tools') ?></label>
                    </th>
                    <td>
                        <input type="number" min="0" max="1000" name="<?php echo DataGenerator::NAME_ATTRIBUTE_TERMS ?>"
                               value="<?php ?>">
                    </td>
                </tr>
            </table>
            <?php submit_button(__('Generate', 'premmerce-dev-tools')); ?>
        </form>
    <?php else: ?>
        <?php printf(
            __('This plugin requires %s plugin to be active!', 'premmerce-dev-tools'),
            '<a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a>'
        ); ?>
    <?php endif; ?>
</div>
