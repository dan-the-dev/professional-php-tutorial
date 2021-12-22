<?php

namespace SocialNews\Framework\Dbal;

final class DatabaseUrl
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}