<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\AssetServiceProvider(), array());
$app->register(new Silex\Provider\SessionServiceProvider());

$app['debug'] = true;