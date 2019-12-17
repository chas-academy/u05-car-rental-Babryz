<?php
  
  namespace Main\core;
  
  class Router {
      public function route($request, $twig) {
        $path = $request->getPath();
        $form = $request->getForm();

        if ($path == "") {
            $controller = new MainController();
            return $controller->MainMenu($twig);
            // -----

        } else if ($path == "/Path") {
            $controller = new BlaController();
            return $controller->bla($twig);

        } else if ($path == "/otherPath") {
            $controller = new BlaController();
            return $controller->bla($twig);

        } else {
            return "Router Error!";        }
      } 
  }
?>