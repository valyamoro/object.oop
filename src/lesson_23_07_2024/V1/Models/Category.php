<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Models;

use App\lesson_23_07_2024\V1\Dto\CategoryDto;

class Category extends Model
{
    private int $id;
    private string $name;

    private function __construct(private readonly CategoryDto $categoryDto) {
        $this->id = $this->categoryDto->id;
        $this->name = $this->categoryDto->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(CategoryDto $categoryDto): Category
    {
        return new Category($categoryDto);
    }

}
