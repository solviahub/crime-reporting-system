<?php
require_once '../../config/database.php';

if (isset($_GET['id'])) {
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

  if ($report):
?>
    <div class="row">
      <div class="col-md-6 mb-3">
        <strong>Report ID:</strong>
        <p><?php echo htmlspecialchars($report['report_id']); ?></p>
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
          <span class="badge bg-<?php echo $badgeClass; ?>"><?php echo ucfirst(str_replace('_', ' ', $report['status'])); ?></span>
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
        <p><?php echo nl2br(htmlspecialchars($report['description'])); ?></p>
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
          <img src="<?php echo BASE_URL . $report['image_path']; ?>" class="img-fluid mt-2 rounded" style="max-height: 400px;">
        </div>
      <?php endif; ?>
    </div>
<?php
  else:
    echo "<p>Report not found.</p>";
  endif;
}
?>