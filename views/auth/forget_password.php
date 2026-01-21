<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password - CDHCS</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%230066cc' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1Z'/></svg>">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        header {
            background: rgba(0, 102, 204, 0.8);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo svg {
            color: white;
        }
        .title h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .title p {
            margin: 0;
            font-size: 0.8rem;
            opacity: 0.8;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }
        nav a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px);
        }
        .forget-form {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        .forget-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0066cc;
            font-size: 28px;
            font-weight: bold;
        }
        .forget-form input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        .forget-form input:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 5px rgba(0, 102, 204, 0.3);
        }
        .forget-form button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0066cc, #004499);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 20px;
        }
        .forget-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
        }
        .forget-form button:active {
            transform: translateY(0);
        }
        .message {
            color: #27ae60;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 1rem;
            background: rgba(0, 102, 204, 0.8);
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1Z"/>
                </svg>
            </div>
            <div class="title">
                <h1>CDHCS</h1>
                <p>Community Disaster Help Coordination System</p>
            </div>
        </div>
        <nav>
            <a href="index.html">Home</a>
        </nav>
    </header>
    <main>
        <div class="forget-form">
            <h2>Reset Password</h2>
            <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>
            <form method="post" id="forget-password-form">
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
                <button type="submit">Reset Password</button>
            </form>
            <div class="back-link">
                <a href="login_form.html">Back to Login</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 CDHCS. All rights reserved.</p>
    </footer>
    <script src="../../assets/js/ajax.js"></script>
</body>
</html>