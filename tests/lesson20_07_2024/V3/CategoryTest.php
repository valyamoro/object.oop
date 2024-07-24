<?php
declare(strict_types=1);

namespace lesson20_07_2024\V3;

use App\lesson_20_07_2024\V3\Category;
use App\lesson_20_07_2024\V3\CategoryDto;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $name = 'category_one';
        $categoryDto = new CategoryDto(
            $id,
            $name,
        );

        $category = Category::create($categoryDto);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals(1, $category->getId());
        $this->assertSame('category_one', $category->getName());
    }

}
