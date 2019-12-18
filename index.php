<?php
    use Main\core\Router;
    use Main\core\Request;
    use Main\utils\DependencyInjector;
 
    require_once __DIR__ . "/vendor/autoload.php";
    $loader = new Twig_Loader_Filesystem(__DIR__);
    $twig = new Twig_Environment($loader);
    
    $di = new DependencyInjector();
    $di->set('Database', $db);
    $di->set('utils\config', $config);
    $di->set('Twig_Environment', $view);
    $di->set('Logger', $log);


    
    
    $request = new Request();
    $router = new Router();
    $htmlCode = $router->route(new Request());
    echo $htmlCode;     
    //echo "<h1>IS THIS WORKING</h1>";
?>