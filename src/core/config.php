<?php
    namespace Main\src\core;

    // Class for getting info from the app.json file.
    class Config {
        
        private $map;

        public function __construct() {
            // Gets the data from that file.
            $json = file_get_contents("config/app.json");
            // Decodes data from that file and changes $map to that data.
            $this->map = json_decode($json, true);
        }

        // Function that returns $map if it's set.
        public function get($key) {
            if (isset($this->map[$key])) {
                return $this->map[$key];
            }
        }
    }