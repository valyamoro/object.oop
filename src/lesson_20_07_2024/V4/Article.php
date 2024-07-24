<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V4;

class Article
{
    private int $id;
    private string $title;
    private string $body;
    private Category $category;
    private User $user;

    private function __construct(private readonly ArticleDto $articleDto) {
        $this->id = $this->articleDto->id;
        $this->title = $this->articleDto->title;
        $this->body = $this->articleDto->body;
        $this->category = $this->articleDto->category;
        $this->user = $this->articleDto->user;
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

    public static function create(ArticleDto $articleDto): Article
    {
        return new Article($articleDto);
    }

}
