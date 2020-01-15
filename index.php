<?php
   
   use Main\src\core\Config;
   use Main\src\core\Router;
   use Main\src\core\Request;
   use Main\src\utils\DependencyInjector;

   require_once __DIR__ . '/vendor/autoload.php';

   // Gets info on database.
   $config = new Config();
   $dbConfig = $config->get('database');

   // Creates PDO object with database info to connect to mysql.
   $db = new PDO(
    'mysql:host=' . $dbConfig['host'] .
    ';dbname=' . $dbConfig['database'],
    $dbConfig['user'],
    $dbConfig['password']
    );

   // Defines twig environment.
   $loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
   $view = new Twig_Environment($loader);

   // Sets values in dependencyInjector.
   $di = new DependencyInjector();
   $di->set('PDO', $db);
   $di->set('utills/config', $config);
   $di->set('Twig_Environment', $view);

   // Renders that the page is html.
   echo "<!DOCTYPE html>";
   // Calls router function to check which controller and method to use and also if there's any parameters.
   // Then executes that method.
   $router = new Router($di);
   $response = $router->route(new Request());
   // Renders result of the executed method as html.
   echo $response;
