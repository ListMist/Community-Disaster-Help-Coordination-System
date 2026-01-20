<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password - CDHCS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { max-width: 300px; }
        input, button { display: block; margin: 10px 0; padding: 8px; width: 100%; }
    </style>
</head>
<body>
    <h1>Reset Password</h1>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Reset Password</button>
    </form>
    <a href="/login">Back to Login</a>
</body>
</html>