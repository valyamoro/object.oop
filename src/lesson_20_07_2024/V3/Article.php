<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V3;

class Article
{
    private int $id;
    private string $title;
    private string $body;
    private Category $category;
    private User $user;

    private function __construct(private readonly ArticleDto $articleDTO) {
        $this->id = $this->articleDTO->id;
        $this->title = $this->articleDTO->title;
        $this->body = $this->articleDTO->body;
        $this->category = $this->articleDTO->category;
        $this->user = $this->articleDTO->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public static function create(ArticleDto $articleDTO): Article
    {
        return new Article($articleDTO);
    }

}
