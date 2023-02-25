<?php

namespace App\SandBox\Application\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\SandBox\Domain\Entity\Page;
use App\SandBox\Domain\Entity\Script;
use App\SandBox\Domain\Enums\PageStatus;
use App\SandBox\infrastructure\Repository\PageRepository;
use App\SandBox\infrastructure\Service\EmptyScriptsRemove;
use App\SandBox\infrastructure\Service\PageCompare;
use App\SandBox\infrastructure\Service\UrlGenerate;

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
            $data->setStatus(PageStatus::CREATED);
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
