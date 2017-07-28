<?php namespace Premmerce\DevTools\Services;


use Premmerce\DevTools\FakeData\DataGenerator;

class DataCleaner {


	public function clean() {
		$this->removeProducts();
		$this->removeCategories();
		$this->removeAttributes();
		$this->clearUnusedData();
		$this->cleanUploads();
		$this->clearTransients();
	}

	public function cleanUploads() {

//		$uploads = wp_upload_dir()['path'];
//
//		$files = glob( $uploads . '/*' );
//		foreach ( $files as $file ) {
//			if ( is_file( $file ) ) {
//				@unlink( $file );
//			}
//		}
//		if ( ! file_exists( $uploads ) ) {
//			@mkdir( $uploads );
//			@chmod( $uploads, 0777 );
//		}

	}

	public function removeProducts() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE %s, %s, %s',
			$wpdb->posts,
			$wpdb->postmeta,
			$wpdb->term_relationships
		);
		$query['from']   = sprintf( 'FROM %s', $wpdb->posts );
		$query['join1']  = sprintf( 'LEFT JOIN %s', $wpdb->postmeta );
		$query['on1']    = sprintf( 'ON %s.post_id = %s.ID', $wpdb->postmeta, $wpdb->posts );
		$query['join2']  = sprintf( 'LEFT JOIN %s', $wpdb->term_relationships );
		$query['on2']    = sprintf( 'ON %s.object_id = %s.ID', $wpdb->term_relationships, $wpdb->posts );
		$query['where']  = sprintf( "WHERE %s.post_type in  ('%s', '%s')", $wpdb->posts, DataGenerator::WOO_PRODUCT, 'product_variation' );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );

	}

	public function removeCategories() {
		global $wpdb;


		$query['delete'] = sprintf( 'DELETE %s, %s, %s, %s',
			$wpdb->term_taxonomy,
			$wpdb->terms,
			$wpdb->termmeta, $wpdb->term_relationships
		);

		$query['from'] = sprintf( 'FROM %s', $wpdb->term_taxonomy );

		$query['join1'] = sprintf( 'LEFT JOIN %s USING (term_id) ', $wpdb->terms );
		$query['join2'] = sprintf( 'LEFT JOIN %s USING (term_id) ', $wpdb->termmeta );
		$query['join3'] = sprintf( 'LEFT JOIN %s USING (term_taxonomy_id) ', $wpdb->term_relationships );

		$query['where'] = sprintf( "WHERE %s.taxonomy = '%s'", $wpdb->term_taxonomy, DataGenerator::WOO_CATEGORY );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );

	}

	public function removeAttributes() {
		global $wpdb;

		$this->removeAttributeTaxonomyTerms();
		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->prefix . 'woocommerce_attribute_taxonomies' );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );
	}


	public function removeAttributeTaxonomyTerms() {
		global $wpdb;

		$taxonomies = wc_get_attribute_taxonomy_names();


		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->term_taxonomy );
		$query['where']  = sprintf( "WHERE taxonomy IN ('%s')", implode( "','", $taxonomies ) );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );

	}

	public function clearUnusedData() {
		$this->clearTermsWithoutTaxonomy();
		$this->clearTermRelationsWithoutPost();
		$this->clearTermRelationsWithoutTaxonomy();
		$this->clearPostMetaWithoutPost();
		$this->clearPostWithNonExistedParent();
		$this->clearTermWithoutTaxonomy();
		$this->clearTermMetaWithoutTerm();
	}

	public function clearTermRelationsWithoutPost() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->term_relationships );
		$query['where']  = sprintf( 'WHERE object_id NOT IN (SELECT id FROM wp_posts)', $wpdb->posts );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );
	}


	public function clearTermRelationsWithoutTaxonomy() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->term_relationships );
		$query['where']  = sprintf( 'WHERE object_id NOT IN (SELECT term_taxonomy_id FROM %s)', $wpdb->term_taxonomy );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );
	}

	public function clearTermWithoutTaxonomy() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->terms );
		$query['where']  = sprintf( 'WHERE term_id NOT IN (SELECT term_taxonomy_id FROM %s)', $wpdb->term_taxonomy );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );

	}

	public function clearTermMetaWithoutTerm() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->termmeta );
		$query['where']  = sprintf( 'WHERE term_id NOT IN (SELECT term_id FROM %s)', $wpdb->terms );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );

	}

	public function clearPostMetaWithoutPost() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->postmeta );
		$query['where']  = sprintf( 'WHERE post_id NOT IN (SELECT ID FROM %s)', $wpdb->posts );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );
	}

	public function clearPostWithNonExistedParent() {
		global $wpdb;

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->posts );
		$query['where']  = sprintf( 'WHERE post_parent <> 0 AND post_parent IS NOT null AND post_parent NOT IN (SELECT ID FROM (SELECT ID FROM %s) x)', $wpdb->posts );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );
	}

	public function clearTermsWithoutTaxonomy() {

		global $wpdb;

		$taxonomies = get_taxonomies();

		$query['delete'] = sprintf( 'DELETE FROM %s', $wpdb->term_taxonomy );
		$query['where']  = sprintf( "WHERE taxonomy NOT IN ('%s')", implode( "','", $taxonomies ) );

		$query = implode( ' ', $query );

		return $wpdb->query( $query );

	}

	public function clearTransients() {
		global $wpdb;

		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE `option_name` LIKE ('_transient_%')" );
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE `option_name` LIKE ('_site_transient_%')" );
	}

}