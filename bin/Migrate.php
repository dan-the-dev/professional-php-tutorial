<?php
declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Migrations\Migration202112011345;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

$injector = include(ROOT_DIR . '/src/Dependencies.php');

$connection = $injector->make(Connection::class);

$migration = new Migration202112011345($connection);
$migration->migrate();

echo "Finished running migrations" . PHP_EOL;
