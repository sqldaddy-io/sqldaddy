<?php

namespace App\SandBox\infrastructure\Service\PageExecute;

use App\DatabaseSwitch\Application\DatabaseInterface;
use App\SandBox\Domain\Entity\Page;
use App\SandBox\Domain\Enums\PageStatus;
use App\SandBox\infrastructure\Repository\PageRepository;
use App\SandBox\infrastructure\Service\PasswordGenerator;
use Ramsey\Uuid\Uuid;

class Execute
{

    public function __construct(
        private DatabaseInterface $database,
        private CreateStructure $createStructure,
        private DropStructure $dropStructure,
        private ScriptsExecute $scriptsExecute,
        private PageRepository $pageRepository,
        private PasswordGenerator $passwordGenerator){
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
