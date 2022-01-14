<?php
declare(strict_types=1);

namespace SocialNews\User\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use SocialNews\User\Application\NicknameTakenQuery;

final class DbalNicknameTakenQuery implements NicknameTakenQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function execute(string $nickname): bool
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('count(*) as count');
        $queryBuilder->from('users');
        $queryBuilder->where("nickname = {$queryBuilder->createNamedParameter(($nickname))}");
        $result = $queryBuilder->executeQuery();
        return (bool)$result->fetchAssociative()['count'];
    }
}