<?php

namespace App\DatabaseSwitch\infrastructure\Structure\SQLServer;

use App\DatabaseSwitch\infrastructure\Structure\StructureInterface;

class SQLServer2022Structure implements StructureInterface
{

    public function create(string $identifier, string $password): string
    {
        return strtr("CREATE DATABASE {db_name}; 
                      USE {db_name}; 
                      CREATE LOGIN {db_user} WITH PASSWORD = '{password}', CHECK_POLICY = OFF;
                      CREATE USER {db_user} FOR LOGIN {db_user}; 
                      GRANT
                        CREATE TABLE,
                        CREATE TYPE,
                        CREATE VIEW,
                        CREATE PROCEDURE,
                        CREATE FUNCTION,
                        CREATE FULLTEXT CATALOG,
                        EXECUTE,
                        DELETE,
                        INSERT,
                        REFERENCES,
                        SELECT,
                        SHOWPLAN,
                        UPDATE
                        TO {db_user};
                        ALTER LOGIN {db_user} WITH DEFAULT_DATABASE={db_name};
                        GRANT ALTER ON SCHEMA::dbo TO {db_user}; 
                        ", [
            '{db_name}' => $this->getDbName($identifier),
            '{db_user}' => $this->getUserName($identifier),
            '{password}' => $password,
        ]);
    }

    public function drop(string $identifier): string
    {
        return strtr("DROP USER IF EXISTS {db_user}; DROP DATABASE IF EXISTS {db_name}; DROP LOGIN {db_user};  ", [
            '{db_name}' => $this->getDbName($identifier),
            '{db_user}' => $this->getUserName($identifier),
        ]);
    }


    public function __toString(): string
    {
        return 'SQL Server2022';
    }

    public function support(string $database): bool
    {
        return (string)$this === $database;
    }


    public function getDbName(string $identifier): string
    {
        return strtr('fly_database_{identifier}', ['{identifier}' => $identifier]);
    }

    public function getUserName(string $identifier): string
    {
        return strtr('fly_database_user_{identifier}', ['{identifier}' => $identifier]);
    }
}
