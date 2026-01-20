<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CDHCS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        ul { list-style: none; padding: 0; }
        li { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
        form { margin: 20px 0; }
        input, select, textarea, button { display: block; margin: 10px 0; padding: 8px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?> (<?php echo htmlspecialchars($user['role']); ?>)</h1>
    <a href="/logout">Logout</a> | <a href="/profile">Profile</a>

    <?php if ($user['role'] == 'affected'): ?>
        <h2>Your Help Requests</h2>
        <ul>
            <?php foreach ($requests as $req): ?>
                <li><?php echo htmlspecialchars($req['type']) . ' - Status: ' . htmlspecialchars($req['status']) . ' - Urgency: ' . htmlspecialchars($req['urgency']); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2>Submit New Help Request</h2>
        <form method="post" action="/submit-request">
            <select name="type" required>
                <option value="food">Food</option>
                <option value="shelter">Shelter</option>
                <option value="medical">Medical</option>
            </select>
            <textarea name="description" placeholder="Description" required></textarea>
            <select name="urgency" required>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <input type="text" name="location" placeholder="Location" required>
            <button type="submit">Submit Request</button>
        </form>
    <?php elseif ($user['role'] == 'volunteer'): ?>
        <h2>Active Help Requests</h2>
        <ul>
            <?php foreach ($activeRequests as $req): ?>
                <li><?php echo htmlspecialchars($req['type']) . ' by ' . htmlspecialchars($req['username']) . ' - Urgency: ' . htmlspecialchars($req['urgency']) . ' - Location: ' . htmlspecialchars($req['location']); ?> <a href="/accept-request/<?php echo $req['id']; ?>">Accept</a></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($user['role'] == 'admin'): ?>
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
    <?php endif; ?>
</body>
</html>