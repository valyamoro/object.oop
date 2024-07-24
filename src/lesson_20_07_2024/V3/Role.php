<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V3;

class Role
{
    private int $id;
    private string $name;

    public const string ADMIN = 'admin';
    public const string MODERATOR = 'moderator';
    public const string USER = 'user';

    private function __construct(private readonly RoleDto $roleDto) {
        $this->id = $this->roleDto->id;
        $this->name = $this->roleDto->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(RoleDto $roleDto): Role
    {
        return new Role($roleDto);
    }

}
