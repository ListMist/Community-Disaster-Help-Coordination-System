<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Affected Person</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        ul { list-style: none; padding: 0; }
        li { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
        form { margin: 20px 0; }
        input, select, textarea, button { display: block; margin: 10px 0; padding: 8px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?> (Affected Person)</h1>
    <a href="/logout">Logout</a> | <a href="/profile">Profile</a>

    <h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"/></svg> Your Help Requests</h2>
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
</body>
</html>