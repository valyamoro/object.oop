<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V1;

readonly class User
{
    public function __construct(
        private int $id,
        private string $login,
        private string $password,
        private string $email,
        private array $roles,
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

}
