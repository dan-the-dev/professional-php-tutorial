<?php
declare(strict_types=1);

namespace SocialNews\User\Presentation;

use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;
use SocialNews\Framework\Csrf\TokenValue;
use SocialNews\Framework\Csrf\TokenKey;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\User\Application\Login;
use SocialNews\User\Application\LoginHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class LoginController
{
    private TemplateRenderer $templateRenderer;
    private StoredTokenValidator $storedTokenValidator;
    private Session $session;
    private LoginHandler $loginHandler;

    public function __construct(
        TemplateRenderer $templateRenderer,
        StoredTokenValidator $storedTokenValidator,
        Session $session,
        LoginHandler $loginHandler
    )
    {
        $this->templateRenderer = $templateRenderer;
        $this->storedTokenValidator = $storedTokenValidator;
        $this->session = $session;
        $this->loginHandler = $loginHandler;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Login.html.twig');
        return new Response($content);
    }

    public function login(Request $request): Response
    {
        $this->session->remove('userId');

        $token = $this->createToken($request);
        if (!$this->storedTokenValidator->validate($token)) {
            $this->session->getFlashBag()->add('errors', 'Invalid token');
        }

        $this->loginHandler->handle(new Login(
            (string) $request->get('nickname'),
            (string) $request->get('password')
        ));

        if ($this->session->get('userId') === null) {
            $this->session->getFlashBag()->add('errors', 'Invalid username or password.');
            return new RedirectResponse('/login');
        }

        $this->session->getFlashBag()->add('success', 'You were logged in.');
        return new RedirectResponse('/');
    }

    /**
     * @param Request $request
     * @return Token
     */
    private function createToken(Request $request): Token
    {
        $tokenKey = new TokenKey('login');
        $tokenValue = new TokenValue((string)$request->get('token'));
        return new Token($tokenKey, $tokenValue);
    }
}