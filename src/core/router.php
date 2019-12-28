<?php
namespace Main\src\core;

  use Main\utils\DependencyInjector;
  use Main\src\controllers\MainMenuController;
  use Main\src\controllers\customerController;

  
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
                $controllerName = 'Main\src\controllers\\' . $info["controller"] . "Controller";
                $controller = new $controllerName($this->di, $request);
                $methodName = $info["method"];
                return call_user_func_array([$controller, $methodName], $map);
            }
        }
      }

      private function match($route, $path, $params, &$map) {
        // $routeArray: ["editCustomer", ":customerNumber", ":customerName"]
        // $pathArray ["editCustomer", "7", "Erik%20Dumas"]
          
        $routeArray = explode("/", $route);
        $pathArray = explode("/", $path);
        $routeSize = count($routeArray);
        $pathSize = count($pathArray);    
        
        if ($routeSize === $pathSize) {
          for ($index = 0; $index < $routeSize; ++$index) {
            // $routeName: ":customerNumber"
            // $pathName: "7"
            $routeName = $routeArray[$index];
            $pathName = $pathArray[$index];
    
            if ((strlen($routeName) > 0) && $routeName[0] === ":") {
              // $key: "customerNumber"
              // $value: "7"
              $key = substr($routeName, 1);
              $value = $pathName;
              
              // "customerNumber": "number",
              if (($params != null) && isset($params[$key]) &&
                  !$this->typeMatch($value, $params[$key])) {
                return false;
              }
    
              // $map["customerNumber"] = "7";
              // $map["customerName"] = "Erik Dumas";
              $map[$key] = urldecode($value); // "%20" => " ", urlcode: " " => "%20"
            }
            else if ($routeName !== $pathName) {
              return false;
            }
          }
          
          return true;
        }
        
        return false;
      }

      private function typeMatch($value, $type) {
        switch ($type) {
          case "number": // ^: början, $: slutet, +: ett eller flera, *: noll eller flera, ?, exakt ett
            return preg_match('/^[0-9]+$/', $value);
        
          case "string":
            return preg_match('/^[%a-zA-Z0-9]+$/', $value);
        }
    
        return true;
      }
  }


