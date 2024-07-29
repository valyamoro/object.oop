<?php

namespace App\lesson_23_07_2024\V2\Collections;

use App\lesson_23_07_2024\V2\Dto\RoleDto;
use App\lesson_23_07_2024\V2\Models\Role;
use App\lesson_23_07_2024\V2\Services\RoleService;

class RoleCollection extends Collection
{
    public function get(): array
    {
        return $this->items;
    }

    public function make(array $items): RoleCollection
    {
        $result = array_map(function(array $item) {
            $roleDto = RoleService::createRoleDto($item);

            return Role::writeNewFrom($roleDto);
        }, $items);

        $this->set($result);

        return $this;
    }


    public function set(array $items): RoleCollection
    {
        $this->items = $items;

        return $this;
    }

}
