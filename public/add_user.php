<?php
include '../config/db.php';

// Handle form submission
if (isset($_POST['mysubmit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        $message = "New user added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
<h2>Add New User</h2>

<?php if (isset($message)) echo "<p>$message</p>"; ?>

<form method="post">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Role:
    <select name="role">
        <option value="affected">Affected Person</option>
        <option value="volunteer">Volunteer</option>
        <option value="admin">Administrator</option>
    </select><br>
    <button type="submit" name="mysubmit">Add User</button>
</form>

<p><a href="register_form.html">Back to Registration</a></p>
</body>
</html>