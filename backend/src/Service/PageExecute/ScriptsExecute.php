<?php

namespace App\Service\PageExecute;

use App\Database\DatabaseInterface;
use App\Entity\Page;

class ScriptsExecute
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function __invoke(Page $page, $identifier, $password, $scripts): array
    {
        $structure = $this->database->structure((string)$page->getDatabaseVersion());
        $this->database->setConnection($page->getDatabaseVersion()->getParam()->getConnectionParam($structure->getDbName($identifier), $structure->getUserName($identifier), $password));
        $responses = [];
        foreach ($scripts as $script) {
            $responses[$script->getId()] = $this->database->execute((string)$page->getDatabaseVersion(), $script->getRequest());
        }
        return $responses;
    }
}
