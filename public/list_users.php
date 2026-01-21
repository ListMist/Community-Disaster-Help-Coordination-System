<?php
include '../config/db.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: list_users.php");
    exit;
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
<h2>All Users</h2>
<p><a href="add_user.php">Add New User</a></p>

<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Created At</th>
    <th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['role']) ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
        <a href="update_user.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="list_users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>