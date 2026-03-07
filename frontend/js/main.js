// Main JavaScript file

// Global functions
let currentLanguage = 'en';

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Main.js loaded');
    
    // Load components
    loadHeader();
    loadFooter();
    
    // Initialize language selector
    initLanguageSelector();
    
    // Initialize mobile menu
    initMobileMenu();
    
    // Initialize logout button
    initLogout();
});

// Load header component
function loadHeader() {
    const headerPlaceholder = document.getElementById('header-placeholder');
    if (!headerPlaceholder) {
        console.log('No header placeholder found');
        return;
    }
    
    // Determine the correct path to components folder
    const path = getComponentPath();
    const headerUrl = path + 'components/header.html';
    
    console.log('Loading header from:', headerUrl);
    
    fetch(headerUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            headerPlaceholder.innerHTML = data;
            console.log('Header loaded successfully');
            
            // Initialize components that depend on header
            initUserMenu();
            updateUserInfo();
            initLanguageSelector(); // Re-initialize after header loads
            initLogout();
        })
        .catch(error => {
            console.error('Error loading header:', error);
            // Fallback content
            headerPlaceholder.innerHTML = `
                <header style="background: var(--primary); color: white; padding: 1rem; text-align: center;">
                    <h2>Crime Reporting App</h2>
                </header>
            `;
        });
}

// Load footer component
function loadFooter() {
    const footerPlaceholder = document.getElementById('footer-placeholder');
    if (!footerPlaceholder) {
        console.log('No footer placeholder found');
        return;
    }
    
    // Determine the correct path to components folder
    const path = getComponentPath();
    const footerUrl = path + 'components/footer.html';
    
    console.log('Loading footer from:', footerUrl);
    
    fetch(footerUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            footerPlaceholder.innerHTML = data;
            console.log('Footer loaded successfully');
        })
        .catch(error => {
            console.error('Error loading footer:', error);
            // Fallback content
            footerPlaceholder.innerHTML = `
                <footer style="background: var(--dark); color: white; padding: 1rem; text-align: center;">
                    <p>&copy; 2024 Crime Reporting App. All rights reserved.</p>
                </footer>
            `;
        });
}

// Determine the correct path to components folder based on current page
function getComponentPath() {
    const path = window.location.pathname;
    console.log('Current path:', path);
    
    // Check if we're in an admin subdirectory
    if (path.includes('/admin/')) {
        // Count the number of subdirectories after /admin/
        const adminPath = path.split('/admin/')[1];
        const depth = adminPath.split('/').length - 1;
        
        // Go up appropriate number of levels
        if (depth > 0) {
            return '../'.repeat(depth);
        } else {
            return './';
        }
    } else {
        // We're in the root directory
        return './';
    }
}

// Update user info in header
function updateUserInfo() {
    const user = JSON.parse(localStorage.getItem('user'));
    if (!user) return;
    
    // Update user name
    const userNameElements = document.querySelectorAll('.user-name, .username');
    userNameElements.forEach(el => {
        if (el) el.textContent = user.name || 'User';
    });
    
    // Update profile image
    const profileImages = document.querySelectorAll('.user-avatar, .profile-img');
    profileImages.forEach(img => {
        if (img && user.avatar) {
            img.src = user.avatar;
        }
    });
}

// Initialize user menu dropdown
function initUserMenu() {
    const userMenu = document.querySelector('.user-menu');
    if (!userMenu) return;
    
    userMenu.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = this.querySelector('.user-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
        }
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        const dropdowns = document.querySelectorAll('.user-dropdown.show');
        dropdowns.forEach(dropdown => dropdown.classList.remove('show'));
    });
}

// Initialize mobile menu
function initMobileMenu() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
}

// Initialize language selector
function initLanguageSelector() {
    const languageSelect = document.getElementById('languageSelect');
    if (!languageSelect) return;
    
    // Load saved language preference
    const savedLang = localStorage.getItem('language') || 'en';
    languageSelect.value = savedLang;
    currentLanguage = savedLang;
    
    languageSelect.addEventListener('change', function(e) {
        const lang = e.target.value;
        localStorage.setItem('language', lang);
        currentLanguage = lang;
        console.log('Language changed to:', lang);
    });
}

// Initialize logout button
function initLogout() {
    const logoutBtn = document.getElementById('logoutBtn');
    if (!logoutBtn) return;
    
    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        logout();
    });
}

// Logout function
function logout() {
    showLoading('Logging out...');
    
    setTimeout(() => {
        localStorage.removeItem('user');
        sessionStorage.clear();
        hideLoading();
        showNotification('Logged out successfully', 'success');
        
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 1000);
    }, 500);
}

// Loading indicator functions
function showLoading(message = 'Loading...') {
    let loader = document.getElementById('global-loader');
    
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'global-loader';
        loader.innerHTML = `
            <div class="loader-content">
                <div class="spinner"></div>
                <p class="loader-message">${message}</p>
            </div>
        `;
        document.body.appendChild(loader);
    } else {
        const messageEl = loader.querySelector('.loader-message');
        if (messageEl) messageEl.textContent = message;
        loader.style.display = 'flex';
    }
}

function hideLoading() {
    const loader = document.getElementById('global-loader');
    if (loader) {
        loader.style.display = 'none';
    }
}

// Notification function
function showNotification(message, type = 'info', duration = 3000) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    let icon = 'info-circle';
    if (type === 'success') icon = 'check-circle';
    if (type === 'error') icon = 'exclamation-circle';
    if (type === 'warning') icon = 'exclamation-triangle';
    
    notification.innerHTML = `
        <i class="fas fa-${icon}"></i>
        <span>${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    if (duration > 0) {
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }
}

// Modal functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Add global styles
const style = document.createElement('style');
style.textContent = `
    .global-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }
    
    .loader-content {
        text-align: center;
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .loader-message {
        color: var(--dark);
        font-size: 1rem;
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 1rem;
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 400px;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification-success {
        border-left: 4px solid var(--success);
    }
    
    .notification-success i {
        color: var(--success);
    }
    
    .notification-error {
        border-left: 4px solid var(--danger);
    }
    
    .notification-error i {
        color: var(--danger);
    }
    
    .notification-warning {
        border-left: 4px solid var(--warning);
    }
    
    .notification-warning i {
        color: var(--warning);
    }
    
    .notification-info {
        border-left: 4px solid var(--primary);
    }
    
    .notification-info i {
        color: var(--primary);
    }
    
    .notification-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: var(--neutral);
        margin-left: auto;
    }
    
    .notification-close:hover {
        color: var(--dark);
    }
    
    .user-dropdown.show {
        display: block;
    }
`;

document.head.appendChild(style);

// Export functions to global scope
window.showLoading = showLoading;
window.hideLoading = hideLoading;
window.showNotification = showNotification;
window.showModal = showModal;
window.hideModal = hideModal;
window.logout = logout;