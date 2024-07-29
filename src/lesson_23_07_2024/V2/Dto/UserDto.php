<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Dto;

use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;

final class UserDto
{
    public function __construct(
        public int $id,
        public string $login,
        public string $password,
        public string $email,
        public UserRolesCollection|RoleCollection $roles,
    ) {}

}
