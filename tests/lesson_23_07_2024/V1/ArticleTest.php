<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V1;

use App\lesson_23_07_2024\V1\Collections\ArticleCollection;
use App\lesson_23_07_2024\V1\Collections\CategoryCollection;
use App\lesson_23_07_2024\V1\Collections\RoleCollection;
use App\lesson_23_07_2024\V1\Collections\UserCollection;
use App\lesson_23_07_2024\V1\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V1\Dto\ArticleDto;
use App\lesson_23_07_2024\V1\Dto\CategoryDto;
use App\lesson_23_07_2024\V1\Dto\UserDto;
use App\lesson_23_07_2024\V1\Models\Article;
use App\lesson_23_07_2024\V1\Models\Category;
use App\lesson_23_07_2024\V1\Models\User;
use App\lesson_23_07_2024\V1\Repositories\ArticleRepository;
use App\lesson_23_07_2024\V1\Repositories\CategoryRepository;
use App\lesson_23_07_2024\V1\Repositories\RoleRepository;
use App\lesson_23_07_2024\V1\Repositories\UserRepository;
use App\lesson_23_07_2024\V1\Repositories\UserRolesRepository;
use App\lesson_23_07_2024\V1\Services\ArticleService;
use App\lesson_23_07_2024\V1\Services\CategoryService;
use App\lesson_23_07_2024\V1\Services\RoleService;
use App\lesson_23_07_2024\V1\Services\UserRolesService;
use App\lesson_23_07_2024\V1\Services\UserService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private ArticleRepository $articleRepository;
    private ArticleService $articleService;
    private Article $article;
    private ArticleDto $articleDto;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->articleRepository = $this->createMock(ArticleRepository::class);
        $userRolesService = new UserRolesService(
            $this->createMock(UserRolesRepository::class),
            $this->createMock(UserRolesCollection::class),
        );
        $roleService = new RoleService(
            $this->createMock(RoleRepository::class),
            $this->createMock(RoleCollection::class),
        );
        $userService = new UserService(
            $this->createMock(UserRepository::class),
            $userRolesService,
            $roleService,
            $this->createMock(UserCollection::class),
        );
        $categoryService = new CategoryService(
            $this->createMock(CategoryRepository::class),
            $this->createMock(CategoryCollection::class),
        );
        $this->roleCollection = $this->createMock(RoleCollection::class);
        $this->articleService = new ArticleService(
            $this->articleRepository,
            $userService,
            $categoryService,
            $this->createMock(ArticleCollection::class),
        );
        $category = Category::create(new CategoryDto(1, 'Tech'));
        $roles = $this->roleCollection->make(
            [
                [
                    'id' => 1,
                    'name' => 'user',
                ],
                [
                    'id' => 2,
                    'name' => 'moderator',
                ],
            ]);
        $user = User::create(new UserDto(
            1,
            'user_1',
            '123456j',
            'user_1@gmail.com',
            $roles,
        ));
        $this->articleDto = new ArticleDto(1, 'article_one', 'article content', $category, $user);
        $this->article = Article::create($this->articleDto);
    }

    public function testGetAll(): void
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'article_one',
                'body' => 'article content 1',
                'category_id' => '1',
                'user_id' => '1',
            ],
            [
                'id' => 2,
                'title' => 'article_two',
                'body' => 'article content 2',
                'category_id' => '1',
                'user_id' => '1',
            ],
        ];
        $this->articleRepository->method('getAll')->willReturn($articles);

        $result = $this->articleService->getAll();

        $this->assertInstanceOf(ArticleCollection::class, $result);
    }

    public function testGetOneWithInvalidId(): void
    {
        $id = 999;
        $this->articleRepository->method('getOne')->with($id)->willReturn([]);

        $result = $this->articleService->getOne($id);

        $this->assertNull($result);
    }

    public function testCreate(): void
    {
        $this->articleRepository->method('create')->with($this->article)->willReturn(1);

        $result = $this->articleService->create($this->articleDto);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertSame($this->article->getId(), $result->getId());
        $this->assertSame($this->article->getTitle(), $result->getTitle());
        $this->assertSame($this->article->getBody(), $result->getBody());
        $this->assertSame($this->article->getCategory(), $result->getCategory());
        $this->assertSame($this->article->getUser(), $result->getUser());
    }

    public function testCreateWithFailedRepository(): void
    {
        $this->articleRepository->method('create')->with($this->article)->willReturn(0);

        $result = $this->articleService->create($this->articleDto);

        $this->assertNull($result);
    }

    public function testUpdate(): void
    {
        $data = [
            'id' => $this->article->getId(),
            'title' => $this->article->getTitle(),
            'body' => $this->article->getBody(),
            'category_id' => $this->article->getCategory()->getId(),
            'user_id' => $this->article->getUser()->getId(),
        ];
        $this->articleRepository->method('update')->with(1, $this->article)->willReturn($data);

        $result = $this->articleService->update(1, $this->articleDto);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertSame($this->article->getId(), $result->getId());
        $this->assertSame($this->article->getTitle(), $result->getTitle());
        $this->assertSame($this->article->getBody(), $result->getBody());
        $this->assertSame($this->article->getCategory(), $result->getCategory());
        $this->assertSame($this->article->getUser(), $result->getUser());
    }

    public function testUpdateWithInvalidId(): void
    {
        $this->articleRepository->method('update')->with(999, $this->article)->willReturn([]);

        $result = $this->articleService->update(999, $this->articleDto);

        $this->assertNull($result);
    }

    public function testDelete(): void
    {
        $this->articleRepository->method('delete')->with($this->article)->willReturn(true);

        $result = $this->articleService->delete($this->articleDto);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertSame($this->article->getId(), $result->getId());
        $this->assertSame($this->article->getTitle(), $result->getTitle());
        $this->assertSame($this->article->getBody(), $result->getBody());
        $this->assertSame($this->article->getCategory(), $result->getCategory());
        $this->assertSame($this->article->getUser(), $result->getUser());
    }

    public function testDeleteWithFailedRepository(): void
    {
        $this->articleRepository->method('delete')->with($this->article)->willReturn(false);

        $result = $this->articleService->delete($this->articleDto);

        $this->assertNull($result);
    }

}
