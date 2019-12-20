<?php
  
  namespace Main\core;

  use Main\controllers\errorController;
  use Main\controllers\customerController;
  use Main\utils\dependecyInjector;
  
  class Router {
      private $di;
      private $routeMap;

      public function __construct($di) {
        $this->di = $di;
        $json = file_get_contents(__DIR__."/../../config/routes.json");
        $this->routeMap = json_decode($json, true); 
      }

      public function route($request): string {
        $result = "";
        $path = $request->getPath();
      }
  }
?>