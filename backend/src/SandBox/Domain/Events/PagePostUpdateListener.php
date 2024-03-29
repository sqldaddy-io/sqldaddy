<?php

namespace App\SandBox\Domain\Events;

use App\SandBox\Domain\Bus\Message\PageMessage;
use App\SandBox\Domain\Entity\Page;
use App\SandBox\Domain\Enums\PageStatus;
use App\SandBox\infrastructure\Service\PagePublish;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;

class PagePostUpdateListener
{

    private PagePublish $publish;
    private MessageBusInterface $messageBus;

    public function __construct(PagePublish $publish, MessageBusInterface $messageBus)
    {
        $this->publish = $publish;
        $this->messageBus = $messageBus;
    }

    /**
     * @throws Exception
     */
    public function postUpdate(Page $page): void
    {
        match ($page->getStatus()) {
            PageStatus::CREATED => throw new Exception('Nothing to do'),
            PageStatus::PENDING => $this->messageBus->dispatch(new PageMessage($page->getPath())),
            default => ($this->publish)($page),
        };
    }
}
