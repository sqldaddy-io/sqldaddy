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
//        $MsSQL = new Database();
//        $MsSQL->setName('SQL Server');
//        $MsSQL->setSort(2);
//        $manager->persist($MsSQL);
//
//        $v2022 = new DatabaseVersion();
//        $v2022->setName('2022');
//        $v2022->setSort(0);
//        $param_v2022  = new DatabaseParam();
//        $param_v2022->setContainerName('mssql2022');
//        $param_v2022->setDriver('sqlsrv');
//        $param_v2022->setUsername($_ENV['SANDBOX_MSSQL_USER']);
//        $param_v2022->setPassword($_ENV['SANDBOX_MSSQL_PASSWORD']);
//        $param_v2022->setHost('mssql2022');
//        $param_v2022->setCharset('utf8');
//        $param_v2022->setServerVersion(2022);
//        $param_v2022->setPort(1433);
//        $v2022->setParam($param_v2022);
//        $v2022->setDatabase($MsSQL);
//        $manager->persist($v2022);
//
//
//        $v2019 = new DatabaseVersion();
//        $v2019->setName('2019');
//        $v2019->setSort(1);
//        $param_v2019  = new DatabaseParam();
//        $param_v2019->setContainerName('mssql2019');
//        $param_v2019->setDriver('sqlsrv');
//        $param_v2019->setUsername($_ENV['SANDBOX_MSSQL_USER']);
//        $param_v2019->setPassword($_ENV['SANDBOX_MSSQL_PASSWORD']);
//        $param_v2019->setHost('mssql2019');
//        $param_v2019->setCharset('utf8');
//        $param_v2019->setServerVersion(2019);
//        $param_v2019->setPort(1433);
//        $v2019->setParam($param_v2019);
//        $v2019->setDatabase($MsSQL);
//        $manager->persist($v2019);
//
//
//        $manager->flush();
    }

}
