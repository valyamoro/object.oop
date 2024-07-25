<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V1\Repositories;

use App\lesson_23_07_2024\V1\Models\Article;

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

    public function create(Article $article): int
    {
        $query = 'INSERT INTO articles (id, title, body, category_id, user_id) VALUES (?, ?, ?, ?, ?)';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $article->getId(),
            $article->getTitle(),
            $article->getBody(),
            $article->getCategory()->getId(),
            $article->getUser()->getId(),
        ]);

        return (int)$this->dbh->lastInsertId();
    }

    public function update(int $id, Article $article): array
    {
        $query = 'UPDATE articles SET title=?, body=?, category_id=?, user_id=? WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $article->getTitle(),
            $article->getBody(),
            $article->getCategory()->getId(),
            $article->getUser()->getId(),
            $id,
        ]);

        return $this->getOne($article->getId());
    }

    public function delete(Article $article): bool
    {
        $query = 'DELETE FROM articles WHERE id=?';

        $sth = $this->dbh->prepare($query);
        $sth->execute([
            $article->getId(),
        ]);

        return (bool)$sth->rowCount();
    }

}
