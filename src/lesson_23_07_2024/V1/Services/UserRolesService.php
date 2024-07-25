<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Services;

use App\lesson_23_07_2024\V1\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V1\Dto\UserRolesDto;
use App\lesson_23_07_2024\V1\Models\UserRoles;
use App\lesson_23_07_2024\V1\Repositories\UserRolesRepository;

final class UserRolesService
{
    public function __construct(
        private readonly UserRolesRepository $userRolesRepository,
        private readonly UserRolesCollection $userRolesCollection,
    ) {}

    public function getAll(): UserRolesCollection
    {
        $userRoles = $this->userRolesRepository->getAll();

        return $this->userRolesCollection->make($userRoles);
    }

    public function getAllByUserId(int $id): UserRolesCollection
    {
        $userRoles = $this->userRolesRepository->getAllByUserId($id);

        return $this->userRolesCollection->make($userRoles);
    }

    public function getOne(int $id): ?UserRoles
    {
        $data = $this->userRolesRepository->getOne($id);

        if ($data === []) {
            return null;
        }

        $userRolesDto = new UserRolesDto(
            $data['id'],
            $data['user_id'],
            $data['role_id'],
        );

        return UserRoles::create($userRolesDto);
    }

    public function create(UserRolesDto $userRolesDto): ?UserRoles
    {
        $userRoles = UserRoles::create($userRolesDto);

        $result = $this->userRolesRepository->create($userRoles);

        return $result === 0 ? null : $userRoles;
    }

    public function update(int $id, UserRolesDto $userRolesDto): ?UserRoles
    {
        $userRoles = UserRoles::create($userRolesDto);

        $result = $this->userRolesRepository->update($id, $userRoles);

        return $result === [] ? null : $userRoles;
    }

    public function delete(UserRolesDto $userRolesDto): ?UserRoles
    {
        $userRoles = UserRoles::create($userRolesDto);

        $result = $this->userRolesRepository->delete($userRoles);

        return $result === false ? null : $userRoles;
    }

}
