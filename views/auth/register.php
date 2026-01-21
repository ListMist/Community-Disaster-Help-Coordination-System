<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CDHCS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { max-width: 300px; }
        input, select, button { display: block; margin: 10px 0; padding: 8px; width: 100%; }
    </style>
</head>
<body>
    <h1>Register for CDHCS</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" name="register" onsubmit="return validateForm()">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="affected">Affected Person</option>
            <option value="volunteer">Volunteer</option>
            <option value="admin">Administrator</option>
        </select>
        <button type="submit">Register</button>
    </form>
    <script>
        function validateForm() {
            var username = document.forms["register"]["username"].value;
            var email = document.forms["register"]["email"].value;
            var password = document.forms["register"]["password"].value;
            var role = document.forms["register"]["role"].value;
            if (username == "" || email == "" || password == "" || role == "") {
                alert("All fields must be filled out");
                return false;
            }
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email format");
                return false;
            }
            if (password.length < 6) {
                alert("Password must be at least 6 characters");
                return false;
            }
            return true;
        }
    </script>
    <p>Already have an account? <a href="/login">Login here</a></p>
</body>
</html>