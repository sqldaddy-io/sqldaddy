<?php

namespace App\State;

use ApiPlatform\Doctrine\Odm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use App\Config\PageStatus;
use App\Entity\Page;
use App\Entity\Script;
use App\Repository\PageRepository;
use App\Service\EmptyScriptsRemove;
use App\Service\PageCompare;
use App\Service\UrlGenerate;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

final class PagePutProcessor implements ProcessorInterface
{

    private ProcessorInterface $decorated;
    private PageCompare $pageCompare;
    private PageRepository $repository;
    private UrlGenerate $urlGenerate;
    private EmptyScriptsRemove $emptyScriptsRemove;

    /**
     * @param ProcessorInterface $decorated
     * @param PageRepository $repository
     * @param PageCompare $pageCompare
     * @param UrlGenerate $urlGenerate
     * @param EmptyScriptsRemove $emptyScriptsRemove
     */
    public function __construct(ProcessorInterface $decorated, PageRepository $repository, PageCompare $pageCompare, UrlGenerate $urlGenerate, EmptyScriptsRemove $emptyScriptsRemove)
    {
        $this->decorated = $decorated;
        $this->repository = $repository;
        $this->pageCompare = $pageCompare;
        $this->urlGenerate = $urlGenerate;
        $this->emptyScriptsRemove = $emptyScriptsRemove;
    }

    /**
     * @param Page $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): Page
    {
        if (($this->pageCompare)($data)) {
            $this->disconnect();
            $data->setPath(($this->urlGenerate)());
            $data->setStatus(PageStatus::PENDING);
            $data->setCreateAt(new \DateTimeImmutable('now'));
            ($this->emptyScriptsRemove)($data);
            return $this->decorated->process($data, $operation, $uriVariables, $context);
        }
        // Since we don't allow the "response" to be sent from outside, there is no "response(Script::getResponse)" of the script in the date array. Because of this, we disconnect the entities and request the real data with the result
        $this->disconnect();
        return $this->repository->find($data->getId());
    }

    private function disconnect(): void
    {
        $this->repository->getEm()->getUnitOfWork()->clear(Script::class);
        $this->repository->getEm()->getUnitOfWork()->clear(Page::class);
    }


}
