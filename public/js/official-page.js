// Official Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('auth_token');
    const userData = localStorage.getItem('user_data');
    
    // Check authentication
    if (!token || !userData) {
        window.location.href = '/login/official';
        return;
    }

    const user = JSON.parse(userData);
    if (!user.isOfficial) {
        window.location.href = '/login/official';
        return;
    }
    
    // Extract first name from user name
    function getFirstName(fullName) {
        if (!fullName) return 'Official';
        const nameParts = fullName.trim().split(' ');
        return nameParts[0] || 'Official';
    }

    // Update welcome message and user name
    function updateWelcomeMessage(hasActivity) {
        const welcomeBadge = document.querySelector('.welcome-badge');
        const officialBadge = document.querySelectorAll('.welcome-badge')[1];
        
        if (welcomeBadge) {
            welcomeBadge.textContent = hasActivity ? 'Welcome Back' : 'Welcome';
        }
        
        if (officialBadge && user) {
            const firstName = getFirstName(user.name);
            officialBadge.textContent = firstName;
        }
    }

    // Show onboarding message for new officials
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
            console.log('Loading official page data...');
            const response = await fetch('/.netlify/functions/api/requests', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            console.log('Response status:', response.status);

            if (response.status === 401) {
                console.log('Unauthorized - redirecting to login');
                window.location.href = '/login/official';
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
                const hasActivity = requests.length > 0;
                
                // Update welcome message based on whether there's activity
                updateWelcomeMessage(hasActivity);
                
                // Show onboarding for new officials
                if (!hasActivity) {
                    showOnboardingMessage();
                }
                
                // Calculate statistics from requests
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
                
                updateRecentActivity(requests);
            } else {
                console.warn('No data in response');
                updateStatistics({ total: 0, pending: 0, active: 0, completed: 0 });
                updateRecentActivity([]);
                // New official - show onboarding
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

        // Store data for auto-refresh
        window.lastActivityData = requests;

        // Helper function to parse date with UTC handling
        function parseDate(dateString) {
            if (typeof dateString === 'string' && dateString.includes('T')) {
                const hasTimezone = dateString.endsWith('Z') || 
                                   dateString.match(/[+-]\d{2}:\d{2}$/) ||
                                   dateString.match(/[+-]\d{4}$/);
                if (!hasTimezone) {
                    dateString = dateString + 'Z';
                }
            }
            return new Date(dateString);
        }

        // Sort by created_at (most recent first) and take first 3
        const recentRequests = requests
            .sort((a, b) => parseDate(b.created_at) - parseDate(a.created_at))
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
                        <p class="activity-description">No requests have been submitted yet</p>
                    </div>
                </div>
            `;
            return;
        }

        activityList.innerHTML = recentRequests.map(req => {
            const timeAgo = getTimeAgo(req.created_at);
            const statusColor = getStatusColor(req.status);
            const statusIcon = getStatusIcon(req.status);
            const categoryName = getCategoryDisplayName(req.category);
            const userName = req.user_name || 'Unknown User';
            
            return `
                <div class="activity-item">
                    <div class="activity-avatar ${statusColor}">
                        ${statusIcon}
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">${getActivityTitle(req.status, categoryName)}</h4>
                        <p class="activity-description">${escapeHtml(req.title || categoryName)} - ${escapeHtml(userName)}</p>
                        <div class="activity-meta">
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 6C7.1 6 8 5.1 8 4C8 2.9 7.1 2 6 2C4.9 2 4 2.9 4 4C4 5.1 4.9 6 6 6ZM6 8C4.67 8 2 8.67 2 10V12H10V10C10 8.67 7.33 8 6 8Z" fill="#717182"/>
                                </svg>
                                <span>${escapeHtml(req.location || 'Location not specified')}</span>
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

    // Load announcements (for officials - show recent requests)
    async function loadAnnouncements() {
        try {
            // For officials, we'll show recent requests as announcements
            const response = await fetch('/.netlify/functions/api/requests', {
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
            const requests = data.requests || [];
            
            // Format as announcements
            const announcements = requests.slice(0, 10).map(req => ({
                id: `request-${req.id}`,
                type: 'request',
                title: req.title || `${getCategoryDisplayName(req.category)} Request`,
                description: req.description || '',
                category: req.category,
                status: req.status,
                location: req.location,
                created_at: req.created_at,
                actor: req.user_name || 'Resident'
            }));
            
            updateAnnouncements(announcements);
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
                    <h4 class="announcement-title">No Recent Requests</h4>
                    <p class="announcement-description">New requests will appear here</p>
                </div>
            `;
            return;
        }

        // Store announcements in a global variable for modal access and auto-refresh
        window.announcementsData = announcements;
        
        announcementsList.innerHTML = announcements.slice(0, 5).map((announcement, index) => {
            const timeAgo = getTimeAgo(announcement.created_at);
            const colorClass = announcement.status === 'completed' ? 'green' : 
                             announcement.status === 'active' ? 'purple' : 'orange';
            
            // Keep description short (max 60 chars)
            const shortDescription = announcement.description.length > 60 
                ? announcement.description.substring(0, 60) + '...' 
                : announcement.description;
            
            return `
                <div class="announcement-item ${colorClass}" data-announcement-index="${index}">
                    <h4 class="announcement-title">${escapeHtml(announcement.title)}</h4>
                    <p class="announcement-description">${escapeHtml(shortDescription || 'No description')}</p>
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
            `;
        }).join('');
        
        // Add click event listeners to announcement items
        announcementsList.querySelectorAll('.announcement-item').forEach((item, index) => {
            item.addEventListener('click', function() {
                openAnnouncementModal(window.announcementsData[index]);
            });
        });
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

    // Open announcement modal
    window.openAnnouncementModal = function(announcement) {
        const modal = document.getElementById('announcement-modal');
        if (!modal || !announcement) return;

        // Set modal content
        document.getElementById('modal-title').textContent = announcement.title;
        document.getElementById('modal-description').textContent = announcement.description || 'No description available';
        
        // Format date and time with UTC handling
        let dateString = announcement.created_at;
        if (typeof dateString === 'string' && dateString.includes('T')) {
            const hasTimezone = dateString.endsWith('Z') || 
                               dateString.match(/[+-]\d{2}:\d{2}$/) ||
                               dateString.match(/[+-]\d{4}$/);
            if (!hasTimezone) {
                dateString = dateString + 'Z';
            }
        }
        const date = new Date(dateString);
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
        badge.textContent = announcement.actor || 'Resident';
        badge.className = 'modal-badge blue';

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

        details.innerHTML = detailsHtml || '<p>No additional details available</p>';

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

    // Make quick action cards functional
    function setupQuickActions() {
        const actionCards = document.querySelectorAll('.action-card');
        
        actionCards.forEach((card, index) => {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function() {
                switch(index) {
                    case 0: // View Dashboard
                        window.location.href = '/dashboard/official';
                        break;
                    case 1: // Manage Requests
                        window.location.href = '/all-requests/official';
                        break;
                    case 2: // Generate Reports
                        window.location.href = '/reports';
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

    // Make "View All" button functional
    const viewAllButton = document.querySelector('.view-all-button');
    if (viewAllButton) {
        viewAllButton.addEventListener('click', function() {
            window.location.href = '/all-requests/official';
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

    // Logout handler
    const logoutBtn = document.querySelector('.logout-button');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            window.location.href = '/login/official';
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

    // Auto-update time displays every minute for real-time updates
    setInterval(function() {
        if (!document.hidden) {
            // Re-render recent activity with updated times
            const activityList = document.querySelector('.activity-list');
            if (activityList && window.lastActivityData) {
                updateRecentActivity(window.lastActivityData);
            }
            
            // Re-render announcements with updated times
            const announcementsList = document.getElementById('announcements-list');
            if (announcementsList && window.announcementsData) {
                updateAnnouncements(window.announcementsData);
            }
        }
    }, 60000); // Update every 60 seconds
});

