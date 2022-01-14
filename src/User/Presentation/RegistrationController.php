<?php
declare(strict_types=1);

namespace SocialNews\User\Presentation;

use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\User\Application\RegisterUserHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class RegistrationController
{
    private TemplateRenderer $templateRenderer;
    private RegisterUserFormFactory $registerUserFormFactory;
    private Session $session;
    private RegisterUserHandler $registerUserHandler;

    public function __construct(TemplateRenderer $templateRenderer, RegisterUserFormFactory $registerUserFormFactory, Session $session, RegisterUserHandler $registerUserHandler)
    {
        $this->templateRenderer = $templateRenderer;
        $this->registerUserFormFactory = $registerUserFormFactory;
        $this->session = $session;
        $this->registerUserHandler = $registerUserHandler;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Registration.html.twig');
        return new Response($content);
    }

    public function register(Request $request): Response
    {
        $response = new RedirectResponse('/register');
        $form = $this->registerUserFormFactory->createFromRequest($request);

        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $error) {
                $this->session->getFlashBag()->add('errors', $error);
            }
            return $response;
        }

        $this->registerUserHandler->handle($form->toCommand());

        $this->session->getFlashBag()->add('success', 'Your account was created. You can now log in.');
        return $response;
    }
}