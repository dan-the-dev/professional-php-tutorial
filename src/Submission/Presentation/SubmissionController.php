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
    private SubmissionFormFactory $submissionFormFactory;
    private Session $session;
    private SubmitLinkHandler $submitLinkHandler;

    public function __construct(TemplateRenderer $templateRenderer, SubmissionFormFactory $submissionFormFactory, Session $session, SubmitLinkHandler $submitLinkHandler)
    {
        $this->templateRenderer = $templateRenderer;
        $this->submissionFormFactory = $submissionFormFactory;
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

        $form = $this->submissionFormFactory->createFromRequest($request);
        if ($form->hasValidationErrors()) {
            /** @var string $error */
            foreach ($form->getValidationErrors() as $error) {
                $this->session->getFlashBag()->add('errors', $error);
            }
            return $response;
        }

        $this->submitLinkHandler->handle($form->toCommand());

        $this->session->getFlashBag()->add('success', 'Your URL was submitted successfully.');
        return $response;
    }
}