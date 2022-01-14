<?php
declare(strict_types=1);

namespace SocialNews\User\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Types;
use SocialNews\User\Domain\User;
use SocialNews\User\Domain\UserRepository;

final class DbalUserRepository implements UserRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function add(User $user): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert('users');
        $queryBuilder->values([
            'id' => $queryBuilder->createNamedParameter($user->getId()->toString()),
            'nickname' => $queryBuilder->createNamedParameter($user->getNickname()),
            'password_hash' => $queryBuilder->createNamedParameter($user->getPasswordHash()),
            'creation_date' => $queryBuilder->createNamedParameter($user->getCreationDate(), Types::DATETIME_MUTABLE)
        ]);
        $queryBuilder->executeQuery();
    }
}