<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "You must be logged in.";
    exit;
}

$userId = $_SESSION['user_id'];
$bookId = $_POST['book_id'] ?? null;
$action = $_POST['action'] ?? '';

if (!$bookId || !in_array($action, ['borrow', 'return'])) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

$stmt = $pdo->prepare("SELECT status FROM books WHERE book_id = ?");
$stmt->execute([$bookId]);
$book = $stmt->fetch();

if (!$book) {
    echo "Book not found.";
    exit;
}

if ($action === 'borrow') {
    if ($book['status'] !== 'available') {
        echo "Book is already borrowed.";
        exit;
    }

    $dueDate = date('Y-m-d', strtotime('+14 days'));

    try {
        $pdo->beginTransaction();

        $pdo->prepare("UPDATE books SET status = 'borrowed' WHERE book_id = ?")
            ->execute([$bookId]);

        $pdo->prepare("INSERT INTO loans (user_id, book_id, due_date) VALUES (?, ?, ?)")
            ->execute([$userId, $bookId, $dueDate]);

        $pdo->commit();
        echo "borrowed";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }

} elseif ($action === 'return') {
    try {
        $pdo->beginTransaction();

        $pdo->prepare("UPDATE books SET status = 'available' WHERE book_id = ?")
            ->execute([$bookId]);

        // Update only the most recent unreturned loan
        $pdo->prepare("
            UPDATE loans 
            SET returned_on = CURDATE() 
            WHERE loan_id = (
                SELECT loan_id FROM (
                    SELECT loan_id 
                    FROM loans 
                    WHERE user_id = ? AND book_id = ? AND returned_on IS NULL 
                    ORDER BY borrowed_on DESC 
                    LIMIT 1
                ) AS subquery
            )
        ")->execute([$userId, $bookId]);

        $pdo->commit();
        echo "returned";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
