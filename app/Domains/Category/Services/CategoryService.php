<?php

namespace App\Domains\Category\Services;

use App\Core\Exceptions\NotFoundException;
use App\Domains\Category\Entities\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

class CategoryService
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
     * CategoryService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Category::class);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getList(array $params = []): array
    {
        if (empty($params)) {
            return $this->repository->findAll();
        }

        return $this->repository->findBy($params);
    }

    /**
     * @param array $params
     * @return Category
     * @throws NotFoundException
     */
    public function getOneBy(array $params): Category
    {
        /** @var Category $category */
        $category = $this->repository->findOneBy($params);

        if (empty($category)) {
            throw new NotFoundException('Category not found');
        }

        return $category;
    }
}