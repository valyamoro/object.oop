<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Repositories;

abstract class BaseRepository
{
    public function __construct(protected \PDO $dbh) {}
}
