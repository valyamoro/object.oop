<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Collections;

abstract class Collection
{
    protected array $items;

    abstract public function get(): array;
    abstract public function make(array $items): ?Collection;
    abstract public function set(array $items): Collection;

}
