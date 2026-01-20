<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Volunteer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        ul { list-style: none; padding: 0; }
        li { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?> (Volunteer)</h1>
    <a href="/logout">Logout</a> | <a href="/profile">Profile</a>

    <h2>Active Help Requests</h2>
    <ul>
        <?php foreach ($activeRequests as $req): ?>
            <li><?php echo htmlspecialchars($req['type']) . ' by ' . htmlspecialchars($req['username']) . ' - Urgency: ' . htmlspecialchars($req['urgency']) . ' - Location: ' . htmlspecialchars($req['location']); ?> <a href="/accept-request/<?php echo $req['id']; ?>">Accept</a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>