<?php

namespace App\SandBox\infrastructure\Service;

use App\SandBox\Domain\Entity\Page;

class EmptyScriptsRemove
{

    public function __invoke(Page $page):void
    {
        foreach ($page->getScripts() as $script) {
            if (empty(trim($script->getRequest()))) {
                $page->removeScript($script);
            }
        }
    }
}
