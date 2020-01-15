<?php
namespace Main\src\core;

  use Main\utils\DependencyInjector;
  use Main\src\controllers\MainMenuController;
  use Main\src\controllers\customerController;

  // Class for functions related to routing the correct controller and method in that controller.
  class Router {
      private $di;
      private $routeMap;

      // Construct that defines databases connection and json file ror the routes.
      public function __construct($di) {
        $this->di = $di;
        $json = file_get_contents(__DIR__."/../../config/routes.json");
        $this->routeMap = json_decode($json, true); 
      }

      // Function that finds correct controller and method to use depending on the url.
      public function route($request): string {
        $result = "";
        $path = $request->getPath();

        foreach ($this->routeMap as $route => $info) {
            $map = [];
            $params = isset($info["params"]) ? $info["params"]  : null;

            if ($this->match($route, $path, $params, $map)) {
                $controllerName = 'Main\src\controllers\\' . $info["controller"] . "Controller";
                $controller = new $controllerName($this->di, $request);
                $methodName = $info["method"];
                return call_user_func_array([$controller, $methodName], $map);
            }
        }
      }

      private function match($route, $path, $params, &$map) {
        $routeArray = explode("/", $route);
        $pathArray = explode("/", $path);
        $routeSize = count($routeArray);
        $pathSize = count($pathArray);    
        
        if ($routeSize === $pathSize) {
          for ($index = 0; $index < $routeSize; ++$index) {
            $routeName = $routeArray[$index];
            $pathName = $pathArray[$index];
    
            if ((strlen($routeName) > 0) && $routeName[0] === ":") {
              $key = substr($routeName, 1);
              $value = $pathName;
              
              if (($params != null) && isset($params[$key]) &&
                  !$this->typeMatch($value, $params[$key])) {
                return false;
              }
    
              $map[$key] = urldecode($value);
            }
            else if ($routeName !== $pathName) {
              return false;
            }
          }
          
          return true;
        }
        
        return false;
      }

      // Function that checks if params is a number or a string
      private function typeMatch($value, $type) {
        switch ($type) {
          case "number": 
            return preg_match('/^[0-9]+$/', $value);
        
          case "string":
            return preg_match('/^[%a-zA-Z0-9]+$/', $value);
        }
    
        return true;
      }
  }


