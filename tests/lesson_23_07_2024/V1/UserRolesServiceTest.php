<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V1;

use App\lesson_23_07_2024\V1\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V1\Dto\UserRolesDto;
use App\lesson_23_07_2024\V1\Models\UserRoles;
use App\lesson_23_07_2024\V1\Repositories\UserRolesRepository;
use App\lesson_23_07_2024\V1\Services\UserRolesService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class UserRolesServiceTest extends TestCase
{
    private UserRolesRepository $userRolesRepository;
    private UserRolesService $userRolesService;
    private UserRoles $userRoles;
    private UserRolesDto $userRolesDto;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRolesRepository = $this->createMock(UserRolesRepository::class);
        $this->userRolesService = new UserRolesService($this->userRolesRepository, $this->createMock(UserRolesCollection::class));
        $this->userRolesDto = new UserRolesDto(1, 1, 1);
        $this->userRoles = UserRoles::create($this->userRolesDto);
    }

    public function testGetAll(): void
    {
        $userRoles = [['id' => 1, 'user_id' => 1, 'role_id' => 1], ['id' => 2, 'user_id' => 2, 'role_id' => 2]];
        $this->userRolesRepository->method('getAll')->willReturn($userRoles);

        $result = $this->userRolesService->getAll();

        $this->assertInstanceOf(UserRolesCollection::class, $result);
    }

    public function testGetOne(): void
    {
        $userRolesData = ['id' => 1, 'user_id' => 1, 'role_id' => 1];
        $this->userRolesRepository->method('getOne')->with(1)->willReturn($userRolesData);

        $result = $this->userRolesService->getOne(1);

        $this->assertInstanceOf(UserRoles::class, $result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals(1, $result->getUserId());
        $this->assertEquals(1, $result->getRoleId());
    }

    public function testGetOneWithInvalidId(): void
    {
        $id = 999;
        $this->userRolesRepository->method('getOne')->with($id)->willReturn([]);

        $result = $this->userRolesService->getOne($id);

        $this->assertNull($result);
    }

    public function testCreate(): void
    {
        $this->userRolesRepository->method('create')->with($this->userRoles)->willReturn(1);

        $result = $this->userRolesService->create($this->userRolesDto);

        $this->assertInstanceOf(UserRoles::class, $result);
        $this->assertSame($this->userRoles->getId(), $result->getId());
        $this->assertSame($this->userRoles->getUserId(), $result->getUserId());
        $this->assertSame($this->userRoles->getRoleId(), $result->getRoleId());
    }

    public function testCreateWithFailedRepository(): void
    {
        $this->userRolesRepository->method('create')->with($this->userRoles)->willReturn(0);

        $result = $this->userRolesService->create($this->userRolesDto);

        $this->assertNull($result);
    }

    public function testUpdate(): void
    {
        $data = [
            'id' => $this->userRoles->getId(),
            'user_id' => $this->userRoles->getUserId(),
            'role_id' => $this->userRoles->getRoleId(),
        ];

        $this->userRolesRepository->method('update')->with(1, $this->userRoles)->willReturn($data);
        $result = $this->userRolesService->update(1, $this->userRolesDto);

        $this->assertInstanceOf(UserRoles::class, $result);
        $this->assertSame($this->userRoles->getId(), $result->getId());
        $this->assertSame($this->userRoles->getUserId(), $result->getUserId());
        $this->assertSame($this->userRoles->getRoleId(), $result->getRoleId());
    }

    public function testUpdateWithInvalidId(): void
    {
        $this->userRolesRepository->method('update')->with(999, $this->userRoles)->willReturn([]);

        $result = $this->userRolesService->update(999, $this->userRolesDto);

        $this->assertNull($result);
    }

    public function testDelete(): void
    {
        $this->userRolesRepository->method('delete')->with($this->userRoles)->willReturn(true);

        $result = $this->userRolesService->delete($this->userRolesDto);

        $this->assertInstanceOf(UserRoles::class, $result);
        $this->assertSame($this->userRoles->getId(), $result->getId());
        $this->assertSame($this->userRoles->getUserId(), $result->getUserId());
        $this->assertSame($this->userRoles->getRoleId(), $result->getRoleId());
    }

    public function testDeleteWithFailedRepository(): void
    {
        $this->userRolesRepository->method('delete')->with($this->userRoles)->willReturn(false);

        $result = $this->userRolesService->delete($this->userRolesDto);

        $this->assertNull($result);
    }

}
