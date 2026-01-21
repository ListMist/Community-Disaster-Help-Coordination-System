<?php
$host = "localhost";
$user = "root";
$password = "";
$dbName = "cdhcs_db";

// Connect to MySQL
$conn = mysqli_connect($host, $user, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
mysqli_select_db($conn, $dbName);

// Create users table if not exists
$tableSql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('affected', 'volunteer', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($tableSql) !== TRUE) {
    die("Error creating users table: " . $conn->error);
}

// Create help_requests table if not exists
$requestTableSql = "CREATE TABLE IF NOT EXISTS help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('food', 'shelter', 'medical') NOT NULL,
    description TEXT,
    urgency ENUM('low', 'medium', 'high') NOT NULL,
    location VARCHAR(255),
    status ENUM('pending', 'accepted', 'resolved') DEFAULT 'pending',
    accepted_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (accepted_by) REFERENCES users(id) ON DELETE SET NULL
)";
if ($conn->query($requestTableSql) !== TRUE) {
    die("Error creating help_requests table: " . $conn->error);
}
?>