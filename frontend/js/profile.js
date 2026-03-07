// Profile JavaScript

// Initialize profile page
document.addEventListener('DOMContentLoaded', function() {
    loadUserProfile();
    initializeProfileTabs();
    loadLoginHistory();
    
    // Check URL hash for tab
    const hash = window.location.hash.substring(1);
    if (hash) {
        showProfileTab(hash);
    }
});

// Load user profile data
function loadUserProfile() {
    const user = JSON.parse(localStorage.getItem('user'));
    
    if (!user) {
        // Redirect to login if not logged in
        window.location.href = 'login.html';
        return;
    }
    
    // Update profile information
    document.getElementById('displayName').textContent = user.name || 'User';
    document.getElementById('displayEmail').textContent = user.email || '';
    
    // Update form fields
    const nameParts = (user.name || '').split(' ');
    document.getElementById('firstName').value = nameParts[0] || '';
    document.getElementById('lastName').value = nameParts.slice(1).join(' ') || '';
    document.getElementById('email').value = user.email || '';
    
    // Load profile image if exists
    if (user.avatar) {
        document.getElementById('profileImage').src = user.avatar;
    }
    
    // Load saved preferences
    loadUserPreferences();
}

// Initialize profile tabs
function initializeProfileTabs() {
    const tabs = document.querySelectorAll('.profile-menu-item');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            showProfileTab(tabId);
        });
    });
}

// Show profile tab
function showProfileTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.profile-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from menu items
    document.querySelectorAll('.profile-menu-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(`${tabName}-tab`).classList.add('active');
    
    // Add active class to menu item
    document.querySelector(`.profile-menu-item[onclick="showProfileTab('${tabName}')"]`).classList.add('active');
    
    // Update URL hash
    window.location.hash = tabName;
}

// Update profile
function updateProfile(event) {
    event.preventDefault();
    
    // Get form data
    const profileData = {
        firstName: document.getElementById('firstName').value,
        lastName: document.getElementById('lastName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        dob: document.getElementById('dob').value
    };
    
    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(profileData.email)) {
        showNotification('Please enter a valid email address', 'error');
        return false;
    }
    
    showLoading('Updating profile...');
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        
        // Update user in localStorage
        const user = JSON.parse(localStorage.getItem('user')) || {};
        user.name = `${profileData.firstName} ${profileData.lastName}`;
        user.email = profileData.email;
        user.phone = profileData.phone;
        user.address = profileData.address;
        
        localStorage.setItem('user', JSON.stringify(user));
        
        // Update display
        document.getElementById('displayName').textContent = user.name;
        document.getElementById('displayEmail').textContent = user.email;
        
        showNotification('Profile updated successfully!', 'success');
    }, 1500);
    
    return false;
}

// Update security settings
function updateSecurity(event) {
    event.preventDefault();
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Validate current password (simulated)
    if (currentPassword !== 'password123') { // Demo only
        showNotification('Current password is incorrect', 'error');
        return false;
    }
    
    // Validate new password
    if (newPassword.length < 8) {
        showNotification('Password must be at least 8 characters', 'error');
        return false;
    }
    
    // Check password match
    if (newPassword !== confirmPassword) {
        showNotification('Passwords do not match', 'error');
        return false;
    }
    
    showLoading('Updating password...');
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        showNotification('Password updated successfully!', 'success');
        
        // Clear form
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
    }, 1500);
    
    return false;
}

// Upload avatar
function uploadAvatar() {
    const input = document.getElementById('avatarUpload');
    const file = input.files[0];
    
    if (!file) return;
    
    // Check file type
    if (!file.type.startsWith('image/')) {
        showNotification('Please select an image file', 'error');
        return;
    }
    
    // Check file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        showNotification('Image must be less than 2MB', 'error');
        return;
    }
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        // Update profile image
        document.getElementById('profileImage').src = e.target.result;
        
        // Save to localStorage
        const user = JSON.parse(localStorage.getItem('user')) || {};
        user.avatar = e.target.result;
        localStorage.setItem('user', JSON.stringify(user));
        
        showNotification('Profile picture updated!', 'success');
    };
    
    reader.readAsDataURL(file);
}

// Enable two-factor authentication
function enable2FA() {
    showLoading('Setting up 2FA...');
    
    setTimeout(() => {
        hideLoading();
        
        // Show QR code modal (simulated)
        const modal = document.createElement('div');
        modal.className = 'modal active';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Setup Two-Factor Authentication</h3>
                    <button class="close-modal" onclick="this.closest('.modal').remove()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Scan this QR code with your authenticator app:</p>
                    <div class="qr-code">
                        <i class="fas fa-qrcode" style="font-size: 200px; color: #000;"></i>
                    </div>
                    <p>Or enter this code manually:</p>
                    <code>ABCD EFGH IJKL MNOP</code>
                </div>
                <div class="modal-footer">
                    <button class="btn-primary" onclick="verify2FA()">Next</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
    }, 1000);
}

// Verify 2FA code
function verify2FA() {
    const code = prompt('Enter the verification code from your authenticator app:');
    
    if (code) {
        showLoading('Verifying...');
        
        setTimeout(() => {
            hideLoading();
            
            // Close modal
            document.querySelector('.modal.active')?.remove();
            
            // Update UI
            document.querySelector('.two-factor-status .status-badge').textContent = 'Enabled';
            document.querySelector('.two-factor-status .status-badge').classList.remove('disabled');
            document.querySelector('.two-factor-status .status-badge').classList.add('enabled');
            
            showNotification('2FA enabled successfully!', 'success');
        }, 1500);
    }
}

// Load login history
function loadLoginHistory() {
    // Simulated login history
    const history = [
        {
            device: 'Chrome on Windows',
            location: 'New York, NY',
            time: 'Feb 27, 2024 14:30',
            current: true
        },
        {
            device: 'Safari on iPhone',
            location: 'New York, NY',
            time: 'Feb 26, 2024 09:15',
            current: false
        },
        {
            device: 'Firefox on MacOS',
            location: 'New York, NY',
            time: 'Feb 25, 2024 18:45',
            current: false
        }
    ];
    
    const historyContainer = document.querySelector('.login-history');
    if (!historyContainer) return;
    
    historyContainer.innerHTML = '';
    
    history.forEach(item => {
        const historyItem = createHistoryItem(item);
        historyContainer.appendChild(historyItem);
    });
}

// Create history item
function createHistoryItem(item) {
    const div = document.createElement('div');
    div.className = 'history-item';
    
    const icon = item.device.includes('iPhone') || item.device.includes('Mobile') 
        ? 'fa-mobile-alt' : 'fa-laptop';
    
    div.innerHTML = `
        <i class="fas ${icon}"></i>
        <div class="history-details">
            <p>${item.device}</p>
            <small>${item.location} • ${item.time}</small>
        </div>
        ${item.current ? '<span class="current-badge">Current</span>' : ''}
    `;
    
    return div;
}

// Save notification settings
function saveNotificationSettings() {
    const settings = {
        emailReportUpdates: document.getElementById('emailReportUpdates')?.checked || false,
        emailSafetyAlerts: document.getElementById('emailSafetyAlerts')?.checked || false,
        emailNewsletter: document.getElementById('emailNewsletter')?.checked || false,
        pushSOS: document.getElementById('pushSOS')?.checked || false,
        pushNearby: document.getElementById('pushNearby')?.checked || false
    };
    
    // Save to localStorage
    localStorage.setItem('notificationSettings', JSON.stringify(settings));
    
    showNotification('Notification settings saved!', 'success');
}

// Save privacy settings
function savePrivacySettings() {
    const settings = {
        anonymousDefault: document.getElementById('anonymousDefault')?.checked || false,
        showProfile: document.getElementById('showProfile')?.checked || false,
        locationTracking: document.getElementById('locationTracking')?.checked || false
    };
    
    localStorage.setItem('privacySettings', JSON.stringify(settings));
    
    showNotification('Privacy settings saved!', 'success');
}

// Save preferences
function savePreferences() {
    const preferences = {
        language: document.getElementById('languagePref')?.value || 'en',
        theme: document.getElementById('themePref')?.value || 'light',
        itemsPerPage: document.getElementById('itemsPerPage')?.value || '10'
    };
    
    localStorage.setItem('userPreferences', JSON.stringify(preferences));
    
    // Apply theme
    applyTheme(preferences.theme);
    
    showNotification('Preferences saved!', 'success');
}

// Load user preferences
function loadUserPreferences() {
    const preferences = JSON.parse(localStorage.getItem('userPreferences'));
    
    if (!preferences) return;
    
    // Set form values
    if (document.getElementById('languagePref')) {
        document.getElementById('languagePref').value = preferences.language || 'en';
    }
    
    if (document.getElementById('themePref')) {
        document.getElementById('themePref').value = preferences.theme || 'light';
    }
    
    if (document.getElementById('itemsPerPage')) {
        document.getElementById('itemsPerPage').value = preferences.itemsPerPage || '10';
    }
    
    // Apply theme
    applyTheme(preferences.theme);
}

// Apply theme
function applyTheme(theme) {
    if (theme === 'dark') {
        document.body.classList.add('dark-theme');
    } else if (theme === 'light') {
        document.body.classList.remove('dark-theme');
    } else {
        // System default
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.remove('dark-theme');
        }
    }
}

// Download user data
function downloadData() {
    showLoading('Preparing your data...');
    
    setTimeout(() => {
        hideLoading();
        
        // Get user data
        const userData = {
            profile: JSON.parse(localStorage.getItem('user')),
            preferences: JSON.parse(localStorage.getItem('userPreferences')),
            notificationSettings: JSON.parse(localStorage.getItem('notificationSettings')),
            privacySettings: JSON.parse(localStorage.getItem('privacySettings')),
            reports: [] // Would fetch from API
        };
        
        // Create download
        const dataStr = JSON.stringify(userData, null, 2);
        const dataBlob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(dataBlob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `user-data-${Date.now()}.json`;
        a.click();
        
        URL.revokeObjectURL(url);
        
        showNotification('Data downloaded successfully!', 'success');
    }, 2000);
}

// Delete account
function deleteAccount() {
    showModal('deleteAccountModal');
}

// Confirm account deletion
function confirmDelete() {
    const confirmText = document.getElementById('confirmDelete').value;
    
    if (confirmText !== 'DELETE') {
        showNotification('Please type DELETE to confirm', 'error');
        return;
    }
    
    showLoading('Deleting account...');
    
    setTimeout(() => {
        hideLoading();
        hideModal('deleteAccountModal');
        
        // Clear all user data
        localStorage.clear();
        sessionStorage.clear();
        
        showNotification('Account deleted successfully', 'success');
        
        // Redirect to home
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 2000);
    }, 2000);
}

// Export functions
window.showProfileTab = showProfileTab;
window.updateProfile = updateProfile;
window.updateSecurity = updateSecurity;
window.uploadAvatar = uploadAvatar;
window.enable2FA = enable2FA;
window.saveNotificationSettings = saveNotificationSettings;
window.savePrivacySettings = savePrivacySettings;
window.savePreferences = savePreferences;
window.downloadData = downloadData;
window.deleteAccount = deleteAccount;
window.confirmDelete = confirmDelete;