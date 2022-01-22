<?php
declare(strict_types=1);

namespace SocialNews\FrontPage\Infrastructure;

use Doctrine\DBAL\Connection;
use SocialNews\FrontPage\Application\Submission;
use SocialNews\FrontPage\Application\QuerySubmission;

final class DbalSubmissionQuery implements QuerySubmission
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->addSelect('submissions.title');
        $queryBuilder->addSelect('submissions.url');
        $queryBuilder->addSelect('authors.nickname');
        $queryBuilder->from('submissions');
        $queryBuilder->join(
            'submissions',
            'users',
            'authors',
            'submissions.author_user_id = authors.id',
        );
        $queryBuilder->orderBy('submissions.creation_date', 'DESC');

        $statement = $queryBuilder->executeQuery();
        $rows = $statement->fetchAllAssociative();

        $submissions = [];
        foreach ($rows as $row) {
            $submissions[] = new Submission($row['url'], $row['title'], $row['nickname']);
        }
        return $submissions;
    }
}