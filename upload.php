<?php
include 'db.php'; // Database connection

$message = ''; // Variable to store messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['orphanName'];
    $location = $_POST['location'];
    $image = $_FILES['image'];

    // Define the upload directory
    $targetDir = "uploads/";
    
    // Ensure the upload directory exists, if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory with proper permissions
    }

    // Define the target file path
    $targetFile = $targetDir . uniqid() . '.' . strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    
    // Get the file extension
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Validate image type
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        $message = "The file is not an image.";
    }
    
    // Validate file size (limit: 5MB)
    elseif ($image["size"] > 5000000) {
        $message = "The file is too large. Maximum size allowed is 5MB.";
    }
    
    // Only allow certain file formats (JPG, PNG, JPEG, GIF)
    elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $message = "Only JPG, JPEG, PNG & GIF files are allowed.";
    } 
    
    // If no errors, proceed with the file upload
    else {
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            // Prepare the SQL query to insert orphan data into the database
            $stmt = $pdo->prepare("INSERT INTO orphans (name, location, image_path) VALUES (:name, :location, :image_path)");
            $stmt->execute(['name' => $name, 'location' => $location, 'image_path' => $targetFile]);
            
            $message = "Orphan details uploaded successfully!";
        } else {
            $message = "Failed to upload the image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Orphan Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Upload Orphan Details</h1>
    </header>
    <nav>
        <a href="dashboard.php">Home</a>
        <a href="admin.php">Admin</a>
        <a href="managers.php">Managers</a>
    </nav>
    <div class="container">
        <section class="form-section">
            <h2>Upload Orphan Information</h2>
            <?php if ($message): ?>
                <p style="color: green;"><?php echo $message; ?></p> <!-- Display message -->
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="orphanName">Orphan Name:</label>
                    <input type="text" id="orphanName" name="orphanName" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="image">Upload Photo:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit">Submit</button>
            </form>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 Orphanage Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
