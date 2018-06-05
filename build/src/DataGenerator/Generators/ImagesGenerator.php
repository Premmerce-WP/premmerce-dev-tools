<?php namespace Premmerce\DevTools\DataGenerator\Generators;


use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Generator;
use Premmerce\DevTools\Services\Query;

class ImagesGenerator
{


    /**
     * @var Generator
     */
    private $faker;

    /**
     * FastProductGenerator constructor.
     *
     * @param Generator $faker
     */
    public function __construct(Generator $faker) {
        $faker->addProvider(new ImagesGeneratorProvider($faker));
        $this->faker = $faker;
    }

    /**
     * @param $number
     *
     * @return array
     */
    public function generateImagesArray($number) {

        $id = Query::create()->getLastPostId();

        $images = [];

        for ($i = 1; $i <= $number; $i++) {
            $id++;
            $images[$id] = $this->generateImage($id);
        }


        $imagesMeta = $this->generateImagesMeta($images);
        Query::create()->insertPosts($images);
        Query::create()->insertPostMeta($imagesMeta);

        return $images;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    private function generateImage($id) {
        $uploadDir = wp_upload_dir();

        $image = $this->faker->imageGenerator($uploadDir['path'], 640, 480, 'png', true, '', $this->faker->hexColor);
        $baseImageName = basename($image);
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
    private function generateImagesMeta(array $images) {
        $uploadDir = wp_upload_dir();

        $meta = [];

        foreach ($images as $id => $image) {
            $file = basename($image ['guid']);
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

}