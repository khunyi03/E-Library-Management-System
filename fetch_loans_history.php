<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT books.title, books.author, loans.borrowed_on, loans.returned_on
    FROM loans
    JOIN books ON loans.book_id = books.book_id
    WHERE loans.user_id = ? AND loans.returned_on IS NOT NULL
    ORDER BY loans.borrowed_on DESC
");
$stmt->execute([$userId]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($history);
