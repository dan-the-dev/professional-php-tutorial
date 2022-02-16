<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

interface TokenStorage
{
    public function store(TokenKey $tokenKey, TokenValue $token): void;

    public function retrieve(TokenKey $tokenKey): ?TokenValue;
}