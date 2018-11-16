<?php

namespace App\Core\Services;

use App;
use App\Domains\Category\Builders\CategoryBuilder;
use App\Domains\Category\Services\CategoryService;
use App\Domains\Offer\Builders\OfferBuilder;
use App\Domains\Offer\Services\OfferService;
use App\Domains\Product\Builders\ProductBuilder;
use App\Domains\Product\Services\ProductService;
use Doctrine\ORM\EntityManager;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ImportFromJsonService
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var DoctrineService
     */
    private $doctrineService;

    /**
     * @var ProductBuilder
     */
    private $productBuilder;

    /**
     * @var CategoryBuilder
     */
    private $categoryBuilder;

    /**
     * @var OfferBuilder
     */
    private $offerBuilder;

    /**
     * ImportFromJsonService constructor.
     *
     * @param Client $client
     * @param DoctrineService $doctrineService
     * @param ProductBuilder $productBuilder
     * @param CategoryBuilder $categoryBuilder
     * @param OfferBuilder $offerBuilder
     */
    public function __construct(
        Client $client,
        DoctrineService $doctrineService,
        ProductBuilder $productBuilder,
        CategoryBuilder $categoryBuilder,
        OfferBuilder $offerBuilder
    )
    {
        $this->url = env('CATALOG_JSON_URL');
        $this->client = $client;
        $this->doctrineService = $doctrineService;
        $this->productBuilder = $productBuilder;
        $this->categoryBuilder = $categoryBuilder;
        $this->offerBuilder = $offerBuilder;
    }

    /**
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function run()
    {
        Log::info('Starting import!');
        $data = $this->getDataFromUrl();
        $count = count($data->products);
        $index = 0;

        foreach ($data->products as $product_data) {
            $product = $this->productBuilder->build($product_data);

            foreach ($product_data->categories as $category_data) {
                $category = $this->categoryBuilder->build($category_data);

                $this->doctrineService->persistOrMerge($category);

                $product->addCategory($category);
            }

            foreach ($product_data->offers as $offer_data) {
                $offer = $this->offerBuilder->build($offer_data);

                $this->doctrineService->persistOrMerge($offer);

                $product->addOffer($offer);
            }

            $this->doctrineService->persistOrMerge($product);
            Log::info('Imported ' . ++$index . ' / ' . $count . ' Product \'' . $product->getTitle() . '\'');
            $this->doctrineService->flush();
        }
        $this->doctrineService->flushAll();

        Log::info('Finish import!');
    }

    /**
     * @return mixed|void
     */
    private function getDataFromUrl()
    {
        try {
            $response = $this->client->get($this->url);
        } catch (Exception $e) {
            Log::error('Error retrieving data at ' . $this->url);
            return;
        }

        return json_decode($response->getBody()->getContents());
    }
}