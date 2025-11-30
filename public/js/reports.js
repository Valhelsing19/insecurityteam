// Activity Log / Reports JavaScript
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

    // Elements
    const tableBody = document.getElementById('activityTableBody');
    const actionFilter = document.getElementById('actionFilter');
    const searchInput = document.getElementById('searchInput');
    const totalActivities = document.getElementById('totalActivities');
    const statusChanges = document.getElementById('statusChanges');
    const assignments = document.getElementById('assignments');
    const logoutBtn = document.getElementById('logoutBtn');
    const exportBtn = document.getElementById('exportBtn');

    let allActivities = [];
    let filteredActivities = [];

    // Logout handler
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            window.location.href = '/login/official';
        });
    }

    // Export handler
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            exportToCSV();
        });
    }

    // Load activity log
    async function loadActivityLog() {
        try {
            const response = await fetch('/.netlify/functions/api/activity-log', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.status === 401) {
                window.location.href = '/login/official';
                return;
            }

            const data = await response.json();
            
            if (response.ok && data.activities) {
                allActivities = data.activities;
                updateSummary();
                filterAndDisplayActivities();
            } else {
                showError('Failed to load activity log');
            }
        } catch (error) {
            console.error('Error loading activity log:', error);
            showError('An error occurred while loading activity log');
        }
    }

    // Update summary statistics
    function updateSummary() {
        const total = allActivities.length;
        const statusCount = allActivities.filter(a => a.action_type === 'status_changed').length;
        const assignmentCount = allActivities.filter(a => a.action_type === 'assigned' || a.action_type === 'unassigned').length;

        if (totalActivities) totalActivities.textContent = total;
        if (statusChanges) statusChanges.textContent = statusCount;
        if (assignments) assignments.textContent = assignmentCount;
    }

    // Filter and display activities
    function filterAndDisplayActivities() {
        const actionValue = actionFilter ? actionFilter.value.toLowerCase() : '';
        const searchValue = searchInput ? searchInput.value.toLowerCase() : '';

        filteredActivities = allActivities.filter(activity => {
            const matchesAction = !actionValue || activity.action_type === actionValue;
            const matchesSearch = !searchValue || 
                                (activity.official && activity.official.name && activity.official.name.toLowerCase().includes(searchValue)) ||
                                (activity.request_title && activity.request_title.toLowerCase().includes(searchValue)) ||
                                (activity.description && activity.description.toLowerCase().includes(searchValue));

            return matchesAction && matchesSearch;
        });

        displayActivities(filteredActivities);
    }

    // Display activities in table
    function displayActivities(activities) {
        if (!tableBody) return;

        if (activities.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="empty-state">No activities found</td></tr>';
            return;
        }

        tableBody.innerHTML = activities.map(activity => {
            const date = formatDateTime(activity.created_at);
            const officialName = activity.official ? activity.official.name : 'System';
            const requestTitle = activity.request_title || `Request #${activity.request_id}`;
            const actionBadge = getActionBadge(activity.action_type);
            const changeDisplay = getChangeDisplay(activity);
            const description = activity.description || '-';

            return `
                <tr>
                    <td class="date-cell">${date}</td>
                    <td><span class="official-name">${escapeHtml(officialName)}</span></td>
                    <td><a href="#" class="request-link" onclick="viewRequest(${activity.request_id})">${escapeHtml(requestTitle)}</a></td>
                    <td>${actionBadge}</td>
                    <td>${changeDisplay}</td>
                    <td>${escapeHtml(description)}</td>
                </tr>
            `;
        }).join('');
    }

    // Helper functions
    function formatDateTime(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleString('en-US', { 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getActionBadge(actionType) {
        const badges = {
            'status_changed': '<span class="action-badge status">Status Changed</span>',
            'priority_set': '<span class="action-badge priority">Priority Changed</span>',
            'assigned': '<span class="action-badge assigned">Assigned</span>',
            'unassigned': '<span class="action-badge unassigned">Unassigned</span>'
        };
        return badges[actionType] || `<span class="action-badge">${actionType}</span>`;
    }

    function getChangeDisplay(activity) {
        if (activity.old_value && activity.new_value) {
            return `
                <div class="change-value">
                    <span>${escapeHtml(activity.old_value)}</span>
                    <svg class="change-arrow" viewBox="0 0 16 16" fill="none">
                        <path d="M4 8L8 12L12 8" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                    </svg>
                    <span>${escapeHtml(activity.new_value)}</span>
                </div>
            `;
        } else if (activity.new_value) {
            return `<span>${escapeHtml(activity.new_value)}</span>`;
        } else if (activity.old_value) {
            return `<span>${escapeHtml(activity.old_value)}</span>`;
        }
        return '-';
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showError(message) {
        if (tableBody) {
            tableBody.innerHTML = `<tr><td colspan="6" class="empty-state" style="color: var(--red);">${escapeHtml(message)}</td></tr>`;
        }
    }

    // Export to CSV
    function exportToCSV() {
        const headers = ['Date & Time', 'Official', 'Request', 'Action', 'Old Value', 'New Value', 'Description'];
        const rows = filteredActivities.map(activity => [
            formatDateTime(activity.created_at),
            activity.official ? activity.official.name : 'System',
            activity.request_title || `Request #${activity.request_id}`,
            activity.action_type,
            activity.old_value || '',
            activity.new_value || '',
            activity.description || ''
        ]);

        const csvContent = [
            headers.join(','),
            ...rows.map(row => row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(','))
        ].join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `activity_log_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    }

    // View request (placeholder)
    window.viewRequest = function(requestId) {
        window.location.href = `/all-requests/official#request-${requestId}`;
    };

    // Event listeners
    if (actionFilter) {
        actionFilter.addEventListener('change', filterAndDisplayActivities);
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterAndDisplayActivities);
    }

    // Initial load
    loadActivityLog();
});

