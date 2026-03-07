// SOS Emergency JavaScript

// Global variables
let sosTimer = null;
let sosCountdown = 10;
let mediaRecorder = null;
let recordedChunks = [];
let locationWatchId = null;
let sosActive = false;

// Initialize SOS page
document.addEventListener('DOMContentLoaded', function() {
    // Check for existing SOS session
    const activeSOS = sessionStorage.getItem('activeSOS');
    if (activeSOS === 'true') {
        showLocationStatus();
    }
    
    // Request notification permissions
    requestNotificationPermission();
    
    // Load emergency contacts
    loadEmergencyContacts();
});

// Trigger SOS alert
function triggerSOS() {
    // Show confirmation modal
    showModal('sosConfirmModal');
}

// Confirm SOS trigger
function confirmSOS() {
    hideModal('sosConfirmModal');
    
    // Show loading
    showLoading('Triggering SOS alert...');
    
    // Simulate API call to emergency services
    setTimeout(() => {
        hideLoading();
        
        // Set SOS active
        sosActive = true;
        sessionStorage.setItem('activeSOS', 'true');
        
        // Get current location
        getCurrentLocationForSOS();
        
        // Start location tracking
        startLocationTracking();
        
        // Send notifications to emergency contacts
        notifyEmergencyContacts();
        
        // Start countdown for automatic call
        startSOSCountdown();
        
        // Show location status
        showLocationStatus();
        
        // Play alert sound
        playAlertSound();
        
        // Show success message
        showNotification('SOS alert triggered! Emergency services notified.', 'warning');
        
        // Trigger vibration if supported
        if (navigator.vibrate) {
            navigator.vibrate([500, 200, 500]);
        }
    }, 2000);
}

// Get current location for SOS
function getCurrentLocationForSOS() {
    if (!navigator.geolocation) {
        showNotification('Geolocation not supported', 'error');
        return;
    }
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const location = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
                accuracy: position.coords.accuracy
            };
            
            // Send location to emergency services
            sendLocationToEmergency(location);
            
            // Update location status
            updateLocationStatus(location);
            
            // Reverse geocode for address
            getAddressFromCoordinates(location);
        },
        function(error) {
            handleLocationError(error);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

// Start real-time location tracking
function startLocationTracking() {
    if (!navigator.geolocation) return;
    
    locationWatchId = navigator.geolocation.watchPosition(
        function(position) {
            const location = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
                accuracy: position.coords.accuracy,
                speed: position.coords.speed,
                timestamp: new Date().toISOString()
            };
            
            // Update emergency services with new location
            updateEmergencyLocation(location);
            
            // Update UI
            updateLocationStatus(location);
        },
        function(error) {
            console.error('Location tracking error:', error);
        },
        {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 5000
        }
    );
}

// Stop location tracking
function stopSharing() {
    if (locationWatchId) {
        navigator.geolocation.clearWatch(locationWatchId);
        locationWatchId = null;
    }
    
    sosActive = false;
    sessionStorage.removeItem('activeSOS');
    
    document.getElementById('locationStatus').style.display = 'none';
    
    showNotification('Location sharing stopped', 'info');
}

// Update location status in UI
function showLocationStatus() {
    const statusDiv = document.getElementById('locationStatus');
    if (statusDiv) {
        statusDiv.style.display = 'flex';
    }
}

// Update location status message
function updateLocationStatus(location) {
    const statusDiv = document.getElementById('locationStatus');
    if (!statusDiv) return;
    
    const message = statusDiv.querySelector('span');
    if (message) {
        message.textContent = `Sharing your live location (Accuracy: ${Math.round(location.accuracy)}m)`;
    }
}

// Send location to emergency services
function sendLocationToEmergency(location) {
    // Simulate API call
    console.log('Sending location to emergency services:', location);
    
    // In production, this would be an API call to emergency services
    fetch('/api/sos/location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            location: location,
            timestamp: new Date().toISOString(),
            userId: getUserID()
        })
    }).catch(error => console.error('Error sending location:', error));
}

// Update emergency services with new location
function updateEmergencyLocation(location) {
    // Simulate real-time location update
    console.log('Updating location:', location);
    
    // In production, this would be a WebSocket or periodic API call
}

// Get address from coordinates
function getAddressFromCoordinates(location) {
    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${location.lat}&lon=${location.lng}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                showNotification(`Location detected: ${data.display_name}`, 'info');
            }
        })
        .catch(error => console.error('Geocoding error:', error));
}

// Handle location errors
function handleLocationError(error) {
    let message = 'Unable to get your location';
    
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message = 'Please enable location access for SOS feature';
            break;
        case error.POSITION_UNAVAILABLE:
            message = 'Location information unavailable';
            break;
        case error.TIMEOUT:
            message = 'Location request timed out';
            break;
    }
    
    showNotification(message, 'error');
}

// Start SOS countdown
function startSOSCountdown() {
    sosCountdown = 10;
    
    const sosButton = document.getElementById('sosButton');
    if (sosButton) {
        sosButton.disabled = true;
        sosButton.innerHTML = `<i class="fas fa-clock"></i><span>Calling in ${sosCountdown}s</span>`;
    }
    
    sosTimer = setInterval(() => {
        sosCountdown--;
        
        if (sosButton) {
            sosButton.innerHTML = `<i class="fas fa-clock"></i><span>Calling in ${sosCountdown}s</span>`;
        }
        
        if (sosCountdown <= 0) {
            clearInterval(sosTimer);
            callEmergency();
        }
    }, 1000);
}

// Call emergency number
function callEmergency() {
    // Reset SOS button
    const sosButton = document.getElementById('sosButton');
    if (sosButton) {
        sosButton.disabled = false;
        sosButton.innerHTML = '<i class="fas fa-exclamation"></i><span>PRESS FOR SOS</span>';
    }
    
    // Simulate emergency call
    showNotification('Connecting to emergency services...', 'info');
    
    // In a real app, this would use the phone's call functionality
    // window.location.href = 'tel:911';
    
    // For demo, show call simulation
    setTimeout(() => {
        showNotification('Emergency call connected', 'success');
    }, 2000);
}

// Notify emergency contacts
function notifyEmergencyContacts() {
    const contacts = getEmergencyContacts();
    
    contacts.forEach(contact => {
        // Simulate sending SMS/notification
        console.log(`Notifying ${contact.name} at ${contact.phone}`);
        
        // In production, this would be an API call
        sendEmergencyNotification(contact);
    });
}

// Get emergency contacts (from user profile)
function getEmergencyContacts() {
    // In production, this would come from user profile
    return [
        { name: 'John Doe', phone: '+1234567890', relation: 'Spouse' },
        { name: 'Jane Smith', phone: '+0987654321', relation: 'Sibling' }
    ];
}

// Send emergency notification to contact
function sendEmergencyNotification(contact) {
    // Simulate API call
    console.log(`SMS sent to ${contact.name}`);
}

// Load emergency contacts
function loadEmergencyContacts() {
    const contactsList = document.querySelector('.contacts-list');
    if (!contactsList) return;
    
    const contacts = getEmergencyContacts();
    
    contacts.forEach(contact => {
        const contactItem = createContactItem(contact);
        contactsList.appendChild(contactItem);
    });
}

// Create contact item
function createContactItem(contact) {
    const div = document.createElement('div');
    div.className = 'contact-item';
    
    div.innerHTML = `
        <div class="contact-info">
            <i class="fas fa-user"></i>
            <div>
                <h3>${contact.name}</h3>
                <p>${contact.relation} | ${contact.phone}</p>
            </div>
        </div>
        <button class="btn-primary" onclick="callNumber('${contact.phone}')">
            <i class="fas fa-phone"></i> Call
        </button>
    `;
    
    return div;
}

// Call a phone number
function callNumber(number) {
    // In a real app, this would initiate a phone call
    // window.location.href = `tel:${number}`;
    
    showNotification(`Calling ${number}...`, 'info');
}

// Share location via SMS
function shareLocation() {
    getCurrentLocationForSOS();
    
    setTimeout(() => {
        const location = {
            lat: document.getElementById('latitude')?.value || 'unknown',
            lng: document.getElementById('longitude')?.value || 'unknown'
        };
        
        const message = `Emergency! I'm at https://maps.google.com/?q=${location.lat},${location.lng}`;
        
        // In a real app, this would open SMS app
        // window.location.href = `sms:?body=${encodeURIComponent(message)}`;
        
        showNotification('Location copied to clipboard', 'success');
        navigator.clipboard.writeText(message);
    }, 2000);
}

// Send silent text message
function sendMessage() {
    const message = "SOS Emergency! Please help!";
    
    // In a real app, this would send via SMS
    // window.location.href = `sms:?body=${encodeURIComponent(message)}`;
    
    showNotification('Silent alert sent to emergency contacts', 'success');
}

// Start video/audio recording
function startRecording() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        showNotification('Recording not supported on this device', 'error');
        return;
    }
    
    showLoading('Accessing camera and microphone...');
    
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then(function(stream) {
            hideLoading();
            
            // Show recording modal
            showModal('recordingModal');
            
            // Set up media recorder
            mediaRecorder = new MediaRecorder(stream);
            
            mediaRecorder.ondataavailable = function(event) {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };
            
            mediaRecorder.onstop = function() {
                // Create video file
                const blob = new Blob(recordedChunks, { type: 'video/webm' });
                const url = URL.createObjectURL(blob);
                
                // Create download link
                const a = document.createElement('a');
                a.href = url;
                a.download = `sos-recording-${Date.now()}.webm`;
                a.click();
                
                // Upload to server
                uploadRecording(blob);
                
                // Clean up
                recordedChunks = [];
                stream.getTracks().forEach(track => track.stop());
            };
            
            // Start recording
            mediaRecorder.start();
            
            // Display preview
            const preview = document.getElementById('recordingPreview');
            if (preview) {
                const video = document.createElement('video');
                video.srcObject = stream;
                video.autoplay = true;
                video.muted = true;
                preview.innerHTML = '';
                preview.appendChild(video);
            }
            
            // Start timer
            startRecordingTimer();
        })
        .catch(function(error) {
            hideLoading();
            showNotification('Could not access camera/microphone', 'error');
            console.error('Media error:', error);
        });
}

// Stop recording
function stopRecording() {
    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
        mediaRecorder.stop();
    }
    
    hideModal('recordingModal');
    stopRecordingTimer();
}

// Upload recording to server
function uploadRecording(blob) {
    const formData = new FormData();
    formData.append('recording', blob, `sos-recording-${Date.now()}.webm`);
    
    // Simulate upload
    showLoading('Uploading recording...');
    
    setTimeout(() => {
        hideLoading();
        showNotification('Recording uploaded successfully', 'success');
    }, 2000);
    
    // In production, this would be an actual API call
    // fetch('/api/sos/upload', { method: 'POST', body: formData })
}

// Recording timer
let timerInterval = null;
let seconds = 0;

function startRecordingTimer() {
    seconds = 0;
    updateTimerDisplay();
    
    timerInterval = setInterval(() => {
        seconds++;
        updateTimerDisplay();
    }, 1000);
}

function stopRecordingTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function updateTimerDisplay() {
    const timer = document.getElementById('recordingTimer');
    if (timer) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        timer.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
}

// Play alert sound
function playAlertSound() {
    const audio = new Audio('assets/sounds/sos-alert.mp3');
    audio.play().catch(e => console.log('Audio play failed:', e));
}

// Request notification permission
function requestNotificationPermission() {
    if ('Notification' in window) {
        Notification.requestPermission();
    }
}

// Send browser notification
function sendBrowserNotification(title, body) {
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification(title, { body: body });
    }
}

// Get user ID
function getUserID() {
    const user = JSON.parse(localStorage.getItem('user'));
    return user?.id || 'anonymous';
}

// Cancel SOS
function cancelSOS() {
    if (confirm('Are you sure you want to cancel SOS?')) {
        stopSharing();
        clearInterval(sosTimer);
        sosActive = false;
        sessionStorage.removeItem('activeSOS');
        showNotification('SOS cancelled', 'info');
    }
}

// Export functions
window.triggerSOS = triggerSOS;
window.confirmSOS = confirmSOS;
window.stopSharing = stopSharing;
window.callEmergency = callEmergency;
window.shareLocation = shareLocation;
window.sendMessage = sendMessage;
window.startRecording = startRecording;
window.stopRecording = stopRecording;
window.callNumber = callNumber;
window.cancelSOS = cancelSOS;