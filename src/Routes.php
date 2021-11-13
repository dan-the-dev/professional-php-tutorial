<?php
declare(strict_types=1);

return [
    [
        'GET',
        '/',
        SocialNews\FrontPage\Presentation\FrontPageController::class . '#show',
    ],
    [
        'GET',
        '/submit',
        SocialNews\FrontPage\Presentation\FrontPageController::class . '#show',
    ],
];
