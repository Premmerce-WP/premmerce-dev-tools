<?php namespace Premmerce\DevTools\Admin;

use Premmerce\DevTools\Services\DataCleaner;

class CleanUpHandler
{
    const REMOVE_PRODUCTS = 'remove_products';

    const REMOVE_CATEGORIES = 'remove_categories';

    const REMOVE_BRANDS = 'remove_brands';

    const REMOVE_ATTRIBUTES = 'remove_attributes';

    const REMOVE_TAGS = 'remove_tags';

    const REMOVE_IMAGES = 'remove_images';

    const REMOVE_TRANSIENTS = 'remove_transient';


    const CLEAR_TERMS = 'clear_terms';

    const CLEAR_TERM_RELATIONS = 'clear_term_relations';


    const CLEAR_TERM_META = 'clear_term_meta';

    const CLEAR_POSTS = 'remove_posts';

    const CLEAR_POST_META = 'clear_post_meta';

    const RECOUNT_TERMS = 'recount_terms';


    private $handlers;

    private $cleaner;

    public function __construct()
    {
        $this->cleaner = new DataCleaner();

        $this->handlers = [
            self::REMOVE_PRODUCTS   => [
                [$this->cleaner, 'removeProducts'],
            ],
            self::REMOVE_BRANDS     => [
                [$this->cleaner, 'removeBrands'],
            ],
            self::REMOVE_TAGS       => [
                [$this->cleaner, 'removeTags'],
            ],
            self::REMOVE_IMAGES     => [
                [$this->cleaner, 'cleanUploads'],
            ],
            self::REMOVE_CATEGORIES => [
                [$this->cleaner, 'removeCategories'],
            ],
            self::REMOVE_ATTRIBUTES => [
                [$this->cleaner, 'removeAttributes'],
                [$this->cleaner, 'removeAttributeTerms'],
                [$this->cleaner, 'removeAllTransients'],
            ],
            self::CLEAR_TERMS       => [
                [$this->cleaner, 'clearTerms'],
            ],
            self::CLEAR_POSTS       => [
                [$this->cleaner, 'clearPosts'],
            ],
            self::RECOUNT_TERMS     => [
                [$this->cleaner, 'recountTermTaxonomies'],
            ],
            self::REMOVE_TRANSIENTS => [
                [$this->cleaner, 'removeAllTransients'],
            ],
        ];
    }

    public function handle($config)
    {
        foreach ($this->handlers as $key => $handlers) {
            if (isset($config[$key])) {
                foreach ($handlers as $handler) {
                    call_user_func($handler);
                }
            }
        }
    }
}
