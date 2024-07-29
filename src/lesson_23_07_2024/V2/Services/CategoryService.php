<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Services;

use App\lesson_23_07_2024\V2\Collections\CategoryCollection;
use App\lesson_23_07_2024\V2\Dto\CategoryDto;
use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CategoryCollection $categoryCollection,
    ) {}

    public function getAll(): CategoryCollection
    {
        $result = $this->categoryRepository->getAll();

        return $this->categoryCollection->make($result);
    }

    public function getOne(int $id): ?Category
    {
        $result = $this->categoryRepository->getOne($id);

        $categoryDto = static::createCategoryDto($result);

        $category = Category::writeNewFrom($categoryDto);

        return $result === [] ? null : $category;
    }

    public function create(CategoryDto $categoryDto): ?Category
    {
        $result = $this->categoryRepository->create($categoryDto);

        if ($result === []) {
            return null;
        }

        $categoryDto = static::createCategoryDto($result);

        return Category::writeNewFrom($categoryDto);
    }

    public function update(CategoryDto $categoryDto): ?Category
    {
        $result = $this->categoryRepository->update($categoryDto);

        if ($result === []) {
            return null;
        }

        $categoryDto = $this->createCategoryDto($result);

        return Category::writeNewFrom($categoryDto);
    }

    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }

    public static function createCategoryDto(array $data): CategoryDto
    {
        return new CategoryDto(
            (int)$data['id'],
            $data['name'],
        );
    }

}
