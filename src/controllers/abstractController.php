<?php
namespace Main\src\controllers;

    use Main\src\core\Request;
    use Main\src\utils\DependencyInjector;

    // Class that all other controller classes exstends from and uses downbelow variables as constructors.
    abstract class AbstractController {
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
    }