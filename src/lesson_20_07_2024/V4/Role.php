<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V4;

class Role
{
    private int $id;
    private string $name;

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
