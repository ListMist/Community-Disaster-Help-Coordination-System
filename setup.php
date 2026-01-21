<?php

$host = 'localhost';

$username = 'root';

$password = '';

$dbname = 'cdhcs_db';

$conn = mysqli_connect($host, $username, $password);

if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

if (mysqli_query($conn, $sql)) {

    mysqli_select_db($conn, $dbname);

    $schema = file_get_contents('config/schema.sql');

    // Remove the CREATE DATABASE and USE lines

    $schema = str_replace("CREATE DATABASE IF NOT EXISTS cdhcs_db;\n\nUSE cdhcs_db;\n\n", '', $schema);

    // Drop existing tables if they exist
    mysqli_query($conn, "DROP TABLE IF EXISTS help_requests");
    mysqli_query($conn, "DROP TABLE IF EXISTS users");

    if (mysqli_multi_query($conn, $schema)) {

        echo "Database and tables created successfully.";

    } else {

        echo "Error creating tables: " . mysqli_error($conn);

    }

} else {

    echo "Error creating database: " . mysqli_error($conn);

}

mysqli_close($conn);
?>