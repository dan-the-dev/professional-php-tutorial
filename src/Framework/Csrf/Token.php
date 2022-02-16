<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

final class Token
{
    private TokenKey $tokenKey;
    private TokenValue $tokenValue;

    public function __construct(TokenKey $tokenKey, TokenValue $tokenValue)
    {
        $this->tokenKey = $tokenKey;
        $this->tokenValue = $tokenValue;
    }

    /**
     * @return TokenKey
     */
    public function tokenKey(): TokenKey
    {
        return $this->tokenKey;
    }

    /**
     * @return TokenValue
     */
    public function tokenValue(): TokenValue
    {
        return $this->tokenValue;
    }

    /**
     * @param TokenValue $anotherTokenValue
     * @return bool
     */
    public function valueEquals(TokenValue $anotherTokenValue): bool
    {
        return $this->tokenValue->equals($anotherTokenValue);
    }
}