<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Models;

use App\lesson_23_07_2024\V1\Collections\RoleCollection;
use App\lesson_23_07_2024\V1\Dto\UserDto;

class User extends Model
{
    private int $id;
    private string $login;
    private string $password;
    private string $email;
    private RoleCollection $roles;

    private function __construct(private readonly UserDto $userDto) {
        $this->id = $this->userDto->id;
        $this->login = $this->userDto->login;
        $this->password = $this->userDto->password;
        $this->email = $this->userDto->email;
        $this->roles = $this->userDto->roles;
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

    public function getRoles(): RoleCollection
    {
        return $this->roles;
    }

    public static function create(UserDto $userDto): User
    {
        return new User($userDto);
    }

}
