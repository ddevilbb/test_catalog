<?php

namespace Tests\Unit;

use App;
use App\Domains\Category\Entities\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use CategoryFactory;
use Doctrine\ORM\EntityManager;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var CategoryRepository
     */
    private $repository;

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
        $this->repository = $this->em->getRepository(Category::class);
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
     * Test if Repository is valid
     */
    public function testIsRepositoryValid()
    {
        $this->assertInstanceOf(CategoryRepository::class, $this->repository);
    }

    /**
     * Test findAll method
     */
    public function testFindAll()
    {
        $categories = $this->repository->findAll();

        $this->assertNotEmpty($categories);

        foreach ($this->categories as $category) {
            $this->assertContains($category, $categories);
        }
    }

    /**
     * Test find method
     */
    public function testFind()
    {
        $category = current($this->categories);

        $foundCategory = $this->repository->find($category->getId());

        $this->assertInstanceOf(Category::class, $foundCategory);
        $this->assertEquals($category, $foundCategory);
    }

    /**
     * Test findBy method
     */
    public function testFindBy()
    {
        $category = current($this->categories);

        $foundCategories = $this->repository->findBy([
            'alias' => $category->getAlias()
        ]);

        $this->assertNotEmpty($foundCategories);
        $this->assertContains($category, $foundCategories);
    }

    /**
     * Test findOneBy method
     */
    public function testFindOneBy()
    {
        $category = current($this->categories);

        $foundCategory = $this->repository->findOneBy([
            'alias' => $category->getAlias()
        ]);

        $this->assertInstanceOf(Category::class, $foundCategory);
        $this->assertEquals($category, $foundCategory);
    }
}