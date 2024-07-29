<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\UserCollection;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Models\User;
use App\lesson_23_07_2024\V2\Models\UserRoles;
use App\lesson_23_07_2024\V2\Services\UserService;

class UserController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserRolesCollection $userRolesCollection,
    ) {}

    public function index(): UserCollection
    {
        return $this->userService->getAll();
    }

    public function store(array $request): ?User
    {
        $roleIds = $request['roles'];

        $roles = array_map(function($roleId) {
            return [
                'id' => 0,
                'user_id' => 0,
                'role_id' => $roleId,
            ];
        }, $roleIds);

        $userRolesCollection = $this->userRolesCollection->make($roles);

        $request['id'] = 0;
        $userDto = $this->userService->createUserDto($request, $userRolesCollection);

        $result = $this->userService->create($userDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function update(array $request): User
    {
        $roleIds = $request['roles'];

        $roles = array_map(function($roleId) {
            return [
                'id' => 0,
                'user_id' => 0,
                'role_id' => $roleId,
            ];
        }, $roleIds);

        $userRolesCollection = $this->userRolesCollection->make($roles);

        $userDto = $this->userService->createUserDto($request, $userRolesCollection);

        $result = $this->userService->update($userDto);

        return $result;
    }

    public function show(array $request): User
    {
        $id = (int)$request['id'];

        $result = $this->userService->getOne($id);

        return $result;
    }

    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        $result = $this->userService->delete($id);

        return $result;
    }

}
