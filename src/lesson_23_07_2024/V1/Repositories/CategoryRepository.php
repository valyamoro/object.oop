<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Repositories;

use App\lesson_23_07_2024\V1\Models\Category;

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

    public function create(Category $category): int
    {
        $query = 'INSERT INTO categories (id, name) VALUES (?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $category->getId(),
            $category->getName(),
        ]);

        return (int)$this->dbh->lastInsertId();
    }

    public function update(int $id, Category $category): array
    {
        $query = 'UPDATE categories SET name=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $category->getName(),
            $id,
        ]);

        return $this->getOne($category->getId());
    }

    public function delete(Category $category): bool
    {
        $query = 'DELETE FROM categories WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $category->getId(),
        ]);

        return (bool)$sth->rowCount();
    }
}
