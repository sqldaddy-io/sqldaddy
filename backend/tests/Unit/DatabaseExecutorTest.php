<?php

namespace App\Tests\Unit;

use App\DatabaseSwitch\infrastructure\Executor\Executor;
use App\DatabaseSwitch\infrastructure\Executor\ExecutorInterface;
use App\DatabaseSwitch\infrastructure\Executor\PostgreSQL\PostgreSQLExecutor;
use App\DatabaseSwitch\infrastructure\Executor\SQLServer\SQLServerExecutor;
use PHPUnit\Framework\TestCase;


class DatabaseExecutorTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testInstanceExecutor()
    {
        /**
         * @var  array<ExecutorInterface> $structures
         * @var  Executor $executor
         */
        $executors = [new PostgreSQLExecutor(), new SQLServerExecutor()];
        $executor = new Executor($executors);
        $this->assertInstanceOf(PostgreSQLExecutor::class, $executor->getExecutor('PostgreSQL15'));
    }
}
