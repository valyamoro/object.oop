<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V3;

readonly class CategoryDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

}
