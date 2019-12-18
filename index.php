<?php
    //use Main/core/Router;
    //use Main/core/Request;
 
    require_once __DIR__ . "/vendor/autoload.php";
    $loader = new Twig_Loader_Filesystem(__DIR__);
    $twig = new Twig_Environment($loader);
    
    function login() {
        $hostname = "localhost";
        $database = "carRental";
        $username = "root";
        $password = "secret";

        $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        if (!$connection) die($connection->errorInfo() [2]);
        return $connection;
    }
 
    
    /*
    $request = new Request();
    $router = new Router();
    $htmlCode = router->route($request, $twig);
    echo $htmlCode; */      
    echo "<h1>IS THIS WORKING</h1>";
?>