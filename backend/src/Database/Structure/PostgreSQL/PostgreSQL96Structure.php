<?php

namespace App\Database\Structure\PostgreSQL;

use App\Database\Structure\StructureInterface;

class PostgreSQL96Structure implements StructureInterface
{

    public function create(string $identifier, string $password): string
    {
        return strtr("CREATE DATABASE fly_database_{identifier}; CREATE USER fly_database_user_{identifier} WITH ENCRYPTED PASSWORD '{password}'; GRANT ALL PRIVILEGES ON DATABASE fly_database_{identifier} TO fly_database_user_{identifier}; ALTER USER fly_database_user_{identifier} SET statement_timeout = 30000; ", [
            '{identifier}' => $identifier,
            '{password}' => $password,
        ]);
    }

    public function drop(string $identifier): string
    {
        return strtr("DROP DATABASE fly_database_{identifier};DROP USER IF EXISTS fly_database_user_{identifier};", [
            '{identifier}' => $identifier
        ]);
    }


    public function __toString(): string
    {
        return 'PostgreSQL9.6';
    }

    public function support(string $database): bool
    {
        return (string)$this === $database;
    }


    public function getDbName(string $identifier): string
    {
        return strtr('fly_database_{identifier}',['{identifier}'=>$identifier]);
    }

    public function getUserName(string $identifier): string
    {
        return strtr('fly_database_user_{identifier}',['{identifier}'=>$identifier]);
    }
}
