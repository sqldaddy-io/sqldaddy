<?php

namespace App\Handler;

use App\Config\PageStatus;
use App\Message\PageMessage;
use App\Repository\PageRepository;
use App\Service\PageExecute\Execute;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
#[AsMessageHandler]
class PageHandler
{

    private PageRepository $pageRepository;
    private Execute $execute;

    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository, Execute $execute)
    {
        $this->pageRepository = $pageRepository;
        $this->execute = $execute;
    }

    public function __invoke(PageMessage $message): void
    {
        $page = $this->pageRepository->findOneBy(['path' => $message->getPath()]);
        $page->setStatus(PageStatus::IN_PROGRESS);
        $this->pageRepository->save($page, true);
        ($this->execute)($page);
    }
}
