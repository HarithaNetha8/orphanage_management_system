<?php
include 'db.php'; // Database connection

$message = ''; // Message to display

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Find the user by username or email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username_or_email OR email = :username_or_email");
    $stmt->execute(['username_or_email' => $username_or_email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Start session and set session variables
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // Redirect to the dashboard page
        exit();
    } else {
        $message = "Invalid username/email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <nav>
        <a href="signup.php">Signup</a>
    </nav>
    <div class="container">
        <section class="form-section">
            <h2>Login</h2>
            <?php if ($message): ?>
                <p style="color: red;"><?php echo $message; ?></p> <!-- Display error message -->
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="username_or_email">Username or Email:</label>
                    <input type="text" id="username_or_email" name="username_or_email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </section>
    </div>
</body>
</html>
