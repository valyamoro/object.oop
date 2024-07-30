<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Controllers;

use App\lesson_23_07_2024\V2\Collections\RoleCollection;
use App\lesson_23_07_2024\V2\Exceptions\ExceptionController;
use App\lesson_23_07_2024\V2\Models\Role;
use App\lesson_23_07_2024\V2\Services\RoleService;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    public function index(): RoleCollection
    {
        $result = $this->roleService->getAll();

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function store(array $request): ?Role
    {
        $roleDto = $this->roleService->createRoleDto(array_merge(
            $request,
            ['id' => 0],
        ));

        $result = $this->roleService->create($roleDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка создания роли',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function update(array $request): ?Role
    {
        $roleDto = $this->roleService->createRoleDto($request);

        $result = $this->roleService->update($roleDto);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка обновления роли',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function show(array $request): ?Role
    {
        $id = (int)$request['id'];

        $result = $this->roleService->getOne($id);

        if ($result === null) {
            throw new ExceptionController(
                'Произошла ошибка получения роли',
                500,
            );
        }

        return $result;
    }

    /**
     * @throws ExceptionController
     */
    public function delete(array $request): bool
    {
        $id = (int)$request['id'];

        $result = $this->roleService->delete($id);

        if ($result === false) {
            throw new ExceptionController(
                'Произошла ошибка удаления роли',
                500,
            );
        }

        return $result;
    }

}
