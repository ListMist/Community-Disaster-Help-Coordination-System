<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = Database::getInstance()->getConnection();
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['user']    = $user; // For consistency with project

        // Role-Based Redirection
        header("Location: dashboard");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials'); window.history.back();</script>";
    }
}
?>