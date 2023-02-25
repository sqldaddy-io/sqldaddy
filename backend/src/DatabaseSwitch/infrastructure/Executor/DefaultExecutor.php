<?php

namespace App\DatabaseSwitch\infrastructure\Executor;


use PDO;
use PDOException;

class DefaultExecutor implements ExecutorInterface
{

    public function run(PDO $connection, string $query): mixed
    {
        try {
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $smtp = $connection->query($query);
            $response[] = $smtp->fetchAll(PDO::FETCH_ASSOC);
            while ($smtp->nextRowset()) {
                $response[] = $smtp->fetchAll(PDO::FETCH_ASSOC);
            }
            return $response;
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function __toString(): string
    {
        return 'default';
    }

    public function support(string $database): bool
    {
        return (string)$this === $database;
    }


}
