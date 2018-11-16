<?php

namespace Tests\Unit;

use App;
use App\Domains\Category\Entities\Category;
use App\Domains\Product\Entities\Product;
use App\Domains\Product\Services\ProductService;
use CategoryFactory;
use Doctrine\ORM\EntityManager;
use ProductFactory;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ProductService
     */
    private $service;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var Category
     */
    private $category;

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setUp()
    {
        parent::setUp();

        $this->em = App::make('em');
        $this->service = App::make(ProductService::class);
        $this->products = [
            ProductFactory::make(),
            ProductFactory::make(),
            ProductFactory::make(),
        ];
        $this->category = CategoryFactory::make();

        $this->em->persist($this->category);

        foreach ($this->products as $product) {
            $product->addCategory($this->category);
            $this->em->persist($product);
        }

        $this->em->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function tearDown()
    {
        parent::tearDown();

        foreach ($this->products as $product) {
            $this->em->remove($product);
        }

        $this->em->remove($this->category);

        $this->em->flush();
    }

    /**
     * Test details method
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function testDetails()
    {
        $product = current($this->products);

        $foundProduct = $this->service->details($product->getId());

        $this->assertInstanceOf(Product::class, $foundProduct);
        $this->assertEquals($product, $foundProduct);
    }

    /**
     * Test getTopSales method
     */
    public function testGetTopSales()
    {
        $products = $this->service->getTopSales();

        $this->assertNotEmpty($products);
        $this->assertCount(20, $products);
        $this->assertInstanceOf(Product::class, current($products));
    }

    /**
     * Test getByCategoryId method
     */
    public function testGetByCategoryId()
    {
        /** @var Product[] $products */
        $products = $this->service->getByCategoryId($this->category->getId());

        $this->assertNotEmpty($products);

        foreach ($this->products as $product) {
            $this->assertContains($product, $products);
        }

        foreach ($products as $product) {
            $this->assertContains($this->category, $product->getCategories());
        }
    }

    /**
     * Test getBySearch method
     */
    public function testGetBySearch()
    {
        $search = 'шокер';
        /** @var Product[] $products */
        $products = $this->service->getBySearch($search);

        $this->assertNotEmpty($products);

        foreach ($products as $product) {
            $this->assertContains($search, $product->getTitle() . $product->getDescription());
        }
    }
}