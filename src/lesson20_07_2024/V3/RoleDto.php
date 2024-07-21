<?php
declare(strict_types=1);

namespace App\lesson20_07_2024\V3;

readonly class RoleDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

}
