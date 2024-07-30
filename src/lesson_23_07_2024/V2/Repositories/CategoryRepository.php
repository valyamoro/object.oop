<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Repositories;

use App\lesson_23_07_2024\V2\Dto\CategoryDto;

class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'SELECT * FROM categories';

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();

        return $result ? $result : [];
    }

    public function getOne(int $id): array
    {
        $query = 'SELECT * FROM categories where id=? limit 1';
        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->fetch();

        $result = $result ? $result : [];

        return $result;
    }

    public function create(CategoryDto $categoryDto): array
    {
        $query = 'INSERT INTO categories (name) VALUES (?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $categoryDto->name,
        ]);

        $result = $this->getOne($this->dbh->lastInsertId());

        return $result;
    }

    public function update(CategoryDto $categoryDto): array
    {
        $query = 'UPDATE categories SET name=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $categoryDto->name,
            $categoryDto->id,
        ]);

        $result = $this->getOne($categoryDto->id);

        return $result;
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM categories WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->rowCount();

        return (bool)$result;
    }

}
