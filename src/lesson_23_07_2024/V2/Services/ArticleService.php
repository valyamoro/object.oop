<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Services;

use App\lesson_23_07_2024\V2\Repositories\ArticleRepository;
use App\lesson_23_07_2024\V2\Collections\ArticleCollection;
use App\lesson_23_07_2024\V2\Dto\ArticleDto;
use App\lesson_23_07_2024\V2\Models\Article;
use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Models\User;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly ArticleCollection $articleCollection,
        private readonly CategoryService $categoryService,
        private readonly UserService $userService,
    ) {}

    public function getAll(): ArticleCollection
    {
        $result = $this->articleRepository->getAll();

        return $this->articleCollection->make($result);
    }

    public function getOne(int $id): ?Article
    {
        $articleData = $this->articleRepository->getOne($id);

        if ($articleData === []) {
            return null;
        }

        $categoryId = (int)$articleData['category_id'];
        $category = $this->categoryService->getOne($categoryId);

        $userId = (int)$articleData['user_id'];
        $user = $this->userService->getOne($userId);

        $articleDto = static::createArticleDto(
            $articleData,
            $category,
            $user,
        );

        return Article::writeNewFrom($articleDto);
    }

    public function store(ArticleDto $articleDto): ?Article
    {
        $result = $this->articleRepository->create($articleDto);

        if ($result === []) {
            return null;
        }

        $articleDto = $this->createArticleDto(
            $result,
            $articleDto->category,
            $articleDto->user,
        );

        return Article::writeNewFrom($articleDto);
    }

    public function update(ArticleDto $articleDto): ?Article
    {
        $result = $this->articleRepository->update($articleDto);

        if ($result === []) {
            return null;
        }

        $articleDto = $this->createArticleDto(
            $result,
            $articleDto->category,
            $articleDto->user,
        );

        return Article::writeNewFrom($articleDto);
    }

    public function delete(int $id): bool
    {
        return $this->articleRepository->delete($id);
    }

    public static function createArticleDto(
        array $data,
        Category $category,
        User $user,
    ): ArticleDto
    {
        return new ArticleDto(
            (int)$data['id'],
            $data['title'],
            $data['body'],
            $category,
            $user,
        );
    }

}
