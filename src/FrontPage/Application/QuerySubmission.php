<?php
declare(strict_types=1);

namespace SocialNews\FrontPage\Application;

interface QuerySubmission
{
    /** @return Submission[] */
    public function execute(): array;
}