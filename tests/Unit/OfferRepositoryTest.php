<?php

namespace Tests\Unit;

use App;
use App\Domains\Offer\Entities\Offer;
use App\Domains\Offer\Repository\OfferRepository;
use Doctrine\ORM\EntityManager;
use OfferFactory;
use Tests\TestCase;

class OfferRepositoryTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var OfferRepository
     */
    private $repository;

    /**
     * @var Offer[]
     */
    private $offers;

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setUp()
    {
        parent::setUp();

        $this->em = App::make('em');
        $this->repository = $this->em->getRepository(Offer::class);
        $this->offers = [
            OfferFactory::make(),
            OfferFactory::make(),
            OfferFactory::make(),
        ];

        foreach ($this->offers as $offer) {
            $this->em->persist($offer);
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

        foreach ($this->offers as $offer) {
            $this->em->remove($offer);
        }

        $this->em->flush();
    }

    /**
     * Test if Repository is valid
     */
    public function testIsRepositoryValid()
    {
        $this->assertInstanceOf(OfferRepository::class, $this->repository);
    }

    /**
     * Test findAll method
     */
    public function testFindAll()
    {
        $offers = $this->repository->findAll();

        $this->assertNotEmpty($offers);

        foreach ($this->offers as $offer) {
            $this->assertContains($offer, $offers);
        }
    }

    /**
     * Test find method
     */
    public function testFind()
    {
        $offer = current($this->offers);

        $foundOffer = $this->repository->find($offer->getId());

        $this->assertInstanceOf(Offer::class, $foundOffer);
        $this->assertEquals($offer, $foundOffer);
    }

    /**
     * Test findBy method
     */
    public function testFindBy()
    {
        $offer = current($this->offers);

        $foundOffers = $this->repository->findBy([
            'article' => $offer->getArticle()
        ]);

        $this->assertNotEmpty($foundOffers);
        $this->assertContains($offer, $foundOffers);
    }

    /**
     * Test findOneBy method
     */
    public function testFindOneBy()
    {
        $offer = current($this->offers);

        $foundOffer = $this->repository->findOneBy([
            'article' => $offer->getArticle()
        ]);

        $this->assertInstanceOf(Offer::class, $foundOffer);
        $this->assertEquals($offer, $foundOffer);
    }
}