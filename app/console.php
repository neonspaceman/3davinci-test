#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

// Load .env
(new Dotenv())->load(__DIR__ . '/../.env');

// Set connection
$connParams = [ 'url' => $_ENV['DATABASE_URL'] ];
$conn = \Doctrine\DBAL\DriverManager::getConnection($connParams, new \Doctrine\DBAL\Configuration());

// Console application
$application = new Application();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet([
  'db' => new ConnectionHelper($conn),
]);
$application->setHelperSet($helperSet);

$application->add(new \Github\Commands\GetUsers());

$application->run();