<?php

namespace App\EventListener;

use App\Entity\Page;
use App\Message\PageMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class PagePostPersistListener
{


    private MessageBusInterface $messageBus;

    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function postPersist(Page $page): void
    {
        $this->messageBus->dispatch(new PageMessage($page->getPath()));
    }
}
