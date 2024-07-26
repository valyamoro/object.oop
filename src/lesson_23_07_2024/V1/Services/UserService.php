<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Services;

use App\lesson_23_07_2024\V1\Collections\UserCollection;
use App\lesson_23_07_2024\V1\Dto\UserDto;
use App\lesson_23_07_2024\V1\Models\User;
use App\lesson_23_07_2024\V1\Repositories\UserRepository;

final class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserRolesService $userRolesService,
        private readonly RoleService $roleService,
        private readonly UserCollection $userCollection,
    ) {}

    public function getAll(): UserCollection
    {
        $users = $this->userRepository->getAll();

        return $this->userCollection->make($users);
    }

    public function getOne(int $id): ?User
    {
        $data = $this->userRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $userRoles = $this->userRolesService->getAllByUserId($data['id']);

        $roles = $this->roleService->convertUserRolesInRoles($userRoles);

        $userDto = new UserDto(
            $data['id'],
            $data['login'],
            $data['password'],
            $data['email'],
            $roles,
        );

        return User::create($userDto);
    }

    public function create(UserDto $userDto): ?User
    {
        $user = User::create($userDto);

        $result = $this->userRepository->create($user);

        return $result === 0 ? null : $user;
    }

    public function update(int $id, UserDto $userDto): ?User
    {
        $user = User::create($userDto);

        $result = $this->userRepository->update($id, $user);

        return $result === [] ? null : $user;
    }

    public function delete(UserDto $userDto): ?User
    {
        $user = User::create($userDto);

        $result = $this->userRepository->delete($user);

        return $result === false ? null : $user;
    }

}
