<?php

namespace App\lesson_23_07_2024\V2\Collections;

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

            $result = Role::writeNewFrom($roleDto);

            return $result;
        }, $items);

        $this->items = $result;

        return $this;
    }


    public function set(array $items): ?RoleCollection
    {
        $isCorrectCollection = true;

        foreach ($items as $item) {
            if (($item instanceof Role) === false) {
                $isCorrectCollection = false;
                break;
            }
        }

        if ($isCorrectCollection) {
            $this->items = $items;

            $result = $this;
        } else {
            $result = null;
        }

        return $result;
    }

}
