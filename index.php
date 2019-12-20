<?php
   use Main\core\config;
   use Main\core\router;
   use Main\core\request;
   use Main\utils\dependecyinjector;

   require_once 'config/app.json';
   require_once 'config/routes.json';
   require_once 'src/core/request.php';
   require_once 'src/core/router.php';
   require_once 'src/utils/dependencyInjector.php';

   require_once __DIR__ . '/vendor/autoload.php';

   $config = new Config();
   $dbConfig = $config->get('database');

   $db = new PDO('mysql:host=' . $dbConfig['host'] . 'dbname=' . $dbConfig['database'], $dbConfig['user'], $dbConfig['password']);

   $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
   $view = new Twig_Environment($loader);

   $di = new Dependecyinjector();
   $di->set('PDO', $db);
   $di->set('utills/config', $config);
   $di->set('Twig_Environment', $view);

    echo "<!DOCTYPE html>";
    $router = new Router($di);
    $response = $router->route(new Request());
    echo $response;
    print_r($di);
