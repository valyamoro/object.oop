<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Models\Role;
use App\lesson_23_07_2024\V2\Services\RoleService;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    public function index(): RoleCollection
    {
        return $this->roleService->getAll();
    }

    public function store(array $request): ?Role
    {
        $request['id'] = 0;
        $roleDto = $this->roleService->createRoleDto($request);

        $result = $this->roleService->create($roleDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function update(array $request): ?Role
    {
        $roleDto = $this->roleService->createRoleDto($request);

        $result = $this->roleService->update($roleDto);

        if ($result === null) {
            return null;
        }

        return $result;
    }

    public function show(array $request): ?Role
    {
        $id = (int)$request['id'];

        return $this->roleService->getOne($id);
    }

    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        return $this->roleService->delete($id);
    }

}
