<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login_template.css">
</head>
<body>

<div class="login-box">
    <h2>Agent Login</h2>

    <form action="dashboard_agent.php" method="POST">

        <div class="input-group">
            <label>Username</label>
            <input type="text" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" required>
        </div>

        <button class="btn-login">Login</button>

    </form>

    <a href="index.html" class="back-home">← Back to Home</a>
</div>

</body>
</html>
