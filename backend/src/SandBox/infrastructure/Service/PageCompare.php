<?php

namespace App\SandBox\infrastructure\Service;

use App\SandBox\Domain\Entity\Page;
use App\SandBox\infrastructure\Repository\PageRepository;

class PageCompare
{


    private PageRepository $repository;

    /**
     * @param PageRepository $repository
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(Page $page): bool
    {
        $uow = $this->repository->getEm()->getUnitOfWork();
        $uow->computeChangeSets();

        $change_set = $uow->getEntityChangeSet($page);
        if(isset($change_set['status'])){
            unset($change_set['status']);
        }
        if ($change_set) {
            return true;
        }
        foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdate) {
            /** @var $collectionUpdate \Doctrine\ORM\PersistentCollection */
            if ($collectionUpdate->getOwner() === $page and $collectionUpdate->isDirty()) {
                $diffs = $collectionUpdate->getInsertDiff();
                $snaps = $collectionUpdate->getSnapshot();
                if(count($snaps) != count($diffs)){
                    return true;
                }
                foreach ($snaps as $index => $snap){
                    if(isset($diffs[$index]) and $snap->getRequest() !== $diffs[$index]->getRequest()){
                        return true;
                    }
                }
            }
        }
        return false;
    }


}
