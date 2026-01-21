<?php
require_once '../config/database.php'; // Your Singleton Database class

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = Database::getInstance()->getConnection();

    // Mapping HTML names to variables
    $username = htmlspecialchars(trim($_POST['username']));
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role     = $_POST['role']; // Matches ENUM: affected, volunteer, admin

    try {
        $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$username, $email, $hashed_pass, $role])) {
            echo "<script>alert('Registration Successful!'); window.location.href='login_form.html';</script>";
        }
    } catch (PDOException $e) {
        die("Registration Error: " . $e->getMessage());
    }
}
?>