<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V2;

class Category
{
    private function __construct(
        private readonly int $id,
        private readonly string $name,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(
        int $id,
        string $name,
    ): Category
    {
        return new Category(
            $id,
            $name,
        );
    }
}
