<?php
$host = 'localhost';
$dbname = 'OMS';
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
