    </main>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4">
            <h5><i class="fas fa-shield-alt me-2"></i>CrimeReport</h5>
            <p>Your trusted platform for reporting crimes anonymously and helping make communities safer.</p>
          </div>
          <div class="col-md-4 mb-4">
            <h5>Quick Links</h5>
            <ul class="list-unstyled">
              <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
              <li><a href="<?php echo BASE_URL; ?>report-crime.php">Report Crime</a></li>
              <li><a href="<?php echo BASE_URL; ?>track-report.php">Track Report</a></li>
              <li><a href="<?php echo BASE_URL; ?>sos-emergency.php">SOS Emergency</a></li>
            </ul>
          </div>
          <div class="col-md-4 mb-4">
            <h5>Contact Info</h5>
            <ul class="list-unstyled">
              <li><i class="fas fa-phone"></i> Emergency: 911</li>
              <li><i class="fas fa-envelope"></i> support@crimesystem.com</li>
              <li><i class="fas fa-clock"></i> 24/7 Support Available</li>
            </ul>
          </div>
        </div>
        <hr>
        <div class="text-center">
          <p>&copy; <?php echo date('Y'); ?> Crime Reporting System. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
    </body>

    </html>
    <?php mysqli_close($conn); ?>