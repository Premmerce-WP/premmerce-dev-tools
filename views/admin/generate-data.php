<div class="wrap">
    <h1>Generate data</h1>

    <form method="post" action="<?php use Premmerce\DevTools\FakeData\DataGenerator;

	echo admin_url( 'admin-post.php' ) ?>">
        <input type="hidden" name="action" value="generate_data">
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label>Products number</label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_PRODUCTS ?>" value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label>Add product photo</label>
                </th>
                <td>
                    <input type="checkbox" name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label>Gallery photos number</label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER ?>"
                           value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label>Product type</label>
                </th>
                <td>
                    <select name="<?php echo DataGenerator::NAME_PRODUCT_TYPE ?>" id="">
						<?php foreach ( DataGenerator::PRODUCT_TYPES as $productType ) : ?>
                            <option value="<?php echo $productType ?>"><?php echo $productType ?></option>
						<?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label>Categories number</label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_CATEGORIES ?>" value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label>Attributes number</label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_ATTRIBUTES ?>" value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label>Each attribute terms number</label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_ATTRIBUTE_TERMS ?>" value="<?php ?>">
                </td>
            </tr>
            </tbody>
        </table>
		<?php submit_button(); ?>
    </form>
</div>