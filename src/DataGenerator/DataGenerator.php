<?php namespace Premmerce\DevTools\DataGenerator;


use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Factory;
use Premmerce\DevTools\DataGenerator\Generators\AttributesGenerator;
use Premmerce\DevTools\DataGenerator\Generators\CategoryGenerator;
use Premmerce\DevTools\DataGenerator\Generators\ProductGenerator;
use Premmerce\DevTools\Services\DataCleaner;

/**
 * Class DataGenerator
 *
 * https://github.com/fzaninotto/Faker#fakerproviderimage
 * https://github.com/bruceheller/images-generator
 *
 * @package Premmerce\DevTools\FakeData
 */
class DataGenerator {

	const NAME_CATEGORIES = 'premmerce_generator_categories';
	const NAME_PRODUCTS = 'premmerce_generator_product';
	const NAME_PRODUCT_PHOTO = 'premmerce_generator_product_photo';
	const NAME_PRODUCT_PHOTO_GALLERY_NUMBER = 'premmerce_generator_product_photo_gallery_number';
	const NAME_ATTRIBUTES = 'premmerce_generator_attributes';
	const NAME_ATTRIBUTE_TERMS = 'premmerce_generator_attribute_terms';
	const NAME_PRODUCT_TYPE = 'premmerce_generator_product_type';


	const WOO_CATEGORY = 'product_cat';

	const WOO_PRODUCT = 'product';

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @var \Faker\Generator
	 */
	private $faker;


	public function __construct() {

		$this->data = [
			self::NAME_CATEGORIES                   => 0,
			self::NAME_PRODUCTS                     => 0,
			self::NAME_PRODUCT_PHOTO                => false,
			self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 0,
			self::NAME_ATTRIBUTES                   => 0,
			self::NAME_ATTRIBUTE_TERMS              => 0,
			self::NAME_PRODUCT_TYPE                 => 'simple',
		];

		$this->faker = Factory::create();
		$this->faker->addProvider( new ImagesGeneratorProvider( $this->faker ) );

	}

	public function generate( array $config ) {

		$config = $this->configure( $config );


		$categoriesNumber     = $config[ self::NAME_CATEGORIES ];
		$attributesNumber     = $config[ self::NAME_ATTRIBUTES ];
		$attributeTermsNumber = $config[ self::NAME_ATTRIBUTE_TERMS ];
		$productsNumber       = $config[ self::NAME_PRODUCTS ];
		$productPhoto         = $config[ self::NAME_PRODUCT_PHOTO ];
		$productType          = $config[ self::NAME_PRODUCT_TYPE ];
		$productGallery       = $config[ self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER ];

		$categoryIds = [];
		$attributes  = [];

		if ( $categoriesNumber ) {
			$categoryGenerator = new CategoryGenerator( $this->faker );
			$categoryIds       = $categoryGenerator->generate( $categoriesNumber );
		}

		if ( $attributesNumber ) {
			$attributesGenerator = new AttributesGenerator( $this->faker );
			$attributes          = $attributesGenerator->generate( $attributesNumber, $attributeTermsNumber );

			delete_transient( 'wc_attribute_taxonomies' );
		}


		if ( $productsNumber ) {

			$productGenerator = new ProductGenerator( $this->faker );

			$productGenerator->setProductType( $productType );
			$productGenerator->setIsGenerateImage( $productPhoto );
			$productGenerator->setGalleryPhotosNumber( $productGallery );

			if ( $categoriesNumber ) {
				$productGenerator->setCategoryIds( $categoryIds );
			}
			if ( $attributesNumber && $attributeTermsNumber ) {
				$productGenerator->setAttributes( $attributes );
			}

			$productGenerator->generate( $productsNumber );
		}
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	private function configure( array $data ) {
		$config = [];
		foreach ( $this->data as $key => $defaultValue ) {
			if ( isset( $data[ $key ] ) && $data[ $key ] ) {
				$config[ $key ] = $data[ $key ];
			}
		}

		return $config;

	}

}