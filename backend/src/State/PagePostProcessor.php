<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Page;
use App\Service\EmptyScriptsRemove;
use App\Service\UrlGenerate;

final class PagePostProcessor implements ProcessorInterface
{

    private ProcessorInterface $decorated;
    private UrlGenerate $urlGenerate;
    private EmptyScriptsRemove $emptyScriptsRemove;

    /**
     * @param ProcessorInterface $decorated
     * @param UrlGenerate $urlGenerate
     * @param EmptyScriptsRemove $emptyScriptsRemove
     */
    public function __construct(ProcessorInterface $decorated, UrlGenerate $urlGenerate, EmptyScriptsRemove $emptyScriptsRemove)
    {
        $this->decorated = $decorated;
        $this->urlGenerate = $urlGenerate;
        $this->emptyScriptsRemove = $emptyScriptsRemove;
    }

    /**
     * @param Page $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $data->setPath(($this->urlGenerate)());
        ($this->emptyScriptsRemove)($data);
        return $this->decorated->process($data, $operation, $uriVariables, $context);
    }


}
