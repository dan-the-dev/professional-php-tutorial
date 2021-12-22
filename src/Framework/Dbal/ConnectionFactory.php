<?php

namespace SocialNews\Framework\Dbal;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

final class ConnectionFactory
{
    private DatabaseUrl $databaseUrl;

    public function __construct(DatabaseUrl $databaseUrl)
    {
        $this->databaseUrl = $databaseUrl;
    }

    public function create(): Connection
    {
        return DriverManager::getConnection(
            ['url' => $this->databaseUrl],
            new Configuration()
        );
    }
}