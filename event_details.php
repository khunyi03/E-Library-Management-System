<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    die("Event not found.");
}

$event_id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    die("Event not found.");
}

echo "<h1>" . htmlspecialchars($event['title']) . "</h1>";
echo "<p>" . nl2br(htmlspecialchars($event['description'])) . "</p>";
echo "<p>Location: " . htmlspecialchars($event['location']) . "</p>";
echo "<p>Date: " . htmlspecialchars($event['event_date']) . " | Time: " . htmlspecialchars($event['event_time']) . "</p>";

if (isset($_SESSION['user_id'])) {
    echo "<form method='post'>
            <button type='submit' name='register'>Register</button>
          </form>";

    if (isset($_POST['register'])) {
        $stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $event_id]);
        echo "You have successfully registered!";
    }
} else {
    echo "<a href='login.php'>Login to register</a>";
}
?>
