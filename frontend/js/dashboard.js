// Dashboard JavaScript

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    loadUserData();
    loadDashboardStats();
    loadRecentReports();
    loadNotifications();
    initializeCharts();
});

// Load user data
function loadUserData() {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
        const userNameElement = document.getElementById('userName');
        if (userNameElement) {
            userNameElement.textContent = user.name.split(' ')[0];
        }
        
        // Update profile image if exists
        const profileImg = document.querySelector('.user-avatar');
        if (profileImg && user.avatar) {
            profileImg.src = user.avatar;
        }
    }
}

// Load dashboard statistics
function loadDashboardStats() {
    // Simulate API call to get stats
    const stats = {
        pending: 3,
        review: 2,
        resolved: 5,
        total: 10
    };
    
    // Update stats in DOM
    document.getElementById('pendingCount').textContent = stats.pending;
    document.getElementById('reviewCount').textContent = stats.review;
    document.getElementById('resolvedCount').textContent = stats.resolved;
    document.getElementById('totalCount').textContent = stats.total;
}

// Load recent reports
function loadRecentReports() {
    // Simulated recent reports data
    const reports = [
        {
            id: 'RPT001',
            type: 'theft',
            typeLabel: 'Theft',
            location: 'Downtown, Main Street',
            date: 'Feb 27, 2024',
            time: '14:30',
            status: 'pending',
            icon: 'fa-theft'
        },
        {
            id: 'RPT002',
            type: 'assault',
            typeLabel: 'Assault',
            location: 'Central Park',
            date: 'Feb 26, 2024',
            time: '22:15',
            status: 'review',
            icon: 'fa-assault'
        },
        {
            id: 'RPT003',
            type: 'vandalism',
            typeLabel: 'Vandalism',
            location: 'Westside Mall',
            date: 'Feb 25, 2024',
            time: '09:45',
            status: 'resolved',
            icon: 'fa-vandalism'
        }
    ];
    
    const reportsList = document.querySelector('.reports-list');
    if (!reportsList) return;
    
    // Clear existing reports (except the ones we'll replace)
    reportsList.innerHTML = '';
    
    // Add reports to the list
    reports.forEach(report => {
        const reportItem = createReportItem(report);
        reportsList.appendChild(reportItem);
    });
}

// Create report item element
function createReportItem(report) {
    const div = document.createElement('div');
    div.className = `report-item ${report.status}`;
    div.setAttribute('data-id', report.id);
    
    div.innerHTML = `
        <div class="report-icon">
            <i class="fas ${report.icon || 'fa-file-alt'}"></i>
        </div>
        <div class="report-details">
            <h4>${report.typeLabel}</h4>
            <p><i class="fas fa-map-marker-alt"></i> ${report.location}</p>
            <p><i class="fas fa-calendar"></i> ${report.date} - ${report.time}</p>
        </div>
        <div class="report-status">
            <span class="status-badge ${report.status}">${getStatusLabel(report.status)}</span>
        </div>
    `;
    
    // Add click event
    div.addEventListener('click', function() {
        viewReportDetails(report.id);
    });
    
    return div;
}

// Get status label based on status code
function getStatusLabel(status) {
    const labels = {
        'pending': 'Pending',
        'review': 'Under Review',
        'resolved': 'Resolved'
    };
    return labels[status] || status;
}

// Load notifications
function loadNotifications() {
    // Simulated notifications
    const notifications = [
        {
            id: 1,
            message: 'Your report #1234 has been assigned to an officer',
            time: '10 minutes ago',
            type: 'info',
            unread: true
        },
        {
            id: 2,
            message: 'Safety alert: Increased police presence in your area',
            time: '1 hour ago',
            type: 'alert',
            unread: true
        },
        {
            id: 3,
            message: 'Report #1232 has been resolved',
            time: 'Yesterday',
            type: 'success',
            unread: false
        }
    ];
    
    const notificationList = document.querySelector('.notification-list');
    const notificationBadge = document.querySelector('.notification-badge');
    
    if (!notificationList) return;
    
    // Update notification badge
    const unreadCount = notifications.filter(n => n.unread).length;
    if (notificationBadge) {
        notificationBadge.textContent = unreadCount;
        notificationBadge.style.display = unreadCount > 0 ? 'flex' : 'none';
    }
    
    // Clear existing
    notificationList.innerHTML = '';
    
    // Add notifications
    notifications.forEach(notification => {
        const item = createNotificationItem(notification);
        notificationList.appendChild(item);
    });
}

// Create notification item
function createNotificationItem(notification) {
    const div = document.createElement('div');
    div.className = `notification-item ${notification.unread ? 'unread' : ''}`;
    
    let icon = 'fa-bell';
    if (notification.type === 'alert') icon = 'fa-shield-alt';
    if (notification.type === 'success') icon = 'fa-check-circle';
    
    div.innerHTML = `
        <i class="fas ${icon}"></i>
        <div class="notification-content">
            <p>${notification.message}</p>
            <small>${notification.time}</small>
        </div>
    `;
    
    return div;
}

// Initialize charts
function initializeCharts() {
    // Check if Chart.js is loaded and canvas exists
    if (typeof Chart === 'undefined' || !document.getElementById('activityChart')) return;
    
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Reports This Week',
                data: [2, 3, 1, 4, 3, 2, 1],
                borderColor: '#007BFF',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// View report details
function viewReportDetails(reportId) {
    // Store report ID in session
    sessionStorage.setItem('viewReportId', reportId);
    
    // Redirect to my-reports page with highlight
    window.location.href = `my-reports.html?highlight=${reportId}`;
}

// Quick action: Report a crime
function reportCrime() {
    window.location.href = 'report.html';
}

// Quick action: View my reports
function viewMyReports() {
    window.location.href = 'my-reports.html';
}

// Quick action: SOS emergency
function sosEmergency() {
    window.location.href = 'sos.html';
}

// Quick action: View profile
function viewProfile() {
    window.location.href = 'profile.html';
}

// View all notifications
function viewAllNotifications() {
    // Could open a notifications page or modal
    showNotification('Notifications feature coming soon!', 'info');
}

// Refresh dashboard data
function refreshDashboard() {
    showLoading('Refreshing data...');
    
    setTimeout(() => {
        loadDashboardStats();
        loadRecentReports();
        loadNotifications();
        hideLoading();
        showNotification('Dashboard updated!', 'success');
    }, 1000);
}

// Export functions
window.viewReportDetails = viewReportDetails;
window.reportCrime = reportCrime;
window.viewMyReports = viewMyReports;
window.sosEmergency = sosEmergency;
window.viewProfile = viewProfile;
window.viewAllNotifications = viewAllNotifications;
window.refreshDashboard = refreshDashboard;