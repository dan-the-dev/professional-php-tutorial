<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

interface TokenStorage
{
    public function store(TokenKey $tokenKey, Token $token): void;

    public function retrieve(string $key): ?Token;
}