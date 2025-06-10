<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
echo "<h1>Registration Confirmed</h1>";
echo "<p>Thank you for registering! Your ticket has been confirmed.</p>";
echo "<a href='dashboard.php'>View Your Events</a>";
?>
