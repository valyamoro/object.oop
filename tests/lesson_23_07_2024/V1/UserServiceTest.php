<?php
declare(strict_types=1);

namespace lesson_23_07_2024\V1;

use App\lesson_23_07_2024\V1\Collections\RoleCollection;
use App\lesson_23_07_2024\V1\Collections\UserCollection;
use App\lesson_23_07_2024\V1\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V1\Dto\UserDto;
use App\lesson_23_07_2024\V1\Models\User;
use App\lesson_23_07_2024\V1\Repositories\RoleRepository;
use App\lesson_23_07_2024\V1\Repositories\UserRepository;
use App\lesson_23_07_2024\V1\Repositories\UserRolesRepository;
use App\lesson_23_07_2024\V1\Services\RoleService;
use App\lesson_23_07_2024\V1\Services\UserRolesService;
use App\lesson_23_07_2024\V1\Services\UserService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserRepository $userRepository;
    private UserService $userService;
    private RoleCollection $roleCollection;
    private UserDto $userDto;
    private User $user;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->roleCollection = $this->createMock(RoleCollection::class);
        $userRolesService = new UserRolesService(
            $this->createMock(UserRolesRepository::class),
            $this->createMock(UserRolesCollection::class),
        );
        $roleService = new RoleService(
            $this->createMock(RoleRepository::class),
            $this->createMock(RoleCollection::class),
        );
        $this->userService = new UserService(
            $this->userRepository,
            $userRolesService,
            $roleService,
            $this->createMock(UserCollection::class),
            $this->createMock(RoleCollection::class),
        );

        $roles = $this->roleCollection->make([['id' => 1, 'name' => 'user'], ['id' => 2, 'name' => 'moderator']]);
        $this->userDto = new UserDto(1, 'user_1', '123456j', 'user_1@gmail.com', $roles);
        $this->user = User::create($this->userDto);
    }

    public function testGetAll(): void
    {
        $roles = $this->roleCollection->make([['id' => 1, 'name' => 'user'], ['id' => 2, 'name' => 'moderator']]);
        $users = [
            ['id' => 1, 'login' => 'user_1', 'password' => '123456j', 'email' => 'user_1@gmail.com', 'roles' => $roles],
            ['id' => 2, 'login' => 'user_2', 'password' => '123456j', 'email' => 'user_2@gmail.com', 'roles' => $roles],
        ];
        $this->userRepository->method('getAll')->willReturn($users);

        $result = $this->userService->getAll();

        $this->assertInstanceOf(UserCollection::class, $result);
    }

    public function testGetOneWithInvalidId(): void
    {
        $id = 999;
        $this->userRepository->method('getOne')->with($id)->willReturn([]);

        $result = $this->userService->getOne($id);

        $this->assertNull($result);
    }

    public function testCreate(): void
    {
        $this->userRepository->method('create')->with($this->user)->willReturn(1);

        $result = $this->userService->create($this->userDto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($this->user->getId(), $result->getId());
        $this->assertSame($this->user->getLogin(), $result->getLogin());
        $this->assertSame($this->user->getPassword(), $result->getPassword());
        $this->assertSame($this->user->getEmail(), $result->getEmail());
        $this->assertSame($this->user->getRoles(), $result->getRoles());
    }

    public function testCreateWithFailedRepository(): void
    {
        $this->userRepository->method('create')->with($this->user)->willReturn(0);

        $result = $this->userService->create($this->userDto);

        $this->assertNull($result);
    }

    public function testUpdate(): void
    {
        $data = [
            'id' => $this->user->getId(),
            'login' => $this->user->getLogin(),
            'password' => $this->user->getPassword(),
            'email' => $this->user->getEmail(),
            'roles' => $this->user->getRoles(),
        ];
        $this->userRepository->method('update')->with(1, $this->user)->willReturn($data);

        $result = $this->userService->update(1, $this->userDto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($this->user->getId(), $result->getId());
        $this->assertSame( $this->user->getLogin(), $result->getLogin());
        $this->assertSame($this->user->getPassword(), $result->getPassword());
        $this->assertSame($this->user->getEmail(), $result->getEmail());
        $this->assertSame($this->user->getRoles(), $result->getRoles());
    }

    public function testUpdateWithInvalidId(): void
    {
        $roles = $this->roleCollection->make([['id' => 1, 'name' => 'user'], ['id' => 2, 'name' => 'moderator']]);
        $userDto = new UserDto(1, 'user_1', '123456j', 'user_1@gmail.com', $roles);
        $user = User::create($userDto);
        $this->userRepository->method('update')->with(999, $user)->willReturn([]);

        $result = $this->userService->update(999, $userDto);

        $this->assertNull($result);
    }

    public function testDelete(): void
    {
        $this->userRepository->method('delete')->with($this->user)->willReturn(true);

        $result = $this->userService->delete($this->userDto);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($this->user->getId(), $result->getId());
        $this->assertSame($this->user->getLogin(), $result->getLogin());
        $this->assertSame($this->user->getPassword(), $result->getPassword());
        $this->assertSame($this->user->getEmail(), $result->getEmail());
        $this->assertSame($this->user->getRoles(), $result->getRoles());
    }

    public function testDeleteWithFailedRepository(): void
    {
        $this->userRepository->method('delete')->with($this->user)->willReturn(false);

        $result = $this->userService->delete($this->userDto);

        $this->assertNull($result);
    }

}
