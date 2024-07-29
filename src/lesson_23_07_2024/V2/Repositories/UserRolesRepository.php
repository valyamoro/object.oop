<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Repositories;

use App\lesson_23_07_2024\V2\Dto\UserRolesDto;
use App\lesson_23_07_2024\V2\Models\UserRoles;

class UserRolesRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'SELECT * FROM user_roles';

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();

        return $result ? $result : [];
    }

    public function getAllByUserId(int $userId): array
    {
        $query = 'SELECT * FROM user_roles WHERE user_id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([$userId]);
        $result = $sth->fetchAll();

        return $result ? $result : [];
    }

    public function getOne(int $id): array
    {
        $query = 'SELECT * FROM user_roles where id=? limit 1';
        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->fetch();

        return $result ? $result : [];
    }

    public function create(UserRolesDto $userRolesDto): array
    {
        $query = 'INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userRolesDto->userId,
            $userRolesDto->roleId,
        ]);

        return $this->getOne($this->dbh->lastInsertId());
    }

    public function update(int $id, UserRolesDto $userRolesDto): array
    {
        $query = 'UPDATE user_roles SET user_id=?, role_id=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userRolesDto->userId,
            $userRolesDto->roleId,
            $id,
        ]);

        return $this->getOne($userRolesDto->id);
    }

    public function delete(UserRolesDto $userRolesDto): bool
    {
        $query = 'DELETE FROM user_roles WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userRolesDto->id,
        ]);

        return (bool)$sth->rowCount();
    }

}
