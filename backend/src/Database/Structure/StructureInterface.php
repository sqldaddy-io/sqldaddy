<?php

namespace App\Database\Structure;

interface StructureInterface
{
    public function create(string $identifier, string $password): string;
    public function drop(string $identifier): string;
    public function getDbName(string $identifier): string;
    public function getUserName(string $identifier): string;
    public function support(string $database): bool;
}
