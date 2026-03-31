<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Get user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  // Check if email is already taken by another user
  $checkSql = "SELECT id FROM users WHERE email = ? AND id != ?";
  $checkStmt = mysqli_prepare($conn, $checkSql);
  mysqli_stmt_bind_param($checkStmt, "si", $email, $user_id);
  mysqli_stmt_execute($checkStmt);
  mysqli_stmt_store_result($checkStmt);

  if (mysqli_stmt_num_rows($checkStmt) > 0) {
    $error = "Email already in use by another account!";
  } else {
    $updateSql = "UPDATE users SET full_name = ?, phone = ?, email = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "sssi", $full_name, $phone, $email, $user_id);

    if (mysqli_stmt_execute($updateStmt)) {
      $_SESSION['full_name'] = $full_name;
      $success = "Profile updated successfully!";
      // Refresh user data
      $user['full_name'] = $full_name;
      $user['phone'] = $phone;
      $user['email'] = $email;
    } else {
      $error = "Error updating profile!";
    }
  }
}

include '../../includes/header.php';
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white text-center py-4">
          <i class="fas fa-user-circle fa-3x"></i>
          <h3 class="mb-0 mt-2">My Profile</h3>
        </div>
        <div class="card-body p-5">
          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
              <small class="text-muted">Username cannot be changed</small>
            </div>
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Account Type</label>
              <input type="text" class="form-control" value="<?php echo ucfirst($user['role']); ?>" disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Member Since</label>
              <input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($user['created_at'])); ?>" disabled>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i>Update Profile
              </button>
            </div>
          </form>

          <hr>

          <div class="text-center">
            <a href="dashboard.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../../includes/footer.php'; ?>