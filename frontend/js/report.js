// Report Form JavaScript

// Current step in multi-step form
let currentStep = 1;
let selectedFiles = [];
let map = null;
let marker = null;

// Initialize report page
document.addEventListener('DOMContentLoaded', function() {
    // Set default date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('crimeDate');
    if (dateInput) {
        dateInput.value = today;
        dateInput.max = today;
    }
    
    // Set default time to current time
    const timeInput = document.getElementById('crimeTime');
    if (timeInput) {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        timeInput.value = `${hours}:${minutes}`;
    }
    
    // Initialize map if on step 2
    initMap();
    
    // Initialize file upload
    initFileUpload();
    
    // Load draft if exists
    loadDraft();
});

// Navigation functions
function nextStep() {
    if (validateStep(currentStep)) {
        // Hide current step
        document.getElementById(`step${currentStep}`).classList.remove('active');
        document.querySelectorAll('.progress-step')[currentStep - 1].classList.remove('active');
        document.querySelectorAll('.progress-step')[currentStep - 1].classList.add('completed');
        
        // Show next step
        currentStep++;
        document.getElementById(`step${currentStep}`).classList.add('active');
        document.querySelectorAll('.progress-step')[currentStep - 1].classList.add('active');
        
        // Initialize map if moving to step 2
        if (currentStep === 2) {
            setTimeout(initMap, 100);
        }
        
        // Update review data if moving to step 4
        if (currentStep === 4) {
            updateReviewData();
        }
        
        // Save draft
        saveDraft();
    }
}

function prevStep() {
    // Hide current step
    document.getElementById(`step${currentStep}`).classList.remove('active');
    document.querySelectorAll('.progress-step')[currentStep - 1].classList.remove('active');
    
    // Show previous step
    currentStep--;
    document.getElementById(`step${currentStep}`).classList.add('active');
    document.querySelectorAll('.progress-step')[currentStep - 1].classList.add('active');
    document.querySelectorAll('.progress-step')[currentStep - 1].classList.remove('completed');
}

// Validate current step
function validateStep(step) {
    switch(step) {
        case 1:
            return validateStep1();
        case 2:
            return validateStep2();
        case 3:
            return true; // File upload is optional
        default:
            return true;
    }
}

function validateStep1() {
    const crimeType = document.getElementById('crimeType').value;
    const crimeDate = document.getElementById('crimeDate').value;
    const crimeTime = document.getElementById('crimeTime').value;
    const description = document.getElementById('description').value;
    
    if (!crimeType) {
        showNotification('Please select a crime type', 'error');
        return false;
    }
    
    if (!crimeDate) {
        showNotification('Please select the date', 'error');
        return false;
    }
    
    if (!crimeTime) {
        showNotification('Please select the time', 'error');
        return false;
    }
    
    if (!description || description.length < 20) {
        showNotification('Please provide a detailed description (minimum 20 characters)', 'error');
        return false;
    }
    
    return true;
}

function validateStep2() {
    const location = document.getElementById('location').value;
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    
    if (!location) {
        showNotification('Please enter a location', 'error');
        return false;
    }
    
    if (!lat || !lng) {
        showNotification('Please select a location on the map', 'error');
        return false;
    }
    
    return true;
}

// Map functions
function initMap() {
    const mapContainer = document.getElementById('locationMap');
    if (!mapContainer || map) return;
    
    // Initialize map with default view (center on a default location)
    map = L.map('locationMap').setView([40.7128, -74.0060], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add click handler to set marker
    map.on('click', function(e) {
        setMarker(e.latlng);
        reverseGeocode(e.latlng);
    });
    
    // Try to get user's location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setView([userLocation.lat, userLocation.lng], 15);
                setMarker(userLocation);
                reverseGeocode(userLocation);
            },
            function(error) {
                console.log('Geolocation error:', error);
            }
        );
    }
}

function setMarker(latlng) {
    if (marker) {
        marker.setLatLng(latlng);
    } else {
        marker = L.marker(latlng, { draggable: true }).addTo(map);
        marker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            updateCoordinates(position);
            reverseGeocode(position);
        });
    }
    
    updateCoordinates(latlng);
}

function updateCoordinates(latlng) {
    document.getElementById('latitude').value = latlng.lat.toFixed(6);
    document.getElementById('longitude').value = latlng.lng.toFixed(6);
}

function reverseGeocode(latlng) {
    // Using OpenStreetMap Nominatim API for reverse geocoding
    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('location').value = data.display_name;
            }
        })
        .catch(error => console.log('Geocoding error:', error));
}

function getCurrentLocation() {
    if (!navigator.geolocation) {
        showNotification('Geolocation is not supported by your browser', 'error');
        return;
    }
    
    showLoading('Getting your location...');
    
    navigator.geolocation.getCurrentLocation
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                if (map) {
                    map.setView([userLocation.lat, userLocation.lng], 16);
                    setMarker(userLocation);
                    reverseGeocode(userLocation);
                }
                
                hideLoading();
                showNotification('Location detected!', 'success');
            },
            function(error) {
                hideLoading();
                let errorMessage = 'Failed to get your location';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Please allow location access';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Location information unavailable';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Location request timed out';
                        break;
                }
                
                showNotification(errorMessage, 'error');
            }
        );
}

// File upload functions
function initFileUpload() {
    const fileInput = document.getElementById('fileInput');
    const fileUpload = document.getElementById('fileUpload');
    
    if (!fileInput || !fileUpload) return;
    
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });
    
    // Handle drag and drop
    fileUpload.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#007BFF';
        this.style.background = '#e3f2fd';
    });
    
    fileUpload.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#dee2e6';
        this.style.background = '';
    });
    
    fileUpload.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#dee2e6';
        this.style.background = '';
        
        handleFiles(e.dataTransfer.files);
    });
    
    // Click to upload
    fileUpload.addEventListener('click', function() {
        fileInput.click();
    });
}

function handleFiles(files) {
    const maxSize = 50 * 1024 * 1024; // 50MB
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime'];
    
    Array.from(files).forEach(file => {
        // Check file type
        if (!allowedTypes.includes(file.type)) {
            showNotification(`File type not supported: ${file.name}`, 'error');
            return;
        }
        
        // Check file size
        if (file.size > maxSize) {
            showNotification(`File too large (max 50MB): ${file.name}`, 'error');
            return;
        }
        
        selectedFiles.push(file);
        previewFile(file);
    });
    
    updateFileCount();
}

function previewFile(file) {
    const preview = document.getElementById('filePreview');
    if (!preview) return;
    
    const reader = new FileReader();
    const previewId = `preview-${Date.now()}-${Math.random()}`;
    
    reader.onload = function(e) {
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item';
        previewItem.id = previewId;
        
        if (file.type.startsWith('image/')) {
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <div class="remove-file" onclick="removeFile('${previewId}')">
                    <i class="fas fa-times"></i>
                </div>
            `;
        } else if (file.type.startsWith('video/')) {
            previewItem.innerHTML = `
                <video src="${e.target.result}"></video>
                <div class="remove-file" onclick="removeFile('${previewId}')">
                    <i class="fas fa-times"></i>
                </div>
            `;
        }
        
        preview.appendChild(previewItem);
    };
    
    reader.readAsDataURL(file);
}

function removeFile(previewId) {
    const previewItem = document.getElementById(previewId);
    if (!previewItem) return;
    
    // Get file index and remove from array
    const index = Array.from(previewItem.parentNode.children).indexOf(previewItem);
    selectedFiles.splice(index, 1);
    
    // Remove preview
    previewItem.remove();
    
    updateFileCount();
}

function updateFileCount() {
    const reviewFiles = document.getElementById('reviewFiles');
    if (reviewFiles) {
        reviewFiles.textContent = `${selectedFiles.length} file(s) selected`;
    }
}

// Review data
function updateReviewData() {
    // Crime type
    const crimeType = document.getElementById('crimeType');
    const crimeTypeText = crimeType.options[crimeType.selectedIndex]?.text || '-';
    document.getElementById('reviewCrimeType').textContent = crimeTypeText;
    
    // Date and time
    const date = document.getElementById('crimeDate').value;
    const time = document.getElementById('crimeTime').value;
    document.getElementById('reviewDateTime').textContent = `${date} ${time}`;
    
    // Description
    const description = document.getElementById('description').value;
    document.getElementById('reviewDescription').textContent = description.substring(0, 100) + '...';
    
    // Location
    const location = document.getElementById('location').value;
    document.getElementById('reviewLocation').textContent = location;
    
    // Coordinates
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    document.getElementById('reviewCoordinates').textContent = lat && lng ? `${lat}, ${lng}` : '-';
    
    // Files
    updateFileCount();
}

// Form submission
function handleReportSubmit(event) {
    event.preventDefault();
    
    // Validate final step
    const confirmAccuracy = document.getElementById('confirmAccuracy');
    const agreeTerms = document.getElementById('agreeTerms');
    
    if (!confirmAccuracy.checked) {
        showNotification('Please confirm the accuracy of the information', 'error');
        return false;
    }
    
    if (!agreeTerms.checked) {
        showNotification('Please agree to the terms of service', 'error');
        return false;
    }
    
    // Show loading
    showLoading('Submitting report...');
    
    // Prepare form data
    const formData = new FormData();
    formData.append('crimeType', document.getElementById('crimeType').value);
    formData.append('crimeDate', document.getElementById('crimeDate').value);
    formData.append('crimeTime', document.getElementById('crimeTime').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('suspectDescription', document.getElementById('suspectDescription')?.value || '');
    formData.append('anonymous', document.getElementById('anonymous')?.checked || false);
    formData.append('location', document.getElementById('location').value);
    formData.append('latitude', document.getElementById('latitude').value);
    formData.append('longitude', document.getElementById('longitude').value);
    formData.append('additionalInfo', document.getElementById('additionalInfo')?.value || '');
    
    // Append files
    selectedFiles.forEach((file, index) => {
        formData.append(`evidence_${index}`, file);
    });
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        
        // Clear draft
        localStorage.removeItem('reportDraft');
        
        // Show success message
        showNotification('Report submitted successfully!', 'success');
        
        // Generate report ID
        const reportId = 'RPT' + Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        
        // Show success modal with report ID
        showSuccessModal(reportId);
        
        // Redirect after delay
        setTimeout(() => {
            window.location.href = 'my-reports.html';
        }, 3000);
    }, 2000);
    
    return false;
}

// Draft functions
function saveDraft() {
    const draft = {
        crimeType: document.getElementById('crimeType')?.value || '',
        crimeDate: document.getElementById('crimeDate')?.value || '',
        crimeTime: document.getElementById('crimeTime')?.value || '',
        description: document.getElementById('description')?.value || '',
        suspectDescription: document.getElementById('suspectDescription')?.value || '',
        anonymous: document.getElementById('anonymous')?.checked || false,
        location: document.getElementById('location')?.value || '',
        latitude: document.getElementById('latitude')?.value || '',
        longitude: document.getElementById('longitude')?.value || '',
        additionalInfo: document.getElementById('additionalInfo')?.value || '',
        step: currentStep
    };
    
    localStorage.setItem('reportDraft', JSON.stringify(draft));
}

function loadDraft() {
    const draft = JSON.parse(localStorage.getItem('reportDraft'));
    if (!draft) return;
    
    // Ask user if they want to restore draft
    if (confirm('You have an unsaved report. Would you like to continue where you left off?')) {
        // Restore form data
        document.getElementById('crimeType').value = draft.crimeType || '';
        document.getElementById('crimeDate').value = draft.crimeDate || '';
        document.getElementById('crimeTime').value = draft.crimeTime || '';
        document.getElementById('description').value = draft.description || '';
        document.getElementById('suspectDescription').value = draft.suspectDescription || '';
        document.getElementById('anonymous').checked = draft.anonymous || false;
        document.getElementById('location').value = draft.location || '';
        document.getElementById('latitude').value = draft.latitude || '';
        document.getElementById('longitude').value = draft.longitude || '';
        document.getElementById('additionalInfo').value = draft.additionalInfo || '';
        
        // Go to saved step
        if (draft.step > 1) {
            for (let i = 1; i < draft.step; i++) {
                nextStep();
            }
        }
    } else {
        // Clear draft
        localStorage.removeItem('reportDraft');
    }
}

// Success modal
function showSuccessModal(reportId) {
    const modal = document.createElement('div');
    modal.className = 'modal active';
    modal.innerHTML = `
        <div class="modal-content success">
            <div class="modal-header">
                <i class="fas fa-check-circle success-icon"></i>
                <h3>Report Submitted Successfully!</h3>
            </div>
            <div class="modal-body">
                <p>Your report has been submitted. Your reference number is:</p>
                <h2 class="report-id-large">${reportId}</h2>
                <p>You can track your report status using this ID.</p>
            </div>
            <div class="modal-footer">
                <button class="btn-primary" onclick="window.location.href='my-reports.html'">
                    View My Reports
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Auto close after 5 seconds
    setTimeout(() => {
        modal.remove();
    }, 5000);
}

// Export functions
window.nextStep = nextStep;
window.prevStep = prevStep;
window.getCurrentLocation = getCurrentLocation;
window.handleReportSubmit = handleReportSubmit;
window.removeFile = removeFile;