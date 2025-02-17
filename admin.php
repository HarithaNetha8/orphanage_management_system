<?php
include 'db.php';

// Fetch all orphan records
$orphans = $pdo->query("SELECT * FROM orphans")->fetchAll(PDO::FETCH_ASSOC);

// Delete orphan logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->query("DELETE FROM orphans WHERE id = $id");
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <nav>
        <a href="dashboard.php">Home</a>
        <a href="upload.php">Upload Orphan</a>
        <a href="managers.php">Managers</a>
    </nav>
    <div class="container">
        <section class="card">
            <h2>Manage Orphans</h2>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orphans as $orphan): ?>
                        <tr>
                            <td><?php echo $orphan['id']; ?></td>
                            <td><?php echo $orphan['name']; ?></td>
                            <td><?php echo $orphan['location']; ?></td>
                            <td><img src="<?php echo $orphan['image_path']; ?>" alt="Image" width="50"></td>
                            <td>
                                <a href="admin.php?delete=<?php echo $orphan['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 Orphanage Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
