<?php

namespace Tests\Unit;

use App;
use App\Domains\Category\Entities\Category;
use App\Domains\Category\Services\CategoryService;
use CategoryFactory;
use Doctrine\ORM\EntityManager;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var CategoryService
     */
    private $service;

    /**
     * @var Category[]
     */
    private $categories;

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setUp()
    {
        parent::setUp();

        $this->em = App::make('em');
        $this->service = App::make(CategoryService::class);
        $this->categories = [
            CategoryFactory::make(),
            CategoryFactory::make(),
            CategoryFactory::make(),
        ];

        foreach ($this->categories as $category) {
            $this->em->persist($category);
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

        foreach ($this->categories as $category) {
            $this->em->remove($category);
        }
        $this->em->flush();
    }

    /**
     * Test getList method without parameters
     */
    public function testGetListWithoutParameters()
    {
        $categories = $this->service->getList();

        $this->assertNotEmpty($categories);
        $this->assertInstanceOf(Category::class, current($categories));

        foreach ($this->categories as $category) {
            $this->assertContains($category, $categories);
        }
    }

    /**
     * Test getList method with parameters
     */
    public function testGetListWithParameters()
    {
        $category = current($this->categories);

        $categories = $this->service->getList([
            'title' => $category->getTitle()
        ]);

        $this->assertNotEmpty($categories);
        $this->assertContains($category, $categories);
    }

    /**
     * Test getOneBy method
     *
     * @throws App\Core\Exceptions\NotFoundException
     */
    public function testGetOneBy()
    {
        $currentCategory = current($this->categories);
        $alias = $currentCategory->getAlias();

        $category = $this->service->getOneBy([
            'alias' => $alias
        ]);

        $this->assertEquals($currentCategory, $category);

    }
}