<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Collections;

use App\lesson_23_07_2024\V2\Models\Article;
use App\lesson_23_07_2024\V2\Services\ArticleService;
use App\lesson_23_07_2024\V2\Services\CategoryService;
use App\lesson_23_07_2024\V2\Services\UserService;

class ArticleCollection extends Collection
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly UserService $userService,
    ) {}

    public function get(): array
    {
        return $this->items;
    }

    public function make(array $items): ArticleCollection
    {
        $result = array_map(function(array $item) {
            $category = $this->categoryService->getOne($item['category_id']);
            $user = $this->userService->getOne($item['user_id']);

            $articleDto = ArticleService::createArticleDto($item, $category, $user);

            $result = Article::writeNewFrom($articleDto);

            return $result;
        }, $items);

        $this->items = $result;

        return $this;
    }

}
