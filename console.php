<?php


$gen = new \Premmerce\DevTools\DataGenerator\DataGenerator();


$config = [
	"premmerce_generator_product"                      => "10",
	"premmerce_generator_product_photo"                => "on",
	"premmerce_generator_product_photo_gallery_number" => "3",
	"premmerce_generator_product_type"                 => "variable",
	"premmerce_generator_categories"                   => "5",
	"premmerce_generator_attributes"                   => "10",
	"premmerce_generator_attribute_terms"              => "5",
];
$gen->generate( $config );