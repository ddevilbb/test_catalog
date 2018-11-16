<?php

use App\Domains\Product\Entities\Product;

class ProductFactory implements FactoryContract
{
    public static function make()
    {
        $faker = Faker\Factory::create();

        return Product::build(
            $faker->numberBetween(50000, 90000),
            $faker->word,
            $faker->imageUrl(),
            $faker->text,
            $faker->dateTime,
            $faker->url,
            $faker->randomFloat(2, 100, 100000),
            $faker->randomNumber(2)
        );
    }
}