<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\UserCollection;
use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Exceptions\ExceptionController;
use App\lesson_23_07_2024\V2\Models\User;
use App\lesson_23_07_2024\V2\Services\UserService;

class UserController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserRolesCollection $userRolesCollection,
    ) {}

    public function index(): UserCollection
    {
        $result = $this->userService->getAll();

        return $result;
    }

    /**
     * @throws ExceptionController
     */
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

        $userDto = $this->userService->createUserDto(
            array_merge(
                $request,
                ['id' => 0],
            ),
            $userRolesCollection,
        );

        $result = $this->userService->create($userDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка создания пользователя',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
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

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка обновления пользователя',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function show(array $request): User
    {
        $id = (int)$request['id'];

        $result = $this->userService->getOne($id);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка получения пользователя',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        $result = $this->userService->delete($id);

        if ($result === false) {
            throw new ExceptionController(
                'Произошла ошибка удаления пользователя',
                500,
            );
        }

        return $result;
    }

}
