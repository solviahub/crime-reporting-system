// Admin Dashboard JavaScript

// Initialize admin dashboard
document.addEventListener('DOMContentLoaded', function() {
    checkAdminAuth();
    loadAdminStats();
    loadRecentReports();
    loadUserActivity();
    initializeAdminCharts();
    initializeSidebar();
    
    // Load page-specific content based on current page
    const currentPage = window.location.pathname.split('/').pop();
    loadPageContent(currentPage);
});

// Check admin authentication
function checkAdminAuth() {
    const user = JSON.parse(localStorage.getItem('user'));
    
    if (!user || user.role !== 'admin') {
        // Redirect to login if not admin
        window.location.href = '../../login.html';
        return false;
    }
    
    // Update admin name
    const adminName = document.querySelector('.username');
    if (adminName) {
        adminName.textContent = user.name || 'Admin User';
    }
    
    return true;
}

// Initialize sidebar
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('adminSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            // Adjust content margin
            const header = document.querySelector('.admin-header');
            const content = document.querySelector('.admin-content');
            
            if (sidebar.classList.contains('collapsed')) {
                if (header) header.style.marginLeft = '80px';
                if (content) content.style.marginLeft = '80px';
            } else {
                if (header) header.style.marginLeft = '280px';
                if (content) content.style.marginLeft = '280px';
            }
        });
    }
    
    // Highlight current page in sidebar
    highlightCurrentPage();
}

// Highlight current page in sidebar
function highlightCurrentPage() {
    const currentPage = window.location.pathname.split('/').pop().replace('.html', '');
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        const page = item.getAttribute('data-page');
        if (page === currentPage) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// Load admin statistics
function loadAdminStats() {
    // Simulated stats
    const stats = {
        newReports: 28,
        pendingReports: 15,
        resolvedToday: 12,
        activeUsers: 1245,
        totalReports: 3456,
        responseTime: '2.5h'
    };
    
    // Update stat cards
    updateStatCards(stats);
}

// Update stat cards
function updateStatCards(stats) {
    const statElements = {
        newReports: document.getElementById('newReports'),
        pendingReports: document.getElementById('pendingReports'),
        resolvedToday: document.getElementById('resolvedToday'),
        activeUsers: document.getElementById('activeUsers'),
        totalReports: document.getElementById('totalReports'),
        responseTime: document.getElementById('responseTime')
    };
    
    for (const [key, element] of Object.entries(statElements)) {
        if (element && stats[key]) {
            element.textContent = stats[key];
        }
    }
}

// Load recent reports
function loadRecentReports() {
    // Simulated reports
    const reports = [
        { id: 'RPT001', type: 'Theft', location: 'Downtown', date: '2024-02-27', status: 'pending', priority: 'high' },
        { id: 'RPT002', type: 'Assault', location: 'Central Park', date: '2024-02-27', status: 'review', priority: 'urgent' },
        { id: 'RPT003', type: 'Vandalism', location: 'Westside', date: '2024-02-26', status: 'investigating', priority: 'medium' },
        { id: 'RPT004', type: 'Fraud', location: 'Eastside', date: '2024-02-26', status: 'pending', priority: 'low' },
        { id: 'RPT005', type: 'Robbery', location: 'Northside', date: '2024-02-25', status: 'resolved', priority: 'high' }
    ];
    
    const tableBody = document.querySelector('#reportsTable tbody');
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    reports.forEach(report => {
        const row = createReportRow(report);
        tableBody.appendChild(row);
    });
}

// Create report table row
function createReportRow(report) {
    const tr = document.createElement('tr');
    
    tr.innerHTML = `
        <td>${report.id}</td>
        <td>${report.type}</td>
        <td>${report.location}</td>
        <td>${report.date}</td>
        <td><span class="status-badge ${report.status}">${getStatusLabel(report.status)}</span></td>
        <td><span class="priority-badge ${report.priority}">${report.priority}</span></td>
        <td>
            <div class="action-buttons">
                <button class="action-btn view" onclick="viewReport('${report.id}')">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="action-btn edit" onclick="editReport('${report.id}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="action-btn delete" onclick="deleteReport('${report.id}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;
    
    return tr;
}

// Get status label
function getStatusLabel(status) {
    const labels = {
        'pending': 'Pending',
        'review': 'Under Review',
        'investigating': 'Investigating',
        'resolved': 'Resolved'
    };
    return labels[status] || status;
}

// Load user activity
function loadUserActivity() {
    // Simulated activity
    const activities = [
        { user: 'John Doe', action: 'Submitted report', target: 'RPT001', time: '5 min ago' },
        { user: 'Jane Smith', action: 'Updated profile', target: '', time: '15 min ago' },
        { user: 'Mike Johnson', action: 'Triggered SOS', target: 'SOS001', time: '1 hour ago' },
        { user: 'Sarah Wilson', action: 'Commented on report', target: 'RPT003', time: '2 hours ago' },
        { user: 'Admin', action: 'Assigned report', target: 'RPT002', time: '3 hours ago' }
    ];
    
    const activityList = document.querySelector('.activity-list');
    if (!activityList) return;
    
    activityList.innerHTML = '';
    
    activities.forEach(activity => {
        const item = createActivityItem(activity);
        activityList.appendChild(item);
    });
}

// Create activity item
function createActivityItem(activity) {
    const div = document.createElement('div');
    div.className = 'activity-item';
    
    div.innerHTML = `
        <div class="activity-icon">
            <i class="fas ${getActivityIcon(activity.action)}"></i>
        </div>
        <div class="activity-details">
            <p><strong>${activity.user}</strong> ${activity.action} ${activity.target}</p>
            <small>${activity.time}</small>
        </div>
    `;
    
    return div;
}

// Get activity icon
function getActivityIcon(action) {
    const icons = {
        'Submitted report': 'fa-file-alt',
        'Updated profile': 'fa-user-edit',
        'Triggered SOS': 'fa-exclamation-triangle',
        'Commented on report': 'fa-comment',
        'Assigned report': 'fa-user-tag'
    };
    return icons[action] || 'fa-bell';
}

// Initialize admin charts
function initializeAdminCharts() {
    if (typeof Chart === 'undefined') return;
    
    // Crime trends chart
    const trendsCtx = document.getElementById('crimeTrendsChart')?.getContext('2d');
    if (trendsCtx) {
        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Theft',
                        data: [12, 19, 15, 17],
                        borderColor: '#007BFF',
                        tension: 0.4
                    },
                    {
                        label: 'Assault',
                        data: [8, 12, 10, 14],
                        borderColor: '#DC3545',
                        tension: 0.4
                    },
                    {
                        label: 'Vandalism',
                        data: [6, 8, 7, 11],
                        borderColor: '#FFC107',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
    
    // Crime types pie chart
    const typesCtx = document.getElementById('crimeTypesChart')?.getContext('2d');
    if (typesCtx) {
        new Chart(typesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Theft', 'Assault', 'Vandalism', 'Fraud', 'Other'],
                datasets: [{
                    data: [45, 23, 34, 18, 12],
                    backgroundColor: [
                        '#007BFF',
                        '#DC3545',
                        '#FFC107',
                        '#28A745',
                        '#6C757D'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
    
    // Response time chart
    const responseCtx = document.getElementById('responseTimeChart')?.getContext('2d');
    if (responseCtx) {
        new Chart(responseCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Average Response Time (hours)',
                    data: [2.5, 2.3, 2.8, 2.1, 2.4, 3.2, 2.9],
                    backgroundColor: '#007BFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
}

// Load page content based on current page
function loadPageContent(page) {
    switch(page) {
        case 'overview.html':
            loadOverviewContent();
            break;
        case 'reports.html':
            loadReportsContent();
            break;
        case 'users.html':
            loadUsersContent();
            break;
        case 'notifications.html':
            loadNotificationsContent();
            break;
        case 'map.html':
            loadMapContent();
            break;
        case 'analytics.html':
            loadAnalyticsContent();
            break;
        case 'settings.html':
            loadSettingsContent();
            break;
    }
}

// Load overview content
function loadOverviewContent() {
    // Update page title
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'Dashboard Overview';
}

// Load reports content
function loadReportsContent() {
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'Manage Reports';
    
    // Initialize filters
    initializeReportFilters();
}

// Initialize report filters
function initializeReportFilters() {
    const filterSelects = document.querySelectorAll('.filter-select');
    const searchInput = document.querySelector('.search-box input');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', filterReports);
    });
    
    if (searchInput) {
        searchInput.addEventListener('keyup', filterReports);
    }
}

// Filter reports
function filterReports() {
    // Get filter values
    const status = document.getElementById('statusFilter')?.value || 'all';
    const type = document.getElementById('typeFilter')?.value || 'all';
    const search = document.querySelector('.search-box input')?.value.toLowerCase() || '';
    
    // Filter table rows
    const rows = document.querySelectorAll('#reportsTable tbody tr');
    
    rows.forEach(row => {
        let show = true;
        
        // Filter by status
        if (status !== 'all') {
            const statusCell = row.querySelector('.status-badge');
            if (!statusCell || !statusCell.classList.contains(status)) {
                show = false;
            }
        }
        
        // Filter by search
        if (search) {
            const text = row.textContent.toLowerCase();
            if (!text.includes(search)) {
                show = false;
            }
        }
        
        row.style.display = show ? '' : 'none';
    });
}

// Load users content
function loadUsersContent() {
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'User Management';
    
    loadUsers();
}

// Load users
function loadUsers() {
    // Simulated users
    const users = [
        { id: 1, name: 'John Doe', email: 'john@example.com', role: 'user', status: 'active', reports: 12 },
        { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'user', status: 'active', reports: 8 },
        { id: 3, name: 'Mike Johnson', email: 'mike@example.com', role: 'officer', status: 'active', reports: 0 },
        { id: 4, name: 'Sarah Wilson', email: 'sarah@example.com', role: 'user', status: 'suspended', reports: 3 },
        { id: 5, name: 'Admin User', email: 'admin@example.com', role: 'admin', status: 'active', reports: 0 }
    ];
    
    const tableBody = document.querySelector('#usersTable tbody');
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    users.forEach(user => {
        const row = createUserRow(user);
        tableBody.appendChild(row);
    });
}

// Create user row
function createUserRow(user) {
    const tr = document.createElement('tr');
    
    tr.innerHTML = `
        <td>${user.id}</td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td><span class="role-badge ${user.role}">${user.role}</span></td>
        <td><span class="status-badge ${user.status}">${user.status}</span></td>
        <td>${user.reports}</td>
        <td>
            <div class="action-buttons">
                <button class="action-btn edit" onclick="editUser(${user.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="action-btn delete" onclick="deleteUser(${user.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;
    
    return tr;
}

// Load notifications content
function loadNotificationsContent() {
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'Notifications';
    
    loadSystemNotifications();
}

// Load system notifications
function loadSystemNotifications() {
    // Simulated notifications
    const notifications = [
        { id: 1, type: 'alert', message: 'SOS triggered in Downtown area', time: '5 min ago', read: false },
        { id: 2, type: 'info', message: 'New report filed #RPT001', time: '15 min ago', read: false },
        { id: 3, type: 'success', message: 'Report #RPT002 resolved', time: '1 hour ago', read: true },
        { id: 4, type: 'warning', message: 'High crime activity in Central Park', time: '2 hours ago', read: true },
        { id: 5, type: 'info', message: 'System update scheduled', time: '1 day ago', read: true }
    ];
    
    const notificationList = document.querySelector('.notification-list');
    if (!notificationList) return;
    
    notificationList.innerHTML = '';
    
    notifications.forEach(notification => {
        const item = createNotificationItem(notification);
        notificationList.appendChild(item);
    });
}

// Create notification item
function createNotificationItem(notification) {
    const div = document.createElement('div');
    div.className = `notification-item ${notification.read ? '' : 'unread'}`;
    
    div.innerHTML = `
        <div class="notification-icon ${notification.type}">
            <i class="fas ${getNotificationIcon(notification.type)}"></i>
        </div>
        <div class="notification-content">
            <p>${notification.message}</p>
            <small>${notification.time}</small>
        </div>
        <div class="notification-actions">
            <button onclick="markAsRead(${notification.id})">
                <i class="fas fa-check"></i>
            </button>
        </div>
    `;
    
    return div;
}

// Get notification icon
function getNotificationIcon(type) {
    const icons = {
        'alert': 'fa-exclamation-triangle',
        'info': 'fa-info-circle',
        'success': 'fa-check-circle',
        'warning': 'fa-exclamation-circle'
    };
    return icons[type] || 'fa-bell';
}

// Load map content
function loadMapContent() {
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'Crime Map';
    
    // Initialize map
    initCrimeMap('crimeMap', { heatmap: true });
    
    // Load crime data
    loadCrimeData();
}

// Load analytics content
function loadAnalyticsContent() {
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'Analytics';
}

// Load settings content
function loadSettingsContent() {
    const title = document.getElementById('currentPageTitle');
    if (title) title.textContent = 'Settings';
    
    loadSystemSettings();
}

// Load system settings
function loadSystemSettings() {
    // Load saved settings from localStorage
    const settings = JSON.parse(localStorage.getItem('adminSettings')) || {
        siteName: 'Crime Reporting App',
        language: 'en',
        timezone: 'America/New_York',
        emailNotifications: true,
        autoAssign: false,
        retentionDays: 30
    };
    
    // Populate form if exists
    const form = document.getElementById('settingsForm');
    if (form) {
        Object.keys(settings).forEach(key => {
            const input = form.elements[key];
            if (input) {
                if (input.type === 'checkbox') {
                    input.checked = settings[key];
                } else {
                    input.value = settings[key];
                }
            }
        });
    }
}

// Save system settings
function saveSystemSettings(event) {
    event.preventDefault();
    
    const form = document.getElementById('settingsForm');
    if (!form) return false;
    
    const settings = {};
    
    // Gather form data
    new FormData(form).forEach((value, key) => {
        settings[key] = value;
    });
    
    // Handle checkboxes
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => {
        settings[cb.name] = cb.checked;
    });
    
    // Save to localStorage
    localStorage.setItem('adminSettings', JSON.stringify(settings));
    
    showNotification('Settings saved successfully!', 'success');
    
    return false;
}

// Report actions
function viewReport(reportId) {
    sessionStorage.setItem('viewReportId', reportId);
    window.location.href = `reports.html?view=${reportId}`;
}

function editReport(reportId) {
    sessionStorage.setItem('editReportId', reportId);
    window.location.href = `reports.html?edit=${reportId}`;
}

function deleteReport(reportId) {
    if (confirm('Are you sure you want to delete this report?')) {
        showLoading('Deleting report...');
        
        setTimeout(() => {
            hideLoading();
            showNotification('Report deleted successfully', 'success');
            
            // Remove row from table
            const row = document.querySelector(`tr:has(button[onclick*="${reportId}"])`);
            if (row) row.remove();
        }, 1000);
    }
}

// User actions
function editUser(userId) {
    showNotification(`Edit user ${userId}`, 'info');
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        showLoading('Deleting user...');
        
        setTimeout(() => {
            hideLoading();
            showNotification('User deleted successfully', 'success');
            
            // Remove row
            const row = document.querySelector(`tr:has(button[onclick*="${userId}"])`);
            if (row) row.remove();
        }, 1000);
    }
}

// Mark notification as read
function markAsRead(notificationId) {
    const item = document.querySelector(`.notification-item:has(button[onclick*="${notificationId}"])`);
    if (item) {
        item.classList.remove('unread');
    }
}

// Export functions
window.viewReport = viewReport;
window.editReport = editReport;
window.deleteReport = deleteReport;
window.editUser = editUser;
window.deleteUser = deleteUser;
window.markAsRead = markAsRead;
window.saveSystemSettings = saveSystemSettings;
window.filterReports = filterReports;