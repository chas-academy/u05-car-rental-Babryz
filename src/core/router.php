<?php
  
  namespace Main\core;

  //use Main\controllers\errorController;
  //use Main\controllers\customerController;
  //use Main\utils\dependecyInjector;

  require_once '../utils/dependencyInjector.php';
  
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

        foreach ($this->routeMap as $route => $info) {
            $map = [];
            $params = isset($info["params"]) ? $info["params"]  : null;

            if ($this->match($route, $path, $params, $map)) {
                $controllerName = '\Main\controllers\\'; . $info["controller"] . "controller";
                $controller = new $controllerName($this->di, $request);
                $methodName = $info["method"];
                return call_user_func_array([$controller, $methodName], $map);
            }
        }
      }
  }


