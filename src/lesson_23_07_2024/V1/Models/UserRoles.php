<?php

namespace App\lesson_23_07_2024\V1\Models;

use App\lesson_23_07_2024\V1\Dto\UserRolesDto;

class UserRoles extends Model
{
    private int $id;
    private string $userId;
    private string $roleId;

    private function __construct(private readonly UserRolesDto $userRolesDto) {
        $this->id = $this->userRolesDto->id;
        $this->userId = $this->userRolesDto->userId;
        $this->roleId = $this->userRolesDto->roleId;
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

    public static function create(UserRolesDto $userRolesDto): UserRoles
    {
        return new UserRoles($userRolesDto);
    }

}
