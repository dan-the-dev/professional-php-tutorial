<?php
declare(strict_types=1);

namespace SocialNews\Framework\Rendering;

class TemplateDirectory
{
    private string $templateDirectory;

    public function __construct(string $rootDirectory)
    {
        $this->templateDirectory = $rootDirectory . DIRECTORY_SEPARATOR . 'templates';
    }

    public function toString(): string
    {
        return $this->templateDirectory;
    }
}