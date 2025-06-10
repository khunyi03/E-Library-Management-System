<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Access Denied.');
}

if (!isset($_GET['id'])) {
    die('Book ID missing.');
}

$book_id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$book_id]);

header('Location: admin_dashboard.php'); // or wherever your admin panel loads books
exit();
?>
