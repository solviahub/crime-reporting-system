// Form Validation
document.addEventListener('DOMContentLoaded', function () {
  // Animate counters
  const counters = document.querySelectorAll('.counter');
  counters.forEach((counter) => {
    const target = parseInt(counter.getAttribute('data-target'));
    let current = 0;
    const increment = target / 50;

    const updateCounter = () => {
      if (current < target) {
        current += increment;
        counter.innerText = Math.ceil(current);
        setTimeout(updateCounter, 20);
      } else {
        counter.innerText = target;
      }
    };

    updateCounter();
  });

  // Form validation for report submission
  const reportForm = document.querySelector('form[action*="report-crime.php"]');
  if (reportForm) {
    reportForm.addEventListener('submit', function (e) {
      const description = document.querySelector(
        'textarea[name="description"]',
      );
      const location = document.querySelector('input[name="location"]');

      if (description.value.trim().length < 10) {
        e.preventDefault();
        showAlert(
          'Please provide a detailed description (minimum 10 characters)',
          'danger',
        );
        description.focus();
      }

      if (location.value.trim().length < 5) {
        e.preventDefault();
        showAlert('Please provide a valid location', 'danger');
        location.focus();
      }
    });
  }

  // Auto-hide alerts
  setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach((alert) => {
      if (!alert.classList.contains('alert-permanent')) {
        setTimeout(() => {
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 300);
        }, 5000);
      }
    });
  }, 1000);
});

// Show alert function
function showAlert(message, type = 'info') {
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
  alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

  const container = document.querySelector('.container');
  if (container) {
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
      alertDiv.style.opacity = '0';
      setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
  }
}

// Confirm delete
function confirmDelete(message) {
  return confirm(message || 'Are you sure you want to delete this item?');
}

// Copy to clipboard
function copyToClipboard(text) {
  navigator.clipboard
    .writeText(text)
    .then(() => {
      showAlert('Copied to clipboard!', 'success');
    })
    .catch(() => {
      showAlert('Failed to copy', 'danger');
    });
}

// Get current location
function getCurrentLocation() {
  return new Promise((resolve, reject) => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        resolve({
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        });
      }, reject);
    } else {
      reject('Geolocation not supported');
    }
  });
}

// Format date
function formatDate(dateString) {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
}

// Format time
function formatTime(timeString) {
  return new Date(`2000-01-01 ${timeString}`).toLocaleTimeString([], {
    hour: '2-digit',
    minute: '2-digit',
  });
}

// Validate email
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

// Validate phone
function validatePhone(phone) {
  const re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
  return re.test(phone);
}

// Show loading state
function showLoading(button) {
  const originalText = button.innerHTML;
  button.disabled = true;
  button.innerHTML = '<span class="loader"></span> Loading...';

  return () => {
    button.disabled = false;
    button.innerHTML = originalText;
  };
}

// Handle AJAX requests
async function fetchAPI(url, options = {}) {
  try {
    const response = await fetch(url, {
      headers: {
        'Content-Type': 'application/json',
        ...options.headers,
      },
      ...options,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
  } catch (error) {
    console.error('API Error:', error);
    showAlert('An error occurred. Please try again.', 'danger');
    throw error;
  }
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]'),
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Dark mode toggle (optional)
function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');
  localStorage.setItem(
    'darkMode',
    document.body.classList.contains('dark-mode'),
  );
}

// Check saved dark mode preference
if (localStorage.getItem('darkMode') === 'true') {
  document.body.classList.add('dark-mode');
}

// Add dark mode toggle button dynamically
const darkModeToggle = document.createElement('button');
darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
darkModeToggle.className = 'dark-mode-toggle';
darkModeToggle.onclick = toggleDarkMode;
document.body.appendChild(darkModeToggle);

// Dark mode styles
const darkModeStyles = `
.dark-mode {
    background-color: #1a202c;
    color: #f7fafc;
}
.dark-mode .card,
.dark-mode .feature-card,
.dark-mode .stat-card {
    background-color: #2d3748;
    color: #f7fafc;
}
.dark-mode-toggle {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 999;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
.dark-mode-toggle:hover {
    transform: scale(1.1);
}
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = darkModeStyles;
document.head.appendChild(styleSheet);

// Print report
function printReport() {
  window.print();
}

// Share report
async function shareReport(reportId) {
  if (navigator.share) {
    try {
      await navigator.share({
        title: 'Crime Report',
        text: `Check out this crime report: ${reportId}`,
        url: window.location.href,
      });
    } catch (err) {
      console.log('Share failed:', err);
    }
  } else {
    copyToClipboard(window.location.href);
  }
}
