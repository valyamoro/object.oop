<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V3;

class Category
{
    private int $id;
    private string $name;

    private function __construct(private readonly CategoryDto $categoryDTO) {
        $this->id = $this->categoryDTO->id;
        $this->name = $this->categoryDTO->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(CategoryDto $categoryDTO): Category
    {
        return new Category($categoryDTO);
    }

}
