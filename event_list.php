<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");

echo "<h1>Upcoming Events</h1>";

while ($row = $stmt->fetch()) {
    echo "<div>";
    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
    echo "<p>Date: " . htmlspecialchars($row['event_date']) . "</p>";
    echo "<a href='event_details.php?id=" . $row['event_id'] . "'>View Details</a>";
    echo "</div><hr>";
}
?>
