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
        $result = $this->roleRepository->getAll();

        return $this->roleCollection->make($result);
    }

    public function getOne(int $id): ?Role
    {
        $result = $this->roleRepository->getOne($id);

        if ($result === []) {
            return null;
        }

        $roleDto = $this->createRoleDto($result);

        return Role::writeNewFrom($roleDto);
    }

    public function create(RoleDto $roleDto): ?Role
    {
        $result = $this->roleRepository->create($roleDto);

        if ($result === []) {
            return null;
        }

        $roleDto = $this->createRoleDto($result);

        return Role::writeNewFrom($roleDto);
    }

    public function update(RoleDto $roleDto): ?Role
    {
        $result = $this->roleRepository->update($roleDto);

        if ($result === []) {
            return null;
        }

        $roleDto = $this->createRoleDto($result);

        return Role::writeNewFrom($roleDto);
    }

    public function delete(int $id): bool
    {
        return $this->roleRepository->delete($id);
    }

    public static function createRoleDto(array $data): RoleDto
    {
        return new RoleDto(
            (int)$data['id'],
            $data['name'],
        );
    }

}
