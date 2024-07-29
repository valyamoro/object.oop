<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Repositories;

use App\lesson_23_07_2024\V2\Dto\UserDto;
use App\lesson_23_07_2024\V2\Models\User;

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

    public function create(UserDto $userDto): array
    {
        $query = 'INSERT INTO users (login, password, email) VALUES (?, ?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userDto->login,
            $userDto->password,
            $userDto->email,
        ]);

        return $this->getOne($this->dbh->lastInsertId());
    }

    public function update(UserDto $userDto): array
    {
        $query = 'UPDATE users SET login=?, password=?, email=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $userDto->login,
            $userDto->password,
            $userDto->email,
            $userDto->id,
        ]);

        return $this->getOne($userDto->id);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM users WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        return (bool)$sth->rowCount();
    }

}
