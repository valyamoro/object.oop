<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Collections;

use App\lesson_23_07_2024\V2\Models\User;
use App\lesson_23_07_2024\V2\Services\RoleService;
use App\lesson_23_07_2024\V2\Services\UserRolesService;
use App\lesson_23_07_2024\V2\Services\UserService;

class UserCollection extends Collection
{
    public function __construct(
        private readonly UserRolesService $userRolesService,
        private readonly RoleService $roleService,
        private readonly RoleCollection $roleCollection,
    ) {}

    public function get(): array
    {
        return $this->items;
    }

    public function make(array $items): UserCollection
    {
        $result = array_map(function(array $item) {
            $userRoles = $this->userRolesService->getAllByUserId($item['id']);
            $roles = $this->convertUserRolesToRoles($userRoles);

            $userDto = UserService::createUserDto($item, $roles);

            $result = User::writeNewFrom($userDto);

            return $result;
        }, $items);

        $this->items = $result;

        return $this;
    }

    public function convertUserRolesToRoles(UserRolesCollection $userRolesCollection): ?RoleCollection
    {
        $roles = [];

        foreach ($userRolesCollection->get() as $item) {
            $roles[] = $this->roleService->getOne($item->getRoleId());
        }

        $result = $this->roleCollection->set($roles);

        return $result === null ? null : $this->roleCollection;
    }

}
