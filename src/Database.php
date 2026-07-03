<?php

namespace Framework;

use PDO;
use PDOStatement;

class Database
{
    private PDO $connection;

    public function __construct(string $name)
    {
        $host     = getenv('DB_HOST') ?: null;
        $port     = getenv('DB_PORT') ?: '3306';
        $dbName   = getenv('DB_DATABASE') ?: null;
        $username = getenv('DB_USERNAME') ?: null;
        $password = getenv('DB_PASSWORD') ?: null;

        if ($host && $dbName && $username) {
            // Step 3: MySQL — environment variables set by docker-compose.mysql.yml
            $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } else {
            // Steps 1 & 2: SQLite
            $this->connection = new PDO("sqlite:" . $name);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->connection->exec('PRAGMA foreign_keys = ON;');
        }
    }

    public function query(string $query): PDOStatement | false
    {
        return $this->connection->query($query);
    }

    /**
     * @param string $sql
     * @param mixed[]|null $params
     * @return PDOStatement
     */
    public function run(string $sql, array|null $params = null): PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function prepare(string $sql): PDOStatement
    {
        return $this->connection->prepare($sql);
    }

    public function exec(string $sql): false|int
    {
        return $this->connection->exec($sql);
    }

    public function getLastID(string|null $field = null): int
    {
        return (int)$this->connection->lastInsertId($field);
    }

    public function migrate(string $migrationsDirectory): void
    {
        $files = scandir($migrationsDirectory);
        if ($files === false) {
            die('Could not read database migration files');
        }
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            echo "Migrating: " . $file . "\n";
            if ($contents = file_get_contents($migrationsDirectory . $file)) {
                $this->connection->exec($contents);
            }
        }
    }
}
