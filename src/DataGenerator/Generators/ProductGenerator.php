<?php namespace Premmerce\DevTools\DataGenerator\Generators;


use Faker\Generator as Faker;
use Generator;
use Premmerce\DevTools\Services\BulkInsertQuery;

class ProductGenerator {


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
	 * @var bool
	 */
	private $isGenerateImage;

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
	public function __construct( Faker $faker ) {
		$this->faker        = $faker;
		$this->userId       = get_current_user_id();
		$this->productTypes = $this->getProductTypes();
	}

	/**
	 * @param array $categoryIds
	 */
	public function setCategoryIds( array $categoryIds ) {
		$this->categoryIds = $categoryIds;
	}

	/**
	 * @param string $productType
	 */
	public function setProductType( $productType ) {
		$this->productType = $productType;
	}

	/**
	 * @param bool $isGenerateImage
	 */
	public function setIsGenerateImage( $isGenerateImage ) {
		$this->isGenerateImage = $isGenerateImage;
	}

	/**
	 * @param bool $galleryPhotosNumber
	 */
	public function setGalleryPhotosNumber( $galleryPhotosNumber ) {
		$this->galleryPhotosNumber = $galleryPhotosNumber;
	}

	/**
	 * @param array $attributeTerms
	 */
	public function setAttributes( array $attributeTerms ) {
		$this->attributeTerms = $attributeTerms;
	}

	/**
	 * @param $num
	 *
	 * @return array|null
	 */
	public function generate( $num ) {

		$this->productIds = $this->insertProducts( $num );

		$this->insertProductTerms( $this->productIds );

		$this->insertProductsMeta( $this->productIds );

		if ( $this->isGenerateImage ) {
			$this->insertImage();
		}


		if ( $this->galleryPhotosNumber > 0 ) {

			$this->insertImageGallery();

		}

		if ( $this->attributeTerms ) {
			$this->generateAttributes();
		}

		foreach ( $this->productIds as $product_id ) {
			wc_delete_product_transients( $product_id );
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
	private function insertProducts( $num ) {
		global $wpdb;

		$products = $this->generateProductsArray( $num );
		BulkInsertQuery::create()->insert( $wpdb->posts, $products );

		$productIds = array_keys( $products );


		return $productIds;
	}

	private function insertProductsMeta( $productIds ) {

		global $wpdb;

		$meta = $this->generatePostMeta( $productIds );

		BulkInsertQuery::create()->insert( $wpdb->postmeta, $meta );

	}


	private function generatePostMeta( $productIds ) {

		$meta = [];
		foreach ( $productIds as $id ) {
			$price = $this->faker->randomFloat( 2, 1, 1000 );

			$data = [
//				'_downloadable'  => 'no',
//				'_virtual'       => 'no',
				'_regular_price' => $price,
				'_stock_status'  => 'instock',
				'_price'         => $price,

			];
			foreach ( $data as $key => $value ) {
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
	private function insertProductTerms( $productIds ) {
		global $wpdb;

		$terms = $this->generateProductTerms( $productIds );
		BulkInsertQuery::create()->insert( $wpdb->term_relationships, $terms );
	}

	/**
	 * generate category and product type
	 *
	 * @param $ids
	 *
	 * @return array
	 */
	private function generateProductTerms( $ids ) {

		$type  = $this->productTypes[ $this->productType ];
		$terms = [];
		foreach ( $ids as $id ) {

			if ( count( $this->categoryIds ) ) {
				$terms[] = [
					'object_id'        => $id,
					'term_taxonomy_id' => $this->faker->randomElement( $this->categoryIds ),
					'term_order'       => 0,

				];
			}

			if ( $type ) {

				$terms[] = [
					'object_id'        => $id,
					'term_taxonomy_id' => $type,
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
	private function generateProductsArray( $num ) {

		$lastId = $this->getLastPost();

		$products = [];
		for ( $i = 1; $i <= $num; $i ++ ) {
			$id              = $lastId + $i;
			$products[ $id ] = $this->generateProduct( $id );
		}

		return $products;
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	private function generateProduct( $id ) {

		$title = ucfirst( $this->faker->word ) . '-' . $id;
		$data  = [
			'ID'           => $id,
			'post_author'  => $this->userId,
			'post_title'   => $title,
			'post_content' => $this->faker->paragraph,
			'post_status'  => 'publish',
			'post_type'    => 'product',
			'post_name'    => sanitize_title( $title ),
		];

		return $data;
	}

	/*******************************************************************************************************************
	 * IMAGES
	 */

	/**
	 * Add product images
	 */
	private function insertImage() {
		global $wpdb;
		$q = BulkInsertQuery::create();

		$images = $this->generateImagesArray( $this->productIds );

		$imagesMeta          = $this->generateImagesMeta( $images );
		$imageThumbnailsMeta = $this->generatePostThumbnailsMeta( $this->productIds, array_keys( $images ) );

		$q->insert( $wpdb->posts, $images );
		$q->insert( $wpdb->postmeta, $imagesMeta );
		$q->insert( $wpdb->postmeta, $imageThumbnailsMeta );

	}

	/**
	 * @param array $postIds
	 * @param int $imagesNumber
	 *
	 * @return array
	 */
	private function generateImagesArray( $postIds, $imagesNumber = 1 ) {

		$lastId = $this->getLastPost();

		$images = [];

		$i = 1;
		foreach ( $postIds as $postId ) {
			$postImages = $imagesNumber;
			while ( $postImages -- > 0 ) {
				$id            = $lastId + $i;
				$images[ $id ] = $this->generateImage( $id, $postId );
				$i ++;
			}
		}

		return $images;

	}

	/**
	 * @param int $id
	 * @param int $postId
	 *
	 * @return array
	 */
	private function generateImage( $id, $postId ) {

		$uploadDir = wp_upload_dir();

		$image            = $this->faker->imageGenerator( $uploadDir['path'], 640, 480, 'png', true, '', $this->faker->hexColor );
		$baseImageName    = basename( $image );
		$uploadedImageUrl = $uploadDir['url'] . '/' . $baseImageName;

		$attachment = [
			'ID'             => $id,
			'guid'           => $uploadedImageUrl,
			'post_mime_type' => wp_check_filetype( $baseImageName )['type'],
			'post_title'     => pathinfo( $baseImageName )['filename'],
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_parent'    => $postId,
			'post_type'      => 'attachment',
		];

		return $attachment;
	}


	/**
	 * @param $images
	 *
	 * @return array
	 */
	private function generateImagesMeta( array $images ) {

		$uploadDir = wp_upload_dir();

		$meta = [];

		foreach ( $images as $id => $image ) {
			$file    = basename( $image ['guid'] );
			$relPath = trim( $uploadDir['subdir'] . '/' . $file, '/' );

			$meta[] = [
				'post_id'    => $id,
				'meta_key'   => '_wp_attached_file',
				'meta_value' => $relPath,
			];

			$meta[] = [
				'post_id'    => $id,
				'meta_key'   => '_wp_attachment_metadata',
				'meta_value' => serialize( [ 'width' => 640, 'height' => 480, "file" => $relPath ] ),
			];
		}

		return $meta;
	}

	/**
	 * @param array $postIds
	 * @param array $thumbnails
	 *
	 * @return array
	 */
	private function generatePostThumbnailsMeta( $postIds, $thumbnails ) {

		$metadata = [];
		foreach ( $postIds as $postId ) {
			$metadata[] = [
				'post_id'    => $postId,
				'meta_key'   => '_thumbnail_id',
				'meta_value' => array_shift( $thumbnails ),
			];
		}

		return $metadata;
	}

	private function insertImageGallery() {
		global $wpdb;
		$q = BulkInsertQuery::create();

		$galleryImages      = $this->generateImagesArray( $this->productIds, $this->galleryPhotosNumber );
		$imagesGalleryMeta  = $this->generateImagesMeta( $galleryImages );
		$productGalleryMeta = $this->generateImageGalleryProductMeta( $galleryImages );

		$q->insert( $wpdb->posts, $galleryImages );
		$q->insert( $wpdb->postmeta, $imagesGalleryMeta );
		$q->insert( $wpdb->postmeta, $productGalleryMeta );
	}

	/**
	 * @param $imageGallery
	 *
	 * @return array
	 */
	private function generateImageGalleryProductMeta( $imageGallery ) {

		$productMeta = [];
		foreach ( $imageGallery as $id => $item ) {
			$productMeta[ $item['post_parent'] ][] = $item['ID'];
		}

		foreach ( $productMeta as $productId => $item ) {
			$productMeta[ $productId ] = [
				'post_id'    => $productId,
				'meta_key'   => '_product_image_gallery',
				'meta_value' => implode( ',', $item ),
			];
		}

		return $productMeta;

	}

	/*******************************************************************************************************************
	 * ATTRIBUTES
	 */

	/**
	 * Add attributes and variations to product
	 */
	private function generateAttributes() {
		global $wpdb;
		$q = BulkInsertQuery::create();


		$rel = $this->generateAttributeTermRelations();
		if ( ! $rel->valid() ) {
			return;
		}
		$q->insert( $wpdb->term_relationships, $rel );

		$productAttributes = $this->generateAttributesMeta();
		$q->insert( $wpdb->postmeta, $productAttributes );

		if ( $this->productVariations ) {
			$variations = $this->generateAttributesVariations();

			$q->insert( $wpdb->posts, $variations );
			$q->insert( $wpdb->postmeta, $this->variationsMeta );

			$meta = $this->generatePostMeta( $this->variationIds );
			$q->insert( $wpdb->postmeta, $meta );

		}

	}

	/**
	 * Create terms relations for wp_term_relationships
	 *
	 * @return Generator
	 */
	public function generateAttributeTermRelations() {
		foreach ( $this->productIds as $productId ) {

			$variationTrigger = $this->productType === 'variable' ? 1 : 0;

			foreach ( $this->attributeTerms as $attribute => $terms ) {

				if ( ! is_array( $terms ) || ! count( $terms ) ) {
					continue;
				}

				$this->productsAttributes[ $productId ][ $attribute ] = [
					'name'         => $attribute,
					'value'        => '',
					'is_visible'   => 1,
					'is_variation' => $variationTrigger,
					'is_taxonomy'  => 1,
					'position'     => 0,

				];

				$countTerms = intval( count( $terms ) / 2 );

				$randomTerms = $this->faker
					->randomElements( $terms, $this->faker->numberBetween( 1, $countTerms ) );

				if ( $variationTrigger ) {
					$this->productVariations[ $productId ][ $attribute ] = $randomTerms;
				}

				$variationTrigger = 0;

				foreach ( $randomTerms as $term ) {

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
		foreach ( $this->productsAttributes as $productId => $attributes ) {
			yield [
				'post_id'    => $productId,
				'meta_key'   => '_product_attributes',
				'meta_value' => serialize( $attributes ),
			];
		}
	}

	/**
	 * Create variations generator
	 *
	 * @return Generator
	 */
	private function generateAttributesVariations() {
		$id = $this->getLastPost() + 1;

		foreach ( $this->productVariations as $productId => $variation ) {
			foreach ( $variation as $attribute => $terms ) {
				foreach ( $terms as $term ) {
					$title = ucfirst( $this->faker->word ) . '-' . $id;

					$variationId            = ++ $id;
					$this->variationsMeta[] = [
						'post_id'    => $variationId,
						'meta_key'   => 'attribute_' . $attribute,
						'meta_value' => $term['name'],

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
						'post_name'    => sanitize_title( $title ),
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

		$terms = get_terms( [
			'taxonomy'   => 'product_type',
			'hide_empty' => false,
		] );

		$productTypes = [];
		foreach ( $terms as $term ) {
			$productTypes[ $term->name ] = $term->term_id;
		}


		return $productTypes;
	}

	/**
	 * @return int
	 */
	private function getLastPost() {
		global $wpdb;

		$query[] = 'SELECT ID';
		$query[] = 'FROM ' . $wpdb->posts;
		$query[] = 'ORDER BY ID DESC';
		$query[] = 'LIMIT 1';

		$query = implode( ' ', $query );

		return (int) $wpdb->get_var( $query );

	}

}