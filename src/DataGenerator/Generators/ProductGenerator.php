<?php namespace Premmerce\DevTools\DataGenerator\Generators;

use Faker\Generator as Faker;
use Generator;
use Premmerce\DevTools\Services\Query;

class ProductGenerator
{
    const WOO_PRODUCT = 'product';

    /**
     * @var Faker
     */
    private $faker;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var array
     */
    private $categoryIds = [];

    /**
     * @var array
     */
    private $productTypes = [];

    /**
     * @var string
     */
    private $productType = 'simple';

    /**
     * @var
     */
    private $brandIds;

    /**
     * @var bool
     */
    private $generateImage;

    /**
     * @var int
     */
    private $galleryPhotosNumber;

    /**
     * @var []
     */
    private $productIds;


    /**
     * @var array
     */
    private $productVariations = [];


    /**
     * @var array
     */
    private $images = [];

    /**
     * @var array
     */
    private $attributeTerms;


    /**
     * FastProductGenerator constructor.
     *
     * @param Faker $faker
     */
    public function __construct(Faker $faker)
    {
        $this->faker        = $faker;
        $this->userId       = get_current_user_id();
        $this->productTypes = $this->getProductTypes();
    }

    /**
     * @param array $categoryIds
     */
    public function setCategoryIds(array $categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }

    /**
     * @param array $attributeTerms
     */
    public function setAttributes(array $attributeTerms)
    {
        $this->attributeTerms = $attributeTerms;
    }

    /**
     * @param array $brandIds
     *
     */
    public function setBrands(array $brandIds)
    {
        $this->brandIds = $brandIds;
    }

    /**
     * @param string $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * @param bool $generateImage
     */
    public function setGenerateImage($generateImage)
    {
        $this->generateImage = $generateImage;
    }

    /**
     * @param bool $galleryPhotosNumber
     */
    public function setGalleryPhotosNumber($galleryPhotosNumber)
    {
        $this->galleryPhotosNumber = $galleryPhotosNumber;
    }


    /**
     * @param array $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @param       $num
     *
     * @return array|null
     *
     */
    public function generate($num)
    {
        $this->productIds = $this->insertProducts($num);

        $this->insertProductTerms($this->productIds);

        $this->insertProductsMeta($this->productIds);

        if ( ! empty($this->images)) {

            if ($this->generateImage) {
                $this->insertThumbnails();

                if ($this->galleryPhotosNumber > 0) {
                    $this->insertImageGallery();
                }
            }
        }

        if ($this->attributeTerms) {
            $this->generateAttributes();
        }

        return $this->productIds;
    }

    /*******************************************************************************************************************
     * PRODUCTS
     */


    /**
     * @param int $num
     *
     * @return array ids
     */
    private function insertProducts($num)
    {
        $products = $this->generateProductsArray($num);
        Query::create()->insertPosts($products);

        $this->log(__METHOD__);

        $productIds = array_keys($products);


        return $productIds;
    }


    private function insertProductsMeta($productIds)
    {
        $meta = [];
        $i    = 0;
        foreach ($productIds as $id) {
            $price = $this->faker->randomFloat(2, 1, 1000);

            $data = [
                '_regular_price' => $price,
                '_stock_status'  => 'instock',
                '_price'         => $price,

            ];
            foreach ($data as $key => $value) {
                $meta[] = [
                    'post_id'    => $id,
                    'meta_key'   => $key,
                    'meta_value' => $value,
                ];
            }

            $this->log(__METHOD__ . ' ' . ++$i);
        }

        Query::create()->insertPostMeta($meta);
        $this->log(__METHOD__ . ' insert');

    }

    /**
     * @param array $productIds
     */
    private function insertProductTerms($productIds)
    {
        $terms = $this->generateProductTerms($productIds);
        Query::create()->insertTermRelationships($terms);

        $this->log(__METHOD__);
    }

    /**
     * generate category and product type
     *
     * @param $ids
     *
     * @return array
     */
    private function generateProductTerms($ids)
    {
        $type = $this->productTypes[$this->productType];

        $terms = [];

        $i = 0;
        foreach ($ids as $id) {
            $tts = [];

            if ( ! empty($this->categoryIds)) {
                $tts[] = $this->faker->randomElement($this->categoryIds);
            }
            if ( ! empty($this->brandIds)) {
                $tts[] = $this->faker->randomElement($this->brandIds);
            }
            if ($type) {
                $tts[] = $type;
            }

            foreach ($tts as $tt) {
                $terms[] = [
                    'object_id'        => $id,
                    'term_taxonomy_id' => $tt,
                    'term_order'       => 0,

                ];
            }
            $this->log(__METHOD__ . ' ' . ++$i);
        }

        return $terms;
    }

    /**
     * @param int $num
     *
     * @return array
     */
    private function generateProductsArray($num)
    {
        $lastId = Query::create()->getLastPostId();

        $products = [];
        for ($i = 1; $i <= $num; $i++) {
            $id            = $lastId + $i;
            $products[$id] = $this->generateProduct($id);
            $this->log(__METHOD__ . ' ' . $i);
        }

        return $products;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    private function generateProduct($id)
    {
        $title = ucfirst($this->faker->word) . '-' . $id;
        $date  = current_time('mysql');
        $data  = [
            'ID'                => $id,
            'post_author'       => $this->userId,
            'post_title'        => $title,
            'post_content'      => $this->faker->paragraph,
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'post_name'         => sanitize_title($title),
            'post_date'         => $date,
            'post_date_gmt'     => $date,
            'post_modified'     => $date,
            'post_modified_gmt' => $date,

        ];

        return $data;
    }

    /*******************************************************************************************************************
     * IMAGES
     */

    /**
     * Add product images
     */
    private function insertThumbnails()
    {
        $thumbnails = array_keys($this->images);
        $metadata   = [];
        $i          = 0;
        foreach ($this->productIds as $postId) {
            $metadata[] = [
                'post_id'    => $postId,
                'meta_key'   => '_thumbnail_id',
                'meta_value' => $this->faker->randomElement($thumbnails),
            ];
            $this->log(__METHOD__ . ' ' . ++$i);
        }


        Query::create()->insertPostMeta($metadata);

        $this->log(__METHOD__);
    }

    /**
     * @return array
     */
    private function insertImageGallery()
    {
        $ids = array_keys($this->images);

        $productMeta = [];
        $i           = 0;
        foreach ($this->productIds as $productId) {
            $pImages = $this->faker->randomElements($ids, $this->galleryPhotosNumber);

            $productMeta[$productId] = [
                'post_id'    => $productId,
                'meta_key'   => '_product_image_gallery',
                'meta_value' => implode(',', $pImages),
            ];
            $this->log(__METHOD__ . ' ' . ++$i);
        }

        Query::create()->insertPostMeta($productMeta);

        $this->log(__METHOD__);

    }

    /*******************************************************************************************************************
     * ATTRIBUTES
     */

    /**
     * Add attributes and variations to product
     */
    private function generateAttributes()
    {

        $this->generateAttributesData();

        if ($this->productVariations) {
            $this->generateVariations();
        }
    }

    /**
     * Create terms relations for wp_term_relationships
     *
     * @return Generator
     */
    public function generateAttributesData()
    {

        $rel  = [];
        $meta = [];

        $i = 0;
        foreach ($this->productIds as $productId) {
            $variationTrigger = $this->productType === 'variable' ? 1 : 0;

            $attributes = [];
            foreach ($this->attributeTerms as $attribute => $terms) {
                if (empty($terms)) {
                    continue;
                }

                $attributes[$attribute] = [
                    'name'         => $attribute,
                    'value'        => '',
                    'is_visible'   => 1,
                    'is_variation' => $variationTrigger,
                    'is_taxonomy'  => 1,
                    'position'     => 0,

                ];


                if ($variationTrigger) {
                    $countTerms = intval(count($terms) / 2);

                    $randomTerms = $this->faker->randomElements($terms, $this->faker->numberBetween(1, $countTerms));

                    $this->productVariations[$productId][$attribute] = $randomTerms;
                    $variationTrigger                                = 0;
                } else {
                    $randomTerms = $this->faker->randomElements($terms, 1);
                }


                foreach ($randomTerms as $term) {
                    $rel[] = [
                        'object_id'        => $productId,
                        'term_taxonomy_id' => $term['term_taxonomy_id'],
                        'term_order'       => 0,
                    ];
                }
            }
            $meta[] = [
                'post_id'    => $productId,
                'meta_key'   => '_product_attributes',
                'meta_value' => serialize($attributes),
            ];

            $this->log(__METHOD__ . ' ' . ++$i);
        }

        Query::create()->insertTermRelationships($rel);
        $this->log(__METHOD__ . 'insert term relationships');
        Query::create()->insertPostMeta($meta);
        $this->log(__METHOD__ . 'insert post meta');
    }

    /**
     * Create variations generator
     *
     * @return Generator
     */
    private function generateVariations()
    {
        $id = Query::create()->getLastPostId();


        $meta  = [];
        $posts = [];
        $ids   = [];

        $i = 0;
        foreach ($this->productVariations as $productId => $variation) {
            foreach ($variation as $attribute => $terms) {
                foreach ($terms as $term) {
                    $id++;

                    $title = ucfirst($this->faker->word) . '-' . $id;

                    $meta[] = [
                        'post_id'    => $id,
                        'meta_key'   => 'attribute_' . $attribute,
                        'meta_value' => sanitize_title($term['name']),

                    ];

                    $ids[]   = $id;
                    $posts[] = [
                        'ID'           => $id,
                        'post_author'  => $this->userId,
                        'post_title'   => $title,
                        'post_content' => $this->faker->paragraph,
                        'post_status'  => 'publish',
                        'post_type'    => 'product_variation',
                        'post_parent'  => $productId,
                        'post_name'    => sanitize_title($title),
                    ];
                }
            }
            $this->log(__METHOD__ . ' ' . ++$i);
        }

        Query::create()->insertPosts($posts);
        $this->log(__METHOD__ . ' insert posts');

        Query::create()->insertPostMeta($meta);
        $this->log(__METHOD__ . ' insert posts meta attribute');

        $this->insertProductsMeta($ids);
    }


    /*******************************************************************************************************************
     * HELPERS
     */

    /**
     * @return array
     */
    private function getProductTypes()
    {
        $terms = get_terms([
            'taxonomy'   => 'product_type',
            'hide_empty' => false,
        ]);

        $productTypes = [];
        foreach ($terms as $term) {
            $productTypes[$term->name] = $term->term_taxonomy_id;
        }


        return $productTypes;
    }

    private function log($value)
    {
        if (defined('WP_CLI')) {
            dump($value);
        }
    }

}
