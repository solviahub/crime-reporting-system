// Authentication JavaScript

// Handle Login Form Submission
function handleLogin(event) {
    event.preventDefault();
    
    // Validate form using Parsley
    if (!$('#loginForm').parsley().validate()) {
        return false;
    }
    
    // Get form data
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember')?.checked || false;
    
    // Show loading state
    showLoading('Logging in...');
    
    // Simulate API call (replace with actual backend)
    setTimeout(() => {
        hideLoading();
        
        // Demo login logic (remove in production)
        if (email === 'user@example.com' && password === 'password123') {
            // Store user data
            const userData = {
                name: 'John Doe',
                email: email,
                role: 'user',
                avatar: 'assets/images/default-avatar.png'
            };
            
            localStorage.setItem('user', JSON.stringify(userData));
            if (remember) {
                localStorage.setItem('rememberMe', 'true');
            }
            
            showNotification('Login successful! Redirecting...', 'success');
            
            // Redirect to dashboard
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 1500);
            
        } else if (email === 'admin@example.com' && password === 'admin123') {
            // Admin login
            const adminData = {
                name: 'Admin User',
                email: email,
                role: 'admin',
                avatar: 'assets/images/admin-avatar.png'
            };
            
            localStorage.setItem('user', JSON.stringify(adminData));
            showNotification('Admin login successful!', 'success');
            
            setTimeout(() => {
                window.location.href = 'admin/dashboard/overview.html';
            }, 1500);
            
        } else {
            showNotification('Invalid email or password', 'error');
        }
    }, 1500);
    
    return false;
}

// Handle Registration Form Submission
function handleRegister(event) {
    event.preventDefault();
    
    // Validate form
    if (!$('#registerForm').parsley().validate()) {
        return false;
    }
    
    // Get form data
    const formData = {
        fullname: document.getElementById('fullname').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        password: document.getElementById('password').value,
        anonymous: document.getElementById('anonymous')?.checked || false,
        terms: document.getElementById('terms').checked
    };
    
    // Validate terms
    if (!formData.terms) {
        showNotification('You must accept the terms and conditions', 'error');
        return false;
    }
    
    // Validate password match
    const confirmPassword = document.getElementById('confirm_password').value;
    if (formData.password !== confirmPassword) {
        showNotification('Passwords do not match', 'error');
        return false;
    }
    
    // Show loading
    showLoading('Creating account...');
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        
        // Demo registration success
        showNotification('Account created successfully! Please login.', 'success');
        
        // Redirect to login
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 2000);
    }, 2000);
    
    return false;
}

// Handle Google Login
function handleGoogleLogin() {
    showLoading('Connecting to Google...');
    
    // Simulate Google OAuth
    setTimeout(() => {
        hideLoading();
        
        // Demo Google login
        const userData = {
            name: 'Google User',
            email: 'user@gmail.com',
            role: 'user',
            avatar: 'assets/images/google-avatar.png'
        };
        
        localStorage.setItem('user', JSON.stringify(userData));
        showNotification('Google login successful!', 'success');
        
        setTimeout(() => {
            window.location.href = 'dashboard.html';
        }, 1500);
    }, 2000);
}

// Handle Google Registration
function handleGoogleRegister() {
    handleGoogleLogin(); // Same flow for demo
}

// Handle Logout
function logout() {
    showLoading('Logging out...');
    
    setTimeout(() => {
        // Clear user data
        localStorage.removeItem('user');
        localStorage.removeItem('rememberMe');
        
        // Clear session
        sessionStorage.clear();
        
        hideLoading();
        showNotification('Logged out successfully', 'success');
        
        // Redirect to home
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 1000);
    }, 500);
}

// Check if user is logged in
function checkAuth(requiredRole = null) {
    const user = JSON.parse(localStorage.getItem('user'));
    
    if (!user) {
        // Redirect to login if not authenticated
        window.location.href = 'login.html';
        return false;
    }
    
    if (requiredRole && user.role !== requiredRole) {
        // Redirect to appropriate dashboard based on role
        if (user.role === 'admin') {
            window.location.href = 'admin/dashboard/overview.html';
        } else {
            window.location.href = 'dashboard.html';
        }
        return false;
    }
    
    return user;
}

// Password Strength Checker
function checkPasswordStrength(password) {
    let strength = 0;
    
    // Length check
    if (password.length >= 8) strength += 1;
    
    // Contains number
    if (/\d/.test(password)) strength += 1;
    
    // Contains lowercase
    if (/[a-z]/.test(password)) strength += 1;
    
    // Contains uppercase
    if (/[A-Z]/.test(password)) strength += 1;
    
    // Contains special character
    if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
    
    return strength;
}

// Update password strength indicator
function updatePasswordStrength(password) {
    const strength = checkPasswordStrength(password);
    const strengthBar = document.querySelector('.strength-bar');
    
    if (!strengthBar) return;
    
    strengthBar.className = 'strength-bar';
    
    if (password.length === 0) {
        strengthBar.style.width = '0';
    } else if (strength <= 2) {
        strengthBar.classList.add('weak');
    } else if (strength <= 3) {
        strengthBar.classList.add('medium');
    } else {
        strengthBar.classList.add('strong');
    }
}

// Forgot Password
function forgotPassword() {
    const email = prompt('Please enter your email address:');
    
    if (!email) return;
    
    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showNotification('Please enter a valid email address', 'error');
        return;
    }
    
    showLoading('Sending reset link...');
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        showNotification('Password reset link sent to your email!', 'success');
    }, 2000);
}

// Initialize auth page
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is already logged in
    const user = JSON.parse(localStorage.getItem('user'));
    const currentPage = window.location.pathname.split('/').pop();
    
    if (user) {
        // Redirect if trying to access login/register pages while logged in
        if (currentPage === 'login.html' || currentPage === 'register.html') {
            if (user.role === 'admin') {
                window.location.href = 'admin/dashboard/overview.html';
            } else {
                window.location.href = 'dashboard.html';
            }
        }
    }
    
    // Initialize password strength checker on register page
    const passwordInput = document.getElementById('password');
    if (passwordInput && window.location.pathname.includes('register')) {
        passwordInput.addEventListener('keyup', function(e) {
            updatePasswordStrength(e.target.value);
        });
    }
    
    // Add logout button listener if exists
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            logout();
        });
    }
});

// Export functions for use in HTML
window.handleLogin = handleLogin;
window.handleRegister = handleRegister;
window.handleGoogleLogin = handleGoogleLogin;
window.handleGoogleRegister = handleGoogleRegister;
window.logout = logout;
window.forgotPassword = forgotPassword;