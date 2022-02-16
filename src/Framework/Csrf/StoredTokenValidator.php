<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

final class StoredTokenValidator
{
    private TokenStorage $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function validate(TokenKey $tokenKey, TokenValue $token): bool
    {
        $storedToken = $this->tokenStorage->retrieve($tokenKey);
        if ($storedToken === null) {
            return false;
        }
        return $token->equals($storedToken);
    }
}