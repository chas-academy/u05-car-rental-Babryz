<?php
  namespace Main\src\core;
  
  // Class for functions related to getting url or form-data.
  class Request {
    private $path;
    private $method;
    private $form;

    public function __construct() {
        $pathArray = explode("?", $_SERVER["REQUEST_URI"]);
        $this->path = substr($pathArray[0], 1);
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->form = array_merge($_POST, $_GET);
    }

    // Gets path and method.
    public function getPath() {
        return $this->path;
    }

    // Gets form data.
    public function getForm() {
        return $this->form;
    }
}