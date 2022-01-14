<?php
declare(strict_types=1);

namespace SocialNews\Submission\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use SocialNews\Submission\Domain\Submission;
use SocialNews\Submission\Domain\SubmissionRepository;

final class DbalSubmissionRepository implements SubmissionRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function add(Submission $submission): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert('submissions');
        $queryBuilder->values([
            'id' => $queryBuilder->createNamedParameter($submission->getId()->toString()),
            'title' => $queryBuilder->createNamedParameter($submission->getTitle()),
            'url' => $queryBuilder->createNamedParameter($submission->getUrl()),
            'creation_date' => $queryBuilder->createNamedParameter($submission->getCreationDate(), 'datetime')
        ]);
        $queryBuilder->executeQuery();
    }
}