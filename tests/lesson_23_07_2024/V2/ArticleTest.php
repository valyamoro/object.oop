<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V2;

use App\lesson_23_07_2024\V2\Models\Article;
use App\lesson_23_07_2024\V2\Models\Category;
use App\lesson_23_07_2024\V2\Collections\ArticleCollection;
use App\lesson_23_07_2024\V2\Collections\CategoryCollection;
use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Collections\UserCollection;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Controllers\ArticleController;
use App\lesson_23_07_2024\V2\Controllers\CategoryController;
use App\lesson_23_07_2024\V2\Controllers\UserController;
use App\lesson_23_07_2024\V2\Database\DatabaseConfiguration;
use App\lesson_23_07_2024\V2\Database\DatabasePDOConnection;
use App\lesson_23_07_2024\V2\Database\PDODriver;
use App\lesson_23_07_2024\V2\Models\User;
use App\lesson_23_07_2024\V2\Repositories\ArticleRepository;
use App\lesson_23_07_2024\V2\Repositories\CategoryRepository;
use App\lesson_23_07_2024\V2\Repositories\RoleRepository;
use App\lesson_23_07_2024\V2\Repositories\UserRepository;
use App\lesson_23_07_2024\V2\Repositories\UserRolesRepository;
use App\lesson_23_07_2024\V2\Services\ArticleService;
use App\lesson_23_07_2024\V2\Services\CategoryService;
use App\lesson_23_07_2024\V2\Services\RoleService;
use App\lesson_23_07_2024\V2\Services\UserRolesService;
use App\lesson_23_07_2024\V2\Services\UserService;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private readonly ArticleController $articleController;
    private readonly CategoryController $categoryController;
    private readonly UserController $userController;
    private readonly PDODriver $PDODriver;

    public function setUp(): void
    {
        parent::setUp();

        $databaseConfig = require __DIR__ . '/../../../src/lesson_23_07_2024/V2/config/test_database.php';

        $databaseConfiguration = new DatabaseConfiguration(...$databaseConfig);
        $databasePdoConnection = new DatabasePDOConnection($databaseConfiguration);
        $this->PDODriver = new PDODriver($databasePdoConnection);

        $userRolesCollection = new UserRolesCollection();
        $userRolesRepository = new UserRolesRepository($this->PDODriver);
        $userRolesService = new UserRolesService(
            $userRolesRepository,
            $userRolesCollection,
        );


        $roleCollection = new RoleCollection();
        $roleRepository = new RoleRepository($this->PDODriver);
        $roleService = new RoleService(
            $roleRepository,
            $roleCollection,
        );

        $userCollection = new UserCollection(
            $userRolesService,
            $roleService,
            $roleCollection,
        );
        $userRepository = new UserRepository($this->PDODriver);
        $userService = new UserService(
            $userRepository,
            $userRolesService,
            $userCollection,
        );
        $this->userController = new UserController(
            $userService,
            $userRolesCollection,
        );

        $categoryCollection = new CategoryCollection();
        $categoryRepository = new CategoryRepository($this->PDODriver);
        $categoryService = new CategoryService($categoryRepository, $categoryCollection);
        $this->categoryController = new CategoryController($categoryService);

        $articleCollection = new ArticleCollection(
            $categoryService,
            $userService,
        );
        $articleRepository = new ArticleRepository($this->PDODriver);
        $articleService = new ArticleService(
            $articleRepository,
            $articleCollection,
            $categoryService,
            $userService,
        );
        $this->articleController = new ArticleController(
            $articleService,
            $categoryService,
            $userService,
        );
    }

    public function testCanGetAll(): void
    {
        $result = $this->articleController->index();

        $this->assertInstanceOf(ArticleCollection::class, $result);
    }

    public function testCanCreate(): void
    {
        $category = $this->categoryController->store([
            'name' => 'category',
        ]);
        $user = $this->userController->store([
            'login' => 'user 1',
            'password' => '123456j',
            'email' => 'user@gmail.com',
            'roles' => [
                '1',
                '2',
                '3',
            ],
        ]);
        $data = [
            'title' => 'article 1',
            'body' => 'article body 1',
            'category_id' => $category->getId(),
            'user_id' => $user->getId(),
        ];

        $result = $this->articleController->store($data);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertSame('article 1', $result->getTitle());
        $this->assertSame('article body 1', $result->getBody());
        $this->assertInstanceOf(Category::class, $result->getCategory());
        $this->assertSame('category', $result->getCategory()->getName());
        $this->assertInstanceOf(User::class, $result->getUser());
        $this->assertSame('user 1', $result->getUser()->getLogin());
        $this->assertSame('123456j', $result->getUser()->getPassword());
        $this->assertSame('user@gmail.com', $result->getUser()->getEmail());
    }

    public function testCanUpdate(): void
    {
        $category = $this->categoryController->store([
            'name' => 'category',
        ]);
        $user = $this->userController->store([
            'login' => 'user 1',
            'password' => '123456j',
            'email' => 'user@gmail.com',
            'roles' => [
                '1',
                '2',
                '3',
            ],
        ]);
        $data = [
            'title' => 'article 1',
            'body' => 'article body 1',
            'category_id' => $category->getId(),
            'user_id' => $user->getId(),
        ];
        $article = $this->articleController->store($data);
        $updatedData = [
            'id' => $article->getId(),
            'title' => 'updated article 1',
            'body' => 'updated article body 1',
            'category_id' => $article->getCategory()->getId(),
            'user_id' => $article->getUser()->getId(),
        ];

        $result = $this->articleController->update($updatedData);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertSame('updated article 1', $result->getTitle());
        $this->assertSame('updated article body 1', $result->getBody());
        $this->assertInstanceOf(Category::class, $result->getCategory());
        $this->assertSame('category', $result->getCategory()->getName());
        $this->assertInstanceOf(User::class, $result->getUser());
        $this->assertSame('user 1', $result->getUser()->getLogin());
        $this->assertSame('123456j', $result->getUser()->getPassword());
        $this->assertSame('user@gmail.com', $result->getUser()->getEmail());
    }

    public function testCanGetOne(): void
    {
        $category = $this->categoryController->store([
            'name' => 'category',
        ]);
        $user = $this->userController->store([
            'login' => 'user 1',
            'password' => '123456j',
            'email' => 'user@gmail.com',
            'roles' => [
                '1',
                '2',
                '3',
            ],
        ]);
        $article = $this->articleController->store([
            'title' => 'article 1',
            'body' => 'article body 1',
            'category_id' => $category->getId(),
            'user_id' => $user->getId(),
        ]);
        $data = [
            'id' => $article->getId(),
        ];

        $result = $this->articleController->show($data);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertSame('article 1', $result->getTitle());
        $this->assertSame('article body 1', $result->getBody());
        $this->assertInstanceOf(Category::class, $result->getCategory());
        $this->assertSame('category', $result->getCategory()->getName());
        $this->assertInstanceOf(User::class, $result->getUser());
        $this->assertSame('user 1', $result->getUser()->getLogin());
        $this->assertSame('123456j', $result->getUser()->getPassword());
        $this->assertSame('user@gmail.com', $result->getUser()->getEmail());
    }

    public function testCanDelete(): void
    {
        $category = $this->categoryController->store([
            'name' => 'category',
        ]);
        $user = $this->userController->store([
            'login' => 'user 1',
            'password' => '123456j',
            'email' => 'user@gmail.com',
            'roles' => [
                '1',
                '2',
                '3',
            ],
        ]);
        $article = $this->articleController->store([
            'title' => 'article 1',
            'body' => 'article body 1',
            'category_id' => $category->getId(),
            'user_id' => $user->getId(),
        ]);
        $data = [
            'id' => $article->getId(),
        ];

        $result = $this->articleController->delete($data);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $query = 'DELETE FROM articles';

        $sth = $this->PDODriver->prepare($query);
        $sth->execute();
    }

}
