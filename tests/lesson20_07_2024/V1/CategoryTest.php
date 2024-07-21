<?php
declare(strict_types=1);

namespace lesson20_07_2024\V1;

use App\lesson20_07_2024\V1\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $name = 'category_one';

        $category = new Category(
            $id,
            $name,
        );

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals(1, $category->getId());
        $this->assertSame('category_one', $category->getName());
    }

}