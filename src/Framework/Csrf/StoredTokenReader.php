<?php

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
    public function read(string $key): Token
    {
        $token = $this->tokenStorage->retrieve($key);
        if (!is_null($token)) {
            return $token;
        }

        return $this->generateToken($key);
    }

    /**
     * @param string $key
     * @return Token
     * @throws Exception
     */
    public function generateToken(string $key): Token
    {
        $token = Token::generate();
        $this->tokenStorage->store($key, $token);
        return $token;
    }
}