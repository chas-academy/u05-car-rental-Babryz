<?php
    /*
    use Main\core\Router;
    use Main\core\Request;
    use Main\utils\DependencyInjector;
    
    
    require_once "src/core/login.php";

    
    
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
    echo $htmlCode;     */
    
    echo <<< _END
    <table border="1" style="width: 70%;">
    <th colspan="5"><h1>Babryz Car Rental</h1></th>
    <tr>
        <form action="/listAllCustomers" method="POST">
            <td>
                <input type="submit" value="Customers" style="width: 100%;">
            </td>
        </form>
        <form action="/listAllCars" method="POST">
            <td>
                <input type="submit" value="Cars" style="width: 100%;">
            </td>
        </form>
        <form action="/checkOutCar" method="POST">
            <td>
                <input type="submit" value="Check Out Car" style="width: 100%;">
            </td>
        </form>
        <form action="/CheckInCar" method="POST">
            <td>
                <input type="submit" value="Check In Car" style="width: 100%;">
            </td>
        </form>
        <form action="/listHistory" method="POST">
            <td>
                <input type="submit" value="History" style="width: 100%;">
            </td>
        </form>
    </tr>
</table>
_END
    

    

    
?>