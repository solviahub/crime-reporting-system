<?php
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crime Reporting System - Report Crime Anonymously</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
        <i class="fas fa-shield-alt me-2"></i>
        <span>CrimeReport</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>">
              <i class="fas fa-home"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>report-crime.php">
              <i class="fas fa-flag"></i> Report Crime
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>track-report.php">
              <i class="fas fa-search"></i> Track Report
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link emergency-btn" href="<?php echo BASE_URL; ?>sos-emergency.php">
              <i class="fas fa-exclamation-triangle"></i> SOS
            </a>
          </li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'super_admin'): ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>modules/admin/dashboard.php">
                  <i class="fas fa-tachometer-alt"></i> Admin
                </a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>modules/user/dashboard.php">
                  <i class="fas fa-user"></i> Dashboard
                </a>
              </li>
            <?php endif; ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/user/profile.php">
                    <i class="fas fa-user"></i> Profile
                  </a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>modules/auth/login.php">
                <i class="fas fa-sign-in-alt"></i> Login
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn-register" href="<?php echo BASE_URL; ?>modules/auth/register.php">
                <i class="fas fa-user-plus"></i> Register
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <main>