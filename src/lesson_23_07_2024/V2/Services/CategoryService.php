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
        $data = $this->categoryRepository->getAll();

        return $this->categoryCollection->make($data);
    }

    public function getOne(int $id): ?Category
    {
        $data = $this->categoryRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $categoryDto = static::createCategoryDto($data);

        $result = Category::writeNewFrom($categoryDto);

        return $result;
    }

    public function create(CategoryDto $categoryDto): ?Category
    {
        $data = $this->categoryRepository->create($categoryDto);

        if ($data === []) {
            return null;
        }

        $categoryDto = static::createCategoryDto($data);

        $result = Category::writeNewFrom($categoryDto);

        return $result;
    }

    public function update(CategoryDto $categoryDto): ?Category
    {
        $data = $this->categoryRepository->update($categoryDto);

        if ($data === []) {
            return null;
        }

        $categoryDto = $this->createCategoryDto($data);

        $result = Category::writeNewFrom($categoryDto);

        return $result;
    }

    public function delete(int $id): bool
    {
        $result = $this->categoryRepository->delete($id);

        return $result;
    }

    public static function createCategoryDto(array $data): CategoryDto
    {
        $result = new CategoryDto(
            (int)$data['id'],
            $data['name'],
        );

        return $result;
    }

}
