<?php

namespace App\DatabaseSwitch\infrastructure\Structure\MySQL;

use App\DatabaseSwitch\infrastructure\Structure\StructureInterface;

class MySQL57Structure implements StructureInterface
{

    public function create(string $identifier, string $password): string
    {
        return strtr("CREATE DATABASE fly_database_{identifier}; CREATE USER 'fly_user{identifier}'@'{host}' IDENTIFIED BY '{password}'; GRANT ALL ON fly_database_{identifier}.* TO 'fly_user{identifier}'@'{host}';", [
            '{identifier}' => $identifier,
            '{password}' => $password,
            '{host}' => '%',
        ]);
    }

    public function drop(string $identifier): string
    {
        return strtr("DROP DATABASE IF EXISTS fly_database_{identifier}; DROP USER IF EXISTS 'fly_user{identifier}'@'{host}';", [
            '{identifier}' => $identifier,
            '{host}' => '%',
        ]);
    }


    public function __toString(): string
    {
        return 'MySQL5.7';
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
        return strtr('fly_user{identifier}',['{identifier}'=>$identifier]);
    }
}
