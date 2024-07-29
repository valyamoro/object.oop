<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Repositories;

use App\lesson_23_07_2024\V2\Database\PDODriver;

abstract class BaseRepository
{
    public function __construct(protected PDODriver $dbh) {}

}
