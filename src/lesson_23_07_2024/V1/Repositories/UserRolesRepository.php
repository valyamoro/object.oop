<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Repositories;

use App\lesson_23_07_2024\V1\Models\UserRoles;

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

    public function create(UserRoles $userRoles): int
    {
        $query = 'INSERT INTO user_roles (id, user_id, role_id) VALUES (?, ?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userRoles->getId(),
            $userRoles->getUserId(),
            $userRoles->getRoleId(),
        ]);

        return (int)$this->dbh->lastInsertId();
    }

    public function update(int $id, UserRoles $userRoles): array
    {
        $query = 'UPDATE user_roles SET user_id=?, role_id=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userRoles->getUserId(),
            $userRoles->getRoleId(),
            $id,
        ]);

        return $this->getOne($userRoles->getId());
    }

    public function delete(UserRoles $userRoles): bool
    {
        $query = 'DELETE FROM user_roles WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userRoles->getId(),
        ]);

        return (bool)$sth->rowCount();
    }

}
