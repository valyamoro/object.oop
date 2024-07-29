<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Database;

class DatabasePDOConnection implements DatabaseConnection
{
    public function __construct(
        private readonly DatabaseConfiguration $databaseConfiguration,
    ) {}

    public function connection(): \PDO
    {
        return new \PDO(
            $this->getDsn(),
            $this->databaseConfiguration->getUsername(),
            $this->databaseConfiguration->getPassword(),
            $this->databaseConfiguration->getOptions(),
        );
    }

    private function getDsn(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->databaseConfiguration->getPort(),
            $this->databaseConfiguration->getHost(),
            $this->databaseConfiguration->getDbname(),
            $this->databaseConfiguration->getCharset(),
        );
    }

}
