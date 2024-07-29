<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Models;

use App\lesson_23_07_2024\V1\Models\Model;
use App\lesson_23_07_2024\V2\Dto\ArticleDto;

class Article extends Model
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $body,
        private readonly Category $category,
        private readonly User $user,
    ) {}

    public static function writeNewFrom(ArticleDto $articleDto): Article
    {
        return new Article(
            $articleDto->id,
            $articleDto->title,
            $articleDto->body,
            $articleDto->category,
            $articleDto->user,
        );
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

}
