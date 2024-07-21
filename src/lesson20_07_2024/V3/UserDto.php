<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V3;

readonly class UserDto
{
    public function __construct(
        public int $id,
        public string $login,
        public string $password,
        public string $email,
        public array $roles,
    ) {}

}
