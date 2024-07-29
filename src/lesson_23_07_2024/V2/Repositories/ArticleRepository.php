<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Repositories;

use App\lesson_23_07_2024\V2\Dto\ArticleDto;

class ArticleRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = 'SELECT * FROM articles';

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();

        return $result ? $result : [];
    }

    public function getOne(int $id): array
    {
        $query = 'SELECT * FROM articles where id=? limit 1';
        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        $result = $sth->fetch();

        return $result ? $result : [];
    }

    public function create(ArticleDto $articleDto): array
    {
        $query = 'INSERT INTO articles (title, body, category_id, user_id) VALUES (?, ?, ?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $articleDto->title,
            $articleDto->body,
            $articleDto->category->getId(),
            $articleDto->user->getId(),
        ]);

        return $this->getOne($this->dbh->lastInsertId());
    }

    public function update(ArticleDto $articleDto): array
    {
        $query = 'UPDATE articles SET title=?, body=?, category_id=?, user_id=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $articleDto->title,
            $articleDto->body,
            $articleDto->category->getId(),
            $articleDto->user->getId(),
            $articleDto->id,
        ]);

        return $this->getOne($articleDto->id);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM articles WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([$id]);

        return (bool)$sth->rowCount();
    }

}
