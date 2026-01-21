<?php

class Database {

    private static $instance = null;

    private $conn;

    private function __construct() {

        $host = 'localhost';

        $dbname = 'cdhcs_db';

        $username = 'root';

        $password = '';

        $this->conn = mysqli_connect($host, $username, $password, $dbname);

        if (!$this->conn) {

            die("Database Error: " . mysqli_connect_error());

        }

    }

    public static function getInstance() {

        if (self::$instance == null) {

            self::$instance = new Database();

        }

        return self::$instance;

    }

    public function getConnection() {

        return $this->conn;

    }

}

?>