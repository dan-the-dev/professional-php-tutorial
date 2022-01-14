<?php
declare(strict_types=1);

namespace SocialNews\Submission\Presentation;

use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Submission\Application\SubmitLink;
use SocialNews\Submission\Application\SubmitLinkHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class SubmissionController
{
    private TemplateRenderer $templateRenderer;
    private StoredTokenValidator $storedTokenValidator;
    private Session $session;
    private SubmitLinkHandler $submitLinkHandler;

    public function __construct(TemplateRenderer $templateRenderer, StoredTokenValidator $storedTokenValidator, Session $session, SubmitLinkHandler $submitLinkHandler)
    {
        $this->templateRenderer = $templateRenderer;
        $this->storedTokenValidator = $storedTokenValidator;
        $this->session = $session;
        $this->submitLinkHandler = $submitLinkHandler;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Submission.html.twig');
        return new Response($content);
    }

    public function submit(Request $request): Response
    {
        $response = new RedirectResponse('/submit');

        if (!$this->storedTokenValidator->validate('submission', new Token((string) $request->get('token')))) {
            $this->session->getFlashBag()->add('errors', 'Invalid Token');
            return $response;
        }

        $this->submitLinkHandler->handle(new SubmitLink($request->get('url'), $request->get('title')));

        $this->session->getFlashBag()->add('success', 'Your URL was submitted successfully.');
        return $response;
    }
}