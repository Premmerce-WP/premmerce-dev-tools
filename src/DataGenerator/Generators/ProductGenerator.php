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
    private $productsAttributes = [];

    /**
     * @var array
     */
    private $productVariations = [];

    /**
     * @var array
     */
    private $variationsMeta = [];

    /**
     * @var array
     */
    private $images = [];

    /**
     * @var array
     */
    private $attributeTerms;

    /**
     * @var array
     */
    private $variationIds;


    /**
     * FastProductGenerator constructor.
     *
     * @param Faker $faker
     */
    public function __construct(Faker $faker) {
        $this->faker = $faker;
        $this->userId = get_current_user_id();
        $this->productTypes = $this->getProductTypes();
    }

    /**
     * @param array $categoryIds
     */
    public function setCategoryIds(array $categoryIds) {
        $this->categoryIds = $categoryIds;
    }

    /**
     * @param string $productType
     */
    public function setProductType($productType) {
        $this->productType = $productType;
    }

    /**
     * @param bool $generateImage
     */
    public function setGenerateImage($generateImage) {
        $this->generateImage = $generateImage;
    }

    /**
     * @param bool $galleryPhotosNumber
     */
    public function setGalleryPhotosNumber($galleryPhotosNumber) {
        $this->galleryPhotosNumber = $galleryPhotosNumber;
    }

    /**
     * @param array $attributeTerms
     */
    public function setAttributes(array $attributeTerms) {
        $this->attributeTerms = $attributeTerms;
    }

    /**
     * @param array $brandIds
     *
     * @internal param array $attributeTerms
     */
    public function setBrands(array $brandIds) {
        $this->brandIds = $brandIds;
    }

    /**
     * @param array $images
     */
    public function setImages($images) {
        $this->images = $images;
    }

    /**
     * @param       $num
     *
     * @return array|null
     *
     */
    public function generate($num) {
        $this->productIds = $this->insertProducts($num);

        $this->insertProductTerms($this->productIds);

        $this->insertProductsMeta($this->productIds);

        if (!empty($this->images)) {

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
    private function insertProducts($num) {
        $products = $this->generateProductsArray($num);
        Query::create()->insertPosts($products);

        $productIds = array_keys($products);


        return $productIds;
    }

    private function insertProductsMeta($productIds) {
        $meta = $this->generatePostMeta($productIds);

        Query::create()->insertPostMeta($meta);
    }


    private function generatePostMeta($productIds) {
        $meta = [];
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
        }

        return $meta;
    }

    /**
     * @param array $productIds
     */
    private function insertProductTerms($productIds) {
        $terms = $this->generateProductTerms($productIds);
        Query::create()->insertTermRelationships($terms);
    }

    /**
     * generate category and product type
     *
     * @param $ids
     *
     * @return array
     */
    private function generateProductTerms($ids) {
        $type = $this->productTypes[$this->productType];
        $terms = [];

        foreach ($ids as $id) {
            $tts = [];

            if (!empty($this->categoryIds)) {
                $tts[] = $this->faker->randomElement($this->categoryIds);
            }
            if (!empty($this->brandIds)) {
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
        }

        return $terms;
    }

    /**
     * @param int $num
     *
     * @return array
     */
    private function generateProductsArray($num) {
        $lastId = Query::create()->getLastPostId();

        $products = [];
        for ($i = 1; $i <= $num; $i++) {
            $id = $lastId + $i;
            $products[$id] = $this->generateProduct($id);
        }

        return $products;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    private function generateProduct($id) {
        $title = ucfirst($this->faker->word) . '-' . $id;
        $data = [
            'ID'           => $id,
            'post_author'  => $this->userId,
            'post_title'   => $title,
            'post_content' => $this->faker->paragraph,
            'post_status'  => 'publish',
            'post_type'    => 'product',
            'post_name'    => sanitize_title($title),
        ];

        return $data;
    }

    /*******************************************************************************************************************
     * IMAGES
     */

    /**
     * Add product images
     */
    private function insertThumbnails() {
        $imageThumbnailsMeta = $this->generatePostThumbnailsMeta(
            $this->productIds, array_keys($this->images)
        );

        Query::create()->insertPostMeta($imageThumbnailsMeta);
    }

    /**
     * @param array $postIds
     * @param array $thumbnails
     *
     * @return array
     */
    private function generatePostThumbnailsMeta($postIds, $thumbnails) {
        $metadata = [];
        foreach ($postIds as $postId) {
            $metadata[] = [
                'post_id'    => $postId,
                'meta_key'   => '_thumbnail_id',
                'meta_value' => $this->faker->randomElement($thumbnails),
            ];
        }

        return $metadata;
    }

    /**
     * @return array
     */
    private function insertImageGallery() {
        $ids = array_keys($this->images);

        $productMeta = [];
        foreach ($this->productIds as $productId) {
            $pImages = $this->faker->randomElements($ids, $this->galleryPhotosNumber);

            $productMeta[$productId] = [
                'post_id'    => $productId,
                'meta_key'   => '_product_image_gallery',
                'meta_value' => implode(',', $pImages),
            ];
        }

        Query::create()->insertPostMeta($productMeta);
    }

    /*******************************************************************************************************************
     * ATTRIBUTES
     */

    /**
     * Add attributes and variations to product
     */
    private function generateAttributes() {

        $rel = $this->generateAttributeTermRelations();
        if (!$rel->valid()) {
            return;
        }
        Query::create()->insertTermRelationships($rel);

        $productAttributes = $this->generateAttributesMeta();
        Query::create()->insertPostMeta($productAttributes);

        if ($this->productVariations) {
            $variations = $this->generateAttributesVariations();

            Query::create()->insertPosts($variations);
            Query::create()->insertPostMeta($this->variationsMeta);

            $meta = $this->generatePostMeta($this->variationIds);
            Query::create()->insertPostMeta($meta);
        }
    }

    /**
     * Create terms relations for wp_term_relationships
     *
     * @return Generator
     */
    public function generateAttributeTermRelations() {
        foreach ($this->productIds as $productId) {
            $variationTrigger = $this->productType === 'variable' ? 1 : 0;

            foreach ($this->attributeTerms as $attribute => $terms) {
                if (!is_array($terms) || !count($terms)) {
                    continue;
                }

                $this->productsAttributes[$productId][$attribute] = [
                    'name'         => $attribute,
                    'value'        => '',
                    'is_visible'   => 1,
                    'is_variation' => $variationTrigger,
                    'is_taxonomy'  => 1,
                    'position'     => 0,

                ];

                $countTerms = intval(count($terms) / 2);

                $randomTerms = $this->faker
                    ->randomElements($terms, $this->faker->numberBetween(1, $countTerms));

                if ($variationTrigger) {
                    $this->productVariations[$productId][$attribute] = $randomTerms;
                }

                $variationTrigger = 0;

                foreach ($randomTerms as $term) {
                    yield [
                        'object_id'        => $productId,
                        'term_taxonomy_id' => $term['term_taxonomy_id'],
                        'term_order'       => 0,
                    ];
                }
            }
        }
    }

    /**
     * Create _product_attributes meta value generator for post_meta table
     *
     * @return Generator
     */
    private function generateAttributesMeta() {
        foreach ($this->productsAttributes as $productId => $attributes) {
            yield [
                'post_id'    => $productId,
                'meta_key'   => '_product_attributes',
                'meta_value' => serialize($attributes),
            ];
        }
    }

    /**
     * Create variations generator
     *
     * @return Generator
     */
    private function generateAttributesVariations() {
        $id = Query::create()->getLastPostId();

        foreach ($this->productVariations as $productId => $variation) {
            foreach ($variation as $attribute => $terms) {
                foreach ($terms as $term) {
                    $id++;
                    $title = ucfirst($this->faker->word) . '-' . $id;

                    $variationId = $id;
                    $this->variationsMeta[] = [
                        'post_id'    => $variationId,
                        'meta_key'   => 'attribute_' . $attribute,
                        'meta_value' => sanitize_title($term['name']),

                    ];

                    $this->variationIds[] = $variationId;
                    yield [
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
        }
    }


    /*******************************************************************************************************************
     * HELPERS
     */

    /**
     * @return array
     */
    private function getProductTypes() {
        $terms = get_terms([
            'taxonomy'   => 'product_type',
            'hide_empty' => false,
        ]);

        $productTypes = [];
        foreach ($terms as $term) {
            $productTypes[$term->name] = $term->term_id;
        }


        return $productTypes;
    }

}
