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

        $queryBuilder->addSelect('title');
        $queryBuilder->addSelect('url');
        $queryBuilder->from('submissions');
        $queryBuilder->orderBy('creation_date', 'DESC');

        $statement = $queryBuilder->executeQuery();
        $rows = $statement->fetchAllAssociative();

        $submissions = [];
        foreach ($rows as $row) {
            $submissions[] = new Submission($row['url'], $row['title']);
        }
        return $submissions;
    }
}