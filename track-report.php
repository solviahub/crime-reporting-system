<?php
require_once 'includes/header.php';

$report = null;
$error = '';
$reportId = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $reportId = mysqli_real_escape_string($conn, $_POST['report_id']);

  $sql = "SELECT * FROM crime_reports WHERE report_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $reportId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    $report = $row;
  } else {
    $error = "No report found with ID: $reportId";
  }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white text-center py-4">
          <h2 class="mb-0"><i class="fas fa-search me-2"></i>Track Your Report</h2>
          <p class="mb-0 mt-2">Enter your unique Report ID to check status</p>
        </div>
        <div class="card-body p-5">
          <form method="POST" class="mb-4">
            <div class="input-group">
              <input type="text" class="form-control form-control-lg" name="report_id" placeholder="Enter Report ID (e.g., CR202401011234)" required>
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-search"></i> Track
              </button>
            </div>
          </form>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>

          <?php if ($report): ?>
            <div class="report-details mt-4">
              <h3 class="mb-4">Report Details</h3>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <strong>Report ID:</strong>
                  <p class="text-primary"><?php echo htmlspecialchars($report['report_id']); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                  <strong>Status:</strong>
                  <p>
                    <?php
                    $statusClass = '';
                    $statusText = '';
                    switch ($report['status']) {
                      case 'pending':
                        $statusClass = 'warning';
                        $statusText = 'Pending';
                        break;
                      case 'under_investigation':
                        $statusClass = 'info';
                        $statusText = 'Under Investigation';
                        break;
                      case 'resolved':
                        $statusClass = 'success';
                        $statusText = 'Resolved';
                        break;
                    }
                    ?>
                    <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                  </p>
                </div>
                <div class="col-md-6 mb-3">
                  <strong>Crime Type:</strong>
                  <p><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($report['crime_type']))); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                  <strong>Date Submitted:</strong>
                  <p><?php echo date('F d, Y', strtotime($report['created_at'])); ?></p>
                </div>
                <div class="col-12 mb-3">
                  <strong>Location:</strong>
                  <p><?php echo htmlspecialchars($report['location']); ?></p>
                </div>
                <div class="col-12 mb-3">
                  <strong>Description:</strong>
                  <p><?php echo nl2br(htmlspecialchars($report['description'])); ?></p>
                </div>
                <div class="col-12 mb-3">
                  <strong>Incident Date & Time:</strong>
                  <p><?php echo date('F d, Y', strtotime($report['incident_date'])) . ' at ' . date('h:i A', strtotime($report['incident_time'])); ?></p>
                </div>
              </div>

              <?php if ($report['image_path']): ?>
                <div class="mb-3">
                  <strong>Evidence Image:</strong><br>
                  <img src="<?php echo BASE_URL . $report['image_path']; ?>" class="img-fluid mt-2 rounded" style="max-height: 300px;">
                </div>
              <?php endif; ?>

              <!-- Status Timeline -->
              <div class="status-timeline mt-4">
                <h5>Report Timeline</h5>
                <div class="timeline">
                  <div class="timeline-item <?php echo $report['status'] != 'pending' ? 'completed' : 'active'; ?>">
                    <div class="timeline-icon">
                      <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div class="timeline-content">
                      <h6>Report Submitted</h6>
                      <small><?php echo date('F d, Y h:i A', strtotime($report['created_at'])); ?></small>
                    </div>
                  </div>
                  <div class="timeline-item <?php echo $report['status'] == 'under_investigation' || $report['status'] == 'resolved' ? 'completed' : ($report['status'] == 'pending' ? '' : 'active'); ?>">
                    <div class="timeline-icon">
                      <i class="fas fa-search"></i>
                    </div>
                    <div class="timeline-content">
                      <h6>Under Investigation</h6>
                      <?php if ($report['status'] == 'under_investigation' || $report['status'] == 'resolved'): ?>
                        <small>Investigation in progress</small>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="timeline-item <?php echo $report['status'] == 'resolved' ? 'completed' : ''; ?>">
                    <div class="timeline-icon">
                      <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="timeline-content">
                      <h6>Resolved</h6>
                      <?php if ($report['status'] == 'resolved'): ?>
                        <small>Case closed</small>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>