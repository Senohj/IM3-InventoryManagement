<?php
require '../includes/auth.php';
redirectIfNotLoggedIn();

require '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    // File upload handling
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/uploads/';
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;
        
        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = $imageName;
            } else {
                $error = "Failed to upload image";
            }
        } else {
            $error = "Only JPG, PNG, and GIF images are allowed";
        }
    }

    if (empty($title) || empty($content)) {
        $error = "Title and content are required";
    } elseif (strlen($title) > 100) {
        $error = "Title must be less than 100 characters";
    } else {
        // Insert post
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, image) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $title, $content, $image])) {
            $success = "Post created successfully!";
            header("Location: ../dashboard.php");
            exit();
        } else {
            $error = "Failed to create post";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | ✨ Inventory Management</title>
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
                <!-- <a href="create.php" class="nav-link active">
                    <i class="fas fa-plus-circle"></i> -->
                    New Product
                <!-- </a> -->
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
            <h1 class="gradient-text">Add New Product</h1>
            <p class="text-muted">Create a new Product for the Inventory!</p>
        </div>
        
        <div class="editor-container slide-in-left">
            <form method="POST" enctype="multipart/form-data" id="postForm">
                <div class="form-group">
                    <label for="title">Product Name</label>
                    <input type="text" id="title" name="title" required 
                           class="glass-input" placeholder="Enter Product Name">
                </div>
                
                <div class="form-group">
                    <label for="content">Description</label>
                    <textarea id="content" name="content" rows="8" required
                              class="glass-input" placeholder="Write the product description here..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <div class="file-upload">
                        <input type="file" id="image" name="image" accept="image/*"
                               onchange="previewImage(this)">
                        <label for="image" class="btn-upload">
                            <i class="fas fa-cloud-upload-alt"></i> Choose File
                        </label>
                        <span id="fileName">No file chosen</span>
                    </div>
                    <img id="imagePreview" class="image-preview" alt="Preview">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-glow">
                        <i class="fas fa-paper-plane"></i> Publish Product
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