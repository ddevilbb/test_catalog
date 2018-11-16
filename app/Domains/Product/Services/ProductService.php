<?php

namespace App\Domains\Product\Services;

use App\Domains\Product\Entities\Product;
use App\Domains\Product\Repositories\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

class ProductService
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
     * ProductService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Product::class);
    }

    /**
     * @param int $id
     * @return Product
     * @throws EntityNotFoundException
     */
    public function details(int $id): Product
    {
        /** @var Product $product */
        $product = $this->repository->find($id);

        if (empty($product)) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Product::class, [$id]);
        }

        return $product;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getTopSales(int $limit = 20)
    {
        return $this->repository->findTopSales($limit);
    }

    /**
     * @param int $category_id
     * @return mixed
     */
    public function getByCategoryId(int $category_id)
    {
        return $this->repository->findByCategoryId($category_id);
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function getBySearch(string $search)
    {
        return $this->repository->findBySearch($search);
    }
}