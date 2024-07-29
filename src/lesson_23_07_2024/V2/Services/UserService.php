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
        $result = $this->userRepository->getAll();

        $this->userCollection->make($result);

        return $this->userCollection;
    }

    public function getOne(int $id): ?User
    {
        $userData = $this->userRepository->getOne($id);

        if ($userData === []) {
            return null;
        }

        $userRoles = $this->userRolesService->getAllByUserId($id);

        $roles = $this->userCollection->convertUserRolesToRoles($userRoles);

        $userDto = $this->createUserDto($userData, $roles);

        return User::writeNewFrom($userDto);
    }

    public function create(UserDto $userDto): ?User
    {
        $userData = $this->userRepository->create($userDto);

        if ($userData === []) {
            return null;
        }

        $userId = $userData['id'];
        $userRoles = $this->addUserRoles($userDto->roles, $userId);
        $roleCollection = $this->userCollection->convertUserRolesToRoles($userRoles);

        $userDto = $this->updateUserDto(
            $userDto,
            $userData,
            $roleCollection,
        );

        return User::writeNewFrom($userDto);
    }

    public function update(UserDto $userDto): ?User
    {
        $userRoles = $this->userRolesService->getAllByUserId($userDto->id);

        $result = $this->deleteUserRoles($userRoles);

        $userRoles = $result ? $this->addUserRoles(
            $userDto->roles,
            $userDto->id,
        ) : null;

        $roleCollection = $this->userCollection->convertUserRolesToRoles($userRoles);

        $userData = $this->userRepository->update($userDto);

        if ($userData === []) {
            return null;
        }

        $userDto = $this->updateUserDto(
            $userDto,
            $userData,
            $roleCollection,
        );

        return User::writeNewFrom($userDto);
    }

    public function delete(int $id): bool
    {
        $userRoles = $this->userRolesService->getAllByUserId($id);

        $result = $this->deleteUserRoles($userRoles);

        $result = $result === null ? false : $this->userRepository->delete($id);

        return $result;
    }

    public function updateUserDto(
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
