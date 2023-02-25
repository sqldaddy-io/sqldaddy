<?php

namespace App\Tests\Integration;

use App\SandBox\infrastructure\Service\PageExecute\Execute;

class ExecuteTest extends DatabaseTestCase
{
    public function testExecute()
    {
        /** @var Execute $execute */
        $execute = $this->container->get(Execute::class);
        $execute($this->page);
        $this->assertSame(
            [[['version' => 'PostgreSQL 15.1 on x86_64-pc-linux-musl, compiled by gcc (Alpine 12.2.1_git20220924-r4) 12.2.1 20220924, 64-bit']]],
            $this->page->getScripts()->first()->getResponse()
        );
    }
}
