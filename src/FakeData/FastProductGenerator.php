<?php namespace Premmerce\DevTools\FakeData;


use Faker\Generator;

class FastProductGenerator {


	const WOO_PRODUCT = 'product';

	/**
	 * @var Generator
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
	 * FastProductGenerator constructor.
	 *
	 * @param Generator $faker
	 */
	public function __construct( Generator $faker ) {
		$this->faker  = $faker;
		$this->userId = get_current_user_id();
	}

	public function generate( $num ) {

		$this->productTypes = $this->getProductTypes();


		$products   = $this->generateProductsArray( $num );
		$productIds = array_keys( $products );
		$this->insertPosts( $products );


		if ( $this->isGenerateImage ) {
			$images = $this->generateImagesArray( $productIds );
			$this->insertPosts( $images );
			$imagesMeta     = $this->generateImagesMeta( $images );
			$thumbnailsMeta = $this->generatePostThumbnailsMeta( $productIds, array_keys( $images ) );
			$this->insertMeta( $thumbnailsMeta );
			$this->insertMeta( $imagesMeta );
		}

		$terms = $this->generateProductTerms( $productIds );

		$this->insertProductTerms( $terms );


		if ( $this->galleryPhotosNumber > 0 ) {
			$galleryImages = $this->generateImagesArray( $productIds, $this->galleryPhotosNumber );
			$this->insertPosts( $galleryImages );
			$imagesGalleryMeta  = $this->generateImagesMeta( $galleryImages );
			$productGalleryMeta = $this->generateImageGalleryProductMeta( $galleryImages );

			$this->insertMeta( $imagesGalleryMeta );
			$this->insertMeta( $productGalleryMeta );

		}


	}

	private function generateImageGalleryProductMeta( $imageGallery ) {

		$productMeta = [];
		foreach ( $imageGallery as $id => $item ) {
			$productMeta[ $item['post_parent'] ][] = $item['ID'];
		}

		foreach ( $productMeta as $productId => $item ) {
			$productMeta[ $productId ] = [
				'post_id'    => $productId,
				'meta_key'   => '_product_image_gallery',
				'meta_value' => implode( ',', $item )
			];
		}

		return $productMeta;

	}

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

	private function insertProductTerms( $terms ) {
		global $wpdb;

		if ( count( $terms ) ) {
			BulkInsertQuery::create()->table( $wpdb->term_relationships )->values( $terms )->query();
		}

	}

	private function insertMeta( $values ) {
		global $wpdb;

		if ( count( $values ) ) {

			BulkInsertQuery::create()->table( $wpdb->postmeta )->values( $values )->query();
		}
	}


	private function generateImagesMeta( $images ) {

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
				'meta_value' => serialize( [ 'width' => 640, 'height' => 480, "file" => $relPath ] )
			];
		}

		return $meta;
	}

	private function generatePostThumbnailsMeta( $postIds, $thumbnails ) {

		$metadata = [];
		foreach ( $postIds as $postId ) {
			$metadata[] = [
				'post_id'    => $postId,
				'meta_key'   => '_thumbnail_id',
				'meta_value' => array_shift( $thumbnails )
			];
		}

		return $metadata;
	}

	private function insertPosts( array $posts ) {

		global $wpdb;

		if ( count( $posts ) ) {

			return BulkInsertQuery::create()->create()->table( $wpdb->posts )->values( $posts )->query();

		}
	}

	private function generateProductsArray( $num ) {

		$lastId = $this->getLastPost();

		$products = [];
		for ( $i = 1; $i <= $num; $i ++ ) {
			$id              = $lastId + $i;
			$products[ $id ] = $this->generateProductData( $id );
		}

		return $products;
	}


	private function generateProductData( $id ) {

		$title = ucfirst( $this->faker->word ) . '-' . $id;
		$data  = [
			'ID'           => $id,
			'post_author'  => $this->userId,
			'post_title'   => $title,
			'post_content' => $this->faker->paragraph,
			'post_status'  => 'publish',
			'post_type'    => 'product',
			'post_name'    => sanitize_title( $title )
		];

		return $data;
	}

	private function getLastPost() {
		global $wpdb;

		$query[] = 'SELECT ID';
		$query[] = 'FROM ' . $wpdb->posts;
		$query[] = 'ORDER BY ID DESC';
		$query[] = 'LIMIT 1';

		$query = implode( ' ', $query );

		return (int) $wpdb->get_var( $query );

	}

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

	private function generateImage( $id, $postId ) {

		$uploadDir = wp_upload_dir();

		$image            = $this->faker->imageGenerator( $uploadDir['path'], 640, 480, 'png', true, $this->faker->word, $this->faker->hexColor );
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
			'post_type'      => 'attachment'
		];

		return $attachment;
	}

	public function setCategoryIds( $categoryIds ) {
		$this->categoryIds = $categoryIds;
	}

	public function setProductType( $productType ) {
		$this->productType = $productType;
	}

	public function setIsGenerateImage( $isGenerateImage ) {
		$this->isGenerateImage = $isGenerateImage;
	}

	public function setGalleryPhotosNumber( $galleryPhotosNumber ) {
		$this->galleryPhotosNumber = $galleryPhotosNumber;
	}

	private function getProductTypes() {

		$terms = get_terms( [
			'taxonomy'   => 'product_type',
			'hide_empty' => false
		] );

		$productTypes = [];
		foreach ( $terms as $term ) {
			$productTypes[ $term->name ] = $term->term_id;
		}


		return $productTypes;
	}
}