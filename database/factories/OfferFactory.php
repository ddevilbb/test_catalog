<?php

use App\Domains\Offer\Entities\Offer;

class OfferFactory implements FactoryContract
{
    public static function make()
    {
        $faker = Faker\Factory::create();

        return Offer::build(
            $faker->numberBetween(50000, 90000),
            $faker->randomFloat(2, 100, 100000),
            $faker->randomNumber(2),
            $faker->randomNumber(2),
            (string)$faker->randomNumber(8)
        );
    }
}