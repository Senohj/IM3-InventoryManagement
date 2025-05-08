<?php
require 'includes/auth.php';
redirectIfNotLoggedIn();

require 'includes/db.php';

// Get user's posts
$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Project Unique</title>
    
    <!-- Modern Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dark-theme">
    <!-- Animated Background -->
    <div class="particles"></div>
    
    <!-- Glassmorphism Navigation -->
    <nav class="glass-nav animate__animated animate__fadeInDown">
        <div class="nav-container">
            <a href="#" class="logo animate__animated animate__pulse animate__infinite animate__slower">✨ Inventory Management</a>
            <div class="nav-links">
                <!-- <a href="/project-unique/dashboard.php" class="nav-link"> -->
                    <!-- <i class="fas fa-home"></i> Dashboard -->
                    Dashboard
                <!-- </a> -->
                <a href="crud/create.php" class="nav-link">
                    <i class="fas fa-plus-circle"></i> New Product
                </a>
                <?php if (isAdmin()): ?>
                    <a href="admin/dashboard.php" class="nav-link">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                <?php endif; ?>
                <a href="auth/logout.php" class="nav-link logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <div class="user-profile">
                <span class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <div class="avatar pulse"></div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container animate__animated animate__fadeIn">
        <div class="header">
            <h1 class="gradient-text">Manage Inventory</h1>
            <p class="subtitle text-muted">Manage your inventory with ease</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card slide-in-left">
                <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                <h3><?= count($posts) ?></h3>
                <p>Total Posts</p>
            </div>
            <div class="stat-card slide-in-right">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <h3>0</h3>
                <p>Pending</p>
            </div>
        </div>

        <!-- Posts Grid -->
        <section class="posts-section">
            <h2 class="section-title">Your Recent Products</h2>
            
            <?php if (empty($posts)): ?>
                <div class="empty-state zoom-in">
                    <i class="fas fa-pen-fancy"></i>
                    <h3>No products yet</h3>
                    <p>Create your first product to get started</p>
                    <a href="crud/create.php" class="btn-glow">Add a Product</a>
                </div>
            <?php else: ?>
                <div class="posts-grid">
                    <?php foreach ($posts as $post): ?>
                        <div class="post-card animate__animated animate__fadeInUp">
                            <?php if ($post['image']): ?>
                                <div class="post-image" style="background-image: url('assets/uploads/<?= htmlspecialchars($post['image']) ?>')"></div>
                            <?php endif; ?>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date"><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                                    <span class="post-status">Published</span>
                                </div>
                                <h3 class="post-title"><?= htmlspecialchars($post['title']) ?></h3>
                                <p class="post-excerpt"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 150))) ?>...</p>
                                <div class="post-actions">
                                    <a href="crud/read.php?id=<?= $post['id'] ?>" class="btn-action view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="crud/update.php?id=<?= $post['id'] ?>" class="btn-action edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="crud/delete.php?id=<?= $post['id'] ?>" class="btn-action delete" onclick="return confirm('Delete this post?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Floating Action Button -->
    <a href="crud/create.php" class="fab animate__animated animate__bounceInUp">
        <i class="fas fa-plus">+</i>
    </a>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript -->
    <script src="assets/js/animations.js"></script>
</body>
</html>