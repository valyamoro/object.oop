<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V4;

readonly class ArticleDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $body,
        public Category $category,
        public User $user,
    ) {}

}
