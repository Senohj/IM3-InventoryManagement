<?php
require '../includes/auth.php';
redirectIfNotLoggedIn();

require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit();
}

$postId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$postId]);
$post = $stmt->fetch();

if (!$post || ($post['user_id'] != $_SESSION['user_id'] && !isAdmin())) {
    header("Location: ../dashboard.php");
    exit();
}

// Delete image if exists
if ($post['image']) {
    $uploadDir = '../assets/uploads/';
    if (file_exists($uploadDir . $post['image'])) {
        unlink($uploadDir . $post['image']);
    }
}

// Delete post
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$postId]);

header("Location: ../dashboard.php");
exit();
?>