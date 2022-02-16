<?php
declare(strict_types=1);

namespace SocialNews\Framework\Csrf;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SymfonySessionTokenStorage implements TokenStorage
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function store(TokenKey $tokenKey, TokenValue $token): void
    {
        $this->session->set($tokenKey->toString(), $token->toString());
    }

    public function retrieve(TokenKey $tokenKey): ?TokenValue
    {
        $tokenValue = $this->session->get($tokenKey->toString());

        if (is_null($tokenValue)) {
            return null;
        }
        return new TokenValue($tokenValue);
    }
}