<?php

namespace App\DataFixtures;

use App\Entity\Database;
use App\Entity\DatabaseParam;
use App\Entity\DatabaseVersion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MsSQLFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $mssql = new Database();
//        $mssql->setName('SQL Server');
//        $mssql->setSort(3);
//        $manager->persist($mssql);
//
//        $v2022 = new DatabaseVersion();
//        $v2022->setName('2022');
//        $v2022->setSort(0);
//        $param_v2022 = new DatabaseParam();
//        $param_v2022->setContainerName('sqlserver2022');
//        $param_v2022->setDriver('sqlsrv');
//        $param_v2022->setUsername($_ENV['SANDBOX_SQLSERVER_USER']);
//        $param_v2022->setPassword($_ENV['SANDBOX_SQLSERVER_PASSWORD']);
//        $param_v2022->setHost('sqlserver2022');
//        $param_v2022->setCharset('utf8');
//        $param_v2022->setServerVersion(2022);
//        $param_v2022->setPort(1433);
//        $v2022->setParam($param_v2022);
//        $v2022->setDatabase($mssql);
//        $manager->persist($v2022);
//        $manager->flush();
    }

}
