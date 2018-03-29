<?php namespace Premmerce\DevTools\DataGenerator\Generators;


use Faker\Generator;
use Premmerce\DevTools\Services\BulkInsertQuery;

class ImagesGenerator{


	/**
	 * @var Generator
	 */
	private $faker;

	/**
	 * FastProductGenerator constructor.
	 *
	 * @param Generator $faker
	 */
	public function __construct(Generator $faker){
		$this->faker = $faker;
	}

	/**
	 * @param $number
	 *
	 * @return array
	 */
	public function generateImagesArray($number){
		global $wpdb;
		$q = BulkInsertQuery::create();

		$id = $this->getLastPost();

		$images = [];

		for($i = 1;$i <= $number;$i ++){
			$id ++;
			$images[ $id ] = $this->generateImage($id);
		}


		$imagesMeta = $this->generateImagesMeta($images);
		$q->insert($wpdb->posts, $images);
		$q->insert($wpdb->postmeta, $imagesMeta);

		return $images;
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	private function generateImage($id){
		$uploadDir = wp_upload_dir();

		$image            = $this->faker->imageGenerator($uploadDir['path'], 640, 480, 'png', true, '', $this->faker->hexColor);
		$baseImageName    = basename($image);
		$uploadedImageUrl = $uploadDir['url'] . '/' . $baseImageName;

		$attachment = [
			'ID'             => $id,
			'guid'           => $uploadedImageUrl,
			'post_mime_type' => wp_check_filetype($baseImageName)['type'],
			'post_title'     => pathinfo($baseImageName)['filename'],
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
		];

		return $attachment;
	}


	/**
	 * @param $images
	 *
	 * @return array
	 */
	private function generateImagesMeta(array $images){
		$uploadDir = wp_upload_dir();

		$meta = [];

		foreach($images as $id => $image){
			$file    = basename($image ['guid']);
			$relPath = trim($uploadDir['subdir'] . '/' . $file, '/');

			$meta[] = [
				'post_id'    => $id,
				'meta_key'   => '_wp_attached_file',
				'meta_value' => $relPath,
			];

			$meta[] = [
				'post_id'    => $id,
				'meta_key'   => '_wp_attachment_metadata',
				'meta_value' => serialize(['width' => 640, 'height' => 480, 'file' => $relPath]),
			];
		}

		return $meta;
	}

	/**
	 * @return int
	 */
	private function getLastPost(){
		global $wpdb;

		$query[] = 'SELECT ID';
		$query[] = 'FROM ' . $wpdb->posts;
		$query[] = 'ORDER BY ID DESC';
		$query[] = 'LIMIT 1';

		$query = implode(' ', $query);

		return (int)$wpdb->get_var($query);
	}
}