<?php namespace Premmerce\DevTools\DataGenerator;

use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Factory;
use Premmerce\DevTools\DataGenerator\Generators\AttributesGenerator;
use Premmerce\DevTools\DataGenerator\Generators\AttributesGeneratorImp;
use Premmerce\DevTools\DataGenerator\Generators\BrandGenerator;
use Premmerce\DevTools\DataGenerator\Generators\CategoryGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ImagesGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ProductGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ShopMenuGenerator;
use Premmerce\DevTools\DataGenerator\Providers\MixProvider;

/**
 * Class DataGenerator
 *
 * https://github.com/fzaninotto/Faker#fakerproviderimage
 * https://github.com/bruceheller/images-generator
 *
 * @package Premmerce\DevTools\FakeData
 */
class DataGenerator{
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
	 * @var \Faker\Generator
	 */
	private $faker;


	public function __construct(){
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

		$this->faker = Factory::create();
		$this->faker->addProvider(new ImagesGeneratorProvider($this->faker));
		$this->faker->addProvider(new MixProvider($this->faker));
	}

	public function generate(array $config){
		$config = $this->configure($config);

		$categoriesNumber       = $config[ self::NAME_CATEGORIES ];
		$categoriesNestingLevel = $config[ self::NAME_CATEGORIES_NESTING ];
		$attributesNumber       = $config[ self::NAME_ATTRIBUTES ];
		$brandsNumber           = $config[ self::NAME_BRANDS ];
		$attributeTermsNumber   = $config[ self::NAME_ATTRIBUTE_TERMS ];
		$productsNumber         = $config[ self::NAME_PRODUCTS ];
		$productPhoto           = $config[ self::NAME_PRODUCT_PHOTO ];
		$productType            = $config[ self::NAME_PRODUCT_TYPE ];
		$shopMenu               = $config[ self::NAME_SHOP_MENU ];
		$productGallery         = $config[ self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER ];

		$categoryIds = [];
		$attributes  = [];
		$brandIds    = [];

		if($shopMenu){
			(new ShopMenuGenerator())->generate();
		}
		if($categoriesNumber){
			$tg          = new CategoryGenerator($this->faker);
			$categoryIds = $tg->generate($categoriesNumber, DataGenerator::WOO_CATEGORY, $categoriesNestingLevel);


			delete_option(self::WOO_CATEGORY . '_children');
		}

		if($brandsNumber){
			$tg       = new BrandGenerator($this->faker);
			$brandIds = $tg->generate($brandsNumber, self::PREMMERCE_BRAND);
		}

		if($attributesNumber){
			$attributesGenerator = new AttributesGeneratorImp($this->faker);
//			$attributesGenerator = new AttributesGenerator($this->faker);
			$attributes = $attributesGenerator->generateAttributes($attributesNumber, $attributeTermsNumber);
			delete_transient('wc_attribute_taxonomies');
		}


		if($productsNumber){

			$images = [];
			if($productPhoto || $productGallery){
				$ig     = new ImagesGenerator($this->faker);
				$images = $ig->generateImagesArray(10);
			}

			$productGenerator = new ProductGenerator($this->faker);

			$productGenerator->setProductType($productType);
			$productGenerator->setGenerateImage($productPhoto);
			$productGenerator->setGalleryPhotosNumber($productGallery);

			if($categoriesNumber){
				$productGenerator->setCategoryIds($categoryIds);
			}
			if($brandsNumber){
				$productGenerator->setBrands($brandIds);
			}
			if($attributesNumber && $attributeTermsNumber){
				$productGenerator->setAttributes($attributes);
			}

			$productGenerator->generate($productsNumber, $images);

		}
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	private function configure(array $data){
		$config = $this->data;
		foreach($data as $key => $value){
			if(isset($config[ $key ]) && $value){
				$config[ $key ] = $value;
			}
		}

		return $config;
	}
}
