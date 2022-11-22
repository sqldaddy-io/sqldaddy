<?php

namespace App\Database\Executor;

use PDO;

interface ExecutorInterface
{
    public function run(PDO $connection, string $query): mixed;
    public function support(string $database): bool;
}
