<?php
declare(strict_types=1);

namespace SocialNews\FrontPage\Infrastructure;

use SocialNews\FrontPage\Application\QuerySubmission;

final class MockQuerySubmission implements QuerySubmission
{
    private array $submissions = [
        ['url' => 'https://google.com', 'title' => 'Google'],
        ['url' => 'https://bing.com', 'title' => 'Bing'],
        ['url' => 'https://yahoo.com', 'title' => 'Yahoo'],
    ];

    /**
     * @inheritDoc
     */
    public function execute(): array
    {
        return $this->submissions;
    }
}