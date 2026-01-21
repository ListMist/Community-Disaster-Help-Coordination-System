<?php

require_once '../config/database.php';

try {

    $db = Database::getInstance()->getConnection();

    echo "Database connected successfully.";

    // Test query

    $stmt = $db->query("SELECT 1");

    echo " Query executed.";

} catch (Exception $e) {

    echo "Error: " . $e->getMessage();

}

?>