<?php
require '../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

\App\App::setBasePath(dirname(__DIR__));

\App\Utils\DotEnv::load();

date_default_timezone_set('Europe/Paris');

if (getenv('SENTRY_DSN') !== null && is_string(getenv('SENTRY_DSN'))) {
    Sentry\init(['dsn' => getenv('SENTRY_DSN') ]);
}

$app = new \App\App();

\App\Utils\WhoopsGuard::load($app, $app->getContainer());

$app->run();
