<?php

namespace App\Applications\Catalog\Http\Controllers;

use App\Applications\Catalog\Http\Requests\ValidateSearchRequest;
use App\Core\Http\Controllers\Controller;
use App\Domains\Category\Services\CategoryService;
use App\Domains\Product\Services\ProductService;

class CatalogController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    private $categoryService;

    /**
     * CatalogController constructor.
     *
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->productService->getTopSales();

        return view('pages.catalog', compact('products'));
    }

    /**
     * @param string $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Core\Exceptions\NotFoundException
     */
    public function showCategory(string $alias)
    {
        $activeCategory = $this->categoryService->getOneBy([
            'alias' => $alias
        ]);

        $products = $this->productService->getByCategoryId($activeCategory->getId());

        return view('pages.catalog', compact('activeCategory', 'products'));
    }

    /**
     * @param string $alias
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Core\Exceptions\NotFoundException
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function showProduct(string $alias, int $id)
    {
        $activeCategory = $this->categoryService->getOneBy([
            'alias' => $alias
        ]);

        $product = $this->productService->details($id);

        return view('pages.product', compact('activeCategory', 'product'));
    }

    /**
     * @param ValidateSearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(ValidateSearchRequest $request)
    {
        $request->validated();

        $search = $request->get('search');

        $products = $this->productService->getBySearch($search);

        return view('pages.catalog', compact('search', 'products'));
    }
}