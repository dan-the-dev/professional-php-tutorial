<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

final class Token
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
     * @throws \Exception
     */
    public static function generate(): Token
    {
        return new Token(bin2hex(random_bytes(256)));
    }

    public function equals(Token $anotherToken): bool
    {
        return $this->token === $anotherToken->token;
    }
}