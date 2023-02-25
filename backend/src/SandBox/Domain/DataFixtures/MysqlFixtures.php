<?php

namespace App\SandBox\Domain\DataFixtures;

use App\SandBox\Domain\Entity\Database;
use App\SandBox\Domain\Entity\DatabaseParam;
use App\SandBox\Domain\Entity\DatabaseVersion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MysqlFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $MySQL = new Database();
        $MySQL->setName('MySQL');
        $MySQL->setSort(1);
        $manager->persist($MySQL);

        $v8 = new DatabaseVersion();
        $v8->setName('8');
        $v8->setSort(0);
        $param_v8 = new DatabaseParam();
        $param_v8->setContainerName('mysql8');
        $param_v8->setDriver('mysql');
        $param_v8->setUsername($_ENV['SANDBOX_MYSQL_USER']);
        $param_v8->setPassword($_ENV['SANDBOX_MYSQL_PASSWORD']);
        $param_v8->setHost('mysql8');
        $param_v8->setCharset('utf8');
        $param_v8->setServerVersion(8);
        $param_v8->setPort(3306);
        $v8->setParam($param_v8);
        $v8->setDatabase($MySQL);
        $manager->persist($v8);

        $v57 = new DatabaseVersion();
        $v57->setName('5.7');
        $v57->setSort(1);
        $param_v57 = new DatabaseParam();
        $param_v57->setContainerName('mysql57');
        $param_v57->setDriver('mysql');
        $param_v57->setUsername($_ENV['SANDBOX_MYSQL_USER']);
        $param_v57->setPassword($_ENV['SANDBOX_MYSQL_PASSWORD']);
        $param_v57->setHost('mysql57');
        $param_v57->setCharset('utf8mb4');
        $param_v57->setServerVersion(8);
        $param_v57->setPort(3306);
        $v57->setParam($param_v57);
        $v57->setDatabase($MySQL);
        $manager->persist($v57);


        $v56 = new DatabaseVersion();
        $v56->setName('5.6');
        $v56->setSort(2);
        $param_v56 = new DatabaseParam();
        $param_v56->setContainerName('mysql56');
        $param_v56->setDriver('mysql');
        $param_v56->setUsername($_ENV['SANDBOX_MYSQL_USER']);
        $param_v56->setPassword($_ENV['SANDBOX_MYSQL_PASSWORD']);
        $param_v56->setHost('mysql56');
        $param_v56->setCharset('utf8mb4');
        $param_v56->setServerVersion(8);
        $param_v56->setPort(3306);
        $v56->setParam($param_v56);
        $v56->setDatabase($MySQL);
        $manager->persist($v56);



        $v55 = new DatabaseVersion();
        $v55->setName('5.5');
        $v55->setSort(3);
        $param_v55 = new DatabaseParam();
        $param_v55->setContainerName('mysql55');
        $param_v55->setDriver('mysql');
        $param_v55->setUsername($_ENV['SANDBOX_MYSQL_USER']);
        $param_v55->setPassword($_ENV['SANDBOX_MYSQL_PASSWORD']);
        $param_v55->setHost('mysql55');
        $param_v55->setCharset('utf8mb4');
        $param_v55->setServerVersion(8);
        $param_v55->setPort(3306);
        $v55->setParam($param_v55);
        $v55->setDatabase($MySQL);
        $manager->persist($v55);

        $manager->flush();
    }

}
