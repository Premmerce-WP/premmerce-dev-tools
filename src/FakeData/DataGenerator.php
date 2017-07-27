<?php namespace Premmerce\DevTools\FakeData;


use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Factory;

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


	const PRODUCT_TYPES = [
		'simple',
		'grouped',
		'variable',
		'external',
	];

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

	/**
	 * @var array
	 */
	private $attributes = [];

	/**
	 * @var array
	 */
	private $terms = [];

	/**
	 * @var DataCleaner
	 */
	private $cleaner;


	public function __construct() {

		$this->data = [
			self::NAME_CATEGORIES                   => 0,
			self::NAME_PRODUCTS                     => 0,
			self::NAME_PRODUCT_PHOTO                => false,
			self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER => 0,
			self::NAME_ATTRIBUTES                   => 0,
			self::NAME_ATTRIBUTE_TERMS              => 0,
			self::NAME_PRODUCT_TYPE                 => self::PRODUCT_TYPES[0],
		];

		$this->faker = Factory::create();
		$this->faker->addProvider( new ImagesGeneratorProvider( $this->faker ) );

		$this->cleaner = new DataCleaner();
	}


	public function generate( array $data ) {

		$productGenerator = new ProductGenerator( $this->faker );

		$categoryGenerator = new CategoryGenerator( $this->faker );


		//place this before any script you want to calculate time
		$time_start = microtime( true );

		$this->configure( $data );

		$this->cleaner->clean();

		$categoriesNumber = $this->data[ self::NAME_CATEGORIES ];

		$categoryIds = $categoryGenerator->generate( $categoriesNumber );

		$fg = new FastProductGenerator( $this->faker );

		$fg->setCategoryIds( $categoryIds );
		$fg->setProductType( $this->data[ self::NAME_PRODUCT_TYPE ] );
		$fg->setIsGenerateImage( $this->data[ self::NAME_PRODUCT_PHOTO ] );
		$fg->setGalleryPhotosNumber($this->data[self::NAME_PRODUCT_PHOTO_GALLERY_NUMBER]);

		$fg->generate( $this->data[ self::NAME_PRODUCTS ] );

		dd();

//		$productGenerator->setCategoryIds( $categoryIds );
//
//		$productGenerator->setIsGeneratePhoto( $this->data[ self::NAME_PRODUCT_PHOTO ] );
//		$productGenerator->setProductType( $this->data[ self::NAME_PRODUCT_TYPE ] );
//
//		$this->iterate( $this->data[ self::NAME_PRODUCTS ], [
//			$productGenerator,
//			'createProduct'
//		] );


		$this->attributes = $this->iterate( $this->data[ self::NAME_ATTRIBUTES ], [ $this, 'createAttribute' ] );


		foreach ( $this->attributes as $attribute ) {
			$this->iterate( $this->data[ self::NAME_ATTRIBUTE_TERMS ], [
				$this,
				'createAttributeTerms'
			], [ $attribute ] );
		}

		$productGenerator->addAttributes( $this->terms );

		$time_end = microtime( true );

		$execution_time = ( $time_end - $time_start );

		delete_transient( 'wc_attribute_taxonomies' );

		dd( $execution_time );

	}

	public function iterate( $num, callable $callable, array $params = [] ) {

		$results = [];
		for ( $i = 1; $i <= $num; $i ++ ) {

			$result = call_user_func_array( $callable, array_merge( [ $i ], $params ) );
			if ( $result ) {
				array_push( $results, $result );
			}
		}

		return $results;

	}

//	public function createCategory( $num ) {
//		$term = wp_insert_term( ucfirst( $this->faker->word ), self::WOO_CATEGORY, [
//				'description' => $this->faker->paragraph,
//				'slug'        => $num . '-' . $this->faker->slug( $this->faker->numberBetween( 1, 3 ) )
//			]
//		);
//
//		if ( ! is_wp_error( $term ) ) {
//			return $term['term_id'];
//		}
//
//
//	}

	/**
	 * Generate list of attributes with values
	 *
	 * @param $num
	 *
	 * @return int|string
	 */
	private function createAttribute( $num ) {

		global $wpdb;

		$attrName = strtolower( $this->faker->word ) . '-' . $num;

		$attribute = array(
			'attribute_label'   => ucfirst( $attrName ),
			'attribute_name'    => $attrName,
			'attribute_type'    => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public'  => 0,
		);

		/** @var int|bool false $success */
		$success = $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );

		if ( $success ) {
			return 'pa_' . $attrName;
		}
	}


	private function createAttributeTerms( $num, $attributeName ) {

		global $wpdb;

		$name = $this->faker->word;

		$query = $wpdb->prepare( "INSERT INTO wp_terms (`name`, `slug`, `term_group`) VALUES ('%s','%s',%d)", $name, $name, 0 );
		$wpdb->query( $query );

		$termId = $wpdb->insert_id;

		//order
		$metaAttrName = str_replace( 'pa_', 'order_', $attributeName );
		$query        = $wpdb->prepare( "INSERT INTO wp_termmeta (`term_id`, `meta_key`, `meta_value`) VALUES ('%s','%s',%d)", $termId, $metaAttrName, 0 );
		$wpdb->query( $query );

		$query = $wpdb->prepare( "INSERT INTO wp_term_taxonomy (`term_id`, `taxonomy`, `count`) VALUES ('%s','%s',%d)", $termId, $attributeName, 0 );
		$wpdb->query( $query );

		$this->terms[ $attributeName ][ $termId ] = $name;
	}


	private function configure(
		$data
	) {
		foreach ( $this->data as $key => $defaultValue ) {
			if ( isset( $data[ $key ] ) && $data[ $key ] ) {
				$this->data[ $key ] = $data[ $key ];
			}
		}

	}

}