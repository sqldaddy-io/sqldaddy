<?php

namespace App\Service\PageExecute;

use App\Config\PageStatus;
use App\Database\DatabaseInterface;
use App\Entity\Page;
use App\Repository\PageRepository;
use App\Service\PasswordGenerator;
use Ramsey\Uuid\Uuid;

class Execute
{

    private DatabaseInterface $database;
    private CreateStructure $createStructure;
    private DropStructure $dropStructure;
    private ScriptsExecute $scriptsExecute;
    private PageRepository $pageRepository;
    private PasswordGenerator $passwordGenerator;

    public function __construct(DatabaseInterface $database, CreateStructure $createStructure, DropStructure $dropStructure, ScriptsExecute $scriptsExecute, PageRepository $pageRepository, PasswordGenerator $passwordGenerator)
    {
        $this->database = $database;
        $this->createStructure = $createStructure;
        $this->dropStructure = $dropStructure;
        $this->scriptsExecute = $scriptsExecute;
        $this->pageRepository = $pageRepository;
        $this->passwordGenerator = $passwordGenerator;
    }


    public function __invoke(Page $page): void
    {
        $identifier = hash('adler32', Uuid::uuid4());
        $password = ($this->passwordGenerator)();
        ($this->createStructure)($page, $identifier, $password);
        $responses = ($this->scriptsExecute)($page, $identifier, $password, $page->getScripts());
        ($this->dropStructure)($page, $identifier);
        foreach ($page->getScripts() as $script) {
            if (!empty($responses[$script->getId()])) {
                $script->setResponse((array)$responses[$script->getId()]);
            }
        }
        $page->setStatus(PageStatus::COMPLETED_SUCCESS);
        $this->pageRepository->save($page, true);
    }
}
