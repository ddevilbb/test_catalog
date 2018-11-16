<?php

namespace App\Domains\Category\Builders;

use App\Domains\Category\Entities\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use stdClass;

class CategoryBuilder
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoryBuilder constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param stdClass $data
     * @return Category
     */
    public function build(stdClass $data)
    {
        /** @var Category $category */
        $category = $this->repository->find($data->id);

        if (empty($category)) {
            return $this->createInstance($data);
        }

        return $this->updateInstance($category, $data);
    }

    /**
     * @param stdClass $data
     * @return Category
     */
    private function createInstance(stdClass $data): Category
    {
        /** @var Category $parentCategory */
        $parentCategory = $this->repository->find((int)$data->parent);

        return Category::build(
            $data->id,
            $data->title,
            $data->alias,
            $parentCategory
        );
    }

    /**
     * @param Category $category
     * @param stdClass $data
     * @return Category
     */
    private function updateInstance(Category $category, stdClass $data): Category
    {
        /** @var Category $parentCategory */
        $parentCategory = $this->repository->find((int)$data->parent);

        $category->setTitle($data->title);
        $category->setAlias($data->alias);
        $category->setParent($parentCategory);

        return $category;
    }
}