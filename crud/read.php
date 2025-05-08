<?php
require '../includes/auth.php';
redirectIfNotLoggedIn();

require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit();
}

$postId = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->execute([$postId]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - ✨ Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">✨ Inventory Management</a>
            <div class="navbar-nav">
                <a class="nav-link" href="../dashboard.php">Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <?php if ($post['image']): ?>
                        <img src="../assets/uploads/<?= htmlspecialchars($post['image']) ?>" class="card-img-top" alt="Post image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h1 class="card-title"><?= htmlspecialchars($post['title']) ?></h1>
                        <p class="text-muted">Posted by <?= htmlspecialchars($post['username']) ?> on <?= date('M j, Y', strtotime($post['created_at'])) ?></p>
                        <div class="card-text">
                            <?= nl2br(htmlspecialchars($post['content'])) ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($post['user_id'] == $_SESSION['user_id'] || isAdmin()): ?>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="update.php?id=<?= $post['id'] ?>" class="btn btn-secondary">Edit</a>
                                <a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>