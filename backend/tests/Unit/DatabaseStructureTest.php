<?php

namespace App\Tests\Unit;

use App\Database\Structure\MySQL\MySQL8Structure;
use App\Database\Structure\PostgreSQL\PostgreSQL15Structure;
use App\Database\Structure\SQLServer\SQLServer2022Structure;
use App\Database\Structure\Structure;
use App\Database\Structure\StructureInterface;
use PHPUnit\Framework\TestCase;

class DatabaseStructureTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testInstanceStructure()
    {
        /**
         * @var  array<StructureInterface> $structures
         * @var  Structure $structure
         */
        $structures = [new PostgreSQL15Structure(), new MySQL8Structure(), new SQLServer2022Structure()];
        $structure = new Structure($structures);
        $this->assertInstanceOf(PostgreSQL15Structure::class, $structure->getStructure('PostgreSQL15'));
    }
}
