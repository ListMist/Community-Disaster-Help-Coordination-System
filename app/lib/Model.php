<?php

require_once __DIR__ . '/../../config/database.php';

class Model {

    protected $db;

    public function __construct() {

        try {

            $this->db = Database::getInstance()->getConnection();

        } catch (Exception $e) {

            $this->db = null;

            error_log("Database connection failed in Model: " . $e->getMessage());

        }

    }

}

?>