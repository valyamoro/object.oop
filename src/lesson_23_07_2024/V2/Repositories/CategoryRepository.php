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

        return $result ? $result : [];
    }

    public function create(CategoryDto $categoryDto): array
    {
        $query = 'INSERT INTO categories (name) VALUES (?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $categoryDto->name,
        ]);

        return $this->getOne($this->dbh->lastInsertId());
    }

    public function update(CategoryDto $categoryDto): array
    {
        $query = 'UPDATE categories SET name=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $categoryDto->name,
            $categoryDto->id,
        ]);

        return $this->getOne($categoryDto->id);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM categories WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        return (bool)$sth->rowCount();
    }
}
