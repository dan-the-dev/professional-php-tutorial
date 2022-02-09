<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

final class TokenKey
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

}