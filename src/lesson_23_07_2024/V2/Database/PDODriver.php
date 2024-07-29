<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Database;

class PDODriver
{
    private \PDO $dbh;
    private ?\PDOStatement $sth;

    public function __construct(private readonly DatabaseConnection $databaseConnection)
    {
        $this->dbh = $this->databaseConnection->connection();
    }

    public function prepare(string $query): self
    {
        $this->sth = $this->dbh->prepare($query);

        return $this;
    }

    public function execute(array $binds = []): self
    {
        $this->sth->execute($binds);

        return $this;
    }

    public function fetch(): array
    {
        $result = $this->sth->fetch();
        $this->sth = null;

        return $result !== false ? $result : [];
    }

    public function fetchAll(): array
    {
        $result = $this->sth->fetchAll();
        $this->sth = null;

        return $result !== false ? $result : [];
    }

    public function lastInsertId(): int
    {
        return (int)$this->dbh->lastInsertId();
    }

    public function rowCount(): int
    {
        $result = $this->sth->rowCount();
        $this->sth = null;

        return $result;
    }

}
