<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Models;

use App\lesson_23_07_2024\V1\Models\Model;
use App\lesson_23_07_2024\V2\Dto\UserRolesDto;

class UserRoles extends Model
{
    private function __construct(
        private readonly int $id,
        private readonly int $userId,
        private readonly int $roleId,
    ) {}

    public static function writeNewFrom(UserRolesDto $userRolesDto): UserRoles
    {
        return new UserRoles(
            $userRolesDto->id,
            $userRolesDto->userId,
            $userRolesDto->roleId,
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

}
