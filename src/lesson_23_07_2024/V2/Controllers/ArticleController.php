<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\ArticleCollection;
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
        return $this->articleService->getAll();
    }

    public function store(array $request): ?Article
    {
        $request['id'] = 0;
        $categoryId = $request['category_id'];
        $category = $this->categoryService->getOne((int)$categoryId);

        $userId = $request['user_id'];
        $user = $this->userService->getOne((int)$userId);

        $articleDto = ArticleService::createArticleDto(
            $request,
            $category,
            $user,
        );

        $result = $this->articleService->store($articleDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function update(array $request): ?Article
    {
        $categoryId = $request['category_id'];
        $category = $this->categoryService->getOne((int)$categoryId);

        $userId = $request['user_id'];
        $user = $this->userService->getOne((int)$userId);


        $articleDto = ArticleService::createArticleDto(
            $request,
            $category,
            $user,
        );

        $result = $this->articleService->update($articleDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function show(array $request): ?Article
    {
        $id = (int)$request['id'];

        return $this->articleService->getOne($id);
    }

    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        return $this->articleService->delete($id);
    }

}
