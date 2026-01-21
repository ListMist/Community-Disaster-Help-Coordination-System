<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        ul { list-style: none; padding: 0; }
        li { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?> (Administrator)</h1>
    <a href="/logout">Logout</a> | <a href="/profile">Profile</a>

    <h2>All Users</h2>
    <ul>
        <?php foreach ($allUsers as $u): ?>
            <li><?php echo htmlspecialchars($u['username']) . ' (' . htmlspecialchars($u['role']) . ') - ' . htmlspecialchars($u['email']); ?> <a href="/delete-user/<?php echo $u['id']; ?>">Delete</a></li>
        <?php endforeach; ?>
    </ul>
    <h2>All Help Requests</h2>
    <ul>
        <?php foreach ($allRequests as $req): ?>
            <li><?php echo htmlspecialchars($req['type']) . ' by ' . htmlspecialchars($req['username']) . ' - Status: ' . htmlspecialchars($req['status']); ?> <a href="/delete-request/<?php echo $req['id']; ?>">Delete</a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>