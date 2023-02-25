<?php

namespace App\SandBox\infrastructure\Service;

use App\SandBox\Domain\Entity\Page;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class PagePublish
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


    public function __invoke(Page $page): void
    {
        $update = new Update(
            '/pages/'.$page->getPath(),
            $this->serializer->serialize($page, 'json', ['groups' => 'page_read'])
        );
        $this->hub->publish($update);
    }
}
