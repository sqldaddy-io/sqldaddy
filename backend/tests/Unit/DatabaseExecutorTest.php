<?php

namespace App\Tests\Unit;

use App\Database\Executor\Executor;
use App\Database\Executor\ExecutorInterface;
use App\Database\Executor\PostgreSQL\PostgreSQLExecutor;
use App\Database\Executor\SQLServer\SQLServerExecutor;
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
