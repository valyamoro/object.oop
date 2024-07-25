<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Repositories;


use App\lesson_23_07_2024\V1\Models\Role;

class RoleRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'SELECT * FROM roles';

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();

        return $result ? $result : [];
    }

    public function getOne(int $id): array
    {
        $query = 'SELECT * FROM roles where id=? limit 1';
        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->fetch();

        return $result ? $result : [];
    }

    public function create(Role $role): int
    {
        $query = 'INSERT INTO roles (id, name) VALUES (?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $role->getId(),
            $role->getName(),
        ]);

        return (int)$this->dbh->lastInsertId();
    }

    public function update(int $id, Role $role): array
    {
        $query = 'UPDATE roles SET name=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $role->getName(),
            $id,
        ]);

        return $this->getOne($role->getId());
    }

    public function delete(Role $role): bool
    {
        $query = 'DELETE FROM roles WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $role->getId(),
        ]);

        return (bool)$sth->rowCount();
    }

}
