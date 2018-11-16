<?php

namespace App\Domains\Product\Repositories;

use App\Domains\Offer\Entities\Offer;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class ProductRepository extends EntityRepository
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function findTopSales(int $limit)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join(Offer::class, 'o', Join::WITH, 'p.id = o.product')
            ->orderBy('SUM(o.sales)', 'DESC')
            ->groupBy('p.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }

    /**
     * @param int $category_id
     * @return mixed
     */
    public function findByCategoryId(int $category_id)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.categories', 'c')
            ->where('c.id = :category_id')
            ->groupBy('p.id')
            ->setParameter('category_id', $category_id)
            ->getQuery()
            ->execute();
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function findBySearch(string $search)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('MATCH_AGAINST(p.title, p.description) AGAINST(:search) > 0')
            ->setParameter('search', $search)
            ->getQuery()
            ->execute();
    }
}