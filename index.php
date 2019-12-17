<?php
   //use Main/core/router;
   //use Main/core/request;

   //require_once __DIR__ . "vendor/autoload.php";

   $db = new PDO(
       'mysql:host=localhost;
       dbname=carRental;',
       'root',
       'secret');

   $query = $db->prepare("select * from customers");
   $query->execute();
   
   <table>
   for ($i = 0; $i < count($query); $i++) {
       echo <<<_END  
        
       _END
   }
   
   /*
   $loader = new Twig_Loader_Filesystem(__DIR__);
   $twig = new Twig_Environment($loader);      
   $request = new Request();
   $router = new Router();
   $htmlCode = router->route($request, $twig);
   echo $htmlCode; */      
   echo "<h1>IS THIS WORKING</h1>";
?>