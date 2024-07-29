<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Dto;

final class UserRolesDto
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $roleId,
    ) {}

}
