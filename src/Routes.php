<?php
declare(strict_types=1);

use SocialNews\FrontPage\Presentation\FrontPageController;
use SocialNews\Submission\Presentation\SubmissionController;

return [
    [
        'GET',
        '/',
        FrontPageController::class . '#show',
    ],
    [
        'GET',
        '/submit',
        SubmissionController::class . '#show',
    ],
    [
        'POST',
        '/submit',
        SubmissionController::class . '#submit',
    ],
];
