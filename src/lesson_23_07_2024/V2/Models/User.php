<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Models;

use App\lesson_23_07_2024\V1\Models\Model;
use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Dto\UserDto;

class User extends Model
{
    private function __construct(
        private readonly int $id,
        private readonly string $login,
        private readonly string $password,
        private readonly string $email,
        private readonly UserRolesCollection|RoleCollection $roles,
    ) {}

    public static function writeNewFrom(UserDto $userDto): User
    {
        return new User(
            $userDto->id,
            $userDto->login,
            $userDto->email,
            $userDto->password,
            $userDto->roles,
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): UserRolesCollection|RoleCollection
    {
        return $this->roles;
    }

}
