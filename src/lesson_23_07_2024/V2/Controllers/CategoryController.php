<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\CategoryCollection;
use App\lesson_23_07_2024\V2\Exceptions\ExceptionController;
use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Services\CategoryService;

class CategoryController
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {}

    public function index(): CategoryCollection
    {
        $result = $this->categoryService->getAll();

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function store(array $request): ?Category
    {
        $categoryDto = $this->categoryService->createCategoryDto(array_merge(
            $request,
            ['id' => 0],
        ));

        $result = $this->categoryService->create($categoryDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка создания категории',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function update(array $request): ?Category
    {
        $categoryDto = $this->categoryService->createCategoryDto($request);

        $result = $this->categoryService->update($categoryDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка обновления категории',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function show(array $request): ?Category
    {
        $id = (int)$request['id'];

        $result = $this->categoryService->getOne($id);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка получения категории',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        $result = $this->categoryService->delete($id);

        if ($result === false) {
            throw new ExceptionController(
                'Произошла ошибка удаления категории',
                500,
            );
        }

        return $result;
    }

}
