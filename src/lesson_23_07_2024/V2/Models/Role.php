<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Models;

use App\lesson_23_07_2024\V1\Models\Model;
use App\lesson_23_07_2024\V2\Dto\RoleDto;

class Role extends Model
{
    private function __construct(
        private readonly int $id,
        private readonly string $name,
    ) {}

    public static function writeNewFrom(RoleDto $roleDto): Role
    {
        return new Role(
            $roleDto->id,
            $roleDto->name,
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

}
