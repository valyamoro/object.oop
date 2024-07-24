<?php

namespace App\lesson_20_07_2024\V4;

enum Roles: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';
}
