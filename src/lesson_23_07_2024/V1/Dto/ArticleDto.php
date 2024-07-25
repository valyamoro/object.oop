<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Dto;

use App\lesson_23_07_2024\V1\Models\Category;
use App\lesson_23_07_2024\V1\Models\User;

class ArticleDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $body,
        public Category $category,
        public User $user,
    ) {}

}
