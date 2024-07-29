<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Services;

use App\lesson_23_07_2024\V2\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V2\Dto\UserRolesDto;
use App\lesson_23_07_2024\V2\Models\UserRoles;
use App\lesson_23_07_2024\V2\Repositories\UserRolesRepository;

class UserRolesService
{
    public function __construct(
        private readonly UserRolesRepository $userRolesRepository,
        private readonly UserRolesCollection $userRolesCollection,
    ) {}

    public function getAll(): UserRolesCollection
    {
        $result = $this->userRolesRepository->getAll();

        return $this->userRolesCollection->make($result);
    }

    public function getAllByUserId(int $userId): UserRolesCollection
    {
        $result = $this->userRolesRepository->getAllByUserId($userId);

        return $this->userRolesCollection->make($result);
    }

    public function create(UserRolesDto $userRolesDto): ?UserRoles
    {
        $result = $this->userRolesRepository->create($userRolesDto);

        if ($result === []) {
            return null;
        }

        $userRolesDto = $this->createUserRolesDto($result);

        return UserRoles::writeNewFrom($userRolesDto);
    }

    public function update(UserRolesDto $userRolesDto): ?UserRoles
    {
        $result = $this->userRolesRepository->update($userRolesDto);

        if ($result === null) {
            return null;
        }

        $userRolesDto = $this->createUserRolesDto($result);

        return UserRoles::writeNewFrom($userRolesDto);
    }

    public function delete(UserRolesDto $userRolesDto): bool
    {
        return $this->userRolesRepository->delete($userRolesDto);
    }

    public static function createUserRolesDto(array $data): UserRolesDto
    {
        return new UserRolesDto(
            (int)$data['id'],
            (int)$data['user_id'],
            (int)$data['role_id'],
        );
    }

}
