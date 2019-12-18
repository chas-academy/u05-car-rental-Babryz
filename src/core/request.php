<?php
  
  namespace Main\core;
  
  class Request {
      private $path, $form;
      
      public function __construct() {
        $this->path = substr($_SERVER["REQUEST_URI"], 1);
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