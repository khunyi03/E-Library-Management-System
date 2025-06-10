<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Access Denied.');
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
$stmt->execute([$id]);

header('Location: admin_dashboard.php');
exit();
?>
