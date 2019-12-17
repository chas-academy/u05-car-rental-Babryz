<?php
  
  namespace Main\core;
  
  class Request {
      private $path, $form;
      
      public function __construct() {
        $this->path = $_SERVER["REQUEST_URI"];
        $this->form = $_POST;
      }

      public function getPath() {
          return $this->path;
      }

      public function getForm() {
          return $this->form;      
      }
  }
?>