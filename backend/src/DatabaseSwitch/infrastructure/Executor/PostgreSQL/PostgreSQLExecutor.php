<?php

namespace App\DatabaseSwitch\infrastructure\Executor\PostgreSQL;

use App\DatabaseSwitch\infrastructure\Executor\ExecutorInterface;
use App\SandBox\infrastructure\Service\SplitSql;
use PDO;
use PDOException;

class PostgreSQLExecutor implements ExecutorInterface
{

    private SplitSql $splitter;

    public function __construct()
    {
        $this->splitter = new SplitSql();
    }

    public function run(PDO $connection, string $query): mixed
    {
        try {
            $response = [];
            $queries = ($this->splitter)($connection->getAttribute(PDO::ATTR_DRIVER_NAME), $query);
            foreach ($queries as $command) {
                $smtp = $connection->query($command);
                $response[] = $smtp->fetchAll(PDO::FETCH_ASSOC);
            }
            return $response;
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function __toString(): string
    {
        return 'PostgreSQL';
    }

    public function support(string $database): bool
    {
        return in_array($database, ['PostgreSQL15', 'PostgreSQL14', 'PostgreSQL13', 'PostgreSQL12' ,'PostgreSQL11', 'PostgreSQL10', 'PostgreSQL9.6']);
    }

}
