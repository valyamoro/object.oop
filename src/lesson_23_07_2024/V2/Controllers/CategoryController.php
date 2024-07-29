<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\CategoryCollection;
use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Services\CategoryService;

class CategoryController
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {}

    public function index(): CategoryCollection
    {
        return $this->categoryService->getAll();
    }

    public function store(array $request): ?Category
    {
        $request['id'] = 0;

        $categoryDto = $this->categoryService->createCategoryDto($request);

        $result = $this->categoryService->create($categoryDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function update(array $request): ?Category
    {
        $categoryDto = $this->categoryService->createCategoryDto($request);

        $result = $this->categoryService->update($categoryDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function show(array $request): ?Category
    {
        $id = (int)$request['id'];

        return $this->categoryService->getOne($id);
    }

    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        return $this->categoryService->delete($id);
    }

}
