<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Services;

use App\lesson_23_07_2024\V1\Collections\CategoryCollection;
use App\lesson_23_07_2024\V1\Dto\CategoryDto;
use App\lesson_23_07_2024\V1\Models\Category;
use App\lesson_23_07_2024\V1\Repositories\CategoryRepository;

final class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CategoryCollection $categoryCollection,
    ) {}

    public function getAll(): CategoryCollection
    {
        $categories = $this->categoryRepository->getAll();

        return $this->categoryCollection->make($categories);
    }

    public function getOne(int $id): ?Category
    {
        $data = $this->categoryRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $categoryDto = new CategoryDto(
            $data['id'],
            $data['name'],
        );

        return Category::create($categoryDto);
    }

    public function create(CategoryDto $categoryDto): ?Category
    {
        $category = Category::create($categoryDto);

        $result = $this->categoryRepository->create($category);

        return $result === 0 ? null : $category;
    }

    public function update(int $id, CategoryDto $categoryDto): ?Category
    {
        $category = Category::create($categoryDto);

        $result = $this->categoryRepository->update($id, $category);

        return $result === [] ? null : $category;
    }

    public function delete(CategoryDto $categoryDto): ?Category
    {
        $category = Category::create($categoryDto);

        $result = $this->categoryRepository->delete($category);

        return $result === false ? null : $category;
    }

}
