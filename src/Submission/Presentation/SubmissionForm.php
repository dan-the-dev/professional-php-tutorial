<?php
declare(strict_types=1);

namespace SocialNews\Submission\Presentation;

use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;
use SocialNews\Submission\Application\SubmitLink;

final class SubmissionForm
{
    private StoredTokenValidator $storedTokenValidator;
    private string $token;
    private string $title;
    private string $url;

    public function __construct(StoredTokenValidator $storedTokenValidator, string $token, string $title, string $url)
    {
        $this->storedTokenValidator = $storedTokenValidator;
        $this->token = $token;
        $this->title = $title;
        $this->url = $url;
    }

    /**
     * @return string[]
     */
    public function getValidationErrors(): array
    {
        $errors = [];

        if (!$this->storedTokenValidator->validate('submission', new Token($this->token))) {
            $errors[] = 'Invalid token';
        }
        if (strlen($this->title) < 1 || strlen($this->title) > 200) {
            $errors[] = 'Title must be between 1 and 200 characters.';
        }
        if (strlen($this->url) < 1 || strlen($this->url) > 200) {
            $errors[] = 'URL must be between 1 and 200 characters.';
        }

        return $errors;
    }

    public function hasValidationErrors(): bool
    {
        return (count($this->getValidationErrors()) > 0);
    }

    public function toCommand(): SubmitLink
    {
        return new SubmitLink(
            $this->url,
            $this->title
        );
    }
}