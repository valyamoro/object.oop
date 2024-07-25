<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Collections;

abstract class Collection
{
    protected array $items;

    abstract public function make(array $data): Collection;
    public function get(): ?array
    {
        return $this->items !== [] ? $this->items : null;
    }

}
