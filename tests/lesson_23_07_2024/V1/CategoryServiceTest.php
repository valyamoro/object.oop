<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V1;

use App\lesson_23_07_2024\V1\Collections\CategoryCollection;
use App\lesson_23_07_2024\V1\Dto\CategoryDto;
use App\lesson_23_07_2024\V1\Models\Category;
use App\lesson_23_07_2024\V1\Repositories\CategoryRepository;
use App\lesson_23_07_2024\V1\Services\CategoryService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private CategoryService $categoryService;
    private CategoryDto $categoryDto;
    private Category $category;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->categoryService = new CategoryService($this->categoryRepository, $this->createMock(CategoryCollection::class));
        $this->categoryDto = new CategoryDto(1, 'Tech');
        $this->category = Category::create($this->categoryDto);
    }

    public function testGetAll(): void
    {
        $categories = [['id' => 1, 'name' => 'Tech'], ['id' => 2, 'name' => 'Countries']];
        $this->categoryRepository->method('getAll')->willReturn($categories);

        $result = $this->categoryService->getAll();

        $this->assertInstanceOf(CategoryCollection::class, $result);
    }

    public function testGetOne(): void
    {
        $categoryData = ['id' => 1, 'name' => 'Tech'];
        $this->categoryRepository->method('getOne')->with(1)->willReturn($categoryData);

        $result = $this->categoryService->getOne(1);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals('Tech', $result->getName());
    }

    public function testGetOneWithInvalidId(): void
    {
        $id = 999;
        $this->categoryRepository->method('getOne')->with($id)->willReturn([]);

        $result = $this->categoryService->getOne($id);

        $this->assertNull($result);
    }

    public function testCreate(): void
    {
        $this->categoryRepository->method('create')->with($this->category)->willReturn(1);

        $result = $this->categoryService->create($this->categoryDto);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame($this->category->getId(), $result->getId());
        $this->assertSame($this->category->getName(), $result->getName());
    }

    public function testCreateWithFailedRepository(): void
    {
        $this->categoryRepository->method('create')->with($this->category)->willReturn(0);

        $result = $this->categoryService->create($this->categoryDto);

        $this->assertNull($result);
    }

    public function testUpdate(): void
    {
        $data = [
            'id' => $this->category->getId(),
            'name' => $this->category->getName(),
        ];

        $this->categoryRepository->method('update')->with(1, $this->category)->willReturn($data);
        $result = $this->categoryService->update(1, $this->categoryDto);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame($this->category->getId(), $result->getId());
        $this->assertSame($this->category->getName(), $result->getName());
    }

    public function testUpdateWithInvalidId(): void
    {
        $this->categoryRepository->method('update')->with(999, $this->category)->willReturn([]);

        $result = $this->categoryService->update(999, $this->categoryDto);

        $this->assertNull($result);
    }

    public function testDelete(): void
    {
        $this->categoryRepository->method('delete')->with($this->category)->willReturn(true);

        $result = $this->categoryService->delete($this->categoryDto);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame($this->category->getId(), $result->getId());
        $this->assertSame($this->category->getName(), $result->getName());
    }

    public function testDeleteWithFailedRepository(): void
    {
        $this->categoryRepository->method('delete')->with($this->category)->willReturn(false);

        $result = $this->categoryService->delete($this->categoryDto);

        $this->assertNull($result);
    }

}
