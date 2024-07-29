<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V2;

use App\lesson_23_07_2024\V2\Collections\CategoryCollection;
use App\lesson_23_07_2024\V2\Controllers\CategoryController;
use App\lesson_23_07_2024\V2\Database\DatabaseConfiguration;
use App\lesson_23_07_2024\V2\Database\DatabasePDOConnection;
use App\lesson_23_07_2024\V2\Database\PDODriver;
use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Repositories\CategoryRepository;
use App\lesson_23_07_2024\V2\Services\CategoryService;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    private readonly CategoryController $categoryController;
    private readonly PDODriver $PDODriver;

    public function setUp(): void
    {
        parent::setUp();

        $databaseConfig = require __DIR__ . '/../../../src/lesson_23_07_2024/V2/config/test_database.php';

        $databaseConfiguration = new DatabaseConfiguration(...$databaseConfig);
        $databasePdoConnection = new DatabasePDOConnection($databaseConfiguration);
        $this->PDODriver = new PDODriver($databasePdoConnection);

        $categoryCollection = new CategoryCollection();
        $categoryRepository = new CategoryRepository($this->PDODriver);
        $categoryService = new CategoryService($categoryRepository, $categoryCollection);
        $this->categoryController = new CategoryController($categoryService);
    }

    public function testCanGetAll(): void
    {
        $result = $this->categoryController->index();

        $this->assertInstanceOf(CategoryCollection::class, $result);
    }

    public function testCanCreate(): void
    {
        $data = [
            'name' => 'category_name',
        ];

        $result = $this->categoryController->store($data);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame('category_name', $result->getName());
    }

    public function testCanUpdate(): void
    {
        $role = $this->categoryController->store([
            'name' => 'category 1',
        ]);
        $updatedData = [
            'id' => $role->getId(),
            'name' => 'updated category 1',
        ];

        $result = $this->categoryController->update($updatedData);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame('updated category 1', $result->getName());
    }

    public function testCanGetOne(): void
    {
        $category = $this->categoryController->store([
            'name' => 'category 1',
        ]);
        $data = [
            'id' => $category->getId(),
        ];

        $result = $this->categoryController->show($data);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame('category 1', $result->getName());
    }

    public function testCanDelete(): void
    {
        $category = $this->categoryController->store([
            'name' => 'category 1',
        ]);
        $data = [
            'id' => $category->getId(),
        ];

        $result = $this->categoryController->delete($data);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $query = 'DELETE FROM categories';

        $sth = $this->PDODriver->prepare($query);
        $sth->execute();
    }

}
