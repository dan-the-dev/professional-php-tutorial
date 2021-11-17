<?php
declare(strict_types=1);

namespace SocialNews\FrontPage\Presentation;

use SocialNews\Framework\Rendering\TemplateRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FrontPageController
{
    private TemplateRenderer $templateRenderer;
    private array $templateData = [
        'submissions' => [
            ['url' => 'https://google.com', 'title' => 'Google'],
            ['url' => 'https://bing.com', 'title' => 'Bing'],
            ['url' => 'https://yahoo.com', 'title' => 'Yahoo'],
        ],
    ];

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function show(Request $request): Response
    {
        $content = $this->templateRenderer->render('FrontPage.html.twig', $this->templateData);
        return new Response($content);
    }
}