<div class="wrap">
    <h1><?php _e( 'Generate data', 'premmerce-dev-tools' ) ?></h1>

    <form method="post" action="<?php use Premmerce\DevTools\DataGenerator\DataGenerator;

	echo admin_url( 'admin-post.php' ) ?>">
        <input type="hidden" name="action" value="generate_data">
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label><?php _e( 'Products number', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_PRODUCTS ?>" value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e( 'Generate product photo', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <input type="checkbox" name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e( 'Product gallery photos number', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_PRODUCT_PHOTO_GALLERY_NUMBER ?>"
                           value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e( 'Product type', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <select name="<?php echo DataGenerator::NAME_PRODUCT_TYPE ?>" id="">
						<?php foreach ( wc_get_product_types() as $name => $title ) : ?>
                            <option value="<?php echo $name ?>"><?php echo $title ?></option>
						<?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e( 'Categories number', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_CATEGORIES ?>" value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e( 'Attributes number', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_ATTRIBUTES ?>" value="<?php ?>">
                </td>
            </tr>
            <tr>
                <th>
                    <label><?php _e( 'Each attribute terms number', 'premmerce-dev-tools' ) ?></label>
                </th>
                <td>
                    <input type="number" name="<?php echo DataGenerator::NAME_ATTRIBUTE_TERMS ?>" value="<?php ?>">
                </td>
            </tr>
            </tbody>
        </table>
		<?php submit_button( __( 'Generate', 'premmerce-dev-tools' ) ); ?>
    </form>
</div>