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
    public function read(string $key): Token
    {
        $token = $this->tokenStorage->retrieve($key);
        if (!is_null($token)) {
            return $token;
        }

        return $this->generateToken(new TokenKey($key));
    }

    /**
     * @return Token
     * @throws Exception
     */
    public function generateToken(TokenKey $tokenKey): Token
    {
        $token = Token::generate();
        $this->tokenStorage->store($tokenKey->toString(), $token);
        return $token;
    }
}