<?php
require 'db.php';

$title = $_GET['title'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM books WHERE title = ?");
$stmt->execute([$title]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($books);
?>
