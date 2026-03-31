<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

if (!isset($_GET['id'])) {
  header('Location: manage-reports.php');
  exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT r.*, 
        CASE WHEN r.user_id IS NOT NULL THEN u.username ELSE 'Anonymous' END as reporter_name
        FROM crime_reports r
        LEFT JOIN users u ON r.user_id = u.id
        WHERE r.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$report = mysqli_fetch_assoc($result);

if (!$report) {
  header('Location: manage-reports.php');
  exit();
}

// Get report updates
$updatesSql = "SELECT u.*, a.username as admin_name 
               FROM report_updates u
               LEFT JOIN users a ON u.admin_id = a.id
               WHERE u.report_id = ?
               ORDER BY u.created_at DESC";
$updatesStmt = mysqli_prepare($conn, $updatesSql);
mysqli_stmt_bind_param($updatesStmt, "i", $id);
mysqli_stmt_execute($updatesStmt);
$updates = mysqli_stmt_get_result($updatesStmt);

include '../../includes/header.php';
?>

<div class="container py-4">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
          <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Report Details</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <strong>Report ID:</strong>
              <p class="text-primary"><?php echo htmlspecialchars($report['report_id']); ?></p>
            </div>
            <div class="col-md-6 mb-3">
              <strong>Status:</strong>
              <p>
                <?php
                $badgeClass = '';
                if ($report['status'] == 'pending') $badgeClass = 'warning';
                elseif ($report['status'] == 'under_investigation') $badgeClass = 'info';
                else $badgeClass = 'success';
                ?>
                <span class="badge bg-<?php echo $badgeClass; ?> badge-lg"><?php echo ucfirst(str_replace('_', ' ', $report['status'])); ?></span>
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <strong>Crime Type:</strong>
              <p><?php echo ucfirst(str_replace('_', ' ', $report['crime_type'])); ?></p>
            </div>
            <div class="col-md-6 mb-3">
              <strong>Submitted By:</strong>
              <p><?php echo htmlspecialchars($report['reporter_name']); ?></p>
            </div>
            <div class="col-12 mb-3">
              <strong>Location:</strong>
              <p><?php echo htmlspecialchars($report['location']); ?></p>
            </div>
            <div class="col-12 mb-3">
              <strong>Description:</strong>
              <div class="bg-light p-3 rounded">
                <?php echo nl2br(htmlspecialchars($report['description'])); ?>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <strong>Incident Date:</strong>
              <p><?php echo date('F d, Y', strtotime($report['incident_date'])); ?></p>
            </div>
            <div class="col-md-6 mb-3">
              <strong>Incident Time:</strong>
              <p><?php echo date('h:i A', strtotime($report['incident_time'])); ?></p>
            </div>
            <div class="col-12 mb-3">
              <strong>Submitted On:</strong>
              <p><?php echo date('F d, Y h:i A', strtotime($report['created_at'])); ?></p>
            </div>
            <?php if ($report['image_path']): ?>
              <div class="col-12 mb-3">
                <strong>Evidence Image:</strong><br>
                <img src="<?php echo BASE_URL . $report['image_path']; ?>" class="img-fluid mt-2 rounded shadow-sm" style="max-height: 400px;">
              </div>
            <?php endif; ?>
          </div>

          <hr>

          <!-- Update Status Form -->
          <h5 class="mt-4">Update Status</h5>
          <form method="POST" action="manage-reports.php" class="mt-3">
            <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
            <div class="row">
              <div class="col-md-6">
                <select name="status" class="form-select">
                  <option value="pending" <?php echo $report['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                  <option value="under_investigation" <?php echo $report['status'] == 'under_investigation' ? 'selected' : ''; ?>>Under Investigation</option>
                  <option value="resolved" <?php echo $report['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                </select>
              </div>
              <div class="col-md-4">
                <input type="text" name="comment" class="form-control" placeholder="Add comment (optional)">
              </div>
              <div class="col-md-2">
                <button type="submit" name="update_status" class="btn btn-primary w-100">
                  Update
                </button>
              </div>
            </div>
          </form>

          <!-- Report Updates Timeline -->
          <?php if (mysqli_num_rows($updates) > 0): ?>
            <hr>
            <h5 class="mt-4">Update History</h5>
            <div class="timeline">
              <?php while ($update = mysqli_fetch_assoc($updates)): ?>
                <div class="timeline-item">
                  <div class="timeline-badge">
                    <i class="fas fa-user-circle"></i>
                  </div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h6 class="mb-0">Status changed from <?php echo ucfirst(str_replace('_', ' ', $update['old_status'])); ?> to <?php echo ucfirst(str_replace('_', ' ', $update['new_status'])); ?></h6>
                      <small class="text-muted">
                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($update['admin_name']); ?> |
                        <i class="fas fa-clock"></i> <?php echo date('F d, Y h:i A', strtotime($update['created_at'])); ?>
                      </small>
                    </div>
                    <?php if ($update['comment']): ?>
                      <div class="timeline-body mt-2">
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($update['comment'])); ?></p>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>

          <div class="d-flex justify-content-between mt-4">
            <a href="manage-reports.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
            <a href="?delete=<?php echo $report['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">
              <i class="fas fa-trash"></i> Delete Report
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .timeline {
    position: relative;
    padding-left: 40px;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 30px;
  }

  .timeline-badge {
    position: absolute;
    left: -40px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    text-align: center;
    line-height: 30px;
  }

  .timeline-panel {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    position: relative;
  }

  .timeline-panel:before {
    content: '';
    position: absolute;
    left: -10px;
    top: 10px;
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 10px solid #f8f9fa;
  }

  .badge-lg {
    font-size: 14px;
    padding: 8px 15px;
  }
</style>

<?php include '../../includes/footer.php'; ?>