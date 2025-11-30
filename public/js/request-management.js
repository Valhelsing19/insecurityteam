// Request Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('auth_token');
    
    // Check authentication
    if (!token) {
        window.location.href = '/login';
        return;
    }

    // Elements
    const statusFilter = document.getElementById('status-filter');
    const priorityFilter = document.getElementById('priority-filter');
    const searchInput = document.getElementById('search-input');
    const tableBody = document.getElementById('requests-table-body');
    const pendingCount = document.getElementById('pendingCount');
    const inProgressCount = document.getElementById('inProgressCount');
    const completedCount = document.getElementById('completedCount');
    const exportBtn = document.querySelector('.export-button');
    const logoutBtn = document.querySelector('.logout-button');

    let allRequests = [];
    let filteredRequests = [];

    // Load user's requests
    async function loadRequests() {
        try {
            console.log('Loading user requests...');
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
                showEmptyState();
                return;
            }

            const data = await response.json();
            console.log('Requests data received:', data);
            
            if (response.ok && data) {
                const requests = data.requests || [];
                console.log('Found', requests.length, 'requests');
                
                if (requests.length > 0 || data.requests !== undefined) {
                    allRequests = requests;
                    updateStatistics();
                    filterAndDisplayRequests();
                } else {
                    console.log('No requests found for this user');
                    allRequests = [];
                    updateStatistics();
                    filterAndDisplayRequests();
                }
            } else {
                console.warn('API response not OK');
                console.log('Response data:', data);
                showEmptyState();
            }
        } catch (error) {
            console.error('Error loading requests:', error);
            console.error('Error details:', error.message);
            if (error.message && error.message.includes('fetch')) {
                // Network error - Functions server might not be running
                if (tableBody) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #E7000B;">
                                <div>Error: Cannot connect to server.</div>
                                <div style="margin-top: 10px; font-size: 14px; color: #666;">
                                    Make sure the Functions server is running:<br>
                                    <code>netlify dev --functions netlify/functions --port 8889</code>
                                </div>
                            </td>
                        </tr>
                    `;
                }
            } else {
                showEmptyState();
            }
        }
    }

    // Update statistics
    function updateStatistics() {
        const pending = allRequests.filter(r => r.status === 'pending').length;
        const inProgress = allRequests.filter(r => r.status === 'active' || r.status === 'in-progress').length;
        const completed = allRequests.filter(r => r.status === 'completed').length;

        if (pendingCount) pendingCount.textContent = pending;
        if (inProgressCount) inProgressCount.textContent = inProgress;
        if (completedCount) completedCount.textContent = completed;
    }

    // Filter and display requests
    function filterAndDisplayRequests() {
        const statusValue = statusFilter ? statusFilter.value.toLowerCase() : '';
        const priorityValue = priorityFilter ? priorityFilter.value.toLowerCase() : '';
        const searchValue = searchInput ? searchInput.value.toLowerCase() : '';

        filteredRequests = allRequests.filter(req => {
            const status = (req.status || '').toLowerCase();
            const priority = (req.priority || 'medium').toLowerCase();
            const title = (req.title || '').toLowerCase();
            const description = (req.description || '').toLowerCase();
            const location = (req.location || '').toLowerCase();

            const statusMatch = !statusValue || statusValue === 'all status' || 
                (statusValue === 'pending' && status === 'pending') ||
                (statusValue === 'in progress' && (status === 'active' || status === 'in-progress')) ||
                (statusValue === 'completed' && status === 'completed');
            
            const priorityMatch = !priorityValue || priorityValue === 'all priority' || 
                priority.includes(priorityValue);
            
            const searchMatch = !searchValue || 
                title.includes(searchValue) || 
                description.includes(searchValue) ||
                location.includes(searchValue);

            return statusMatch && priorityMatch && searchMatch;
        });

        renderTable();
    }

    // Render table with requests
    function renderTable() {
        if (!tableBody) return;

        if (filteredRequests.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                        No requests found
                    </td>
                </tr>
            `;
            return;
        }

        // Get user data for name
        const userData = localStorage.getItem('user_data');
        const user = userData ? JSON.parse(userData) : null;
        const userName = user?.name || 'You';

        tableBody.innerHTML = filteredRequests.map(req => {
            const initial = userName.charAt(0).toUpperCase();
            const date = req.created_at ? new Date(req.created_at).toISOString().split('T')[0] : 'N/A';
            const priority = req.priority || 'medium';
            const status = req.status || 'pending';
            const title = req.title || req.description || 'No title';
            const statusClass = status === 'pending' ? 'pending' : 
                               (status === 'active' || status === 'in-progress') ? 'in-progress' : 
                               status === 'completed' ? 'completed' : 'pending';
            
            const statusIcon = status === 'pending' ? 
                '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1"/><path d="M6 2V6L9 9" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>' :
                (status === 'active' || status === 'in-progress') ?
                '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1"/><path d="M6 3V6L9 9" stroke="currentColor" stroke-width="1" stroke-linecap="round"/></svg>' :
                '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><path d="M3 6L5 8L9 4" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/><circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1"/></svg>';

            return `
                <tr>
                    <td>
                        <div class="resident-cell">
                            <div class="resident-avatar">${initial}</div>
                            <span class="resident-name">${userName}</span>
                        </div>
                    </td>
                    <td class="issue-cell">${escapeHtml(title)}</td>
                    <td class="date-cell">${date}</td>
                    <td>
                        <span class="priority-badge ${priority}">${priority}</span>
                    </td>
                    <td>
                        <span class="status-badge ${statusClass}">
                            ${statusIcon}
                            ${status}
                        </span>
                    </td>
                    <td>
                        <button class="action-button" onclick="viewRequest(${req.id})">
                            <span>View</span>
                            <svg class="action-arrow" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Show empty state
    function showEmptyState() {
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                        No requests yet. <a href="/submit-request" style="color: #155DFC;">Submit your first request</a>
                    </td>
                </tr>
            `;
        }
        if (pendingCount) pendingCount.textContent = '0';
        if (inProgressCount) inProgressCount.textContent = '0';
        if (completedCount) completedCount.textContent = '0';
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // View request details
    window.viewRequest = function(requestId) {
        // Navigate to request details or show modal
        console.log('View request:', requestId);
        // You can implement a modal or navigate to a details page
    };

    // Export to CSV
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            exportToCSV();
        });
    }

    function exportToCSV() {
        if (filteredRequests.length === 0) {
            alert('No requests to export');
            return;
        }

        const headers = ['Resident', 'Issue', 'Date', 'Priority', 'Status', 'Location'];
        const rows = filteredRequests.map(req => {
            const userData = localStorage.getItem('user_data');
            const user = userData ? JSON.parse(userData) : null;
            const userName = user?.name || 'You';
            const date = req.created_at ? new Date(req.created_at).toISOString().split('T')[0] : 'N/A';
            return [
                userName,
                req.title || req.description || 'No title',
                date,
                req.priority || 'medium',
                req.status || 'pending',
                req.location || 'N/A'
            ];
        });

        const csvContent = [
            headers.join(','),
            ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
        ].join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `requests-${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    }

    // Filter function
    function filterTable() {
        filterAndDisplayRequests();
    }

    // Add event listeners
    if (statusFilter) {
        statusFilter.addEventListener('change', filterTable);
    }

    if (priorityFilter) {
        priorityFilter.addEventListener('change', filterTable);
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    // Make filter selects fully clickable
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(filterSelect => {
        const select = filterSelect.querySelector('select');
        if (select) {
            filterSelect.addEventListener('click', function(e) {
                if (e.target !== select) {
                    select.focus();
                    select.click();
                }
            });
        }
    });

    // Logout handler
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            window.location.href = '/login';
        });
    }

    // Load requests on page load
    loadRequests();

    // Refresh data when page becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            console.log('Page visible - refreshing requests');
            loadRequests();
        }
    });

    // Also refresh when window gains focus
    window.addEventListener('focus', function() {
        console.log('Window focused - refreshing requests');
        loadRequests();
    });
});
