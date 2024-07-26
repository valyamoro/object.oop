<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Services;

use App\lesson_23_07_2024\V1\Collections\RoleCollection;
use App\lesson_23_07_2024\V1\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V1\Dto\RoleDto;
use App\lesson_23_07_2024\V1\Models\Role;
use App\lesson_23_07_2024\V1\Repositories\RoleRepository;

final class RoleService
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
        private readonly RoleCollection $roleCollection,
    ) {}

    public function getAll(): RoleCollection
    {
        $roles = $this->roleRepository->getAll();

        return $this->roleCollection->make($roles);
    }

    public function getOne(int $id): ?Role
    {
        $data = $this->roleRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $roleDto = new RoleDto(
            $data['id'],
            $data['name'],
        );

        return Role::create($roleDto);
    }

    public function create(RoleDto $roleDto): ?Role
    {
        $role = Role::create($roleDto);

        $result = $this->roleRepository->create($role);

        return $result === 0 ? null : $role;
    }

    public function update(int $id ,RoleDto $roleDto): ?Role
    {
        $role = Role::create($roleDto);

        $result = $this->roleRepository->update($id, $role);

        return $result === [] ? null : $role;
    }

    public function delete(RoleDto $roleDto): ?Role
    {
        $role = Role::create($roleDto);

        $result = $this->roleRepository->delete($role);

        return $result === false ? null : $role;
    }


    public function convertUserRolesInRoles(UserRolesCollection $userRolesCollection): RoleCollection
    {
        $rolesData = [];

        foreach ($userRolesCollection as $item) {
            $rolesData[] = $this->getOne($item->getId());
        }

        return $this->roleCollection->make($rolesData);
    }

}
