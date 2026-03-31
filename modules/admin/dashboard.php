<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Get statistics
$stats = [];

// Total reports
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crime_reports");
$stats['total_reports'] = mysqli_fetch_assoc($result)['total'];

// Pending reports
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crime_reports WHERE status = 'pending'");
$stats['pending'] = mysqli_fetch_assoc($result)['total'];

// Under investigation
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crime_reports WHERE status = 'under_investigation'");
$stats['under_investigation'] = mysqli_fetch_assoc($result)['total'];

// Resolved
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crime_reports WHERE status = 'resolved'");
$stats['resolved'] = mysqli_fetch_assoc($result)['total'];

// Total users
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$stats['total_users'] = mysqli_fetch_assoc($result)['total'];

// SOS alerts
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM sos_emergencies WHERE status = 'active'");
$stats['active_sos'] = mysqli_fetch_assoc($result)['total'];

// Recent reports
$recentReports = mysqli_query($conn, "SELECT * FROM crime_reports ORDER BY created_at DESC LIMIT 5");

// Recent SOS alerts
$recentSOS = mysqli_query($conn, "SELECT * FROM sos_emergencies ORDER BY created_at DESC LIMIT 5");

include '../../includes/header.php';
?>

<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h2>
      <p>Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</p>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row mb-4">
    <div class="col-md-3 mb-3">
      <div class="card stat-card bg-primary text-white">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="card-title">Total Reports</h6>
              <h2 class="mb-0"><?php echo $stats['total_reports']; ?></h2>
            </div>
            <i class="fas fa-flag fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card stat-card bg-warning text-white">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="card-title">Pending</h6>
              <h2 class="mb-0"><?php echo $stats['pending']; ?></h2>
            </div>
            <i class="fas fa-clock fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card stat-card bg-info text-white">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="card-title">Under Investigation</h6>
              <h2 class="mb-0"><?php echo $stats['under_investigation']; ?></h2>
            </div>
            <i class="fas fa-search fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card stat-card bg-success text-white">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="card-title">Resolved</h6>
              <h2 class="mb-0"><?php echo $stats['resolved']; ?></h2>
            </div>
            <i class="fas fa-check-circle fa-3x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <!-- Recent Reports -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
          <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Reports</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Report ID</th>
                  <th>Crime Type</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($report = mysqli_fetch_assoc($recentReports)): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($report['report_id']); ?></td>
                    <td><?php echo ucfirst(str_replace('_', ' ', $report['crime_type'])); ?></td>
                    <td><?php echo htmlspecialchars(substr($report['location'], 0, 30)) . '...'; ?></td>
                    <td>
                      <?php
                      $badgeClass = '';
                      if ($report['status'] == 'pending') $badgeClass = 'warning';
                      elseif ($report['status'] == 'under_investigation') $badgeClass = 'info';
                      else $badgeClass = 'success';
                      ?>
                      <span class="badge bg-<?php echo $badgeClass; ?>"><?php echo ucfirst(str_replace('_', ' ', $report['status'])); ?></span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($report['created_at'])); ?></td>
                    <td>
                      <a href="view-report.php?id=<?php echo $report['id']; ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
          <div class="text-center mt-3">
            <a href="manage-reports.php" class="btn btn-primary">View All Reports</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <!-- Quick Actions -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
          <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="manage-reports.php" class="btn btn-outline-primary">
              <i class="fas fa-list"></i> Manage All Reports
            </a>
            <a href="manage-users.php" class="btn btn-outline-primary">
              <i class="fas fa-users"></i> Manage Users
            </a>
            <a href="../../report-crime.php" class="btn btn-outline-success">
              <i class="fas fa-plus"></i> Add New Report
            </a>
          </div>
        </div>
      </div>

      <!-- Active SOS Alerts -->
      <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
          <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Active SOS Alerts</h5>
        </div>
        <div class="card-body">
          <?php if (mysqli_num_rows($recentSOS) > 0): ?>
            <div class="list-group">
              <?php while ($sos = mysqli_fetch_assoc($recentSOS)): ?>
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1"><?php echo htmlspecialchars($sos['name']); ?></h6>
                    <small><?php echo date('H:i', strtotime($sos['created_at'])); ?></small>
                  </div>
                  <p class="mb-1">📍 <?php echo htmlspecialchars($sos['location']); ?></p>
                  <small>📞 <?php echo htmlspecialchars($sos['phone']); ?></small>
                </div>
              <?php endwhile; ?>
            </div>
          <?php else: ?>
            <p class="text-muted text-center mb-0">No active SOS alerts</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .stat-card {
    transition: transform 0.3s ease;
    border-radius: 15px;
    border: none;
  }

  .stat-card:hover {
    transform: translateY(-5px);
  }

  .opacity-50 {
    opacity: 0.5;
  }
</style>

<?php include '../../includes/footer.php'; ?>