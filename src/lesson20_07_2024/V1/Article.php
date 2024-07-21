<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V1;

readonly class Article
{
    public function __construct(
        private int $id,
        private string $title,
        private string $body,
        private Category $category,
        private User $user,
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

}
