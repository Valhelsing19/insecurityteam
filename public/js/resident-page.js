// Resident Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('auth_token');
    
    // Check authentication
    if (!token) {
        window.location.href = '/login';
        return;
    }

    // Get user data
    const userData = localStorage.getItem('user_data');
    const user = userData ? JSON.parse(userData) : null;
    
    // Extract first name from user name
    function getFirstName(fullName) {
        if (!fullName) return 'Resident';
        const nameParts = fullName.trim().split(' ');
        return nameParts[0] || 'Resident';
    }

    // Update welcome message and user name
    function updateWelcomeMessage(hasRequests) {
        const welcomeBadge = document.querySelector('.welcome-badge');
        const residentBadge = document.querySelectorAll('.welcome-badge')[1];
        
        if (welcomeBadge) {
            welcomeBadge.textContent = hasRequests ? 'Welcome Back' : 'Welcome';
        }
        
        if (residentBadge && user) {
            const firstName = getFirstName(user.name);
            residentBadge.textContent = firstName;
        }
    }

    // Show onboarding message for new users
    function showOnboardingMessage() {
        const onboardingContainer = document.getElementById('onboarding-message');
        if (!onboardingContainer) return;
        
        onboardingContainer.style.display = 'block';
        
        // Auto-hide after 10 seconds
        setTimeout(() => {
            if (onboardingContainer) {
                onboardingContainer.style.opacity = '0';
                setTimeout(() => {
                    onboardingContainer.style.display = 'none';
                }, 500);
            }
        }, 10000);
    }

    // Load dashboard data
    async function loadDashboardData() {
        try {
            console.log('Loading resident page data...');
            const response = await fetch('/.netlify/functions/api/dashboard', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            console.log('Response status:', response.status);

            if (response.status === 401) {
                console.log('Unauthorized - redirecting to login');
                window.location.href = '/login';
                return;
            }

            if (!response.ok) {
                const errorText = await response.text();
                console.error('API error:', response.status, errorText);
                return;
            }

            const data = await response.json();
            console.log('Dashboard data received:', data);
            
            if (data) {
                const requests = data.requests || [];
                // Check if CURRENT USER has any requests (not all users)
                const hasRequests = requests.some(r => {
                    // Check both user_id field and nested users object
                    return (r.user_id === user.id) || (r.users && r.users.id === user.id);
                });
                
                // Update welcome message based on whether current user has requests
                updateWelcomeMessage(hasRequests);
                
                // Show onboarding for new users
                if (!hasRequests) {
                    showOnboardingMessage();
                }
                
                // Update statistics - handle both direct stats and calculated stats
                if (data.stats) {
                    updateStatistics(data.stats);
                } else if (requests && Array.isArray(requests)) {
                    // Calculate stats from requests if stats not provided
                    const stats = {
                        total: requests.length,
                        pending: requests.filter(r => (r.status || '').toLowerCase() === 'pending').length,
                        active: requests.filter(r => {
                            const status = (r.status || '').toLowerCase();
                            return status === 'active' || status === 'in-progress';
                        }).length,
                        completed: requests.filter(r => (r.status || '').toLowerCase() === 'completed').length
                    };
                    updateStatistics(stats);
                } else {
                    // No data available
                    updateStatistics({ total: 0, pending: 0, active: 0, completed: 0 });
                }
                
                updateRecentActivity(requests);
            } else {
                console.warn('No data in response');
                updateStatistics({ total: 0, pending: 0, active: 0, completed: 0 });
                updateRecentActivity([]);
                // New user - show onboarding
                updateWelcomeMessage(false);
                showOnboardingMessage();
            }
        } catch (error) {
            console.error('Error loading dashboard:', error);
            // Show user-friendly error
            const activityList = document.querySelector('.activity-list');
            if (activityList) {
                activityList.innerHTML = '<div class="activity-item"><div class="activity-content"><div class="activity-text" style="color: #E7000B;">Error loading data. Please refresh the page.</div></div></div>';
            }
        }
    }

    // Update statistics cards
    function updateStatistics(stats) {
        const activeEl = document.getElementById('stat-active');
        const completedEl = document.getElementById('stat-completed');
        const pendingEl = document.getElementById('stat-pending');

        if (activeEl) activeEl.textContent = stats?.active || 0;
        if (completedEl) completedEl.textContent = stats?.completed || 0;
        if (pendingEl) pendingEl.textContent = stats?.pending || 0;
    }

    // Update recent activity
    function updateRecentActivity(requests) {
        const activityList = document.querySelector('.activity-list');
        if (!activityList) return;

        // Sort by created_at (most recent first) and take first 3
        const recentRequests = requests
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            .slice(0, 3);

        if (recentRequests.length === 0) {
            activityList.innerHTML = `
                <div class="activity-item">
                    <div class="activity-avatar blue">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <rect x="3.33" y="1.67" width="13.33" height="16.67" stroke="#155DFC" stroke-width="1.67"/>
                            <circle cx="11.67" cy="1.67" r="2.5" fill="#155DFC"/>
                        </svg>
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">No Recent Activity</h4>
                        <p class="activity-description">Submit your first request to get started</p>
                    </div>
                </div>
            `;
            return;
        }

        // Store data for auto-refresh
        window.lastActivityData = requests;
        
        activityList.innerHTML = recentRequests.map(req => {
            const timeAgo = getTimeAgo(req.created_at);
            const statusColor = getStatusColor(req.status);
            const statusIcon = getStatusIcon(req.status);
            const categoryName = getCategoryDisplayName(req.category);
            
            return `
                <div class="activity-item">
                    <div class="activity-avatar ${statusColor}">
                        ${statusIcon}
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">${getActivityTitle(req.status, categoryName)}</h4>
                        <p class="activity-description">${req.title || categoryName}</p>
                        <div class="activity-meta">
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 6C7.1 6 8 5.1 8 4C8 2.9 7.1 2 6 2C4.9 2 4 2.9 4 4C4 5.1 4.9 6 6 6ZM6 8C4.67 8 2 8.67 2 10V12H10V10C10 8.67 7.33 8 6 8Z" fill="#717182"/>
                                </svg>
                                <span>${req.location || 'Location not specified'}</span>
                            </div>
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 2C3.24 2 1 4.24 1 7C1 9.76 3.24 12 6 12C8.76 12 11 9.76 11 7C11 4.24 8.76 2 6 2ZM6 11C3.79 11 2 9.21 2 7C2 4.79 3.79 3 6 3C8.21 3 10 4.79 10 7C10 9.21 8.21 11 6 11Z" fill="#717182"/>
                                    <path d="M6.5 4V7.25L8.5 8.5L8 9.5L5.5 7.5V4H6.5Z" fill="#717182"/>
                                </svg>
                                <span>${timeAgo}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Helper functions
    function getTimeAgo(dateString) {
        // Ensure proper date parsing - handle both Date objects and strings
        let date;
        if (dateString instanceof Date) {
            date = dateString;
        } else if (typeof dateString === 'string') {
            // Supabase returns UTC timestamps - ensure we parse them correctly
            // If the string doesn't have timezone info (Z, +, or -), append 'Z' to indicate UTC
            let utcString = dateString;
            if (dateString.includes('T')) {
                // Check if it already has timezone info
                const hasTimezone = dateString.endsWith('Z') || 
                                   dateString.match(/[+-]\d{2}:\d{2}$/) ||
                                   dateString.match(/[+-]\d{4}$/);
                
                if (!hasTimezone) {
                    // No timezone specified - Supabase timestamps are in UTC, so append 'Z'
                    utcString = dateString + 'Z';
                }
            }
            date = new Date(utcString);
            
            // If the date is invalid, return 'Just now'
            if (isNaN(date.getTime())) {
                console.error('Invalid date:', dateString, 'Parsed as:', utcString);
                return 'Just now';
            }
        } else {
            return 'Just now';
        }
        
        const now = new Date();
        const diffMs = now.getTime() - date.getTime();
        
        // Handle negative differences (future dates) - should show "Just now"
        if (diffMs < 0) {
            return 'Just now';
        }
        
        const diffSecs = Math.floor(diffMs / 1000);
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);

        // Show exact seconds for very recent (less than 1 minute)
        if (diffSecs < 60) {
            return diffSecs <= 0 ? 'Just now' : `${diffSecs} ${diffSecs === 1 ? 'second' : 'seconds'} ago`;
        }
        
        // Show exact minutes (less than 1 hour)
        if (diffMins < 60) {
            return `${diffMins} ${diffMins === 1 ? 'minute' : 'minutes'} ago`;
        }
        
        // Show exact hours (less than 24 hours)
        if (diffHours < 24) {
            return `${diffHours} ${diffHours === 1 ? 'hour' : 'hours'} ago`;
        }
        
        // Show exact days (less than 7 days)
        if (diffDays < 7) {
            return `${diffDays} ${diffDays === 1 ? 'day' : 'days'} ago`;
        }
        
        // For older dates, show the actual date
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getStatusColor(status) {
        switch(status?.toLowerCase()) {
            case 'pending': return 'orange';
            case 'active':
            case 'in-progress': return 'blue';
            case 'completed': return 'green';
            default: return 'orange';
        }
    }

    function getStatusIcon(status) {
        const statusLower = (status || '').toLowerCase();
        if (statusLower === 'completed') {
            return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="1.67" y="1.67" width="16.67" height="16.67" stroke="#00A63E" stroke-width="1.67"/><path d="M7.5 8.33L9.17 10L12.5 6.67" stroke="#00A63E" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        } else if (statusLower === 'active' || statusLower === 'in-progress') {
            return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 5L10 1.67L10 5" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/><path d="M10 5L10 16.67L10 5" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/></svg>';
        } else {
            return '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1.65 2.49L16.68 15.01" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/><path d="M10 7.5L10 0L10 7.5" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/><path d="M10 14.17L10 10L10 14.17" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/></svg>';
        }
    }

    function getCategoryDisplayName(category) {
        if (!category) return 'General Request';
        const categoryMap = {
            'broken-streetlights': 'Broken Streetlights',
            'potholes': 'Potholes',
            'clogged-drainage': 'Clogged Drainage',
            'damaged-sidewalks': 'Damaged Sidewalks',
            'other': 'Other'
        };
        return categoryMap[category.toLowerCase()] || category.charAt(0).toUpperCase() + category.slice(1);
    }

    function getActivityTitle(status, categoryName) {
        const statusLower = (status || '').toLowerCase();
        switch(statusLower) {
            case 'pending': return `${categoryName} Request Submitted`;
            case 'active':
            case 'in-progress': return `${categoryName} Under Review`;
            case 'completed': return `${categoryName} Resolved`;
            default: return `${categoryName} Request`;
        }
    }

    // Make quick action cards functional
    function setupQuickActions() {
        const actionCards = document.querySelectorAll('.action-card');
        
        actionCards.forEach((card, index) => {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function() {
                switch(index) {
                    case 0: // Submit New Request
                        window.location.href = '/submit-request';
                        break;
                    case 1: // View My Requests
                        window.location.href = '/my-requests';
                        break;
                    case 2: // Dashboard
                        window.location.href = '/dashboard';
                        break;
                }
            });
            
            // Add hover effect
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'transform 0.2s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // Make "View All" button for recent activity functional
    const viewAllButton = document.querySelector('.view-all-button');
    if (viewAllButton && !viewAllButton.id) {
        viewAllButton.addEventListener('click', function() {
            window.location.href = '/my-requests';
        });
    }

    // Make "View All" button for announcements functional
    const announcementsViewAll = document.getElementById('announcements-view-all');
    if (announcementsViewAll) {
        announcementsViewAll.addEventListener('click', function() {
            const announcementsList = document.getElementById('announcements-list');
            if (announcementsList) {
                if (announcementsList.style.maxHeight === 'none') {
                    // Collapse back
                    announcementsList.style.maxHeight = '400px';
                    this.querySelector('span').textContent = 'View All';
                } else {
                    // Expand to show all
                    announcementsList.style.maxHeight = 'none';
                    this.querySelector('span').textContent = 'Show Less';
                }
            }
        });
    }

    // Load announcements
    async function loadAnnouncements() {
        try {
            const response = await fetch('/.netlify/functions/api/announcements', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                console.error('Failed to load announcements');
                return;
            }

            const data = await response.json();
            updateAnnouncements(data.announcements || []);
        } catch (error) {
            console.error('Error loading announcements:', error);
        }
    }

    // Update announcements display
    function updateAnnouncements(announcements) {
        const announcementsList = document.getElementById('announcements-list');
        if (!announcementsList) return;

        if (announcements.length === 0) {
            announcementsList.innerHTML = `
                <div class="announcement-item blue">
                    <h4 class="announcement-title">No Recent Activity</h4>
                    <p class="announcement-description">Your activity and updates will appear here</p>
                </div>
            `;
            return;
        }

        // Store announcements in a global variable for modal access and auto-refresh
        window.announcementsData = announcements;
        
        announcementsList.innerHTML = announcements.map((announcement, index) => {
            const timeAgo = getTimeAgo(announcement.created_at);
            const colorClass = announcement.type === 'user_request' ? 'blue' : 
                             announcement.status === 'completed' ? 'green' : 
                             announcement.status === 'active' ? 'purple' : 'orange';
            
            // Keep description short (max 60 chars)
            const shortDescription = announcement.description.length > 60 
                ? announcement.description.substring(0, 60) + '...' 
                : announcement.description;
            
            // Get first image for thumbnail (if available)
            const mediaFiles = announcement.media_files || [];
            const firstImage = mediaFiles.find(m => m.type === 'image');
            const hasMedia = mediaFiles.length > 0;
            
            return `
                <div class="announcement-item ${colorClass}" data-announcement-index="${index}">
                    ${firstImage ? `
                    <div class="announcement-thumbnail">
                        <img src="${escapeHtml(firstImage.url)}" alt="Request image" loading="lazy">
                    </div>
                    ` : ''}
                    <div class="announcement-content">
                        <h4 class="announcement-title">${escapeHtml(announcement.title)}</h4>
                        <p class="announcement-description">${escapeHtml(shortDescription)}</p>
                        ${hasMedia ? `
                        <div class="announcement-media-badge">
                            <svg class="media-icon" viewBox="0 0 16 16" fill="none">
                                <rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.33"/>
                                ${mediaFiles.filter(m => m.type === 'image').length > 0 ? `
                                <path d="M5 5.5C5.28 5.5 5.5 5.72 5.5 6C5.5 6.28 5.28 6.5 5 6.5C4.72 6.5 4.5 6.28 4.5 6C4.5 5.72 4.72 5.5 5 5.5Z" fill="currentColor"/>
                                <path d="M11 9L8 6L5 9" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                                ` : ''}
                                ${mediaFiles.filter(m => m.type === 'video').length > 0 ? `
                                <path d="M6 5L10 8L6 11V5Z" fill="currentColor"/>
                                ` : ''}
                            </svg>
                            <span>${mediaFiles.filter(m => m.type === 'image').length} image${mediaFiles.filter(m => m.type === 'image').length !== 1 ? 's' : ''}, ${mediaFiles.filter(m => m.type === 'video').length} video${mediaFiles.filter(m => m.type === 'video').length !== 1 ? 's' : ''}</span>
                        </div>
                        ` : ''}
                        <div class="announcement-meta">
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 2C3.24 2 1 4.24 1 7C1 9.76 3.24 12 6 12C8.76 12 11 9.76 11 7C11 4.24 8.76 2 6 2ZM6 11C3.79 11 2 9.21 2 7C2 4.79 3.79 3 6 3C8.21 3 10 4.79 10 7C10 9.21 8.21 11 6 11Z" fill="#717182"/>
                                    <path d="M6.5 4V7.25L8.5 8.5L8 9.5L5.5 7.5V4H6.5Z" fill="#717182"/>
                                </svg>
                                <span>${timeAgo}</span>
                            </div>
                            ${announcement.location ? `
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 6C7.1 6 8 5.1 8 4C8 2.9 7.1 2 6 2C4.9 2 4 2.9 4 4C4 5.1 4.9 6 6 6ZM6 8C4.67 8 2 8.67 2 10V12H10V10C10 8.67 7.33 8 6 8Z" fill="#717182"/>
                                </svg>
                                <span>${escapeHtml(announcement.location)}</span>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        }).join('');
        
        // Add click event listeners to announcement items
        announcementsList.querySelectorAll('.announcement-item').forEach((item, index) => {
            item.addEventListener('click', function() {
                openAnnouncementModal(window.announcementsData[index]);
            });
        });
    }

    // Open announcement modal
    window.openAnnouncementModal = function(announcement) {
        const modal = document.getElementById('announcement-modal');
        if (!modal || !announcement) return;

        // Set modal content
        document.getElementById('modal-title').textContent = announcement.title;
        document.getElementById('modal-description').textContent = announcement.description || 'No description available';
        
        // Format date and time
        const date = new Date(announcement.created_at);
        const formattedDate = date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        const formattedTime = date.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
        document.getElementById('modal-time').textContent = `${formattedDate} at ${formattedTime}`;

        // Set badge
        const badge = document.getElementById('modal-badge');
        if (announcement.type === 'user_request') {
            badge.textContent = 'Your Request';
            badge.className = 'modal-badge blue';
        } else {
            badge.textContent = announcement.actor || 'System Update';
            badge.className = 'modal-badge purple';
        }

        // Set details
        const details = document.getElementById('modal-details');
        let detailsHtml = '';
        
        if (announcement.location) {
            detailsHtml += `
                <div class="modal-detail-item">
                    <strong>Location:</strong> ${escapeHtml(announcement.location)}
                </div>
            `;
        }
        
        if (announcement.category) {
            detailsHtml += `
                <div class="modal-detail-item">
                    <strong>Category:</strong> ${escapeHtml(getCategoryDisplayName(announcement.category))}
                </div>
            `;
        }
        
        if (announcement.status) {
            detailsHtml += `
                <div class="modal-detail-item">
                    <strong>Status:</strong> <span class="status-badge ${announcement.status}">${escapeHtml(announcement.status)}</span>
                </div>
            `;
        }
        
        if (announcement.action_type) {
            detailsHtml += `
                <div class="modal-detail-item">
                    <strong>Action:</strong> ${escapeHtml(announcement.action_type.replace(/_/g, ' '))}
                </div>
            `;
        }
        
        if (announcement.old_value && announcement.new_value) {
            detailsHtml += `
                <div class="modal-detail-item">
                    <strong>Changed:</strong> ${escapeHtml(announcement.old_value)} → ${escapeHtml(announcement.new_value)}
                </div>
            `;
        }
        
        if (announcement.department) {
            detailsHtml += `
                <div class="modal-detail-item">
                    <strong>Department:</strong> ${escapeHtml(announcement.department)}
                </div>
            `;
        }

        details.innerHTML = detailsHtml || '<p>No additional details available</p>';
        
        // Display media files in modal
        const mediaContainer = document.getElementById('modal-media');
        if (mediaContainer) {
            const mediaFiles = announcement.media_files || [];
            if (mediaFiles.length > 0) {
                let mediaHtml = '<h3 class="modal-section-title">Media Files</h3><div class="modal-media-grid">';
                
                mediaFiles.forEach((media, index) => {
                    if (media.type === 'image') {
                        mediaHtml += `
                            <div class="modal-media-item">
                                <img src="${escapeHtml(media.url)}" alt="${escapeHtml(media.filename || 'Image')}" class="modal-media-image" onclick="window.open('${escapeHtml(media.url)}', '_blank')" style="cursor: pointer;">
                            </div>
                        `;
                    } else if (media.type === 'video') {
                        mediaHtml += `
                            <div class="modal-media-item">
                                <video controls class="modal-media-video">
                                    <source src="${escapeHtml(media.url)}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        `;
                    }
                });
                
                mediaHtml += '</div>';
                mediaContainer.innerHTML = mediaHtml;
                mediaContainer.style.display = 'block';
            } else {
                mediaContainer.innerHTML = '';
                mediaContainer.style.display = 'none';
            }
        }

        // Show modal
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    // Close announcement modal
    window.closeAnnouncementModal = function() {
        const modal = document.getElementById('announcement-modal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    };

    // Escape HTML helper
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Logout handler
    const logoutBtn = document.querySelector('.logout-button');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            window.location.href = '/login';
        });
    }

    // Initialize
    setupQuickActions();
    loadDashboardData();
    loadAnnouncements();

    // Auto-refresh when page becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            console.log('Page visible - refreshing data');
            loadDashboardData();
            loadAnnouncements();
        }
    });

    // Also refresh when window gains focus
    window.addEventListener('focus', function() {
        console.log('Window focused - refreshing data');
        loadDashboardData();
        loadAnnouncements();
    });

    // Auto-refresh every 30 seconds when page is active
    setInterval(function() {
        if (!document.hidden) {
            console.log('Auto-refreshing data');
            loadDashboardData();
            loadAnnouncements();
        }
    }, 30000);
});

