<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Access Denied.');
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    die('Book not found.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $isbn = $_POST['isbn'];
    $description = $_POST['description'];
    $cover_url = $_POST['cover_url'];

    $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, genre=?, isbn=?, description=?, cover_url=? WHERE id=?");
    $stmt->execute([$title, $author, $genre, $isbn, $description, $cover_url, $id]);

    echo "Book Updated. <a href='admin_dashboard.php'>Back to Dashboard</a>";
    exit();
}
?>

<!-- Optional: for standalone testing -->
<form method="post">
    Title: <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required><br>
    Author: <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required><br>
    Genre: <input type="text" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>"><br>
    ISBN: <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>"><br>
    Description: <textarea name="description"><?php echo htmlspecialchars($book['description']); ?></textarea><br>
    Cover Image URL: <input type="url" name="cover_url" value="<?php echo htmlspecialchars($book['cover_url']); ?>"><br>
    <button type="submit">Update Book</button>
</form>
