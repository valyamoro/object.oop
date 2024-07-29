<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Collections;

use App\lesson_23_07_2024\V2\Dto\UserRolesDto;
use App\lesson_23_07_2024\V2\Models\UserRoles;
use App\lesson_23_07_2024\V2\Services\UserRolesService;

class UserRolesCollection extends Collection
{
    public function get(): array
    {
        return $this->items;
    }

    public function make(array $items): ?UserRolesCollection
    {
        $result = array_map(function(array $item) {
            $userRolesDto = UserRolesService::createUserRolesDto($item);

            return UserRoles::writeNewFrom($userRolesDto);
        }, $items);

        $this->set($result);

        return $result ? $this : null;
    }

    public function set(array $items): UserRolesCollection
    {
        $this->items = $items;

        return $this;
    }

}
