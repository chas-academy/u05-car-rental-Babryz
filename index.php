<?php
    use Main/core/router;
    use Main/core/request;

    require_once __DIR__ . "vendor/autoload.php";
    $loader = new Twig_Loader_Filesystem(__DIR__);
    $twig = new Twig_Environment($loader);

    $request = new Request();
    $router = new Router();
    $htmlCode = router->route($request, $twig);
    echo $htmlCode;

    echo "<h1>IS THIS WORKING</h1>";
?>