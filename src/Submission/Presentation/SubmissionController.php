<?php
declare(strict_types=1);

namespace SocialNews\Submission\Presentation;

use LogicException;
use SocialNews\Framework\Rbac\AuthenticatedUser;
use SocialNews\Framework\Rbac\Permission\SubmitLink;
use SocialNews\Framework\Rbac\User;
use SocialNews\Framework\Rendering\TemplateRenderer;
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
    private User $user;

    public function __construct(
        TemplateRenderer $templateRenderer,
        SubmissionFormFactory $submissionFormFactory,
        Session $session,
        SubmitLinkHandler $submitLinkHandler,
        User $user
    )
    {
        $this->templateRenderer = $templateRenderer;
        $this->submissionFormFactory = $submissionFormFactory;
        $this->session = $session;
        $this->submitLinkHandler = $submitLinkHandler;
        $this->user = $user;
    }

    public function show(): Response
    {
        if (!$this->user->hasPermission(new SubmitLink())) {
            $this->session->getFlashBag()->add('errors', 'You have to log in before you can submit a link.');
            return new RedirectResponse('/login');
        }

        $content = $this->templateRenderer->render('Submission.html.twig');
        return new Response($content);
    }

    public function submit(Request $request): Response
    {
        if (!$this->user->hasPermission(new SubmitLink())) {
            $this->session->getFlashBag()->add('errors', 'You have to log in before you can submit a link.');
            return new RedirectResponse('/login');
        }

        $response = new RedirectResponse('/submit');

        $form = $this->submissionFormFactory->createFromRequest($request);
        if ($form->hasValidationErrors()) {
            /** @var string $error */
            foreach ($form->getValidationErrors() as $error) {
                $this->session->getFlashBag()->add('errors', $error);
            }
            return $response;
        }

        if (!$this->user instanceof AuthenticatedUser) {
            throw new LogicException('Only authenticated users can submit links.');
        }

        $this->submitLinkHandler->handle($form->toCommand($this->user));

        $this->session->getFlashBag()->add('success', 'Your URL was submitted successfully.');
        return $response;
    }
}