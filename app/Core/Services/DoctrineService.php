<?php

namespace App\Core\Services;

use Doctrine\ORM\EntityManager;

class DoctrineService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var int
     */
    private $currentSize;

    /**
     * DoctrineService constructor.
     *
     * @param EntityManager $em
     * @param int|null $batchSize
     */
    public function __construct(EntityManager $em, int $batchSize = null)
    {
        $this->em = $em;
        $this->batchSize = $batchSize ?? 60;
        $this->currentSize = 0;
    }

    /**
     * @param $entity
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistOrMerge($entity)
    {
        $repository = $this->em->getRepository(get_class($entity));

        if (empty($repository->find($entity->getId()))) {
            $this->em->persist($entity);
        } else {
            $this->em->merge($entity);
        }

        ++$this->currentSize;
    }

    /**
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush()
    {
        if ($this->currentSize % $this->batchSize === 0) {
            $this->flushAll();
        }
    }

    /**
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flushAll()
    {
        $this->em->flush();
        $this->em->clear();
    }
}