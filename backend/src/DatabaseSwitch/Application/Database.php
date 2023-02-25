<?php

namespace App\DatabaseSwitch\Application;

use App\DatabaseSwitch\infrastructure\Executor\Executor;
use App\DatabaseSwitch\infrastructure\Structure\Structure;
use App\DatabaseSwitch\infrastructure\Structure\StructureInterface;
use Doctrine\DBAL\Exception;
use PDO;
use UnexpectedValueException;

class Database implements DatabaseInterface
{

    protected PDO $connection;
    protected Structure $structure;
    protected Executor $executor;


    /**
     * @param array<StructureInterface> $structures
     */
    public function __construct(array $structures = [], array $executors = [])
    {
        $this->structure = new Structure($structures);
        $this->executor = new Executor($executors);
    }

    public function structure(string $database): StructureInterface
    {
        if (!$this->supportsStructure($database)) {
            throw new UnexpectedValueException(sprintf('Structure for the database "%s" is not supported.', $database));
        }
        return $this->structure->getStructure($database);
    }


    public function execute(string $database, string $query): mixed
    {
        if (!$this->supportsExecutor($database)) {
            throw new UnexpectedValueException(sprintf('Structure for the database "%s" is not supported.', $database));
        }
        if (!$this->connection instanceof PDO) {
            throw new UnexpectedValueException('You must to select database. Use Database::setConnection method');
        }

        return $this->executor->getExecutor($database)->run($this->connection, $query);
    }


    public function setConnection(array $param): bool
    {
        try {
            $this->connection = new PDO($param['dns'], $param['user'], $param['password']);
            return  true;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function supportsStructure(string $database): bool
    {
        return $this->structure->supportsStructure($database);
    }

    public function supportsExecutor(string $database): bool
    {
        return $this->executor->supportsExecutor($database);
    }



}
