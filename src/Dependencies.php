<?php
declare(strict_types=1);

use Auryn\Injector;
use Doctrine\DBAL\Connection;
use SocialNews\Framework\Dbal\ConnectionFactory;
use SocialNews\Framework\Dbal\DatabaseUrl;
use SocialNews\Framework\Rendering\TemplateDirectory;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Framework\Rendering\TwigTemplateRendererFactory;
use SocialNews\FrontPage\Application\QuerySubmission;
use SocialNews\FrontPage\Infrastructure\DbalSubmissionQuery;

$injector = new Injector();

$injector->alias(QuerySubmission::class, DbalSubmissionQuery::class); // binding interface to implementation we want to use
$injector->share(QuerySubmission::class); // singleton

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]); // define instantiation rules for a class

$injector->delegate( // delegate the creation of a specific object to the given callable function
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

$injector->define(
    DatabaseUrl::class,
    [':url' => 'sqlite:///' . ROOT_DIR . '/storage/dbsqlite3']
);

$injector->delegate(Connection::class, function () use ($injector): Connection {
    $factory = $injector->make(ConnectionFactory::class);
    return $factory->create();
});

$injector->share(Connection::class);

return $injector;