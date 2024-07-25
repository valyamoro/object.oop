<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Services;

use App\lesson_23_07_2024\V1\Collections\ArticleCollection;
use App\lesson_23_07_2024\V1\Dto\ArticleDto;
use App\lesson_23_07_2024\V1\Models\Article;
use App\lesson_23_07_2024\V1\Repositories\ArticleRepository;

final class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserService $userService,
        private readonly CategoryService $categoryService,
        private readonly ArticleCollection $articleCollection,
    ) {}

    public function getAll(): ArticleCollection
    {
        $articles = $this->articleRepository->getAll();

        return $this->articleCollection->make($articles);
    }

    public function getOne(int $id): ?Article
    {
        $data = $this->articleRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $data['category'] = $this->categoryService->getOne($data['category_id']);
        $data['user'] = $this->userService->getOne($data['user_id']);

        $articleDto = new ArticleDto(
            $data['id'],
            $data['title'],
            $data['body'],
            $data['category'],
            $data['user'],
        );

        return Article::create($articleDto);
    }

    public function create(ArticleDto $articleDto): ?Article
    {
        $article = Article::create($articleDto);

        $result = $this->articleRepository->create($article);

        return $result === 0 ? null : $article;
    }

    public function update(int $id, ArticleDto $articleDto): ?Article
    {
        $article = Article::create($articleDto);

        $result = $this->articleRepository->update($id, $article);

        return $result === [] ? null : $article;
    }

    public function delete(ArticleDto $articleDto): ?Article
    {
        $article = Article::create($articleDto);

        $result = $this->articleRepository->delete($article);

        return $result === false ? null : $article;
    }

}
