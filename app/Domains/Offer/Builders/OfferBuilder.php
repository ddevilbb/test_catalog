<?php

namespace App\Domains\Offer\Builders;

use App\Domains\Offer\Entities\Offer;
use App\Domains\Offer\Repository\OfferRepository;
use stdClass;

class OfferBuilder
{
    /**
     * @var OfferRepository
     */
    private $repository;

    /**
     * OfferBuilder constructor.
     *
     * @param OfferRepository $repository
     */
    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;

    }

    /**
     * @param stdClass $data
     * @return Offer
     */
    public function build(stdClass $data): Offer
    {
        /** @var Offer $offer */
        $offer = $this->repository->find($data->id);

        if (empty($offer)) {
            return $this->createInstance($data);
        }

        return $this->updateInstance($offer, $data);
    }

    /**
     * @param stdClass $data
     * @return Offer
     */
    private function createInstance(stdClass $data): Offer
    {
        return Offer::build(
            $data->id,
            $data->price,
            $data->amount,
            $data->sales,
            $data->article
        );
    }

    /**
     * @param Offer $offer
     * @param stdClass $data
     * @return Offer
     */
    private function updateInstance(Offer $offer, stdClass $data): Offer
    {
        $offer->setPrice($data->price);
        $offer->setAmount($data->amount);
        $offer->setSales($data->sales);
        $offer->setArticle($data->article);

        return $offer;
    }
}