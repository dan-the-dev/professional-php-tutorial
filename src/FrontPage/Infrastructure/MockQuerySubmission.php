<?php
declare(strict_types=1);

namespace SocialNews\FrontPage\Infrastructure;

use Doctrine\DBAL\Connection;
use SocialNews\FrontPage\Application\QuerySubmission;

final class MockQuerySubmission implements QuerySubmission
{
    private Connection $connection;

    private array $submissions = [
        ['url' => 'https://google.com', 'title' => 'Google'],
        ['url' => 'https://bing.com', 'title' => 'Bing'],
        ['url' => 'https://yahoo.com', 'title' => 'Yahoo'],
    ];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(): array
    {
        return $this->submissions;
    }
}