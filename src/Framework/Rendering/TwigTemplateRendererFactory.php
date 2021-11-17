<?php
declare(strict_types=1);

namespace SocialNews\Framework\Rendering;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigTemplateRendererFactory
{
    private TemplateDirectory $templateDirectory;

    public function __construct(TemplateDirectory $templateDirectory)
    {
        $this->templateDirectory = $templateDirectory;
    }

    public function create(): TwigTemplateRenderer
    {
      $loader = new FilesystemLoader([$this->templateDirectory->toString()]);
      $twigEnvironment = new Environment($loader);
      return new TwigTemplateRenderer($twigEnvironment);
    }
}