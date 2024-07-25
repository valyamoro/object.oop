<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Collections;

use App\lesson_23_07_2024\V1\Dto\RoleDto;
use App\lesson_23_07_2024\V1\Models\Role;

class RoleCollection extends Collection
{
    public function make(array $data): RoleCollection
    {
        $collection = [];

        foreach ($data as $item) {
            $id = $item['id'];
            $name = $item['name'];

            $roleDto = new RoleDto(
                $id,
                $name,
            );
            $role = Role::create($roleDto);

            $collection[] = $role;
        }

        $this->items = $collection;

        return $this;
    }

}
