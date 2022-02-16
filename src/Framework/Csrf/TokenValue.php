<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

use Exception;

final class TokenValue
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function toString(): string
    {
        return $this->token;
    }

    /**
     * @throws Exception
     */
    public static function generate(): TokenValue
    {
        return new TokenValue(bin2hex(random_bytes(256)));
    }

    public function equals(TokenValue $anotherToken): bool
    {
        return $this->token === $anotherToken->token;
    }
}