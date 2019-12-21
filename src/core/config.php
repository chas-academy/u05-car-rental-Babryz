<?php
    namespace Main\src\core;

    class Config {
        
        private $map;

        public function __construct() {
            $json = file_get_contents("config/app.json");
            $this->map = json_decode($json, true);
        }

        public function get($key) {
            if (isset($this->map[$key])) {
                return $this->map[$key];
            }
        }
    }