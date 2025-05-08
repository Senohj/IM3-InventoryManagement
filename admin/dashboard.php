<?php
require '../includes/auth.php';
redirectIfNotAdmin();

require '../includes/db.php';

$users = $pdo->query("SELECT * FROM users")->fetchAll();
$posts = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Project Unique</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dark-theme">
    <div class="particles"></div>
    
    <nav class="glass-nav">
        <div class="container">
            <a href="#" class="logo">Admin Panel</a>
            <div class="nav-links">
                <a href="../dashboard.php">User View</a>
                <a href="../auth/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="header">
            <h1 class="gradient-text">Admin Dashboard</h1>
            <p class="text-muted">Manage all users and content</p>
        </div>
        
        <div class="admin-sections">
            <section class="admin-section">
                <h2>Users</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= ucfirst($user['role']) ?></td>
                                    <td>
                                        <a href="#" class="btn-action edit">Edit</a>
                                        <a href="#" class="btn-action delete">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section class="admin-section">
                <h2>Recent Posts</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <!-- Similar table structure for posts -->
                    </table>
                </div>
            </section>
        </div>
    </main>

    <script src="../assets/js/animations.js"></script>
</body>
</html>