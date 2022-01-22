<?php
declare(strict_types=1);

namespace SocialNews\User\Infrastructure;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Types;
use LogicException;
use Ramsey\Uuid\Uuid;
use SocialNews\User\Domain\User;
use SocialNews\User\Domain\UserRepository;
use SocialNews\User\Domain\UserWasLoggedIn;
use Symfony\Component\HttpFoundation\Session\Session;

final class DbalUserRepository implements UserRepository
{
    private Connection $connection;
    private Session $session;

    public function __construct(Connection $connection, Session $session)
    {
        $this->connection = $connection;
        $this->session = $session;
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

    public function save(User $user): void
    {
        foreach ($user->getRecordedEvents() as $event) {
            if ($event instanceof UserWasLoggedIn) {
                $this->session->set('userId', $user->getId()->toString());
                continue;
            }
            throw new LogicException(get_class($event) . ' was not handled.');
        }
        $user->clearRecordedEvents();

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->update('users');
        $queryBuilder->set('nickname', $queryBuilder->createNamedParameter($user->getNickname()));
        $queryBuilder->set('password_hash', $queryBuilder->createNamedParameter($user->getPasswordHash()));
        $queryBuilder->set('failed_login_attempts', $queryBuilder->createNamedParameter($user->getFailedLoginAttempts()));
        $queryBuilder->set('last_failed_login_attempts', $queryBuilder->createNamedParameter($user->getLastFailedLoginAttempts(), Types::DATETIME_MUTABLE));
        $queryBuilder->executeQuery();
    }

    public function findByNickname(string $nickname): ?User
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('id');
        $queryBuilder->select('nickname');
        $queryBuilder->select('password_hash');
        $queryBuilder->select('creation_date');
        $queryBuilder->select('failed_login_attempts');
        $queryBuilder->select('last_failed_login_attempts');
        $queryBuilder->from('users');
        $queryBuilder->where("nickname = {$queryBuilder->createNamedParameter($nickname)}");
        $statement = $queryBuilder->executeQuery();
        $row = $statement->fetchAssociative();

        if (!$row) {
            return null;
        }
        return $this->createUserFromDatabaseRow($row);
    }

    private function createUserFromDatabaseRow(array $row): ?User
    {
        if (!$row) {
            return null;
        }

        $lastFailedLoginAttempt = null;
        if ($row['last_failed_login_attempt']) {
            $lastFailedLoginAttempt = new DateTimeImmutable($row['last_failed_login_attempt']);
        }

        return new User(
            Uuid::fromString($row['id']),
            $row['nickname'],
            $row['password_hash'],
            new DateTimeImmutable($row['creation_date']),
            (int) $row['failed_login_attempts'],
            $lastFailedLoginAttempt
        );
    }
}