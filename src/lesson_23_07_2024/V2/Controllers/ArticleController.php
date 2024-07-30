<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\ArticleCollection;
use App\lesson_23_07_2024\V2\Exceptions\ExceptionController;
use App\lesson_23_07_2024\V2\Models\Article;
use App\lesson_23_07_2024\V2\Services\ArticleService;
use App\lesson_23_07_2024\V2\Services\CategoryService;
use App\lesson_23_07_2024\V2\Services\UserService;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly CategoryService $categoryService,
        private readonly UserService $userService,
    ) {}

    public function index(): ArticleCollection
    {
        $result = $this->articleService->getAll();

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function store(array $request): ?Article
    {
        $categoryId = (int)$request['category_id'];
        $userId = (int)$request['user_id'];

        $category = $this->categoryService->getOne($categoryId);
        $user = $this->userService->getOne($userId);

        $articleDto = ArticleService::createArticleDto(
            array_merge(
                $request, ['id' => 0],
            ),
            $category,
            $user,
        );

        $result = $this->articleService->store($articleDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка создания статьи',
                500,
            );
        }

        return $result;
    }

    public function update(array $request): ?Article
    {
        $categoryId = (int)$request['category_id'];
        $userId = (int)$request['user_id'];

        $category = $this->categoryService->getOne($categoryId);
        $user = $this->userService->getOne($userId);

        $articleDto = ArticleService::createArticleDto(
            $request,
            $category,
            $user,
        );

        $result = $this->articleService->update($articleDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка обновления статьи',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function show(array $request): ?Article
    {
        $id = (int)$request['id'];

        $result = $this->articleService->getOne($id);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка получения статьи',
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

        $result = $this->articleService->delete($id);

        if ($result === false) {
            throw new ExceptionController(
                'Произошла ошибка удаления статьи',
                500,
            );
        }

        return $result;
    }

}
