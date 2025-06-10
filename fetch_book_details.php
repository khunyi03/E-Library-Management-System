<?php
require 'db.php';

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        echo json_encode($book);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Book not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Book ID is required']);
}
?>
