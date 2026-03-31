<?php
require_once '../../config/database.php';
require_once '../../includes/auth.php';
requireAdmin();

// Handle status update
if (isset($_POST['update_status'])) {
  $report_id = mysqli_real_escape_string($conn, $_POST['report_id']);
  $new_status = mysqli_real_escape_string($conn, $_POST['status']);
  $comment = mysqli_real_escape_string($conn, $_POST['comment']);

  // Get old status
  $oldStatusSql = "SELECT status FROM crime_reports WHERE id = ?";
  $oldStmt = mysqli_prepare($conn, $oldStatusSql);
  mysqli_stmt_bind_param($oldStmt, "i", $report_id);
  mysqli_stmt_execute($oldStmt);
  $oldResult = mysqli_stmt_get_result($oldStmt);
  $oldStatus = mysqli_fetch_assoc($oldResult)['status'];

  // Update report status
  $updateSql = "UPDATE crime_reports SET status = ? WHERE id = ?";
  $updateStmt = mysqli_prepare($conn, $updateSql);
  mysqli_stmt_bind_param($updateStmt, "si", $new_status, $report_id);

  if (mysqli_stmt_execute($updateStmt)) {
    // Add update record
    $updateRecordSql = "INSERT INTO report_updates (report_id, admin_id, comment, old_status, new_status) VALUES (?, ?, ?, ?, ?)";
    $recordStmt = mysqli_prepare($conn, $updateRecordSql);
    mysqli_stmt_bind_param($recordStmt, "iisss", $report_id, $_SESSION['user_id'], $comment, $oldStatus, $new_status);
    mysqli_stmt_execute($recordStmt);

    $success = "Report status updated successfully!";
  } else {
    $error = "Error updating report status!";
  }
}

// Handle delete
if (isset($_GET['delete'])) {
  $report_id = mysqli_real_escape_string($conn, $_GET['delete']);
  $deleteSql = "DELETE FROM crime_reports WHERE id = ?";
  $deleteStmt = mysqli_prepare($conn, $deleteSql);
  mysqli_stmt_bind_param($deleteStmt, "i", $report_id);

  if (mysqli_stmt_execute($deleteStmt)) {
    $success = "Report deleted successfully!";
  } else {
    $error = "Error deleting report!";
  }
}

// Filters
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$crime_type_filter = isset($_GET['crime_type']) ? $_GET['crime_type'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';

$where = [];
if ($status_filter) $where[] = "status = '$status_filter'";
if ($crime_type_filter) $where[] = "crime_type = '$crime_type_filter'";
if ($date_filter) $where[] = "DATE(created_at) = '$date_filter'";

$where_clause = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

$reports = mysqli_query($conn, "SELECT * FROM crime_reports $where_clause ORDER BY created_at DESC");

include '../../includes/header.php';
?>

<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2><i class="fas fa-list me-2"></i>Manage Reports</h2>
      <p>View, update, and manage all crime reports</p>
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

  <!-- Filters -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form method="GET" class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">All</option>
            <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="under_investigation" <?php echo $status_filter == 'under_investigation' ? 'selected' : ''; ?>>Under Investigation</option>
            <option value="resolved" <?php echo $status_filter == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Crime Type</label>
          <select name="crime_type" class="form-select">
            <option value="">All</option>
            <option value="theft" <?php echo $crime_type_filter == 'theft' ? 'selected' : ''; ?>>Theft</option>
            <option value="assault" <?php echo $crime_type_filter == 'assault' ? 'selected' : ''; ?>>Assault</option>
            <option value="fraud" <?php echo $crime_type_filter == 'fraud' ? 'selected' : ''; ?>>Fraud</option>
            <option value="cyber_crime" <?php echo $crime_type_filter == 'cyber_crime' ? 'selected' : ''; ?>>Cyber Crime</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Date</label>
          <input type="date" name="date" class="form-control" value="<?php echo $date_filter; ?>">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
          <a href="manage-reports.php" class="btn btn-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Reports Table -->
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Report ID</th>
              <th>Crime Type</th>
              <th>Location</th>
              <th>Status</th>
              <th>Submitted</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($report = mysqli_fetch_assoc($reports)): ?>
              <tr>
                <td><?php echo $report['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($report['report_id']); ?></strong></td>
                <td><?php echo ucfirst(str_replace('_', ' ', $report['crime_type'])); ?></td>
                <td><?php echo htmlspecialchars(substr($report['location'], 0, 40)); ?></td>
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
                  <button class="btn btn-sm btn-primary" onclick="viewReport(<?php echo $report['id']; ?>)">
                    <i class="fas fa-eye"></i> View
                  </button>
                  <button class="btn btn-sm btn-info" onclick="updateStatus(<?php echo $report['id']; ?>, '<?php echo $report['status']; ?>')">
                    <i class="fas fa-edit"></i> Update
                  </button>
                  <a href="?delete=<?php echo $report['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- View Report Modal -->
<div class="modal fade" id="viewReportModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Report Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="reportDetails">
        Loading...
      </div>
    </div>
  </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Update Report Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="report_id" id="update_report_id">
          <div class="mb-3">
            <label class="form-label">New Status</label>
            <select name="status" class="form-select" required>
              <option value="pending">Pending</option>
              <option value="under_investigation">Under Investigation</option>
              <option value="resolved">Resolved</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Comment (Optional)</label>
            <textarea name="comment" class="form-control" rows="3" placeholder="Add any comments or notes about this update..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function viewReport(id) {
    fetch('get-report-details.php?id=' + id)
      .then(response => response.text())
      .then(data => {
        document.getElementById('reportDetails').innerHTML = data;
        new bootstrap.Modal(document.getElementById('viewReportModal')).show();
      });
  }

  function updateStatus(id, currentStatus) {
    document.getElementById('update_report_id').value = id;
    const statusSelect = document.querySelector('#updateStatusModal select[name="status"]');
    statusSelect.value = currentStatus;
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
  }
</script>

<?php include '../../includes/footer.php'; ?>