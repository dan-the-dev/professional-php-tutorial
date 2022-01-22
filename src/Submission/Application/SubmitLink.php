<?php
declare(strict_types=1);

namespace SocialNews\Submission\Application;

use Ramsey\Uuid\UuidInterface;

final class SubmitLink
{
    private string $url;
    private string $title;
    private UuidInterface $authorId;

    public function __construct(string $url, string $title, UuidInterface $authorId)
    {
        $this->url = $url;
        $this->title = $title;
        $this->authorId = $authorId;
    }

    /**
     * @return UuidInterface
     */
    public function getAuthorId(): UuidInterface
    {
        return $this->authorId;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


}