<?php namespace Premmerce\DevTools\DataGenerator;

use Faker\Factory;
use Faker\Generator;
use Premmerce\DevTools\DataGenerator\Generators\AttributesGenerator;
use Premmerce\DevTools\DataGenerator\Generators\BrandGenerator;
use Premmerce\DevTools\DataGenerator\Generators\CategoryGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ImagesGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ProductGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ShopMenuGenerator;
use Premmerce\DevTools\DataGenerator\Providers\ExplodeProvider;
use Premmerce\DevTools\DataGenerator\Providers\MixProvider;
use Premmerce\DevTools\DataGenerator\Providers\TreeBuilder;
use Premmerce\DevTools\Services\DataCleaner;

/**
 * Class DataGenerator
 *
 * https://github.com/fzaninotto/Faker#fakerproviderimage
 * https://github.com/bruceheller/images-generator
 *
 * @package Premmerce\DevTools\FakeData
 */
class DataGenerator
{
    const NAME_CATEGORIES = 'categories';
    const NAME_CATEGORIES_NESTING = 'category_levels';
    const NAME_PRODUCTS = 'product';
    const NAME_PRODUCT_TYPE = 'product_type';
    const NAME_PRODUCT_PHOTO = 'product_photo';
    const NAME_PRODUCT_PHOTO_GALLERY_NUMBER = 'product_gallery_number';
    const NAME_BRANDS = 'brands';
    const NAME_ATTRIBUTES = 'attributes';
    const NAME_ATTRIBUTE_TERMS = 'attribute_terms';
    const NAME_SHOP_MENU = 'shop_menu';


    const WOO_CATEGORY = 'product_cat';

    const PREMMERCE_BRAND = 'product_brand';

    const WOO_PRODUCT = 'product';

    /**
     * @var array
     */
    private $data;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var TreeBuilder
     */
    private $treeBuilder;


    public function __construct()
    {
        $this->data = [
            self::NAME_CATEGORIES                   => 0,
            self::NAME_CATEGORIES_NESTING           => 1,
            self::NAME_PRODUCTS                     => 0,
            self::NAME_PRODUCT_PHOTO                => false,
            self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 0,
            self::NAME_BRANDS                       => 0,
            self::NAME_ATTRIBUTES                   => 0,
            self::NAME_ATTRIBUTE_TERMS              => 0,
            self::NAME_SHOP_MENU                    => false,
            self::NAME_PRODUCT_TYPE                 => 'simple',
        ];

        $this->faker       = Factory::create();
        $this->storage     = new Storage();
        $this->treeBuilder = new TreeBuilder();

        $this->faker->addProvider(new MixProvider($this->faker));
        $this->faker->addProvider(new ExplodeProvider($this->faker));
    }

    /**
     * Generate data by config
     *
     * @param array $config
     */
    public function generate(array $config)
    {

        $this->storage->clear();

        $config = $this->configure($config);

        $this->generateCategories($config);

        $this->generateBrands($config);

        $this->generateAttributes($config);


        $tree = $this->storage->getCategories();

        $topCategories = count($tree);
        $termTaxonomy  = $this->storage->getCategoriesTermTaxonomy();
        $brands        = $this->storage->getBrands();
        $attributes    = $this->storage->getAttributes();


        if ($config[self::NAME_PRODUCTS]) {

            if ( ! empty($topCategories)) {
                $attributes = $this->faker->explodeArray($attributes, $topCategories);
                $brands     = $this->faker->explodeArray($brands, $topCategories);

                $productCounts = $this->faker->explodeNumber($config[self::NAME_PRODUCTS], $topCategories);

                foreach ($tree as $parent => $item) {
                    $countProducts = array_shift($productCounts);
                    if ($countProducts) {
                        $cats                        = $this->treeBuilder->toItemParent([$parent => $item]);
                        $termIds                     = array_flip(array_keys($cats));
                        $termTaxonomyIds             = array_intersect_key($termTaxonomy, $termIds);
                        $config[self::NAME_PRODUCTS] = $countProducts;
                        $this->generateProducts($config, $termTaxonomyIds, array_shift($brands),
                            array_shift($attributes));
                    }

                }
            } else {
                $this->generateProducts($config, null, $brands, $attributes);
            }
        }


        $this->generateShopMenu($config);

        $dc = new DataCleaner();

        $dc->removeAllTransients();
        $dc->recountTermTaxonomies();

    }

    /**
     * Generate products
     *
     * @param $config
     * @param $categoryIds
     * @param $brandIds
     * @param $attributes
     */
    private function generateProducts($config, $categoryIds, $brandIds, $attributes)
    {
        $productsNumber = $config[self::NAME_PRODUCTS];
        $productPhoto   = $config[self::NAME_PRODUCT_PHOTO];
        $productType    = $config[self::NAME_PRODUCT_TYPE];
        $productGallery = $config[self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER];

        if ($productsNumber) {


            $productGenerator = new ProductGenerator($this->faker);

            if ($productPhoto || $productGallery) {
                $ig     = new ImagesGenerator($this->faker);
                $images = $ig->generateImagesArray(10);
                $productGenerator->setImages($images);
            }


            $productGenerator->setProductType($productType);
            $productGenerator->setGenerateImage($productPhoto);
            $productGenerator->setGalleryPhotosNumber($productGallery);

            if ( ! empty($categoryIds)) {
                $productGenerator->setCategoryIds($categoryIds);
            }

            if ( ! empty($brandIds)) {
                $productGenerator->setBrands($brandIds);
            }

            if ( ! empty($attributes)) {
                $productGenerator->setAttributes($attributes);
            }

            $productGenerator->generate($productsNumber);


        }
    }


    /**
     * Generate shop menu
     *
     * @param $config
     */
    private function generateShopMenu($config)
    {
        if ($config[self::NAME_SHOP_MENU]) {
            (new ShopMenuGenerator())->generate();
        }

    }

    /**
     * Generate product attributes
     *
     * @param $config
     */
    private function generateAttributes($config)
    {
        $attributesNumber     = $config[self::NAME_ATTRIBUTES];
        $attributeTermsNumber = $config[self::NAME_ATTRIBUTE_TERMS];

        if ($attributesNumber) {
            $attributesGenerator = new AttributesGenerator($this->faker);
            $attributes          = $attributesGenerator->generateAttributes($attributesNumber, $attributeTermsNumber);
            delete_transient('wc_attribute_taxonomies');

            $this->storage->setAttributes($attributes);
        }
    }

    /**
     * Generate product brands
     *
     * @param $config
     */
    private function generateBrands($config)
    {
        $brandsNumber = $config[self::NAME_BRANDS];

        if ($brandsNumber) {
            $tg       = new BrandGenerator($this->faker);
            $brandIds = $tg->generate($brandsNumber, self::PREMMERCE_BRAND);

            $this->storage->setBrands($brandIds);
        }

    }

    /**
     * Generate product categories
     *
     * @param $config
     */
    private function generateCategories($config)
    {
        $categoriesNumber       = $config[self::NAME_CATEGORIES];
        $categoriesNestingLevel = $config[self::NAME_CATEGORIES_NESTING];

        if ($categoriesNumber) {
            $tg  = new CategoryGenerator($this->faker, $this->treeBuilder);
            $res = $tg->generate($categoriesNumber, DataGenerator::WOO_CATEGORY, $categoriesNestingLevel, false);

            $taxonomies = $res[0];

            $termTaxonomies = [];

            foreach ($taxonomies as $taxonomy) {
                $termTaxonomies[$taxonomy['term_id']] = $taxonomy['term_taxonomy_id'];
            }
            delete_option(self::WOO_CATEGORY . '_children');

            $this->storage->setCategoriesTermTaxonomy($termTaxonomies);
            $this->storage->setCategories($tg->getTree());
        }

    }

    /**
     * Clear temporary storage
     */
    public function clearStorage()
    {
        $this->storage->clear();
    }

    /**
     * @param $data
     *
     * @return array
     */
    private function configure(array $data)
    {
        $config = $this->data;
        foreach ($data as $key => $value) {
            if (isset($config[$key]) && $value) {
                $config[$key] = $value;
            }
        }

        return $config;
    }
}
