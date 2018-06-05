<?php

if ( ! defined('WPINC')) {
    die;
}

use Premmerce\DevTools\Admin\CleanUpHandler;

?>
<div class="wrap">
    <h1><?php _e('Clean up', 'premmerce-dev-tools') ?></h1>
    <form method="post" action="<?php echo admin_url('admin-post.php') ?>">
        <input type="hidden" name="action" value="clean_up">
        <hr>
        <h2><?php _e('Remove items from database', 'premmerce-dev-tools') ?></h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label><?php _e('Select all', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-select-all="remove" type="checkbox">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Products', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="remove" type="checkbox"
                           name="<?php echo CleanUpHandler::REMOVE_PRODUCTS ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Product categories', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="remove" type="checkbox"
                           name="<?php echo CleanUpHandler::REMOVE_CATEGORIES ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Product attributes', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="remove" type="checkbox"
                           name="<?php echo CleanUpHandler::REMOVE_ATTRIBUTES ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Product brands', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="remove" type="checkbox"
                           name="<?php echo CleanUpHandler::REMOVE_BRANDS ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Product tags', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="remove" type="checkbox"
                           name="<?php echo CleanUpHandler::REMOVE_TAGS ?>">
                </td>
            </tr>
            </tbody>
        </table>
        <hr>
        <h2><?php _e('Uploads', 'premmerce-dev-tools') ?></h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label><?php _e('Remove unused image files', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="checkbox" name="<?php echo CleanUpHandler::REMOVE_IMAGES ?>">
                </td>
            </tr>
            </tbody>
        </table>
        <hr>
        <h2><?php _e('Clear unused items from database', 'premmerce-dev-tools') ?></h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label><?php _e('Select all', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-select-all="clean" type="checkbox">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Terms', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="clean" type="checkbox"
                           name="<?php echo CleanUpHandler::CLEAR_TERMS ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e('Posts', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input data-selectable="clean" type="checkbox"
                           name="<?php echo CleanUpHandler::CLEAR_POSTS ?>">
                </td>
            </tr>
        </table>
        <h2><?php _e('Recount', 'premmerce-dev-tools') ?></h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label><?php _e('Recount terms', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="checkbox" name="<?php echo CleanUpHandler::RECOUNT_TERMS ?>">
                </td>
            </tr>
        </table>
        <?php submit_button(__('Submit', 'premmerce-dev-tools')); ?>
    </form>
</div>
