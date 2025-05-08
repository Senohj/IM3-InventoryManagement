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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $deleteImage = isset($_POST['delete_image']);
    
    $image = $post['image'];
    
    // Handle new image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/uploads/';
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;
        
        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if ($image && file_exists($uploadDir . $image)) {
                    unlink($uploadDir . $image);
                }
                $image = $imageName;
            } else {
                $error = "Failed to upload image";
            }
        } else {
            $error = "Only JPG, PNG, and GIF images are allowed";
        }
    } elseif ($deleteImage && $image) {
        // Delete existing image
        $uploadDir = '../assets/uploads/';
        if (file_exists($uploadDir . $image)) {
            unlink($uploadDir . $image);
        }
        $image = null;
    }

    if (empty($title) || empty($content)) {
        $error = "Title and content are required";
    } elseif (strlen($title) > 100) {
        $error = "Title must be less than 100 characters";
    } else {
        // Update post
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
        if ($stmt->execute([$title, $content, $image, $postId])) {
            $success = "Post updated successfully!";
            header("Location: read.php?id=$postId");
            exit();
        } else {
            $error = "Failed to update post";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - ✨ Inventory Management</title>
    <link href="https://cdn.jsdeli<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | ✨ Inventory Management</title>

    <!-- Modern Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/project-unique/assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .editor-container {
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .image-preview {
            max-height: 200px;
            border-radius: 8px;
            display: none;
            margin-top: 1rem;
        }
    </style>
</head>
<body class="dark-theme">
    <!-- Animated Background -->
    <div class="particles"></div>

    <!-- Glassmorphism Navigation -->
    <nav class="glass-nav animate__animated animate__fadeInDown">
        <div class="nav-container">
            <a href="#" class="logo animate__animated animate__pulse animate__infinite animate__slower">✨ Inventory Management</a>
            <div class="nav-links">
                <a href="../dashboard.php" class="nav-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <?php if (isAdmin()): ?>
                    <a href="admin/dashboard.php" class="nav-link">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                <?php endif; ?>
                <a href="/project-unique/auth/logout.php" class="nav-link logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <div class="user-profile">
                <span class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <div class="avatar pulse"></div>
            </div>
        </div>
    </nav>

    <main class="container animate__animated animate__fadeIn">
        <div class="header">
            <h1 class="gradient-text">Edit Product</h1>
            <p class="text-muted">Make updates to your inventory product</p>
        </div>

        <div class="editor-container slide-in-left">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Product Name</label>
                    <input type="text" id="title" name="title" required class="glass-input"
                           value="<?= htmlspecialchars($post['title']) ?>">
                </div>

                <div class="form-group">
                    <label for="content">Description</label>
                    <textarea id="content" name="content" rows="8" required class="glass-input"><?= htmlspecialchars($post['content']) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Image</label>
                    <?php if ($post['image']): ?>
                        <div>
                            <img src="../assets/uploads/<?= htmlspecialchars($post['image']) ?>" class="image-preview">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="delete_image" name="delete_image">
                                <label class="form-check-label" for="delete_image">Delete this image</label>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>No image</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="image">Update Image</label>
                    <div class="file-upload">
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                        <label for="image" class="btn-upload">
                            <i class="fas fa-cloud-upload-alt"></i> Choose File
                        </label>
                        <span id="fileName">No file chosen</span>
                    </div>
                    <img id="imagePreview" class="image-preview" alt="Preview">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-glow">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                    <a href="../dashboard.php" class="btn-cancel btn-glow">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const fileName = document.getElementById('fileName');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    fileName.textContent = input.files[0].name;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
