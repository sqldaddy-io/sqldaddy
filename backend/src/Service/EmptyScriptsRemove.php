<?php

namespace App\Service;

use App\Entity\Page;

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
