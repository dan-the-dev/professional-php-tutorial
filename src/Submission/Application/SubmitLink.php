<?php
declare(strict_types=1);

namespace SocialNews\Submission\Application;

final class SubmitLink
{
    private string $url;
    private string $title;

    public function __construct(string $url, string $title)
    {
        $this->url = $url;
        $this->title = $title;
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