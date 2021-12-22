<?php
declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

final class Migration202112011345
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function migrate(): void
    {
        $schema = new Schema();
        $this->createSubmissionTable($schema);

        $queries = $schema->toSql($this->connection->getDatabasePlatform());
        foreach ($queries as $query) {
            $this->connection->executeQuery($query);
        }
    }

    private function createSubmissionTable(Schema $schema): void
    {
        $table = $schema->createTable('submissions');
        $table->addColumn('id', Types::GUID);
        $table->addColumn('title', Types::STRING);
        $table->addColumn('url', Types::STRING);
        $table->addColumn('creation_date', Types::DATETIME_IMMUTABLE);
    }
}