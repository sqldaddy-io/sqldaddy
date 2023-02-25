<?php

namespace App\DatabaseSwitch\infrastructure\Executor;


use Symfony\Component\Serializer\Exception\RuntimeException;

class Executor
{
    private array $executors = [];

    /**
     * @param array<ExecutorInterface> $executors
     */
    public function __construct(array $executors = [])
    {
        $this->executors = $executors;
    }


    public function supportsExecutor(string $database): bool
    {
        try {
            $this->getExecutor($database);
        } catch (RuntimeException) {
            return false;
        }
        return true;
    }


    public function getExecutor(string $database): ExecutorInterface
    {
        foreach ($this->executors as $executor){
            if($executor->support($database)){
                return  $executor;
            }
        }
        return  new DefaultExecutor();
    }
}
