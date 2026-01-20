<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CDHCS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { max-width: 300px; }
        input, select, button { display: block; margin: 10px 0; padding: 8px; width: 100%; }
    </style>
</head>
<body>
    <h1>Login to CDHCS</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" name="login" onsubmit="return validateForm()">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="/register">Register here</a></p>
    <p><a href="/forget-password">Forgot Password?</a></p>
    <script>
        function validateForm() {
            var email = document.forms["login"]["email"].value;
            var password = document.forms["login"]["password"].value;
            if (email == "" || password == "") {
                alert("Email and password must be filled out");
                return false;
            }
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email format");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>