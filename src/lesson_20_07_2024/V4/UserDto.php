<?php
declare(strict_types=1);

namespace App\lesson_20_07_2024\V4;

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
