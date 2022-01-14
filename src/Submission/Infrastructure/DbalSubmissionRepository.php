<?php
declare(strict_types=1);

namespace SocialNews\Submission\Infrastructure;

use Doctrine\DBAL\Connection;
use SocialNews\Submission\Domain\Submission;
use SocialNews\Submission\Domain\SubmissionRepository;

final class DbalSubmissionRepository implements SubmissionRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(Submission $submission): void
    {
        $this->connection->exec("
            INSERT INTO
                submissions (id, title, url, creation_date)
                VALUES (
                        '{$submission->getId()->toString()}',
                        '{$submission->getTitle()}',
                        '{$submission->getUrl()}',
                        '{$submission->getCreationDate()->format('Y-m-d H:i:s')}'
                )
        ");
    }
}