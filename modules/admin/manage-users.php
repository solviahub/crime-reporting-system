<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Handle delete user
if (isset($_GET['delete'])) {
  $user_id = mysqli_real_escape_string($conn, $_GET['delete']);
  $deleteSql = "DELETE FROM users WHERE id = ? AND role != 'super_admin'";
  $deleteStmt = mysqli_prepare($conn, $deleteSql);
  mysqli_stmt_bind_param($deleteStmt, "i", $user_id);

  if (mysqli_stmt_execute($deleteStmt)) {
    $success = "User deleted successfully!";
  } else {
    $error = "Error deleting user!";
  }
}

// Handle promote to admin
if (isset($_GET['promote'])) {
  $user_id = mysqli_real_escape_string($conn, $_GET['promote']);
  $updateSql = "UPDATE users SET role = 'admin' WHERE id = ? AND role = 'user'";
  $updateStmt = mysqli_prepare($conn, $updateSql);
  mysqli_stmt_bind_param($updateStmt, "i", $user_id);

  if (mysqli_stmt_execute($updateStmt)) {
    $success = "User promoted to admin successfully!";
  } else {
    $error = "Error promoting user!";
  }
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");

include '../../includes/header.php';
?>

<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2><i class="fas fa-users me-2"></i>Manage Users</h2>
      <p>View and manage all registered users</p>
    </div>
  </div>

  <?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $success; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $error; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Role</th>
              <th>Registered</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
              <tr>
                <td><?php echo $user['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                <td>
                  <?php
                  $badgeClass = '';
                  if ($user['role'] == 'super_admin') $badgeClass = 'danger';
                  elseif ($user['role'] == 'admin') $badgeClass = 'warning';
                  else $badgeClass = 'info';
                  ?>
                  <span class="badge bg-<?php echo $badgeClass; ?>"><?php echo strtoupper($user['role']); ?></span>
                </td>
                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                <td>
                  <?php if ($user['role'] == 'user'): ?>
                    <a href="?promote=<?php echo $user['id']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Promote this user to admin?')">
                      <i class="fas fa-arrow-up"></i> Promote
                    </a>
                  <?php endif; ?>
                  <?php if ($user['role'] != 'super_admin'): ?>
                    <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../../includes/footer.php'; ?>