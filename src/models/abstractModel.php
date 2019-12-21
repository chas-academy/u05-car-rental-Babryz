<?php

namespace Main\src\models;

use PDO;

abstract class AbstractModel {
    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
}