<?php
declare(strict_types=1);

namespace SocialNews\FrontPage\Presentation;

use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\FrontPage\Application\QuerySubmission;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FrontPageController
{
    private TemplateRenderer $templateRenderer;
    private QuerySubmission $querySubmission;

    public function __construct(TemplateRenderer $templateRenderer, QuerySubmission $querySubmission)
    {
        $this->templateRenderer = $templateRenderer;
        $this->querySubmission = $querySubmission;
    }

    public function show(Request $request): Response
    {
        // controller decide how to show data coming from application layer, twig template in this case
        // the Submission implementation of execute is deciding what to show, in this case simply returning the data
        $content = $this->templateRenderer->render('FrontPage.html.twig', ['submissions' => $this->querySubmission->execute()]);
        return new Response($content);
    }
}