<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Collections;

use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Services\CategoryService;

class CategoryCollection extends Collection
{
    public function get(): array
    {
        return $this->items;
    }

    public function make(array $items): ?CategoryCollection
    {
        $result = array_map(function(array $item) {
            $categoryDto = CategoryService::createCategoryDto($item);

            return Category::writeNewFrom($categoryDto);
        }, $items);

        $this->set($result);

        return $this;
    }

    public function set(array $items): CategoryCollection
    {
        $this->items = $items;

        return $this;
    }

}
