<?php

namespace App\Database\DependencyInjection;

use App\Database\Database;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class DatabasePass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container)
    {

        if (!$container->findTaggedServiceIds('database.structure_tag')) {
            throw new RuntimeException('You must tag at least one service as "database.structure_tag" to use the "database" service.');
        }
        if (!$container->findTaggedServiceIds('database.executor_tag')) {
            throw new RuntimeException('You must tag at least one service as "database.executor_tag" to use the "database" service.');
        }

        $container->getDefinition(Database::class)
            ->addArgument($this->findAndSortTaggedServices('database.structure_tag', $container))
            ->addArgument($this->findAndSortTaggedServices('database.executor_tag', $container));
    }
}
