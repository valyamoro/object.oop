<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Services;

use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Collections\UserCollection;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Dto\UserDto;
use App\lesson_23_07_2024\V2\Dto\UserRolesDto;
use App\lesson_23_07_2024\V2\Models\User;
use App\lesson_23_07_2024\V2\Repositories\UserRepository;
use lesson20_07_2024\V1\RoleTest;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserRolesService $userRolesService,
        private readonly UserCollection $userCollection,
    ) {}

    public function getAll(): ?UserCollection
    {
        $data = $this->userRepository->getAll();

        $result = $this->userCollection->make($data);

        return $result;
    }

    public function getOne(int $id): ?User
    {
        $data = $this->userRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $userRoles = $this->userRolesService->getAllByUserId($id);

        $roles = $this->userCollection->convertUserRolesToRoles($userRoles);

        $userDto = $this->createUserDto($data, $roles);

        $result = User::writeNewFrom($userDto);

        return $result;
    }

    public function create(UserDto $userDto): ?User
    {
        $data = $this->userRepository->create($userDto);

        if ($data === []) {
            return null;
        }

        $userId = $data['id'];
        $userRoles = $this->addUserRoles(
            $userDto->roles,
            $userId,
        );
        $roleCollection = $this->userCollection->convertUserRolesToRoles($userRoles);

        $userDto = static::createUserDto(
            $data,
            $roleCollection,
        );

        $result = User::writeNewFrom($userDto);

        return $result;
    }

    public function update(UserDto $userDto): ?User
    {
        $userRoles = $this->userRolesService->getAllByUserId($userDto->id);

        if ($this->deleteUserRoles($userRoles) === null) {
            return null;
        }

        $userRoles = $this->addUserRoles(
            $userDto->roles,
            $userDto->id,
        );
        $roleCollection = $this->userCollection->convertUserRolesToRoles($userRoles);

        $data = $this->userRepository->update($userDto);

        if ($data === []) {
            return null;
        }

        $userDto = static::createUserDto(
            $data,
            $roleCollection,
        );

        $result = User::writeNewFrom($userDto);

        return $result;
    }

    public function delete(int $id): bool
    {
        $userRoles = $this->userRolesService->getAllByUserId($id);

        if ($this->deleteUserRoles($userRoles) === null) {
            return false;
        }

        $result = $this->userRepository->delete($id);

        return $result;
    }

    private function updateUserDto(
        UserDto $userDto,
        array $data,
        RoleCollection $roleCollection,
    ): UserDto
    {
        $userDto->id = $data['id'];
        $userDto->login = $data['login'];
        $userDto->password = $data['password'];
        $userDto->email = $data['email'];
        $userDto->roles = $roleCollection;

        return $userDto;
    }

    public static function createUserDto(
        array $userData,
        UserRolesCollection|RoleCollection $roleCollection,
    ): UserDto
    {
        return new UserDto(
            (int)$userData['id'],
            $userData['login'],
            $userData['password'],
            $userData['email'],
            $roleCollection,
        );
    }

    private function deleteUserRoles(UserRolesCollection $userRolesCollection): ?UserRolesCollection
    {
        foreach ($userRolesCollection->get() as $userRole) {
            $userRoleDto = new UserRolesDto(
                $userRole->getId(),
                $userRole->getUserId(),
                $userRole->getRoleId(),
            );

            $result = $this->userRolesService->delete($userRoleDto);

            if ($result === false) {
                return null;
            }
        }

        return $userRolesCollection;
    }

    private function addUserRoles(
        UserRolesCollection $userRolesCollection,
        int $userId,
    ): ?UserRolesCollection
    {
        foreach ($userRolesCollection->get() as $userRole) {
            $userRoleDto = new UserRolesDto(
                $userRole->getId(),
                $userId,
                $userRole->getRoleId(),
            );

            $result = $this->userRolesService->create($userRoleDto);

            if ($result === null) {
                return null;
            }
        }

        return $userRolesCollection;
    }

}
