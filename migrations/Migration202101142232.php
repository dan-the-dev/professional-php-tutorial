<?php
declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

final class Migration202101142232
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function migrate(): void
    {
        $schema = new Schema();
        $this->createUsersTable($schema);

        $queries = $schema->toSql($this->connection->getDatabasePlatform());
        foreach ($queries as $query) {
            $this->connection->executeQuery($query);
        }
    }

    private function createUsersTable(Schema $schema): void
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', Types::GUID);
        $table->addColumn('nickname', Types::STRING);
        $table->addColumn('password_hash', Types::STRING);
        $table->addColumn('creation_date', Types::DATETIME_IMMUTABLE);
        $table->addColumn('failed_login_attempts', Types::INTEGER, ['default' => 0]);
        $table->addColumn('last_failed_login_attempts', Types::DATETIME_IMMUTABLE, ['notnull' => false]);
    }
}