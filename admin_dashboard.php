<?php
session_start();
require 'db.php';

// Check if admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Access Denied.');
}

echo "<h1>Admin Dashboard</h1>";
echo "<a href='admin_add_event.php'>Add New Event</a><br><br>";

$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");

while ($event = $stmt->fetch()) {
    echo "<div>";
    echo "<h3>" . htmlspecialchars($event['title']) . "</h3>";
    echo "<p>Date: " . htmlspecialchars($event['event_date']) . "</p>";
    echo "<a href='admin_edit_event.php?id=" . $event['event_id'] . "'>Edit</a> | ";
    echo "<a href='admin_delete_event.php?id=" . $event['event_id'] . "'>Delete</a>";
    echo "</div><hr>";
}
?>
