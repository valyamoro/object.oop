<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V2;

class User
{
    private function __construct(
        private readonly int $id,
        private readonly string $login,
        private readonly string $password,
        private readonly string $email,
        private readonly array $roles,
    ) {}

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

    public static function create(
        int $id,
        string $login,
        string $password,
        string $email,
        array $roles,
    ): User
    {
        return new User(
            $id,
            $login,
            $password,
            $email,
            $roles,
        );
    }

}
