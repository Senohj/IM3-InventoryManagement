<?php
require '../includes/db.php';
require '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (loginUser($pdo, $username, $password)) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Project Unique</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dark-theme">
    <div class="particles"></div>
    
    <main class="container">
        <div class="auth-container glass-card animate__animated animate__fadeIn">
            <div class="auth-header">
                <h1 class="gradient-text">Project Unique</h1>
                <p class="text-muted">Sign in to continue</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" class="auth-form">
                <div class="form-group">
                    <input type="text" name="username" class="glass-input" placeholder="Username" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" class="glass-input" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn-glow w-100">Login</button>
            </form>
            
            <div class="auth-footer">
                <p class="text-muted">Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </main>

    <script src="../assets/js/animations.js"></script>
</body>
</html>