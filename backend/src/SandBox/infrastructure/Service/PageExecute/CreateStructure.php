<?php

namespace App\SandBox\infrastructure\Service\PageExecute;

use App\DatabaseSwitch\Application\DatabaseInterface;
use App\SandBox\Domain\Entity\Page;

class CreateStructure
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function __invoke(Page $page, $identifier, $password): bool
    {
        $structure = $this->database->structure((string)$page->getDatabaseVersion());
        $this->database->setConnection($page->getDatabaseVersion()->getParam()->getConnectionParam());
        $this->database->execute((string)$page->getDatabaseVersion(), $structure->create($identifier, $password));
        return true;
    }
}
