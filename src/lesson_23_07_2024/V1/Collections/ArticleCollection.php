<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Collections;

use App\lesson_23_07_2024\V1\Dto\ArticleDto;
use App\lesson_23_07_2024\V1\Models\Article;
use App\lesson_23_07_2024\V1\Services\CategoryService;
use App\lesson_23_07_2024\V1\Services\UserService;

class ArticleCollection extends Collection
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly UserService $userService,
    ) {}

    public function make(array $data): ArticleCollection
    {
        $collection = [];

        foreach ($data as $item) {
            $id = $item['id'];
            $title = $item['title'];
            $body = $item['body'];
            $category = $this->categoryService->getOne($item['category_id']);
            $user = $this->userService->getOne($item['user_id']);
            $articleDto = new ArticleDto(
                $id,
                $title,
                $body,
                $category,
                $user,
            );

            $article = Article::create($articleDto);

            $collection[] = $article;

        }

        $this->items = $collection;

        return $this;
    }

}
