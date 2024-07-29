<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V2;

use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Database\DatabaseConfiguration;
use App\lesson_23_07_2024\V2\Database\DatabasePDOConnection;
use App\lesson_23_07_2024\V2\Database\PDODriver;
use App\lesson_23_07_2024\V2\Models\Role;
use App\lesson_23_07_2024\V2\Repositories\RoleRepository;
use App\lesson_23_07_2024\V2\Services\RoleService;
use App\lesson_23_07_2024\V2\Controllers\RoleController;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    private readonly RoleController $roleController;
    private readonly PDODriver $PDODriver;

    public function setUp(): void
    {
        parent::setUp();

        $databaseConfig = require __DIR__ . '/../../../src/lesson_23_07_2024/V2/config/test_database.php';

        $databaseConfiguration = new DatabaseConfiguration(...$databaseConfig);
        $databasePdoConnection = new DatabasePDOConnection($databaseConfiguration);
        $this->PDODriver = new PDODriver($databasePdoConnection);

        $roleCollection = new RoleCollection();
        $roleRepository = new RoleRepository($this->PDODriver);
        $roleService = new RoleService($roleRepository, $roleCollection);
        $this->roleController = new RoleController($roleService);
    }

    public function testCanGetAll(): void
    {
        $result = $this->roleController->index();

        $this->assertInstanceOf(RoleCollection::class, $result);
    }

    public function testCanCreate(): void
    {
        $data = [
            'name' => 'role_name',
        ];

        $result = $this->roleController->store($data);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertSame('role_name', $result->getName());
    }

    public function testCanUpdate(): void
    {
        $role = $this->roleController->store([
            'name' => 'role 1',
        ]);
        $updatedData = [
            'id' => $role->getId(),
            'name' => 'updated role 1',
        ];

        $result = $this->roleController->update($updatedData);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertSame('updated role 1', $result->getName());
    }

    public function testCanGetOne(): void
    {
        $role = $this->roleController->store([
            'name' => 'role 1',
        ]);
        $data = [
            'id' => $role->getId(),
        ];

        $result = $this->roleController->show($data);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertSame('role 1', $result->getName());
    }

    public function testCanDelete(): void
    {
        $role = $this->roleController->store([
            'name' => 'role 1',
        ]);
        $data = [
            'id' => $role->getId(),
        ];

        $result = $this->roleController->delete($data);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $query = 'DELETE FROM roles';

        $sth = $this->PDODriver->prepare($query);
        $sth->execute();
    }

}
