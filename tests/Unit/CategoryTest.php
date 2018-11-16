<?php

namespace Tests\Unit;

use App\Domains\Category\Entities\Category;
use CategoryFactory;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Test Create Category Instance
     */
    public function testCreateInstance()
    {
        $category = CategoryFactory::make();

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * Test Set Parent Category
     */
    public function testSetParent()
    {
        $category = CategoryFactory::make();
        $parentCategory = CategoryFactory::make();

        $category->setParent($parentCategory);

        $this->assertInstanceOf(Category::class, $category->getParent());
        $this->assertEquals($category->getParent(), $parentCategory);
        $this->assertNotEmpty($parentCategory->getChildren());
        $this->assertContains($category, $parentCategory->getChildren()->toArray());
    }
}