<?php

namespace Tests\Unit;

use App\Domains\Product\Entities\Product;
use CategoryFactory;
use ProductFactory;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test create Product instance
     */
    public function testCreateInstance()
    {
        $product = ProductFactory::make();

        $this->assertInstanceOf(Product::class, $product);
    }

    /**
     * Test add and remove Product Category
     */
    public function testAddAndRemoveCategory()
    {
        $product = ProductFactory::make();
        $category = CategoryFactory::make();

        $product->addCategory($category);

        $this->assertNotEmpty($product->getCategories());
        $this->assertContains($category, $product->getCategories());

        $product->removeCategory($category);

        $this->assertNotContains($category, $product->getCategories());
        $this->assertEmpty($product->getCategories());
    }
}