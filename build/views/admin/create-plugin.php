<?php

if ( ! defined('WPINC')) {
    die;
}

/** @var WP_User $current_user */
$current_user = wp_get_current_user();
?>
<div class="wrap">
    <h1><?php _e('New plugin', 'premmerce-dev-tools') ?></h1>
    <form method="post" action="<?php echo admin_url('admin-post.php') ?>">
        <input type="hidden" name="action" value="create_plugin">
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label for="premmerce_plugin_author"><?php _e('Plugin author', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_author" value="<?php echo $current_user->display_name ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="premmerce_plugin_name"><?php _e('Plugin directory name',
                            'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_name" placeholder="plugin-name">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="premmerce_plugin_name_humanized"><?php _e('Plugin name',
                            'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_name_humanized" placeholder="Plugin name">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="premmerce_plugin_namespace"><?php _e('Plugin namespace',
                            'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_namespace">
                    <p class="description"><?php _e('For example', 'premmerce-dev-tools') ?>: PluginName,
                        Company\PluginName</p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="premmerce_plugin_description"><?php _e('Plugin description',
                            'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <textarea name="premmerce_plugin_description" cols="30" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="premmerce_plugin_version"><?php _e('Plugin version', 'premmerce-dev-tools') ?></label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_version" value="1.0">
                </td>
            </tr>
            </tbody>
        </table>
        <p>
            <?php _e('run > \'composer install\' command after generation, inside the plugin
                        directory', 'premmerce-dev-tools') ?>
        </p>
        <?php submit_button(__('Generate plugin', 'premmerce-dev-tools')); ?>
    </form>

</div>
