<?php
// Database connection parameters for MAMP
$servername = "localhost";
$username = "root";
$password = "root";  // Default for MAMP is "root"
$dbname = "Assignment 8";  // Replace with your database name if different
$port = 8889;  // MAMP MySQL port

// Create connection (including the port)
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize POST data
$first_name     = $conn->real_escape_string($_POST['first_name']);
$last_name      = $conn->real_escape_string($_POST['last_name']);
$book_title     = $conn->real_escape_string($_POST['book_title']);
$book_author    = $conn->real_escape_string($_POST['book_author']);
$rating         = intval($_POST['rating']);
$written_review = $conn->real_escape_string($_POST['written_review']);
$review_date    = $_POST['review_date'];  // expecting format YYYY-MM-DD

// Insert the review into the table
$sql = "INSERT INTO YourFirstName_Reviews (first_name, last_name, book_title, book_author, rating, written_review, review_date)
        VALUES ('$first_name', '$last_name', '$book_title', '$book_author', $rating, '$written_review', '$review_date')";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Review Submitted Successfully!</h1>";
    echo "<p>Thank you, $first_name! Your review for <strong>$book_title</strong> by $book_author has been recorded.</p>";
    echo '<p><a href="review_form.html">Submit another review</a> | <a href="reviews.php">View all reviews</a></p>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


