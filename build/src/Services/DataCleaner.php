<?php namespace Premmerce\DevTools\Services;

class DataCleaner
{

    public function all()
    {
        $this->removeProducts();
        $this->removeCategories();
        $this->removeBrands();
        $this->removeTags();
        $this->removeAttachments();
        $this->removeAttributes();
        $this->removeAttributeTaxonomyTerms();
        $this->removeMenus();
        $this->removeAllTransients();
        $this->clearTerms();
        $this->clearPosts();
        $this->cleanUploads();
    }

    /**
     * Clear menus
     */
    public function removeMenus()
    {
        $this->removeMenuTaxonomies();
        $this->removeMenuItems();
    }

    /**
     * @return false|int
     */
    public function removeMenuItems()
    {
        return $this->removePostTypes(['nav_menu_item']);
    }


    /**
     * @return false|int
     */
    public function removePosts()
    {
        return $this->removePostTypes(['post']);
    }

    /**
     * @return false|int
     */
    public function removePages()
    {
        return $this->removePostTypes(['page']);
    }

    /**
     * @return false|int
     */
    public function removeAttachments()
    {
        return $this->removePostTypes(['attachment']);
    }

    /**
     * @return false|int
     */
    public function removeProducts()
    {

        return $this->removePostTypes(['product', 'product_variation']);
    }

    public function removePostTypes($type)
    {
        global $wpdb;

        $query['delete'] = sprintf(
            'DELETE %s, %s, %s, %s',
            $wpdb->posts,
            $wpdb->postmeta,
            $wpdb->term_relationships,
            'child'
        );
        $query['from']   = sprintf('FROM %s', $wpdb->posts);


        $query['join1'] = sprintf('LEFT JOIN %s child', $wpdb->posts);
        $query['on1']   = sprintf('ON %s.ID = child.post_parent', $wpdb->posts);

        $query['join2'] = sprintf('LEFT JOIN %s', $wpdb->postmeta);
        $query['on2']   = sprintf('ON %s.post_id = %s.ID', $wpdb->postmeta, $wpdb->posts);

        $query['join3'] = sprintf('LEFT JOIN %s', $wpdb->term_relationships);
        $query['on3']   = sprintf('ON %s.object_id = %s.ID', $wpdb->term_relationships, $wpdb->posts);

        $query['where'] = sprintf("WHERE %s.post_type in  ('%s')", $wpdb->posts, implode("','", $type));

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Remove categories - terms, taxonomies , term_meta, relationships
     *
     * @return false|int
     */
    public function removeMenuTaxonomies()
    {
        return $this->removeTaxonomyTerms('nav_menu');
    }

    /**
     * Remove categories - terms, taxonomies , term_meta, relationships
     *
     * @return false|int
     */
    public function removeCategories()
    {
        return $this->removeTaxonomyTerms('product_cat');
    }

    /**
     * Remove brands - terms, taxonomies , term_meta, relationships
     *
     * @return false|int
     */
    public function removeBrands()
    {
        return $this->removeTaxonomyTerms('product_brand');
    }

    /**
     * Remove brands - terms, taxonomies , term_meta, relationships
     *
     * @return false|int
     */
    public function removeTags()
    {
        return $this->removeTaxonomyTerms('product_tag');
    }


    /**
     * @param string|array $taxonomy
     *
     * @return false|int
     */
    public function removeTaxonomyTerms($taxonomy)
    {
        global $wpdb;

        if ( ! is_array($taxonomy)) {
            $taxonomy = [$taxonomy];
        }

        $query['delete'] = sprintf(
            'DELETE %s, %s, %s, %s',
            $wpdb->term_taxonomy,
            $wpdb->terms,
            $wpdb->termmeta,
            $wpdb->term_relationships
        );

        $query['from'] = sprintf('FROM %s', $wpdb->term_taxonomy);

        $query['join1'] = sprintf('LEFT JOIN %s USING (term_id) ', $wpdb->terms);
        $query['join2'] = sprintf('LEFT JOIN %s USING (term_id) ', $wpdb->termmeta);
        $query['join3'] = sprintf('LEFT JOIN %s USING (term_taxonomy_id) ', $wpdb->term_relationships);

        $query['where'] = sprintf("WHERE %s.taxonomy IN ('%s')", $wpdb->term_taxonomy, implode("','", $taxonomy));


        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Remove attributes - woocommerce_attribute_taxonomies
     *
     * @return false|int
     */
    public function removeAttributes()
    {
        global $wpdb;

        $this->removeAttributeTaxonomyTerms();
        $query['delete'] = sprintf('DELETE FROM %s', $wpdb->prefix . 'woocommerce_attribute_taxonomies');

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Remove attribute terms - terms , term_taxonomy, term_relationships, term_meta
     *
     * @return false|int
     */
    public function removeAttributeTaxonomyTerms()
    {
        $taxonomies = wc_get_attribute_taxonomy_names();


        if (count($taxonomies)) {
            return $this->removeTaxonomyTerms($taxonomies);
        }

        return 0;
    }

    /**
     * Remove all transients
     */
    public function removeAllTransients()
    {
        global $wpdb;

        return $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE ('_transient_%')")
               + $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE ('_site_transient_%')");
    }


    /* ***************************************************
     * TERM RELATIONS
     */

    /**
     * Clear term relationship without post or term
     */
    public function clearTermRelations()
    {
        $this->clearTermRelationsWithoutPost();
        $this->clearTermRelationsWithoutTerm();
    }


    /**
     * Clear term relationships with non existent object_id
     *
     * @return false|int
     */
    public function clearTermRelationsWithoutPost()
    {
        global $wpdb;

        $query['delete'] = sprintf('DELETE FROM %s', $wpdb->term_relationships);
        $query['where']  = sprintf('WHERE object_id NOT IN (SELECT id FROM wp_posts)', $wpdb->posts);

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Clear term relationships with non existent term_id
     *
     * @return false|int
     */
    public function clearTermRelationsWithoutTerm()
    {
        global $wpdb;

        $query['delete'] = sprintf('DELETE FROM %s', $wpdb->term_relationships);
        $query['where']  = sprintf('WHERE term_taxonomy_id NOT IN (SELECT term_taxonomy_id FROM %s)',
            $wpdb->term_taxonomy);

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }


    /* ***************************************************
     * TERMS
     */

    /**
     * Clear term relationships with non existent object_id
     *
     * @return false|int
     */
    public function recountTermTaxonomies()
    {
        global $wpdb;


        $query['update'] = sprintf('UPDATE %s tt', $wpdb->term_taxonomy);
        $query['join']   = sprintf('join (select tr.term_taxonomy_id, count(tr.object_id) as count from wp_term_relationships tr group by tr.term_taxonomy_id) counts',
            $wpdb->term_relationships);
        $query['on']     = sprintf('on counts.term_taxonomy_id = tt.term_taxonomy_id');
        $query['set']    = sprintf('SET tt.count = counts.count');

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }


    /**
     * Clear terms, term_taxonomy
     *
     */
    public function clearTerms()
    {

        $this->clearTermWithoutTaxonomy();
        $this->clearTermWithoutTermTaxonomy();
        $this->clearTermTaxonomyWithoutTerm();
        $this->clearTermMetaWithoutTerm();
        $this->clearTermRelations();
    }

    /**
     * Clear term with non existent taxonomy
     *
     * @return false|int
     */
    public function clearTermWithoutTaxonomy()
    {
        global $wpdb;

        $taxonomies = get_taxonomies();

        $query['delete'] = "DELETE {$wpdb->term_taxonomy}, {$wpdb->terms} FROM {$wpdb->term_taxonomy}";
        $query['join']   = "LEFT JOIN {$wpdb->terms} USING (term_id)";
        $query['where']  = sprintf("WHERE taxonomy NOT IN ('%s')", implode("','", $taxonomies));

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Clear term_taxonomy with non existent term_id in terms table
     *
     * @return false|int
     */
    public function clearTermTaxonomyWithoutTerm()
    {
        global $wpdb;

        $query['delete'] = "DELETE FROM $wpdb->term_taxonomy";
        $query['where']  = "WHERE term_id NOT IN (SELECT term_id FROM {$wpdb->terms})";

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Clear term with non existent term_id in term_taxonomy table
     *
     * @return false|int
     */
    public function clearTermWithoutTermTaxonomy()
    {
        global $wpdb;

        $query['delete'] = "DELETE FROM $wpdb->terms";
        $query['where']  = "WHERE term_id NOT IN (SELECT term_id FROM {$wpdb->term_taxonomy})";

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /**
     * Clear term_meta with non existent term_id in terms table
     * @return false|int
     */
    public function clearTermMetaWithoutTerm()
    {
        global $wpdb;

        $query['delete'] = sprintf('DELETE FROM %s', $wpdb->termmeta);
        $query['where']  = sprintf('WHERE term_id NOT IN (SELECT term_id FROM %s)', $wpdb->terms);

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }


    /* ***************************************************
     * POST
     */

    /**
     * Clear post
     */
    public function clearPosts()
    {
        $this->clearPostWithNonExistedParent();
        $this->clearPostMetaWithoutPost();
    }

    /**
     * Clear post_meta with non existent post
     *
     * @return false|int
     */
    public function clearPostMetaWithoutPost()
    {
        global $wpdb;

        $query['delete'] = sprintf('DELETE FROM %s', $wpdb->postmeta);
        $query['where']  = sprintf('WHERE post_id NOT IN (SELECT ID FROM %s)', $wpdb->posts);

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }


    /**
     * Clear post with non existent parent_post
     *
     * @return false|int
     */
    public function clearPostWithNonExistedParent()
    {
        global $wpdb;

        $query['delete'] = sprintf('DELETE FROM %s', $wpdb->posts);
        $query['where']  = sprintf('WHERE post_parent <> 0 AND post_parent IS NOT null AND post_parent NOT IN (SELECT ID FROM (SELECT ID FROM %s) x)',
            $wpdb->posts);

        $query = implode(' ', $query);

        return $wpdb->query($query);
    }

    /* ***************************************************
     * UPLOADS
     */

    public function cleanUploads()
    {
        global $wpdb;

        $query['select'] = "SELECT meta_value FROM {$wpdb->posts}";
        $query['join']   = "JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id";
        $query['where']  = "WHERE post_type = 'attachment' AND meta_key = '_wp_attached_file'";
        $query           = implode(' ', $query);


        $existingImages = $wpdb->get_col($query);

        $uploads = wp_upload_dir();

        $baseDir = $uploads['basedir'];
        $path    = $uploads['path'];


        $files = glob($path . '/*');
        foreach ($files as $file) {
            if (is_file($file) && ! in_array(str_replace($baseDir . '/', '', $file), $existingImages)) {
                @unlink($file);
            }
        }
    }
}
