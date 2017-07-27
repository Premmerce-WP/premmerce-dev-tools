<?php
/** @var WP_User $current_user */
$current_user = wp_get_current_user();
?>
<div class="wrap">
    <h1>New plugin</h1>
    <form method="post" action="<?php echo admin_url( 'admin-post.php' ) ?>">
        <input type="hidden" name="action" value="create_plugin">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_author">Plugin author</label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_author" value="<?php echo $current_user->display_name ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_name">Plugin name</label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_name" placeholder="plugin-name">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_name_humanized">Plugin name humanized</label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_name_humanized" placeholder="Plugin name">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_namespace">Plugin namespace</label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_namespace">
                    <p class="description">For example: PluginName, Company\PluginName</p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_description">Plugin description</label>
                </th>
                <td>
                    <textarea name="premmerce_plugin_description" cols="30" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_version">Plugin version</label>
                </th>
                <td>
                    <input type="text" name="premmerce_plugin_version" value="1.0">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="premmerce_plugin_use_composer">Use Composer</label>
                </th>
                <td>
                    <input type="checkbox" name="premmerce_plugin_use_composer">
                    <p class="description">run > 'composer init' command after plugin generation</p>
                </td>
            </tr>
            </tbody>
        </table>
		<?php submit_button(); ?>
    </form>

</div>