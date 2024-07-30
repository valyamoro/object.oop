<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Services;

use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Dto\RoleDto;
use App\lesson_23_07_2024\V2\Models\Role;
use App\lesson_23_07_2024\V2\Repositories\RoleRepository;

class RoleService
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
        private readonly RoleCollection $roleCollection,
    ) {}

    public function getAll(): RoleCollection
    {
        $data = $this->roleRepository->getAll();

        $result = $this->roleCollection->make($data);

        return $result;
    }

    public function getOne(int $id): ?Role
    {
        $data = $this->roleRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $roleDto = $this->createRoleDto($data);

        $result = Role::writeNewFrom($roleDto);

        return $result;
    }

    public function create(RoleDto $roleDto): ?Role
    {
        $data = $this->roleRepository->create($roleDto);

        if ($data === []) {
            return null;
        }

        $roleDto = $this->createRoleDto($data);

        $result = Role::writeNewFrom($roleDto);

        return $result;
    }

    public function update(RoleDto $roleDto): ?Role
    {
        $data = $this->roleRepository->update($roleDto);

        if ($data === []) {
            return null;
        }

        $roleDto = $this->createRoleDto($data);

        $result = Role::writeNewFrom($roleDto);

        return $result;
    }

    public function delete(int $id): bool
    {
        $result = $this->roleRepository->delete($id);

        return $result;
    }

    public static function createRoleDto(array $data): RoleDto
    {
        $result = new RoleDto(
            (int)$data['id'],
            $data['name'],
        );

        return $result;
    }

}
