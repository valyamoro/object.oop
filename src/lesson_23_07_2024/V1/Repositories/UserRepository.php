<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Repositories;

use App\lesson_23_07_2024\V1\Models\User;

class UserRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'SELECT * FROM users';

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();

        return $result ? $result : [];
    }

    public function getOne(int $id): array
    {
        $query = 'SELECT * FROM users where id=? limit 1';
        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->fetch();

        return $result ? $result : [];
    }

    public function create(User $user): int
    {
        $query = 'INSERT INTO users (id, login, password, email) VALUES (?, ?, ?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $user->getId(),
            $user->getLogin(),
            $user->getPassword(),
            $user->getEmail(),
        ]);

        return (int)$this->dbh->lastInsertId();
    }

    public function update(int $id, User $user): array
    {
        $query = 'UPDATE users SET login=?, password=?, email=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $user->getLogin(),
            $user->getPassword(),
            $user->getEmail(),
            $id,
        ]);

        return $this->getOne($user->getId());
    }

    public function delete(User $user): bool
    {
        $query = 'DELETE FROM users WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $user->getId(),
        ]);

        return (bool)$sth->rowCount();
    }

}
