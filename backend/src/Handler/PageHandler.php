<?php

namespace App\Handler;

use App\Config\PageStatus;
use App\Message\PageMessage;
use App\Repository\PageRepository;
use App\Service\PageExecute\Execute;
use Exception;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler]
class PageHandler
{

    private PageRepository $pageRepository;
    private Execute $execute;

    /**
     * @param PageRepository $pageRepository
     * @param Execute $execute
     */
    public function __construct(PageRepository $pageRepository, Execute $execute)
    {
        $this->pageRepository = $pageRepository;
        $this->execute = $execute;
    }

    /**
     * @throws Exception
     */
    public function __invoke(PageMessage $message): void
    {
        $page = $this->pageRepository->findOneBy(['path' => $message->getPath()]);
        try {
            $page->setStatus(PageStatus::IN_PROGRESS);
            $this->pageRepository->save($page, true);
            ($this->execute)($page);
        } catch (RuntimeException $exception) {
            $page->setStatus(PageStatus::COMPLETED_ERROR);
            $this->pageRepository->save($page, true);
            throw new UnrecoverableMessageHandlingException($exception->getMessage());
        }
    }
}
