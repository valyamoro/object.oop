<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V2;

class Article
{
    private function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $body,
        private readonly Category $category,
        private readonly User $user,
    ) {}

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

    public static function create(
        int $id,
        string $title,
        string $body,
        Category $category,
        User $user,
    ): Article
    {
        return new Article(
            $id,
            $title,
            $body,
            $category,
            $user,
        );
    }

}
