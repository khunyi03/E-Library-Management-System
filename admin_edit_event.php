<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Access Denied.');
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    die('Event not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    $stmt = $pdo->prepare("UPDATE events SET title=?, description=?, location=?, category=?, event_date=?, event_time=? WHERE event_id=?");
    $stmt->execute([$title, $description, $location, $category, $event_date, $event_time, $id]);
    echo "Event Updated. <a href='admin_dashboard.php'>Back to Dashboard</a>";
    exit();
}
?>

<form method="post">
    Title: <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>
    Description: <textarea name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>
    Location: <input type="text" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required><br>
    Category: <input type="text" name="category" value="<?php echo htmlspecialchars($event['category']); ?>" required><br>
    Date: <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required><br>
    Time: <input type="time" name="event_time" value="<?php echo $event['event_time']; ?>" required><br>
    <button type="submit">Update Event</button>
</form>
