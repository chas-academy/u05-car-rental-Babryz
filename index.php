<?php
   
   use Main\src\core\Config;
   use Main\src\core\Router;
   use Main\src\core\Request;
   use Main\src\utils\DependencyInjector;

   require_once __DIR__ . '/vendor/autoload.php';

   $config = new Config();
   $dbConfig = $config->get('database');

   $db = new PDO(
    'mysql:host=' . $dbConfig['host'] .
    ';dbname=' . $dbConfig['database'],
    $dbConfig['user'],
    $dbConfig['password']
    );

   $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
   $view = new Twig_Environment($loader);

   $di = new DependencyInjector();
   $di->set('PDO', $db);
   $di->set('utills/config', $config);
   $di->set('Twig_Environment', $view);

    echo "<!DOCTYPE html>";
    $router = new Router($di);
    $response = $router->route(new Request());
    echo $response;
