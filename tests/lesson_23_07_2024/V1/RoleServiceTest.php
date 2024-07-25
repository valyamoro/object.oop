<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V1;

use App\lesson_23_07_2024\V1\Collections\RoleCollection;
use App\lesson_23_07_2024\V1\Dto\RoleDto;
use App\lesson_23_07_2024\V1\Models\Role;
use App\lesson_23_07_2024\V1\Repositories\RoleRepository;
use App\lesson_23_07_2024\V1\Services\RoleService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class RoleServiceTest extends TestCase
{
    private RoleRepository $roleRepository;
    private RoleService $roleService;
    private RoleDto $roleDto;
    private Role $role;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->roleRepository = $this->createMock(RoleRepository::class);
        $this->roleService = new RoleService($this->roleRepository, $this->createMock(RoleCollection::class));
        $this->roleDto = new RoleDto(1, 'Admin');
        $this->role = Role::create($this->roleDto);
    }

    public function testGetAll(): void
    {
        $roles = [['id' => 1, 'name' => 'Admin'], ['id' => 2, 'name' => 'User']];
        $this->roleRepository->method('getAll')->willReturn($roles);

        $result = $this->roleService->getAll();

        $this->assertInstanceOf(RoleCollection::class, $result);
    }

    public function testGetOne(): void
    {
        $roleData = ['id' => 1, 'name' => 'Admin'];
        $this->roleRepository->method('getOne')->with(1)->willReturn($roleData);

        $result = $this->roleService->getOne(1);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals('Admin', $result->getName());
    }

    public function testGetOneWithInvalidId(): void
    {
        $id = 999;
        $this->roleRepository->method('getOne')->with($id)->willReturn([]);

        $result = $this->roleService->getOne($id);

        $this->assertNull($result);
    }

    public function testCreate(): void
    {
        $this->roleRepository->method('create')->with($this->role)->willReturn(1);

        $result = $this->roleService->create($this->roleDto);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertSame($this->role->getId(), $result->getId());
        $this->assertSame($this->role->getName(), $result->getName());
    }

    public function testCreateWithFailedRepository(): void
    {
        $this->roleRepository->method('create')->with($this->role)->willReturn(0);

        $result = $this->roleService->create($this->roleDto);

        $this->assertNull($result);
    }

    public function testUpdate(): void
    {
        $data = [
            'id' => $this->role->getId(),
            'name' => $this->role->getName(),
        ];
        $this->roleRepository->method('update')->with(1, $this->role)->willReturn($data);

        $result = $this->roleService->update(1, $this->roleDto);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertSame($this->role->getId(), $result->getId());
        $this->assertSame($this->role->getName(), $result->getName());
    }

    public function testUpdateWithInvalidId(): void
    {
        $this->roleRepository->method('update')->with(999, $this->role)->willReturn([]);

        $result = $this->roleService->update(999, $this->roleDto);

        $this->assertNull($result);
    }

    public function testDelete(): void
    {
        $this->roleRepository->method('delete')->with($this->role)->willReturn(true);

        $result = $this->roleService->delete($this->roleDto);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertSame($this->role->getId(), $result->getId());
        $this->assertSame($this->role->getName(), $result->getName());
    }

    public function testDeleteWithFailedRepository(): void
    {
        $this->roleRepository->method('delete')->with($this->role)->willReturn(false);

        $result = $this->roleService->delete($this->roleDto);

        $this->assertNull($result);
    }

}
