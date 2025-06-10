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
    SELECT books.title, books.author, loans.due_date, loans.loan_id
    FROM loans
    JOIN books ON loans.book_id = books.book_id
    WHERE loans.user_id = ? AND loans.returned_on IS NULL
");
$stmt->execute([$userId]);
$loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($loans);
