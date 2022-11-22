<?php

namespace App\Service\PageExecute;

use App\Database\DatabaseInterface;
use App\Entity\Page;

class DropStructure
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function __invoke(Page $page, $identifier): bool
    {
        $structure = $this->database->structure((string)$page->getDatabaseVersion());
        $this->database->setConnection($page->getDatabaseVersion()->getParam()->getConnectionParam());
        $this->database->execute((string)$page->getDatabaseVersion(), $structure->drop($identifier));
        return true;
    }
}
