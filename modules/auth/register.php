<?php
require_once '../../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);

  // Validation
  if ($password != $confirmPassword) {
    $error = "Passwords do not match!";
  } else {
    // Check if username exists
    $checkSql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "ss", $username, $email);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
      $error = "Username or email already exists!";
    } else {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPassword, $fullName, $phone);

      if (mysqli_stmt_execute($stmt)) {
        $success = "Registration successful! You can now login.";
      } else {
        $error = "Registration failed. Please try again.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Crime Reporting System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }

    .register-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 50px 0;
    }

    .register-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }

    .register-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .register-body {
      padding: 40px;
    }

    .btn-register {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      padding: 12px;
      font-weight: 600;
    }

    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>
  <div class="container register-container">
    <div class="row justify-content-center w-100">
      <div class="col-md-8 col-lg-6">
        <div class="register-card">
          <div class="register-header">
            <i class="fas fa-user-plus fa-3x mb-3"></i>
            <h2>Create Account</h2>
            <p class="mb-0">Join us in making communities safer</p>
          </div>
          <div class="register-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
              <div class="alert alert-success"><?php echo $success; ?></div>
              <div class="text-center mt-3">
                <a href="login.php" class="btn btn-primary">Login Now</a>
              </div>
            <?php else: ?>
              <form method="POST">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" class="form-control" name="full_name" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Username *</label>
                    <input type="text" class="form-control" name="username" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Email Address *</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="tel" class="form-control" name="phone">
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Password *</label>
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                  </div>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-register">
                    <i class="fas fa-user-plus me-2"></i>Register
                  </button>
                </div>
              </form>
              <hr>
              <p class="text-center mb-0">
                Already have an account? <a href="login.php">Login here</a>
              </p>
              <p class="text-center mt-2">
                <a href="../../index.php">← Back to Home</a>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>