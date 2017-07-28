<div class="wrap">
    <h1>Generate data</h1>

    <form method="post" action="<?php use Premmerce\DevTools\FakeData\DataGenerator;

	echo admin_url( 'admin-post.php' ) ?>">
        <input type="hidden" name="action" value="generate_data">
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label>Add product photo</label>
                </th>
                <td>
                    <input type="checkbox" name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO ?>">
                </td>
            </tr>
        </table>
		<?php submit_button(); ?>
    </form>
</div>