CREATE DATABASE IF NOT EXISTS cdhcs_db;

USE cdhcs_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('affected', 'volunteer', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS help_requests (
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
);

CREATE VIEW user_view AS SELECT id, username, email, role, created_at FROM users;
