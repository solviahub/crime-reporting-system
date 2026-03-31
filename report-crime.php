<?php
require_once 'includes/header.php';
require_once 'includes/auth.php';

$error = '';
$success = '';
$reportId = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $name = isset($_POST['anonymous']) ? '' : mysqli_real_escape_string($conn, $_POST['name']);
  $email = isset($_POST['anonymous']) ? '' : mysqli_real_escape_string($conn, $_POST['email']);
  $crimeType = mysqli_real_escape_string($conn, $_POST['crime_type']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $incidentDate = mysqli_real_escape_string($conn, $_POST['incident_date']);
  $incidentTime = mysqli_real_escape_string($conn, $_POST['incident_time']);
  $isAnonymous = isset($_POST['anonymous']) ? 1 : 0;
  $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

  // Generate unique report ID
  $reportId = generateReportId();

  // Handle image upload
  $imagePath = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $_FILES['image']['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
      $uploadDir = 'assets/uploads/';
      if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }
      $imagePath = $uploadDir . $reportId . '_' . time() . '.' . $ext;
      move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }
  }

  // Insert into database
  $sql = "INSERT INTO crime_reports (report_id, user_id, name, email, crime_type, description, location, incident_date, incident_time, image_path, is_anonymous) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sissssssssi", $reportId, $userId, $name, $email, $crimeType, $description, $location, $incidentDate, $incidentTime, $imagePath, $isAnonymous);

  if (mysqli_stmt_execute($stmt)) {
    $success = "Report submitted successfully! Your Report ID is: <strong>$reportId</strong>";

    // Create notification for admins
    $adminSql = "INSERT INTO notifications (title, message) VALUES (?, ?)";
    $adminStmt = mysqli_prepare($conn, $adminSql);
    $title = "New Crime Report";
    $message = "A new crime report has been submitted with ID: $reportId";
    mysqli_stmt_bind_param($adminStmt, "ss", $title, $message);
    mysqli_stmt_execute($adminStmt);
  } else {
    $error = "Error submitting report. Please try again.";
  }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white text-center py-4">
          <h2 class="mb-0"><i class="fas fa-flag me-2"></i>Report a Crime</h2>
          <p class="mb-0 mt-2">Your identity will be protected. Report safely and anonymously.</p>
        </div>
        <div class="card-body p-5">
          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="alert alert-success">
              <?php echo $success; ?>
              <div class="mt-3">
                <a href="track-report.php" class="btn btn-primary">Track Your Report</a>
                <a href="report-crime.php" class="btn btn-secondary">Submit Another Report</a>
              </div>
            </div>
          <?php else: ?>
            <form method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Your Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Optional">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email" class="form-control" name="email" placeholder="Optional">
                </div>
              </div>

              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="anonymous" id="anonymous">
                  <label class="form-check-label" for="anonymous">
                    Report Anonymously
                  </label>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Crime Type *</label>
                <select class="form-select" name="crime_type" required>
                  <option value="">Select Crime Type</option>
                  <option value="theft">Theft</option>
                  <option value="assault">Assault</option>
                  <option value="fraud">Fraud</option>
                  <option value="cyber_crime">Cyber Crime</option>
                  <option value="drug_related">Drug Related</option>
                  <option value="domestic_violence">Domestic Violence</option>
                  <option value="sexual_harassment">Sexual Harassment</option>
                  <option value="murder">Murder</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Description *</label>
                <textarea class="form-control" name="description" rows="5" required placeholder="Provide detailed information about the incident..."></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Location *</label>
                <input type="text" class="form-control" name="location" required placeholder="Address or location description">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Incident Date *</label>
                  <input type="date" class="form-control" name="incident_date" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Incident Time *</label>
                  <input type="time" class="form-control" name="incident_time" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Upload Evidence (Optional)</label>
                <input type="file" class="form-control" name="image" accept="image/*">
                <small class="text-muted">Supported formats: JPG, PNG, GIF (Max 5MB)</small>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="fas fa-paper-plane me-2"></i>Submit Report
                </button>
              </div>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>