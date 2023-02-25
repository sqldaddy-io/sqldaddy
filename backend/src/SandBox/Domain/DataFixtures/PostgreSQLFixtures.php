<?php

namespace App\SandBox\Domain\DataFixtures;

use App\SandBox\Domain\Entity\Database;
use App\SandBox\Domain\Entity\DatabaseParam;
use App\SandBox\Domain\Entity\DatabaseVersion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostgreSQLFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $PostgreSql = new Database();
        $PostgreSql->setName('PostgreSQL');
        $PostgreSql->setSort(0);
        $manager->persist($PostgreSql);

        $v15 = new DatabaseVersion();
        $v15->setName('15');
        $v15->setSort(0);
        $param_v15 = new DatabaseParam();
        $param_v15->setContainerName('postgres15');
        $param_v15->setDriver('pgsql');
        $param_v15->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v15->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v15->setHost('postgres15');
        $param_v15->setCharset('utf8');
        $param_v15->setServerVersion(15);
        $param_v15->setPort(5432);
        $v15->setParam($param_v15);
        $v15->setDatabase($PostgreSql);
        $manager->persist($v15);

        $v14 = new DatabaseVersion();
        $v14->setName('14');
        $v14->setSort(1);
        $param_v14 = new DatabaseParam();
        $param_v14->setContainerName('postgres14');
        $param_v14->setDriver('pgsql');
        $param_v14->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v14->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v14->setHost('postgres14');
        $param_v14->setCharset('utf8');
        $param_v14->setServerVersion(14);
        $param_v14->setPort(5432);
        $v14->setParam($param_v14);
        $v14->setDatabase($PostgreSql);
        $manager->persist($v14);

        $v13 = new DatabaseVersion();
        $v13->setName('13');
        $v13->setSort(2);
        $param_v13 = new DatabaseParam();
        $param_v13->setContainerName('postgres13');
        $param_v13->setDriver('pgsql');
        $param_v13->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v13->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v13->setHost('postgres13');
        $param_v13->setCharset('utf8');
        $param_v13->setServerVersion(13);
        $param_v13->setPort(5432);
        $v13->setParam($param_v13);
        $v13->setDatabase($PostgreSql);
        $manager->persist($v13);


        $v12 = new DatabaseVersion();
        $v12->setName('12');
        $v12->setSort(3);
        $param_v12 = new DatabaseParam();
        $param_v12->setContainerName('postgres12');
        $param_v12->setDriver('pgsql');
        $param_v12->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v12->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v12->setHost('postgres12');
        $param_v12->setCharset('utf8');
        $param_v12->setServerVersion(12);
        $param_v12->setPort(5432);
        $v12->setParam($param_v12);
        $v12->setDatabase($PostgreSql);
        $manager->persist($v12);

        $v11 = new DatabaseVersion();
        $v11->setName('11');
        $v11->setSort(4);
        $param_v11 = new DatabaseParam();
        $param_v11->setContainerName('postgres11');
        $param_v11->setDriver('pgsql');
        $param_v11->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v11->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v11->setHost('postgres11');
        $param_v11->setCharset('utf8');
        $param_v11->setServerVersion(11);
        $param_v11->setPort(5432);
        $v11->setParam($param_v11);
        $v11->setDatabase($PostgreSql);
        $manager->persist($v11);

        $v10 = new DatabaseVersion();
        $v10->setName('10');
        $v10->setSort(5);
        $param_v10 = new DatabaseParam();
        $param_v10->setContainerName('postgres10');
        $param_v10->setDriver('pgsql');
        $param_v10->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v10->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v10->setHost('postgres10');
        $param_v10->setCharset('utf8');
        $param_v10->setServerVersion(10);
        $param_v10->setPort(5432);
        $v10->setParam($param_v10);
        $v10->setDatabase($PostgreSql);
        $manager->persist($v10);

        $v96 = new DatabaseVersion();
        $v96->setName('9.6');
        $v96->setSort(6);
        $param_v96 = new DatabaseParam();
        $param_v96->setContainerName('postgres9.6');
        $param_v96->setDriver('pgsql');
        $param_v96->setUsername($_ENV['SANDBOX_POSTGRES_USER']);
        $param_v96->setPassword($_ENV['SANDBOX_POSTGRES_PASSWORD']);
        $param_v96->setHost('postgres9.6');
        $param_v96->setCharset('utf8');
        $param_v96->setServerVersion(9.6);
        $param_v96->setPort(5432);
        $v96->setParam($param_v96);
        $v96->setDatabase($PostgreSql);
        $manager->persist($v96);

        $manager->flush();
    }

}
