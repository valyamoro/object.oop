<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V2;

class Role
{
    public const string ADMIN = 'admin';
    public const string MODERATOR = 'moderator';
    public const string USER = 'user';

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
    ): Role
    {
        return new Role(
            $id,
            $name,
        );
    }

}
