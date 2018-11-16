<?php

namespace App\Applications\Catalog\Http\Composers;

use App\Domains\Category\Services\CategoryService;
use Illuminate\View\View;

class CatalogComposer
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CatalogComposer constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categoryService->getList([
            'parent' => null
        ]));
    }
}