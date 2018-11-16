<?php

use App\Domains\Category\Entities\Category;

class CategoryFactory implements FactoryContract
{
    public static function make()
    {
        $faker = Faker\Factory::create();

        return Category::build(
            $faker->numberBetween(50000, 90000),
            $faker->word,
            $faker->slug,
            null
        );
    }
}