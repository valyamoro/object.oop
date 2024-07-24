<?php
declare(strict_types=1);

namespace lesson20_07_2024\V2;

use App\lesson_20_07_2024\V2\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $name = 'category_one';

        $category = Category::create(
            $id,
            $name,
        );

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals(1, $category->getId());
        $this->assertSame('category_one', $category->getName());
    }

}