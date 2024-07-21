<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V3;

class User
{
    private int $id;
    private string $login;
    private string $password;
    private string $email;
    private array $roles;

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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public static function create(UserDto $userDto): User
    {
        return new User($userDto);
    }

}
