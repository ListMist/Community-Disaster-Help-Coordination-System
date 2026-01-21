<?php
// Include your new Singleton Database class
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get the single database connection
    $db = Database::getInstance()->getConnection();

    // 2. Map form names to variables
    // Note: your HTML uses 'username', 'email', 'password', and 'role'
    $name     = htmlspecialchars(trim($_POST['username']));
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    // 3. Basic PHP Validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        die("An error occurred: All fields are required.");
    }

    try {
        // 4. Secure Password Hashing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // 5. Database Interaction (SQL)
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$name, $email, $hashed_password, $role])) {
            echo "<script>
                    alert('Account created successfully!');
                    window.location.href='login.php';
                  </script>";
        }
    } catch (PDOException $e) {
        // 6. Detailed Error Catching
        if ($e->getCode() == 23000) {
            die("An error occurred: That email or username is already registered.");
        } else {
            // During development, seeing the actual error helps a lot
            die("Database Error: " . $e->getMessage());
        }
    }
}
?>