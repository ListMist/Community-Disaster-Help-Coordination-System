<?php

$host = 'localhost';

$username = 'root';

$password = '';

$dbname = 'cdhcs_db';

try {

    $pdo = new PDO("mysql:host=$host", $username, $password);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");

    $pdo->exec("USE $dbname");

    $sql = file_get_contents('config/schema.sql');

    // Remove the CREATE DATABASE and USE lines

    $sql = str_replace("CREATE DATABASE IF NOT EXISTS cdhcs_db;\n\nUSE cdhcs_db;\n\n", '', $sql);

    $pdo->exec($sql);

    echo "Database and tables created successfully.";

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();

}

?>