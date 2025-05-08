<?php
require 'includes/auth.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Project Unique</title>
    <!-- Modern Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Additional styles specific to landing page */
        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 5rem 0;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
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
                <a href="auth/login.php" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="auth/register.php" class="nav-link">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content animate__animated animate__fadeIn">
            <h1 class="gradient-text animate__animated animate__fadeInDown">Welcome to ✨ Inventory Management</h1>
            <p class="lead text-muted animate__animated animate__fadeIn animate__delay-1s">
                A complete PHP/MySQL web application with authentication and CRUD functionality.
                Note : Naa sa User.php ang tables sir
            </p>
            
            <div class="cta-buttons animate__animated animate__fadeInUp animate__delay-1s">
                <a href="auth/login.php" class="btn-glow">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="auth/register.php" class="btn-glow secondary">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <div class="container">
        <div class="features">
            <div class="feature-card animate__animated animate__fadeInLeft">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Secure Authentication</h3>
                <p class="text-muted">Password hashing and session management to keep your data safe.</p>
            </div>
            
            <div class="feature-card animate__animated animate__fadeInUp">
                <div class="feature-icon">
                    <i class="fas fa-database"></i>
                </div>
                <h3>CRUD Operations</h3>
                <p class="text-muted">Full Create, Read, Update, and Delete functionality with MySQL.</p>
            </div>
            
            <div class="feature-card animate__animated animate__fadeInRight">
                <div class="feature-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>Modern Design</h3>
                <p class="text-muted">Sleek glassmorphism UI with smooth animations and dark/light mode.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="glass-footer">
        <div class="container">
            <p class="text-center text-muted">© <?= date('Y') ?> ✨ Inventory Management. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/animations.js"></script>
</body>
</html>