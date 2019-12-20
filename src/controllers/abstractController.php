<?php
    
    require_once '../core/request.php';
    require_once '../utils/dependencyinjector.php';

    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $di;

    public function __construct($di, $request) {
        $this->request = $request;
        $this->di = $di;
        $this->db = $di->get("PDO");
        $this->view = $di->get("Twig_Environment");
        $this->config = $di->get('utils/config');

    }

    public function render($template, $params) {
        return $this->view->loadTemplate($template)->render($params);
    }