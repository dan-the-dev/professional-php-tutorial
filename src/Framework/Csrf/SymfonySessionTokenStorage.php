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

    public function store(TokenKey $tokenKey, Token $token): void
    {
        $this->session->set($tokenKey->toString(), $token->toString());
    }

    public function retrieve(string $key): ?Token
    {
        $tokenValue = $this->session->get($key);

        if (is_null($tokenValue)) {
            return null;
        }
        return new Token($tokenValue);
    }
}