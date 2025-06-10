<?php
$host = "localhost";
$dbname = "e_library"; // make sure this matches your actual database name
$username = "root";
$password = ""; // WAMP default: blank password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
