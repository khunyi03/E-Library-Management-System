<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Access Denied.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    $stmt = $pdo->prepare("INSERT INTO events (title, description, location, category, event_date, event_time, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $location, $category, $event_date, $event_time, $_SESSION['user_id']]);
    echo "Event Added. <a href='admin_dashboard.php'>Back to Dashboard</a>";
}
?>

<form method="post">
    Title: <input type="text" name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    Location: <input type="text" name="location" required><br>
    Category: <input type="text" name="category" required><br>
    Date: <input type="date" name="event_date" required><br>
    Time: <input type="time" name="event_time" required><br>
    <button type="submit">Add Event</button>
</form>
