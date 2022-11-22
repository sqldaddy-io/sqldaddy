<?php

namespace App\Database;

use App\Database\Structure\StructureInterface;

interface DatabaseInterface
{
    public function setConnection(array $param): bool;
    public function structure(string $database): StructureInterface;
    public function execute(string $database, string $query): mixed;
}
