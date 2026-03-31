<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Get user's reports
$reports = mysqli_query($conn, "SELECT * FROM crime_reports WHERE user_id = $user_id ORDER BY created_at DESC");

include '../../includes/header.php';
?>

<div class="container py-5">
  <div class="row">
    <div class="col-lg-4">
      <!-- User Profile Card -->
      <div class="card shadow-lg border-0 mb-4">
        <div class="card-header bg-gradient-primary text-white text-center py-4">
          <i class="fas fa-user-circle fa-4x"></i>
          <h4 class="mt-2"><?php echo htmlspecialchars($_SESSION['full_name']); ?></h4>
          <p class="mb-0">@<?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="profile.php" class="btn btn-outline-primary">
              <i class="fas fa-user-edit"></i> Edit Profile
            </a>
            <a href="../../report-crime.php" class="btn btn-primary">
              <i class="fas fa-plus"></i> New Report
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <!-- Recent Reports -->
      <div class="card shadow-lg border-0">
        <div class="card-header bg-white">
          <h5 class="mb-0"><i class="fas fa-history me-2"></i>My Reports</h5>
        </div>
        <div class="card-body">
          <?php if (mysqli_num_rows($reports) > 0): ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Report ID</th>
                    <th>Crime Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($report = mysqli_fetch_assoc($reports)): ?>
                    <tr>
                      <td><strong><?php echo htmlspecialchars($report['report_id']); ?></strong></td>
                      <td><?php echo ucfirst(str_replace('_', ' ', $report['crime_type'])); ?></td>
                      <td>
                        <?php
                        $badgeClass = '';
                        if ($report['status'] == 'pending') $badgeClass = 'warning';
                        elseif ($report['status'] == 'under_investigation') $badgeClass = 'info';
                        else $badgeClass = 'success';
                        ?>
                        <span class="badge bg-<?php echo $badgeClass; ?>">
                          <?php echo ucfirst(str_replace('_', ' ', $report['status'])); ?>
                        </span>
                      </td>
                      <td><?php echo date('M d, Y', strtotime($report['created_at'])); ?></td>
                      <td>
                        <a href="../../track-report.php?report_id=<?php echo $report['report_id']; ?>" class="btn btn-sm btn-primary">
                          <i class="fas fa-eye"></i> Track
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="text-center py-5">
              <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
              <p>You haven't submitted any reports yet.</p>
              <a href="../../report-crime.php" class="btn btn-primary">Submit Your First Report</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../../includes/footer.php'; ?>