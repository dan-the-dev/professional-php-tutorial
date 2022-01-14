<?php
declare(strict_types=1);

use SocialNews\FrontPage\Presentation\FrontPageController;
use SocialNews\Submission\Presentation\SubmissionController;
use SocialNews\User\Presentation\RegistrationController;

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
    [
        'GET',
        '/register',
        RegistrationController::class . '#show',
    ],
    [
        'POST',
        '/register',
        RegistrationController::class . '#register',
    ],
];
