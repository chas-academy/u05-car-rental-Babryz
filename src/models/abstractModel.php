<?php

namespace Main\src\models;

use PDO;

// Class that all other classes extends from.
abstract class AbstractModel {
    protected $db;

    // Function for constructing all classes which uses database as constructor.
    public function __construct($db) {
        $this->db = $db;
    }
}