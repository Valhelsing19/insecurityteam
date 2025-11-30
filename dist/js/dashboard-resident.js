// Resident Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('auth_token');
    
    // Check authentication
    if (!token) {
        window.location.href = '/login';
        return;
    }

    // Chart instances
    let issuesChart = null;
    let trendChart = null;

    // Load dashboard data
    async function loadDashboardData() {
        try {
            console.log('Loading dashboard data...');
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
                // Still try to parse as JSON in case it's an error response
                try {
                    const errorData = JSON.parse(errorText);
                    console.error('Error details:', errorData);
                } catch (e) {
                    console.error('Could not parse error response');
                }
                return;
            }

            const data = await response.json();
            console.log('Dashboard data received:', data);
            console.log('Stats:', data.stats);
            console.log('Requests count:', data.requests?.length || 0);
            
            if (data) {
                
                // Update statistics - handle both direct stats and calculated stats
                if (data.stats) {
                    // Use provided stats
                    updateStatistics(data.stats);
                } else if (data.requests && Array.isArray(data.requests)) {
                    // Calculate stats from requests if stats not provided
                    const stats = {
                        total: data.requests.length,
                        pending: data.requests.filter(r => (r.status || '').toLowerCase() === 'pending').length,
                        active: data.requests.filter(r => {
                            const status = (r.status || '').toLowerCase();
                            return status === 'active' || status === 'in-progress';
                        }).length,
                        completed: data.requests.filter(r => (r.status || '').toLowerCase() === 'completed').length
                    };
                    updateStatistics(stats);
                } else {
                    // No data available
                    updateStatistics({ total: 0, pending: 0, active: 0, completed: 0 });
                }
                
                updateCharts(data.requests || []);
                updateRecentActivity(data.requests || []);
            } else {
                console.warn('No data in response');
                updateStatistics({ total: 0, pending: 0, active: 0, completed: 0 });
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
    function updateStatistics(stats) {
        const totalEl = document.getElementById('totalRequests');
        const pendingEl = document.getElementById('pendingRequests');
        const inProgressEl = document.getElementById('inProgressRequests');
        const completedEl = document.getElementById('completedRequests');

        if (totalEl) totalEl.textContent = stats?.total || 0;
        if (pendingEl) pendingEl.textContent = stats?.pending || 0;
        if (inProgressEl) inProgressEl.textContent = stats?.active || 0;
        if (completedEl) completedEl.textContent = stats?.completed || 0;
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
                const reqDate = new Date(req.created_at);
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

        // Get user data
        const userData = localStorage.getItem('user_data');
        const user = userData ? JSON.parse(userData) : null;
        const userName = user?.name || 'You';

        // Sort by created_at (most recent first) and take first 5
        const recentRequests = requests
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
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
            pending: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#E17100"/></svg>',
            active: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#155DFC"/></svg>',
            'in-progress': '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#155DFC"/></svg>',
            completed: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#00A63E"/></svg>'
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
            window.location.href = '/login';
        });
    }

    // Load data on page load
    loadDashboardData();

    // Refresh data when page becomes visible (user returns from submitting request)
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
});
