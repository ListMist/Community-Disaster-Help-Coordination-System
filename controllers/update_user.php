<?php
include '../config/db.php';

if (!isset($_GET['id'])) {
    die("No user ID provided.");
}

$id = intval($_GET['id']);
$msg = "";

// Fetch existing data
$res = $conn->query("SELECT * FROM users WHERE id = $id");
if ($res->num_rows == 0) die("User not found.");
$user = $res->fetch_assoc();

// Handle update form
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $updateFields = "username=?, email=?, role=?";
    $types = "sss";
    $params = [$username, $email, $role];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updateFields .= ", password=?";
        $types .= "s";
        $params[] = $password;
    }

    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare("UPDATE users SET $updateFields WHERE id=?");
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) $msg = "Updated successfully!";
    else $msg = "Error: " . $stmt->error;
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
<h2>Update User</h2>
<?php if($msg) echo "<p>$msg</p>"; ?>

<form method="post">
    Username: <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
    Password: <input type="password" name="password" placeholder="Leave blank to keep current"><br>
    Role:
    <select name="role">
        <option value="affected" <?= $user['role']=='affected'?'selected':'' ?>>Affected Person</option>
        <option value="volunteer" <?= $user['role']=='volunteer'?'selected':'' ?>>Volunteer</option>
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Administrator</option>
    </select><br>
    <button type="submit" name="update">Update</button>
</form>

<p><a href="list_users.php">Back to User List</a></p>
</body>
</html>