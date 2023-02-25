<?php

namespace App\Tests\Unit;

use App\SandBox\infrastructure\Service\SplitSql;
use PHPUnit\Framework\TestCase;

class SplitSqlTest extends TestCase
{
    private SplitSql $splitSql;

    protected function setUp(): void
    {
        parent::setUp();
        $this->splitSql = new SplitSql();
    }

    public function testPostgreSQLQueries()
    {
        $queries = 'CREATE DATABASE fly_database_{identifier}; CREATE USER fly_database_user_{identifier} WITH ENCRYPTED PASSWORD {password}; GRANT ALL PRIVILEGES ON DATABASE fly_database_{identifier} TO fly_database_user_{identifier}; ALTER USER fly_database_user_{identifier} SET statement_timeout = 30000;';

        $this->assertSame([
            'CREATE DATABASE fly_database_{identifier}',
            'CREATE USER fly_database_user_{identifier} WITH ENCRYPTED PASSWORD {password}',
            'GRANT ALL PRIVILEGES ON DATABASE fly_database_{identifier} TO fly_database_user_{identifier}',
            'ALTER USER fly_database_user_{identifier} SET statement_timeout = 30000',
        ], ($this->splitSql)('pgsql', $queries));
    }

    public function testPostgreSQLFunction()
    {
        $queries = "drop table if exists users;
                    create table users(user_id int, name varchar, password varchar);
                    insert into users (user_id, name, password) values
                        (1, 'Alex', 'pass1'),
                        (2, 'Alex2', 'pass2'),
                        (3, 'Alex3', 'pass3');create function getUser(id int) 
                    returns  users
                    language plpgsql as 
                    $$
                    declare
                      info users;
                    begin  
                     select * from users where users.user_id=id into info;
                     if info is null then
                         raise warning 'such user does not exist';
                         select * from users order by user_id desc limit 1 into info;
                     end if;
                    return info;
                    end;
                    $$; ";

         $this->assertCount(4,  ($this->splitSql)('pgsql', $queries));
    }

}
