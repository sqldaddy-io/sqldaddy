<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20221208214816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'inset SQL Server';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("SELECT setval('database_id_seq', (SELECT MAX(id) FROM database))");
        $this->addSql("ALTER TABLE database ALTER id SET DEFAULT nextval('database_id_seq')");
        $this->addSql("SELECT setval('database_param_id_seq', (SELECT MAX(id) FROM database_param))");
        $this->addSql("ALTER TABLE database_param ALTER id SET DEFAULT nextval('database_param_id_seq')");
        $this->addSql("SELECT setval('database_version_id_seq', (SELECT MAX(id) FROM database_version))");
        $this->addSql("ALTER TABLE database_version ALTER id SET DEFAULT nextval('database_version_id_seq')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE database ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE database_version ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE database_param ALTER id DROP DEFAULT');
    }

    public function postUp(Schema $schema): void
    {
        $this->connection->exec("INSERT INTO database (name, sort) VALUES ('SQL Server',	3);");
        $db_id = $this->connection->lastInsertId();
        $this->connection->exec("INSERT INTO database_param (driver, host, port, username, password, server_version, charset, container_name) VALUES ('sqlsrv',	'sqlserver2022',	1433,	'" . $_ENV['SANDBOX_SQLSERVER_USER'] . "',	'" . $_ENV['SANDBOX_SQLSERVER_PASSWORD'] . "',	'2022',	'utf8',	'sqlserver2022');");
        $db_param_id = $this->connection->lastInsertId();
        $this->connection->exec("INSERT INTO database_version (database_id, param_id, name, sort) VALUES ({$db_id}, {$db_param_id},	'2022',	0);");
    }
}
