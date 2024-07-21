<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V3;

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
