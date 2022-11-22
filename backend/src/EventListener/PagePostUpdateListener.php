<?php

namespace App\EventListener;

use App\Entity\Page;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class PagePostUpdateListener
{

    private HubInterface $hub;
    private SerializerInterface $serializer;

    /**
     * @param HubInterface $hub
     * @param SerializerInterface $serializer
     */
    public function __construct(HubInterface $hub, SerializerInterface $serializer)
    {
        $this->hub = $hub;
        $this->serializer = $serializer;
    }

    public function postUpdate(Page $page): void
    {
        $update = new Update(
            '/pages/'.$page->getPath(),
            $this->serializer->serialize($page, 'json', ['groups' => 'page_read'])
        );
        $this->hub->publish($update);
    }
}
