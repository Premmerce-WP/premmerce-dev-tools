<?php namespace Premmerce\DevTools\FakeData;

use Faker\Generator;

class ProductGenerator {

	const WOO_PRODUCT = 'product';

	/**
	 * @var Generator
	 */
	private $faker;

	/**
	 * @var array
	 */
	private $categoryIds;

	/**
	 * @var array
	 */
	private $products = [];


	/**
	 * @var bool
	 */
	private $isGeneratePhoto = false;

	/**
	 * @var string
	 */
	private $productType = 'simple';

	/**
	 * @var bool
	 */
	private $isGenerateGallery = true;

	/**
	 * @var int
	 */
	private $imageGallerySize = 5;


	public function __construct( Generator $faker ) {
		$this->faker = $faker;
	}

	public function setCategoryIds( array $categoryIds ) {
		$this->categoryIds = $categoryIds;
	}

	public function createProduct( $num ) {


		$data      = $this->createProductData( $num );
		$productId = wp_insert_post( $data );
		$this->updateProductGUID( $productId );

		if ( $this->isGeneratePhoto ) {
			$this->addProductImage( $productId );
		}

		if ( $this->isGenerateGallery ) {
			$this->generateImageGallery( $productId );
		}

		$this->addProductMetadata( $productId );
		$this->addProductTerms( $productId );


		return $this->products[ $productId ] = $data;
	}

	public function generateImageGallery( $productId ) {

		$ids = [];
		for ( $i = 1; $i <= $this->imageGallerySize; $i ++ ) {
			$ids[] = $this->addProductImage( $productId, false );
		}

		if ( count( $ids ) ) {

			update_post_meta( $productId, '_product_image_gallery', implode( ',', $ids ) );
		}
	}

	public function createProductData( $num, array $customData = [] ) {
		$user_id = get_current_user_id();

		$title = ucfirst( $this->faker->word ) . '-' . $num;
		$data  = [
			'post_author'  => $user_id,
			'post_title'   => $title,
			'post_content' => $this->faker->paragraph,
			'post_status'  => 'publish',
			'post_type'    => 'product',
		];

		$data = array_replace( $data, $customData );

		$data['post_name'] = sanitize_title( isset( $data['post_name'] ) ? $data['post_name'] : $data['post_title'] );

		return $data;
	}

	public function updateProductGUID( $postId ) {
		global $wpdb;
		$wpdb->update( $wpdb->posts, array( 'guid' => get_permalink( $postId ) ), [ 'ID' => $postId ] );
	}

	public function addAttributes( $attributeTerms ) {
		global $wpdb;

		foreach ( $this->products as $productId => $title ) {
			$attr             = [];
			$variationTrigger = $this->productType === 'variable' ? 1 : 0;
			foreach ( $attributeTerms as $attribute => $terms ) {

				$termIds = array_keys( $terms );

				$randomTermIds = $this->faker->randomElements( $termIds, $this->faker->numberBetween( 1, count( $terms ) ) );

				$query = "INSERT INTO {$wpdb->term_relationships} (object_id,term_taxonomy_id,term_order)  VALUES ";

				$values = [];
				foreach ( $randomTermIds as $termId ) {
					$values[] = "({$productId}, (SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE term_id = {$termId}), 0)";
				}


				$query = $query . implode( ',', $values ) . ';';

				if ( $wpdb->query( $query ) ) {
					$productAttribute   = [
						'name'         => $attribute,
						'value'        => '',
						'is_visible'   => 1,
						'is_variation' => $variationTrigger,
						'is_taxonomy'  => 1,
						'position'     => 0,
					];
					$attr[ $attribute ] = $productAttribute;
				}

				if ( $variationTrigger ) {

					$variationTerms = [];
					foreach ( $randomTermIds as $randomTermId ) {
						$variationTerms[ $randomTermId ] = $terms[ $randomTermId ];
					}

					$this->createVariations( $productId, $attribute, $variationTerms );
					$variationTrigger = 0;
				}


			}


			update_post_meta( $productId, '_product_attributes', $attr, true );

		}
	}

	public function createVariations( $productId, $attribute, $variationTerms ) {
		foreach ( $variationTerms as $id => $term ) {
			$product = $this->products[ $productId ];
			$data    = $this->createProductData( $productId . '-' . $id, [
				'post_type'   => 'product_variation',
				'post_parent' => $productId,
				'post_title'  => $product['post_title']
			] );


			$variationId = wp_insert_post( $data );

			$this->updateProductGUID( $variationId );

			$this->addProductMetadata( $variationId, [
				'attribute_' . $attribute => $term
			] );

		}

	}

	public function addProductMetadata( $postId, array $customMeta = [] ) {

		$price = $this->faker->randomFloat( 2, 1, 1000 );

		$data = [
			'_downloadable'  => 'no',
			'_virtual'       => 'no',
			'_regular_price' => $price,
			'_stock_status'  => 'instock',
			'_price'         => $price,
		];

		$data = array_replace( $data, $customMeta );

		foreach ( $data as $key => $value ) {
			update_post_meta( $postId, $key, $value );
		}
	}

	/**
	 * @param $productId
	 *
	 * @internal param string $productType variable|simple
	 */
	public function addProductTerms( $productId ) {
		wp_set_object_terms( $productId, $this->faker->randomElement( $this->categoryIds ), 'product_cat' );
		wp_set_object_terms( $productId, $this->productType, 'product_type' );
	}

	private function addProductImage( $postId, $thumbnail = true ) {

		$image = $this->faker->imageGenerator(
			$dir = null,
			$width = 640,
			$height = 480,
			$format = 'png',
			$fullPath = true,
			$text = $this->faker->word,
			$backgroundColor = null,
			$textColor = null
		);

		$uploadDir         = wp_upload_dir();
		$baseImageName     = basename( $image );
		$uploadedImagePath = $uploadDir['path'] . '/' . $baseImageName;
		$uploadedImageUrl  = $uploadDir['url'] . '/' . $baseImageName;
		rename( $image, $uploadedImagePath );

		$attachment = [
			'giud'           => $uploadedImageUrl,
			'post_mime_type' => wp_check_filetype( $baseImageName )['type'],
			'title'          => pathinfo( $baseImageName )['filename'],
			'post_content'   => '',
			'post_status'    => 'inherit'
		];

		// Insert the attachment.
		$attachmentId = wp_insert_attachment( $attachment, $uploadedImagePath, $postId );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attachmentId, $uploadedImagePath );
		wp_update_attachment_metadata( $attachmentId, $attach_data );

		if ( $thumbnail ) {
			set_post_thumbnail( $postId, $attachmentId );
		}

		return $attachmentId;
	}

	/**
	 * @param bool $isGeneratePhoto
	 */
	public function setIsGeneratePhoto( $isGeneratePhoto ) {
		$this->isGeneratePhoto = $isGeneratePhoto;
	}

	/**
	 * @param string $productType
	 */
	public function setProductType( $productType ) {
		$this->productType = $productType;
	}


}