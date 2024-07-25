<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Collections;

use App\lesson_23_07_2024\V1\Dto\CategoryDto;
use App\lesson_23_07_2024\V1\Models\Category;

class CategoryCollection extends Collection
{
    public function make(array $data): CategoryCollection
    {
        $collection = [];

        foreach ($data as $item) {
            $id = $item['id'];
            $name = $item['name'];

            $categoryDto = new CategoryDto(
                $id,
                $name,
            );
            $category = Category::create($categoryDto);

            $collection[] = $category;
        }

        $this->items = $collection;

        return $this;
    }

}
