<?php
require_once 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

  $sql = "INSERT INTO sos_emergencies (user_id, name, phone, location) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "isss", $userId, $name, $phone, $location);

  if (mysqli_stmt_execute($stmt)) {
    $success = "SOS Alert sent successfully! Authorities have been notified. Help is on the way!";

    // Create notification for admins
    $adminSql = "INSERT INTO notifications (title, message) VALUES (?, ?)";
    $adminStmt = mysqli_prepare($conn, $adminSql);
    $title = "SOS Emergency Alert!";
    $message = "SOS alert from $name at $location. Phone: $phone";
    mysqli_stmt_bind_param($adminStmt, "ss", $title, $message);
    mysqli_stmt_execute($adminStmt);
  } else {
    $error = "Error sending SOS alert. Please try again or call emergency services directly.";
  }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-danger text-white text-center py-4">
          <h2 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>SOS Emergency</h2>
          <p class="mb-0 mt-2">Only use in real emergencies. Immediate assistance will be dispatched.</p>
        </div>
        <div class="card-body p-5">
          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="alert alert-success">
              <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
              <div class="mt-3">
                <a href="index.php" class="btn btn-primary">Return Home</a>
              </div>
            </div>
          <?php else: ?>
            <div class="text-center mb-4">
              <div class="sos-button-wrapper">
                <button class="sos-button" id="sosTriggerBtn">
                  <i class="fas fa-bell"></i>
                  <span>SOS</span>
                </button>
              </div>
              <p class="mt-3 text-muted">Click the SOS button above for immediate emergency assistance</p>
            </div>

            <div id="sosForm" style="display: none;">
              <h4 class="mb-3">Confirm Emergency Details</h4>
              <form method="POST">
                <div class="mb-3">
                  <label class="form-label">Your Name *</label>
                  <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Phone Number *</label>
                  <input type="tel" class="form-control" name="phone" required placeholder="Your current phone number">
                </div>
                <div class="mb-3">
                  <label class="form-label">Current Location *</label>
                  <input type="text" class="form-control" name="location" required placeholder="Your current address or location">
                  <button type="button" class="btn btn-sm btn-secondary mt-2" id="getLocationBtn">
                    <i class="fas fa-location-dot"></i> Get My Current Location
                  </button>
                </div>
                <div class="alert alert-warning">
                  <i class="fas fa-exclamation-triangle"></i>
                  <strong>Warning:</strong> This is an emergency alert. Only submit if you require immediate assistance.
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fas fa-paper-plane"></i> Send SOS Alert
                  </button>
                </div>
              </form>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('sosTriggerBtn').addEventListener('click', function() {
    if (confirm('⚠️ EMERGENCY ALERT ⚠️\n\nThis will send an immediate alert to authorities.\nOnly proceed if this is a REAL emergency.\n\nDo you want to continue?')) {
      document.getElementById('sosForm').style.display = 'block';
      document.querySelector('.sos-button-wrapper').style.display = 'none';
    }
  });

  document.getElementById('getLocationBtn').addEventListener('click', function() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        const locationInput = document.querySelector('input[name="location"]');
        locationInput.value = `Lat: ${position.coords.latitude}, Lng: ${position.coords.longitude}`;
      });
    } else {
      alert('Geolocation is not supported by this browser.');
    }
  });
</script>

<style>
  .sos-button-wrapper {
    text-align: center;
    padding: 20px;
  }

  .sos-button {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff0000, #cc0000);
    border: none;
    color: white;
    cursor: pointer;
    animation: pulse 2s infinite;
    transition: all 0.3s ease;
    box-shadow: 0 0 30px rgba(255, 0, 0, 0.5);
  }

  .sos-button i {
    font-size: 48px;
    display: block;
    margin-bottom: 10px;
  }

  .sos-button span {
    font-size: 24px;
    font-weight: bold;
    display: block;
  }

  .sos-button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 40px rgba(255, 0, 0, 0.8);
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
      box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.7);
    }

    70% {
      transform: scale(1.05);
      box-shadow: 0 0 0 20px rgba(255, 0, 0, 0);
    }

    100% {
      transform: scale(1);
      box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
    }
  }
</style>

<?php require_once 'includes/footer.php'; ?>