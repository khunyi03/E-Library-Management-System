<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "Access Denied.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: show raw POST data
    var_dump($_POST); //  Remove this after testing

    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $description = $_POST['description'] ?? '';
    $cover_url = $_POST['cover_url'] ?? '';

    if (!$title || !$author) {
        echo "Title and Author are required.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO books (title, author, genre, isbn, description, cover_url, status) VALUES (?, ?, ?, ?, ?, ?, 'available')");
        $stmt->execute([$title, $author, $genre, $isbn, $description, $cover_url]);

        echo "Book Added";
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Database Error: " . $e->getMessage();
    }
}
?>
