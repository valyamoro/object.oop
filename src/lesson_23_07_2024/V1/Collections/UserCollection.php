<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Collections;

use App\lesson_23_07_2024\V1\Dto\UserDto;
use App\lesson_23_07_2024\V1\Models\User;
use App\lesson_23_07_2024\V1\Services\RoleService;
use App\lesson_23_07_2024\V1\Services\UserRolesService;
use App\lesson_23_07_2024\V1\Services\UserService;

class UserCollection extends Collection
{
    public function __construct(
        private readonly UserRolesService $userRolesService,
        private readonly RoleService $roleService,
        private readonly RoleCollection $roleCollection,
    ) {}

    public function make(array $data): UserCollection
    {
        $collection = [];

        foreach ($data as $item) {
            $id = $item['id'];
            $login = $item['login'];
            $password = $item['password'];
            $email = $item['email'];
            $userRoles = $this->userRolesService->getAllByUserId($id);

            $roles = $this->roleService->convertUserRolesInRoles($userRoles);

            $userDto = new UserDto(
                $id,
                $login,
                $password,
                $email,
                $roles,
            );
            $user = User::create($userDto);

            $collection[] = $user;
        }

        $this->items = $collection;

        return $this;
    }

}
