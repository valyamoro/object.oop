<?php

namespace App\lesson_23_07_2024\V1\Dto;

class UserRolesDto
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $roleId,
    ) {}

}
