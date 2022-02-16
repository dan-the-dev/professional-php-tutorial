<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

use Exception;

final class StoredTokenReader
{
    private TokenStorage $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @throws Exception
     */
    public function read(TokenKey $tokenKey): Token
    {
        $token = $this->tokenStorage->retrieve($tokenKey->toString());
        if (!is_null($token)) {
            return $token;
        }

        return $this->generateToken($tokenKey);
    }

    /**
     * @return Token
     * @throws Exception
     */
    public function generateToken(TokenKey $tokenKey): Token
    {
        $token = Token::generate();
        $this->tokenStorage->store($tokenKey, $token);
        return $token;
    }
}