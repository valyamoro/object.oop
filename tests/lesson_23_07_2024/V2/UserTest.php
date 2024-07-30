<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V2;

use App\lesson_23_07_2024\V2\Controllers\RoleController;
use App\lesson_23_07_2024\V2\Repositories\RoleRepository;
use App\lesson_23_07_2024\V2\Services\RoleService;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Repositories\UserRolesRepository;
use App\lesson_23_07_2024\V2\Collections\UserCollection;
use App\lesson_23_07_2024\V2\Controllers\UserController;
use App\lesson_23_07_2024\V2\Database\DatabaseConfiguration;
use App\lesson_23_07_2024\V2\Database\DatabasePDOConnection;
use App\lesson_23_07_2024\V2\Database\PDODriver;
use App\lesson_23_07_2024\V2\Models\User;
use App\lesson_23_07_2024\V2\Repositories\UserRepository;
use App\lesson_23_07_2024\V2\Services\UserRolesService;
use App\lesson_23_07_2024\V2\Services\UserService;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private readonly UserController $userController;
    private readonly PDODriver $PDODriver;
    private readonly RoleController $roleController;

    public function setUp(): void
    {
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
        $this->roleController = new RoleController($roleService);

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
    }

    public function testCanGetAll(): void
    {
        $result = $this->userController->index();

        $this->assertInstanceOf(UserCollection::class, $result);
    }

    public function testCanCreate(): void
    {
        $role = $this->roleController->store([
            'name' => 'role_name',
        ]);
        $data = [
            'login' => 'user_1',
            'password' => '123456j',
            'email' => 'user_1@gmail.com',
            'roles' => [
                $role->getId(),
            ],
        ];

        $result = $this->userController->store($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame('user_1', $result->getLogin());
        $this->assertSame('123456j', $result->getPassword());
        $this->assertSame('user_1@gmail.com', $result->getEmail());
        $this->assertInstanceOf(RoleCollection::class, $result->getRoles());
        $this->assertSame('role_name', $result->getRoles()->get()[0]->getName());
    }

    public function testCanUpdate(): void
    {
        $role = $this->roleController->store([
            'name' => 'role_name',
        ]);
        $user = $this->userController->store([
            'login' => 'user_1',
            'password' => '123456j',
            'email' => 'user_1@gmail.com',
            'roles' => [
                $role->getId(),
            ],
        ]);
        $updatedData = [
            'id' => $user->getId(),
            'login' => 'updated user_1',
            'password' => '123456j',
            'email' => 'updated user_1@gmail.com',
            'roles' => [
                '3',
            ],
        ];

        $result = $this->userController->update($updatedData);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame('updated user_1', $result->getLogin());
        $this->assertSame('123456j', $result->getPassword());
        $this->assertSame('updated user_1@gmail.com', $result->getEmail());
        $this->assertInstanceOf(RoleCollection::class, $result->getRoles());
        $this->assertSame('role_name', $result->getRoles()->get()[0]->getName());
    }

    public function testCanGetOne(): void
    {
        $role = $this->roleController->store([
            'name' => 'role_name',
        ]);
        $user = $this->userController->store([
            'login' => 'user_1',
            'password' => '123456j',
            'email' => 'user_1@gmail.com',
            'roles' => [
                $role->getId(),
            ],
        ]);
        $data = [
            'id' => $user->getId(),
        ];

        $result = $this->userController->show($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame('user_1', $result->getLogin());
        $this->assertSame('123456j', $result->getPassword());
        $this->assertSame('user_1@gmail.com', $result->getEmail());
        $this->assertInstanceOf(RoleCollection::class, $result->getRoles());
        $this->assertSame('role_name', $result->getRoles()->get()[0]->getName());
    }

    public function testCanDelete(): void
    {
        $role = $this->roleController->store([
            'name' => 'role_name',
        ]);
        $user = $this->userController->store([
            'login' => 'user_1',
            'password' => '123456j',
            'email' => 'user_1@gmail.com',
            'roles' => [
                $role->getId(),
            ],
        ]);
        $data = [
            'id' => $user->getId(),
        ];

        $result = $this->userController->delete($data);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        $query = 'DELETE FROM users';

        $sth = $this->PDODriver->prepare($query);
        $sth->execute();

        $query = 'DELETE FROM user_roles';

        $sth = $this->PDODriver->prepare($query);
        $sth->execute();
    }

}
