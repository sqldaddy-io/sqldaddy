<?php

namespace App\Database\Executor\SQLServer;

use App\Database\Executor\ExecutorInterface;
use App\Service\SplitSql;
use PDO;
use PDOException;

class SQLServerExecutor implements ExecutorInterface
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
                $response[] = ($smtp->columnCount()) ? $smtp->fetchAll(PDO::FETCH_ASSOC) : [];
            }
            return $response;
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function __toString(): string
    {
        return 'SQL Server';
    }

    public function support(string $database): bool
    {
        return in_array($database, ['SQL Server2022']);
    }

}
