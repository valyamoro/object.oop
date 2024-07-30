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
        $data = $this->userRolesRepository->getAll();

        $result = $this->userRolesCollection->make($data);

        return $result;
    }

    public function getAllByUserId(int $userId): UserRolesCollection
    {
        $data = $this->userRolesRepository->getAllByUserId($userId);

        $result = $this->userRolesCollection->make($data);

        return $result;
    }

    public function create(UserRolesDto $userRolesDto): ?UserRoles
    {
        $data = $this->userRolesRepository->create($userRolesDto);

        if ($data === []) {
            return null;
        }

        $userRolesDto = $this->createUserRolesDto($data);

        $result = UserRoles::writeNewFrom($userRolesDto);

        return $result;
    }

    public function delete(UserRolesDto $userRolesDto): bool
    {
        $result = $this->userRolesRepository->delete($userRolesDto);

        return $result;
    }

    public static function createUserRolesDto(array $data): UserRolesDto
    {
        $result = new UserRolesDto(
            (int)$data['id'],
            (int)$data['user_id'],
            (int)$data['role_id'],
        );

        return $result;
    }

}
