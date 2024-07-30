<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Repositories;


use App\lesson_23_07_2024\V2\Dto\RoleDto;

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

    public function create(RoleDto $roleDto): array
    {
        $query = 'INSERT INTO roles (name) VALUES (?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $roleDto->name,
        ]);

        $result = $this->getOne($this->dbh->lastInsertId());

        return $result;
    }

    public function update(RoleDto $roleDto): array
    {
        $query = 'UPDATE roles SET name=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $roleDto->name,
            $roleDto->id,
        ]);

        $result = $this->getOne($roleDto->id);

        return $result;
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM roles WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->rowCount();

        return (bool)$result;
    }

}
