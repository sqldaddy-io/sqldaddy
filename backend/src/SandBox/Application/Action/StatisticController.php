<?php

namespace App\SandBox\Application\Action;

use App\SandBox\infrastructure\Repository\PageRepository;
use App\SandBox\infrastructure\Service\Docker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StatisticController extends AbstractController
{

    private PageRepository $repository;

    /**
     * @param PageRepository $repository
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(): array
    {
        return $this->repository->getStatistics();
    }
}
