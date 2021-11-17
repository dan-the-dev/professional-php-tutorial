<?php
declare(strict_types=1);

namespace SocialNews\Framework\Rendering;

use Twig\Environment;

class TwigTemplateRenderer implements TemplateRenderer
{
    private Environment $twigEnvironment;

    public function __construct(Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function render(string $template, array $data = []): string
    {
        return $this->twigEnvironment->render($template, $data);
    }
}