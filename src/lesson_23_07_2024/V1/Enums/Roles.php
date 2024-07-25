<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Enums;

enum Roles: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';
}
