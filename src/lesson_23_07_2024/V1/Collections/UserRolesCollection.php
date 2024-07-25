<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Collections;

use App\lesson_23_07_2024\V1\Dto\UserRolesDto;
use App\lesson_23_07_2024\V1\Models\UserRoles;

class UserRolesCollection extends Collection
{

    public function make(array $data): UserRolesCollection
    {
        $collection = [];

        foreach ($data as $item) {
            $id = $item['id'];
            $userId = $item['user_id'];
            $roleId = $item['role_id'];

            $roleDto = new UserRolesDto(
                $id,
                $userId,
                $roleId,
            );

            $userRoles = UserRoles::create($roleDto);

            $collection[] = $userRoles;
        }

        $this->items = $collection;

        return $this;
    }

}
