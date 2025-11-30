// Official Dashboard JavaScript
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

    // Chart instances
    let issuesChart = null;
    let trendChart = null;

    // Load dashboard data
    async function loadDashboardData() {
        try {
            console.log('Loading official dashboard data...');
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
            
            if (response.ok && data) {
                const requests = data.requests || [];
                console.log('Found', requests.length, 'requests');
                
                if (requests.length > 0 || data.requests !== undefined) {
                    // updateStatistics expects an array of requests, which is correct
                    updateStatistics(requests);
                    updateCharts(requests);
                    updateRecentActivity(requests);
                } else {
                    console.warn('No requests in response');
                    updateStatistics([]);
                    updateCharts([]);
                    updateRecentActivity([]);
                }
            } else {
                console.warn('API response not OK or invalid data structure');
                console.log('Response data:', data);
                updateStatistics([]);
                updateCharts([]);
                updateRecentActivity([]);
            }
        } catch (error) {
            console.error('Error loading dashboard:', error);
            console.error('Error details:', error.message, error.stack);
            // Show user-friendly error
            const activityList = document.getElementById('recentActivityList');
            if (activityList) {
                activityList.innerHTML = '<div class="activity-item"><div class="activity-content"><div class="activity-text" style="color: #E7000B;">Error loading data. Please check if the server is running.</div></div></div>';
            }
        }
    }

    // Update statistics cards
    function updateStatistics(requests) {
        const total = requests.length;
        const pending = requests.filter(r => r.status === 'pending').length;
        const inProgress = requests.filter(r => r.status === 'active' || r.status === 'in-progress').length;
        const completed = requests.filter(r => r.status === 'completed').length;

        const totalEl = document.getElementById('totalRequests');
        const pendingEl = document.getElementById('pendingRequests');
        const inProgressEl = document.getElementById('inProgressRequests');
        const completedEl = document.getElementById('completedRequests');

        if (totalEl) totalEl.textContent = total;
        if (pendingEl) pendingEl.textContent = pending;
        if (inProgressEl) inProgressEl.textContent = inProgress;
        if (completedEl) completedEl.textContent = completed;
    }

    // Update charts with real data
    function updateCharts(requests) {
        // Calculate issues by type
        const categoryCounts = {
            'broken-streetlights': 0,
            'potholes': 0,
            'clogged-drainage': 0,
            'damaged-sidewalks': 0,
            other: 0
        };

        requests.forEach(req => {
            const category = (req.category || 'other').toLowerCase();
            // Handle both old and new category names
            let normalizedCategory = category;
            if (category === 'plumbing' || category === 'heating' || category === 'lighting') {
                normalizedCategory = 'other';
            } else if (category === 'electrical' && (req.description || '').toLowerCase().includes('streetlight')) {
                normalizedCategory = 'broken-streetlights';
            }
            
            if (categoryCounts.hasOwnProperty(normalizedCategory)) {
                categoryCounts[normalizedCategory]++;
            } else {
                categoryCounts.other++;
            }
        });

        // Calculate trend over time (last 6 months)
        const now = new Date();
        const months = [];
        const monthData = [0, 0, 0, 0, 0, 0];
        
        for (let i = 5; i >= 0; i--) {
            const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
            months.push(date.toLocaleDateString('en-US', { month: 'short' }));
        }

        requests.forEach(req => {
            if (req.created_at) {
                // Parse date with UTC handling
                let dateString = req.created_at;
                if (typeof dateString === 'string' && dateString.includes('T')) {
                    const hasTimezone = dateString.endsWith('Z') || 
                                       dateString.match(/[+-]\d{2}:\d{2}$/) ||
                                       dateString.match(/[+-]\d{4}$/);
                    if (!hasTimezone) {
                        dateString = dateString + 'Z';
                    }
                }
                const reqDate = new Date(dateString);
                const monthsAgo = (now.getMonth() - reqDate.getMonth()) + (now.getFullYear() - reqDate.getFullYear()) * 12;
                if (monthsAgo >= 0 && monthsAgo < 6) {
                    monthData[monthsAgo]++;
                }
            }
        });

        // Update Issues by Type Chart
        const issuesCtx = document.getElementById('issuesChart');
        if (issuesCtx) {
            if (issuesChart) {
                issuesChart.destroy();
            }
            
            issuesChart = new Chart(issuesCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Broken Streetlights', 'Potholes', 'Clogged Drainage', 'Damaged Sidewalks', 'Other'],
                    datasets: [{
                        label: 'Issues',
                        data: [
                            categoryCounts['broken-streetlights'],
                            categoryCounts['potholes'],
                            categoryCounts['clogged-drainage'],
                            categoryCounts['damaged-sidewalks'],
                            categoryCounts.other
                        ],
                        backgroundColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(99, 102, 241, 1)',
                            'rgba(99, 102, 241, 1)',
                            'rgba(99, 102, 241, 1)',
                            'rgba(99, 102, 241, 1)'
                        ],
                        borderRadius: 0,
                        barThickness: 86
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
                                stepSize: 1,
                                font: {
                                    family: 'Inter',
                                    size: 12
                                },
                                color: '#666666'
                            },
                            grid: {
                                color: '#E5E7EB',
                                borderDash: [3, 3]
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 12
                                },
                                color: '#666666'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Update Trend Over Time Chart
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            if (trendChart) {
                trendChart.destroy();
            }
            
            const maxValue = Math.max(...monthData, 1);
            trendChart = new Chart(trendCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Requests',
                        data: monthData,
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2
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
                            max: Math.ceil(maxValue * 1.2) || 10,
                            ticks: {
                                stepSize: Math.max(1, Math.ceil(maxValue / 4)),
                                font: {
                                    family: 'Inter',
                                    size: 12
                                },
                                color: '#666666'
                            },
                            grid: {
                                color: '#E5E7EB',
                                borderDash: [3, 3]
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 12
                                },
                                color: '#666666'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    }

    // Update recent activity
    function updateRecentActivity(requests) {
        const activityList = document.getElementById('recentActivityList');
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

        // Sort by created_at (most recent first) and take first 5
        const recentRequests = requests
            .sort((a, b) => parseDate(b.created_at) - parseDate(a.created_at))
            .slice(0, 5);

        if (recentRequests.length === 0) {
            activityList.innerHTML = '<div class="activity-item"><div class="activity-content"><div class="activity-text">No recent activity</div></div></div>';
            return;
        }

        activityList.innerHTML = recentRequests.map(req => {
            const timeAgo = getTimeAgo(req.created_at);
            const statusColor = getStatusColor(req.status);
            const statusIcon = getStatusIcon(req.status);
            const category = req.category || 'request';
            const userName = req.user_name || 'Resident';
            
            return `
                <div class="activity-item">
                    <div class="activity-avatar ${statusColor}">
                        ${statusIcon}
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>${userName}</strong> ${getActivityText(req.status, category)}
                        </div>
                        <div class="activity-time">${timeAgo}</div>
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
        switch(status) {
            case 'pending': return 'orange';
            case 'active':
            case 'in-progress': return 'blue';
            case 'completed': return 'green';
            default: return 'orange';
        }
    }

    function getStatusIcon(status) {
        const icons = {
            pending: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1.67 12.5L11.67 5L13.33 2.61L15.83 12.61L4.17 2.5" stroke="#E17100" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.33 2.61L15.83 12.61" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/><path d="M4.17 2.5L1.67 12.5" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/><path d="M13.33 2.61L11.67 5" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/></svg>',
            active: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 5L10 1.67L10 5" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/><path d="M10 5L10 16.67L10 5" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/></svg>',
            completed: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="1.67" y="1.67" width="16.67" height="16.67" stroke="#00A63E" stroke-width="1.67"/><path d="M7.5 8.33L9.17 10L12.5 6.67" stroke="#00A63E" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/></svg>'
        };
        return icons[status] || icons.pending;
    }

    function getActivityText(status, category) {
        const categoryName = category.charAt(0).toUpperCase() + category.slice(1);
        switch(status) {
            case 'pending': return `submitted a ${categoryName} request`;
            case 'active':
            case 'in-progress': return `${categoryName} request marked as in progress`;
            case 'completed': return `${categoryName} issue resolved`;
            default: return `submitted a ${categoryName} request`;
        }
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

    // Load data on page load
    loadDashboardData();

    // Refresh data when page becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            console.log('Page visible - refreshing dashboard data');
            loadDashboardData();
        }
    });

    // Also refresh when window gains focus
    window.addEventListener('focus', function() {
        console.log('Window focused - refreshing dashboard data');
        loadDashboardData();
    });

    // Auto-refresh every 30 seconds when page is active
    setInterval(function() {
        if (!document.hidden) {
            console.log('Auto-refreshing dashboard data');
            loadDashboardData();
        }
    }, 30000);

    // Auto-update time displays every minute for real-time updates
    setInterval(function() {
        if (!document.hidden) {
            // Re-render recent activity with updated times
            const activityList = document.getElementById('recentActivityList');
            if (activityList && window.lastActivityData) {
                updateRecentActivity(window.lastActivityData);
            }
        }
    }, 60000); // Update every 60 seconds
});
