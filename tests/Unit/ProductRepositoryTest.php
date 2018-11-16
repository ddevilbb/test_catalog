<?php

namespace Tests\Unit;

use App;
use App\Domains\Product\Entities\Product;
use App\Domains\Product\Repositories\ProductRepository;
use Doctrine\ORM\EntityManager;
use ProductFactory;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setUp()
    {
        parent::setUp();

        $this->em = App::make('em');
        $this->repository = $this->em->getRepository(Product::class);
        $this->products = [
            ProductFactory::make(),
            ProductFactory::make(),
            ProductFactory::make(),
        ];

        foreach ($this->products as $product) {
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

        $this->em->flush();
    }

    /**
     * Test if Repository is valid
     */
    public function testIsRepositoryValid()
    {
        $this->assertInstanceOf(ProductRepository::class, $this->repository);
    }

    /**
     * Test findAll method
     */
    public function testFindAll()
    {
        $products = $this->repository->findAll();

        $this->assertNotEmpty($products);

        foreach ($this->products as $product) {
            $this->assertContains($product, $products);
        }
    }

    /**
     * Test find method
     */
    public function testFind()
    {
        $product = current($this->products);

        $foundProduct = $this->repository->find($product->getId());

        $this->assertInstanceOf(Product::class, $foundProduct);
        $this->assertEquals($product, $foundProduct);
    }

    /**
     * Test findBy method
     */
    public function testFindBy()
    {
        $product = current($this->products);

        $foundProducts = $this->repository->findBy([
            'title' => $product->getTitle()
        ]);

        $this->assertNotEmpty($foundProducts);
        $this->assertContains($product, $foundProducts);
    }

    /**
     * Test findOneBy method
     */
    public function testFindOneBy()
    {
        $product = current($this->products);

        $foundProduct = $this->repository->findOneBy([
            'title' => $product->getTitle(),
            'image' => $product->getImage(),
        ]);

        $this->assertInstanceOf(Product::class, $foundProduct);
        $this->assertEquals($product, $foundProduct);
    }
}