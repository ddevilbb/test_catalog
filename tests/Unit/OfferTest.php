<?php

namespace Tests\Unit;

use App\Domains\Offer\Entities\Offer;
use App\Domains\Product\Entities\Product;
use OfferFactory;
use ProductFactory;
use Tests\TestCase;

class OfferTest extends TestCase
{
    /**
     * Test create Offer instance
     */
    public function testCreateInstance()
    {
        $offer = OfferFactory::make();

        $this->assertInstanceOf(Offer::class, $offer);
    }

    /**
     * Test set Product for Offer
     */
    public function testSetProduct()
    {
        $offer = OfferFactory::make();
        $product = ProductFactory::make();

        $offer->setProduct($product);

        $this->assertInstanceOf(Product::class, $offer->getProduct());
        $this->assertEquals($product, $offer->getProduct());
    }
}