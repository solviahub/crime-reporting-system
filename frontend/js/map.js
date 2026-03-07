// Map JavaScript - For crime mapping and location features

// Global variables
let crimeMap = null;
let heatmapLayer = null;
let markersLayer = null;
let userMarker = null;

// Initialize map
function initCrimeMap(mapElementId, options = {}) {
    const mapElement = document.getElementById(mapElementId);
    if (!mapElement) return null;
    
    // Default options
    const defaultOptions = {
        center: [40.7128, -74.0060], // New York City
        zoom: 12,
        heatmap: false,
        markers: true
    };
    
    const mapOptions = { ...defaultOptions, ...options };
    
    // Create map
    crimeMap = L.map(mapElementId).setView(mapOptions.center, mapOptions.zoom);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(crimeMap);
    
    // Initialize layers
    markersLayer = L.layerGroup().addTo(crimeMap);
    
    if (mapOptions.heatmap) {
        initHeatmapLayer();
    }
    
    return crimeMap;
}

// Initialize heatmap layer
function initHeatmapLayer() {
    if (!crimeMap || typeof L.heatLayer === 'undefined') return;
    
    heatmapLayer = L.heatLayer([], {
        radius: 25,
        blur: 15,
        maxZoom: 17,
        gradient: {
            0.4: 'blue',
            0.6: 'lime',
            0.8: 'yellow',
            1.0: 'red'
        }
    }).addTo(crimeMap);
}

// Load crime data for map
function loadCrimeData(filters = {}) {
    // Simulated crime data
    const crimeData = [
        { lat: 40.7128, lng: -74.0060, type: 'theft', severity: 3, date: '2024-02-27' },
        { lat: 40.7138, lng: -74.0050, type: 'assault', severity: 5, date: '2024-02-26' },
        { lat: 40.7148, lng: -74.0040, type: 'vandalism', severity: 2, date: '2024-02-25' },
        { lat: 40.7118, lng: -74.0070, type: 'robbery', severity: 4, date: '2024-02-24' },
        { lat: 40.7158, lng: -74.0030, type: 'fraud', severity: 1, date: '2024-02-23' },
        { lat: 40.7108, lng: -74.0080, type: 'drugs', severity: 3, date: '2024-02-22' }
    ];
    
    // Clear existing markers
    clearMarkers();
    
    // Add markers
    crimeData.forEach(crime => {
        addCrimeMarker(crime);
    });
    
    // Update heatmap
    updateHeatmap(crimeData);
}

// Add crime marker to map
function addCrimeMarker(crime) {
    if (!crimeMap || !markersLayer) return;
    
    // Get icon based on crime type
    const icon = getCrimeIcon(crime.type);
    
    // Create marker
    const marker = L.marker([crime.lat, crime.lng], { icon: icon })
        .bindPopup(createPopupContent(crime));
    
    markersLayer.addLayer(marker);
}

// Get icon for crime type
function getCrimeIcon(crimeType) {
    const iconColor = getCrimeColor(crimeType);
    
    return L.divIcon({
        html: `<i class="fas fa-map-marker-alt" style="color: ${iconColor}; font-size: 24px;"></i>`,
        className: 'crime-marker',
        iconSize: [24, 24],
        popupAnchor: [0, -24]
    });
}

// Get color for crime type
function getCrimeColor(crimeType) {
    const colors = {
        'theft': '#007BFF',
        'assault': '#DC3545',
        'vandalism': '#FFC107',
        'robbery': '#28A745',
        'fraud': '#6C757D',
        'drugs': '#17A2B8',
        'default': '#007BFF'
    };
    
    return colors[crimeType] || colors.default;
}

// Create popup content for crime
function createPopupContent(crime) {
    return `
        <div class="crime-popup">
            <h4>${crime.type.charAt(0).toUpperCase() + crime.type.slice(1)}</h4>
            <p><strong>Date:</strong> ${crime.date}</p>
            <p><strong>Severity:</strong> ${'⭐'.repeat(crime.severity)}</p>
            <button class="btn-primary btn-small" onclick="viewCrimeDetails('${crime.id}')">
                View Details
            </button>
        </div>
    `;
}

// Update heatmap
function updateHeatmap(crimeData) {
    if (!heatmapLayer) return;
    
    // Convert crime data to heatmap format
    const heatPoints = crimeData.map(crime => [
        crime.lat,
        crime.lng,
        crime.severity || 1
    ]);
    
    heatmapLayer.setLatLngs(heatPoints);
}

// Clear all markers
function clearMarkers() {
    if (markersLayer) {
        markersLayer.clearLayers();
    }
}

// Get user's current location
function getUserLocation(callback) {
    if (!navigator.geolocation) {
        showNotification('Geolocation is not supported', 'error');
        return;
    }
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const location = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
                accuracy: position.coords.accuracy
            };
            
            if (callback) callback(location);
        },
        function(error) {
            let message = 'Failed to get location';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message = 'Please enable location access';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = 'Location unavailable';
                    break;
                case error.TIMEOUT:
                    message = 'Location request timed out';
                    break;
            }
            
            showNotification(message, 'error');
            if (callback) callback(null);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

// Center map on user location
function centerOnUser() {
    getUserLocation(function(location) {
        if (location && crimeMap) {
            crimeMap.setView([location.lat, location.lng], 15);
            
            // Add or update user marker
            addUserMarker(location);
        }
    });
}

// Add user marker
function addUserMarker(location) {
    if (!crimeMap) return;
    
    // Remove existing user marker
    if (userMarker) {
        crimeMap.removeLayer(userMarker);
    }
    
    // Create custom icon for user
    const userIcon = L.divIcon({
        html: '<i class="fas fa-user-circle" style="color: #007BFF; font-size: 32px;"></i>',
        className: 'user-marker',
        iconSize: [32, 32]
    });
    
    // Add marker
    userMarker = L.marker([location.lat, location.lng], { icon: userIcon })
        .bindPopup('You are here')
        .addTo(crimeMap);
}

// Filter crimes by date range
function filterCrimesByDate(startDate, endDate) {
    // In production, this would filter the data
    showNotification('Filtering crimes by date range', 'info');
}

// Filter crimes by type
function filterCrimesByType(crimeTypes) {
    // In production, this would filter the data
    showNotification('Filtering crimes by type', 'info');
}

// Export map as image
function exportMapAsImage() {
    if (!crimeMap) return;
    
    showLoading('Generating map image...');
    
    // Use leaflet-image or similar library
    // For demo, we'll use html2canvas
    if (typeof html2canvas === 'undefined') {
        showNotification('Map export requires html2canvas library', 'error');
        hideLoading();
        return;
    }
    
    const mapContainer = document.getElementById('crimeMap');
    
    html2canvas(mapContainer).then(canvas => {
        hideLoading();
        
        // Create download link
        const link = document.createElement('a');
        link.download = `crime-map-${Date.now()}.png`;
        link.href = canvas.toDataURL();
        link.click();
        
        showNotification('Map exported successfully!', 'success');
    });
}

// Get crime statistics for area
function getAreaStatistics(bounds) {
    // In production, this would query the API
    const stats = {
        total: 156,
        byType: {
            theft: 45,
            assault: 23,
            vandalism: 34,
            robbery: 18,
            fraud: 22,
            drugs: 14
        },
        trend: '+12%',
        hotspots: 5
    };
    
    return stats;
}

// Export functions
window.initCrimeMap = initCrimeMap;
window.loadCrimeData = loadCrimeData;
window.centerOnUser = centerOnUser;
window.filterCrimesByDate = filterCrimesByDate;
window.filterCrimesByType = filterCrimesByType;
window.exportMapAsImage = exportMapAsImage;