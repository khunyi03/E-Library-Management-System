<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

echo "<h1>My Dashboard</h1>";

$stmt = $pdo->prepare("
    SELECT events.title, events.event_date, events.location
    FROM registrations
    JOIN events ON registrations.event_id = events.event_id
    WHERE registrations.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$events = $stmt->fetchAll();

if ($events) {
    foreach ($events as $event) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($event['title']) . "</h3>";
        echo "<p>Date: " . htmlspecialchars($event['event_date']) . " | Location: " . htmlspecialchars($event['location']) . "</p>";
        echo "</div><hr>";
    }
} else {
    echo "<p>You have not registered for any events yet.</p>";
}
?>
<a href="logout.php">Logout</a>
