<?php

namespace App\Domains\Product\Builders;

use App\Domains\Product\Entities\Product;
use App\Domains\Product\Repositories\ProductRepository;
use DateTime;
use stdClass;

class ProductBuilder
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductBuilder constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param stdClass $data
     * @return Product
     */
    public function build(stdClass $data): Product
    {
        /** @var Product $product */
        $product = $this->repository->find($data->id);

        if (empty($product)) {
            return $this->createInstance($data);
        }

        return $this->updateInstance($product, $data);
    }

    /**
     * @param stdClass $data
     * @return Product
     */
    private function createInstance(stdClass $data): Product
    {
        $first_invoice = $data->first_invoice ? DateTime::createFromFormat('Y-m-d H:i:s', $data->first_invoice) : null;

        return Product::build(
            $data->id,
            $data->title,
            $data->image,
            $data->description,
            $first_invoice,
            $data->url,
            $data->price,
            $data->amount
        );
    }

    /**
     * @param Product $product
     * @param stdClass $data
     * @return Product
     */
    private function updateInstance(Product $product, stdClass $data): Product
    {
        $first_invoice = $data->first_invoice ? DateTime::createFromFormat('Y-m-d H:i:s', $data->first_invoice) : null;

        $product->setTitle($data->title);
        $product->setImage($data->image);
        $product->setDescription($data->description);
        $product->setFirstInvoice($first_invoice);
        $product->setUrl($data->url);
        $product->setPrice($data->price);
        $product->setAmount($data->amount);

        return $product;
    }
}