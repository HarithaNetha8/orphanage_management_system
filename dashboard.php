<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $username; ?>!</h1>
    </header>
    <nav>
        <a href="logout.php">Logout</a>
        <a href="upload.php">Upload Orphan</a>
        <a href="orphanages.php">Orphanages</a>
        <a href="admin.php">Admin</a>
        <a href="contactus.php">Contact Us</a>
    </nav>
    <div class="container">
        <h2>Your Dashboard</h2>
        <ul>
            <li><a href="upload.php">Upload Orphan Details</a></li>
            <li><a href="orphanages.php">View Orphanages</a></li>
            <li><a href="admin.php">Admin Panel</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
        </ul>
    </div>
</body>
</html>
