<?php
require_once '../../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ss", $username, $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['full_name'] = $user['full_name'];

      if ($user['role'] == 'admin' || $user['role'] == 'super_admin') {
        header('Location: ../../modules/admin/dashboard.php');
      } else {
        header('Location: ../../index.php');
      }
      exit();
    } else {
      $error = "Invalid password!";
    }
  } else {
    $error = "User not found!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Crime Reporting System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .login-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }

    .login-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .login-body {
      padding: 40px;
    }

    .btn-login {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      padding: 12px;
      font-weight: 600;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>
  <div class="container login-container">
    <div class="row justify-content-center w-100">
      <div class="col-md-6 col-lg-5">
        <div class="login-card">
          <div class="login-header">
            <i class="fas fa-shield-alt fa-3x mb-3"></i>
            <h2>Welcome Back</h2>
            <p class="mb-0">Login to your account</p>
          </div>
          <div class="login-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label class="form-label">Username or Email</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-login">
                  <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
              </div>
            </form>
            <hr>
            <p class="text-center mb-0">
              Don't have an account? <a href="register.php">Register here</a>
            </p>
            <p class="text-center mt-2">
              <a href="../../index.php">← Back to Home</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>