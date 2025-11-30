// All Requests Official JavaScript
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
    const tableBody = document.getElementById('requestsTableBody');
    const statusFilter = document.getElementById('statusFilter');
    const priorityFilter = document.getElementById('priorityFilter');
    const searchInput = document.getElementById('searchInput');
    const pendingCount = document.getElementById('pendingCount');
    const inProgressCount = document.getElementById('inProgressCount');
    const completedCount = document.getElementById('completedCount');
    const logoutBtn = document.getElementById('logoutBtn');
    const exportBtn = document.getElementById('exportBtn');

    let allRequests = [];
    let filteredRequests = [];

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

    // Load requests
    async function loadRequests() {
        try {
            const response = await fetch('/.netlify/functions/api/requests', {
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
            
            if (response.ok && data.requests) {
                allRequests = data.requests;
                updateStatistics();
                filterAndDisplayRequests();
            } else {
                showError('Failed to load requests');
            }
        } catch (error) {
            console.error('Error loading requests:', error);
            showError('An error occurred while loading requests');
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

        filteredRequests = allRequests.filter(request => {
            const matchesStatus = !statusValue || request.status === statusValue || 
                                 (statusValue === 'in-progress' && request.status === 'active');
            const matchesPriority = !priorityValue || (request.priority || 'medium') === priorityValue;
            const matchesSearch = !searchValue || 
                                (request.user_name && request.user_name.toLowerCase().includes(searchValue)) ||
                                (request.title && request.title.toLowerCase().includes(searchValue)) ||
                                (request.description && request.description.toLowerCase().includes(searchValue));

            return matchesStatus && matchesPriority && matchesSearch;
        });

        displayRequests(filteredRequests);
    }

    // Use event delegation for dropdown clicks (prevents duplicate listeners)
    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            // Handle priority badge clicks
            if (e.target.closest('.priority-clickable')) {
                const badge = e.target.closest('.priority-clickable');
                const requestId = badge.getAttribute('data-request-id');
                if (requestId) {
                    togglePriorityDropdown(parseInt(requestId), e);
                }
            }
            
            // Handle status badge clicks
            if (e.target.closest('.status-clickable')) {
                const badge = e.target.closest('.status-clickable');
                const requestId = badge.getAttribute('data-request-id');
                if (requestId) {
                    toggleStatusDropdown(parseInt(requestId), e);
                }
            }
        });
    }

    // Display requests in table
    function displayRequests(requests) {
        if (!tableBody) return;

        if (requests.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="empty-state">No requests found</td></tr>';
            return;
        }

        tableBody.innerHTML = requests.map(request => {
            const residentName = request.user_name || 'Unknown';
            const initials = getInitials(residentName);
            const issue = request.title || request.description || 'No description';
            const date = formatDate(request.created_at);
            const priority = request.priority || 'medium';
            const status = request.status || 'pending';
            const assignedOfficial = request.assigned_official ? request.assigned_official.name : null;

            return `
                <tr>
                    <td>
                        <div class="resident-cell">
                            <div class="resident-avatar">${initials}</div>
                            <span class="resident-name">${escapeHtml(residentName)}</span>
                        </div>
                    </td>
                    <td class="issue-cell">${escapeHtml(issue)}</td>
                    <td class="date-cell">${date}</td>
                    <td>
                        <div class="priority-dropdown-container">
                            <span class="priority-badge ${priority} priority-clickable" 
                                  data-request-id="${request.id}"
                                  style="cursor: pointer;">
                                ${priority}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="status-dropdown-container">
                            <span class="status-badge ${status} status-clickable" 
                                  data-request-id="${request.id}"
                                  style="cursor: pointer;">
                                ${getStatusIcon(status)}
                                ${status}
                            </span>
                        </div>
                    </td>
                    <td>
                        <button class="action-button" onclick="openRequestModal(${request.id})">
                            <span class="action-text">
                                <span>${assignedOfficial ? 'View' : 'Assign'}</span>
                            </span>
                            <svg class="action-arrow" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Helper functions
    function getInitials(name) {
        if (!name) return 'U';
        const parts = name.trim().split(' ');
        if (parts.length >= 2) {
            return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
        }
        return name[0].toUpperCase();
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
    }

    function getStatusIcon(status) {
        const icons = {
            'pending': '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><rect x="0.99" y="1.49" width="10" height="9" stroke="#BB4D00" stroke-width="1"/><path d="M5.99 4.5V8.49" stroke="#BB4D00" stroke-width="1" stroke-linecap="round"/></svg>',
            'active': '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><path d="M5.99 3V6.99" stroke="#1447E6" stroke-width="1" stroke-linecap="round"/><rect x="1" y="1" width="9.99" height="9.99" stroke="#1447E6" stroke-width="1"/></svg>',
            'in-progress': '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><path d="M5.99 3V6.99" stroke="#1447E6" stroke-width="1" stroke-linecap="round"/><rect x="1" y="1" width="9.99" height="9.99" stroke="#1447E6" stroke-width="1"/></svg>',
            'completed': '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><path d="M4.5 5L6 6.5L7.5 5" stroke="#008236" stroke-width="1" stroke-linecap="round"/><rect x="2.5" y="2.5" width="7" height="7" stroke="#008236" stroke-width="1"/></svg>',
            'cancelled': '<svg class="status-icon" viewBox="0 0 12 12" fill="none"><path d="M3 3L9 9M9 3L3 9" stroke="#DC2626" stroke-width="1" stroke-linecap="round"/></svg>'
        };
        return icons[status] || '';
    }

    function escapeHtml(text) {
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
        const headers = ['Resident', 'Issue', 'Date', 'Priority', 'Status', 'Assigned To'];
        const rows = filteredRequests.map(req => [
            req.user_name || 'Unknown',
            req.title || req.description || '',
            formatDate(req.created_at),
            req.priority || 'medium',
            req.status || 'pending',
            req.assigned_official ? req.assigned_official.name : 'Unassigned'
        ]);

        const csvContent = [
            headers.join(','),
            ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
        ].join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `requests_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    }

    // Create dropdown menu dynamically
    function createDropdownMenu(type, requestId, options) {
        const dropdown = document.createElement('div');
        dropdown.className = `${type}-dropdown`;
        dropdown.id = `${type}-dropdown-${requestId}`;
        dropdown.style.cssText = 'display: none; position: fixed; z-index: 10000; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); min-width: 120px;';
        
        options.forEach(option => {
            const item = document.createElement('div');
            item.className = 'dropdown-item';
            item.textContent = option.label;
            item.onclick = () => {
                if (type === 'priority') {
                    updatePriority(requestId, option.value);
                } else {
                    updateStatus(requestId, option.value);
                }
            };
            dropdown.appendChild(item);
        });
        
        document.body.appendChild(dropdown);
        return dropdown;
    }

    // Toggle priority dropdown
    window.togglePriorityDropdown = function(requestId, event) {
        event.stopPropagation();
        
        // Close all other dropdowns
        document.querySelectorAll('.priority-dropdown, .status-dropdown').forEach(dropdown => {
            if (dropdown.id !== `priority-dropdown-${requestId}`) {
                dropdown.style.display = 'none';
            }
        });

        // Get or create dropdown
        let dropdown = document.getElementById(`priority-dropdown-${requestId}`);
        if (!dropdown) {
            dropdown = createDropdownMenu('priority', requestId, [
                { label: 'Low', value: 'low' },
                { label: 'Medium', value: 'medium' },
                { label: 'High', value: 'high' },
                { label: 'Urgent', value: 'urgent' }
            ]);
        }

        const isVisible = dropdown.style.display === 'block';
        
        if (isVisible) {
            dropdown.style.display = 'none';
        } else {
            // Position dropdown
            const badge = event.target.closest('.priority-clickable') || event.target;
            if (badge) {
                const rect = badge.getBoundingClientRect();
                dropdown.style.top = (rect.bottom + 4) + 'px';
                dropdown.style.left = rect.left + 'px';
                dropdown.style.display = 'block';
            }
        }
    };

    // Toggle status dropdown
    window.toggleStatusDropdown = function(requestId, event) {
        event.stopPropagation();
        
        // Close all other dropdowns
        document.querySelectorAll('.status-dropdown, .priority-dropdown').forEach(dropdown => {
            if (dropdown.id !== `status-dropdown-${requestId}`) {
                dropdown.style.display = 'none';
            }
        });

        // Get or create dropdown
        let dropdown = document.getElementById(`status-dropdown-${requestId}`);
        if (!dropdown) {
            dropdown = createDropdownMenu('status', requestId, [
                { label: 'Pending', value: 'pending' },
                { label: 'Active', value: 'active' },
                { label: 'Completed', value: 'completed' },
                { label: 'Cancelled', value: 'cancelled' }
            ]);
        }

        const isVisible = dropdown.style.display === 'block';
        
        if (isVisible) {
            dropdown.style.display = 'none';
        } else {
            // Position dropdown
            const badge = event.target.closest('.status-clickable') || event.target;
            if (badge) {
                const rect = badge.getBoundingClientRect();
                dropdown.style.top = (rect.bottom + 4) + 'px';
                dropdown.style.left = rect.left + 'px';
                dropdown.style.display = 'block';
            }
        }
    };

    // Update priority
    window.updatePriority = async function(requestId, newPriority) {
        // Close dropdown
        const dropdown = document.getElementById(`priority-dropdown-${requestId}`);
        if (dropdown) dropdown.style.display = 'none';

        try {
            const response = await fetch(`/.netlify/functions/api/requests/${requestId}/priority`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    priority: newPriority,
                    description: `Priority changed to ${newPriority}`
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showNotification('Priority updated successfully', 'success');
                // Reload requests to reflect changes
                await loadRequests();
            } else {
                showNotification(data.error || 'Failed to update priority', 'error');
            }
        } catch (error) {
            console.error('Error updating priority:', error);
            showNotification('Error updating priority. Please try again.', 'error');
        }
    };

    // Update status
    window.updateStatus = async function(requestId, newStatus) {
        // Close dropdown
        const dropdown = document.getElementById(`status-dropdown-${requestId}`);
        if (dropdown) dropdown.style.display = 'none';

        try {
            const response = await fetch(`/.netlify/functions/api/requests/${requestId}/status`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: newStatus,
                    description: `Status changed to ${newStatus}`
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showNotification('Status updated successfully', 'success');
                // Reload requests to reflect changes
                await loadRequests();
            } else {
                showNotification(data.error || 'Failed to update status', 'error');
            }
        } catch (error) {
            console.error('Error updating status:', error);
            showNotification('Error updating status. Please try again.', 'error');
        }
    };

    // Show notification
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existing = document.querySelector('.notification');
        if (existing) existing.remove();

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            background: ${type === 'success' ? '#00A63E' : '#E7000B'};
            color: white;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            z-index: 10000;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
        `;
        notification.textContent = message;

        // Add animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        if (!document.querySelector('#notification-style')) {
            style.id = 'notification-style';
            document.head.appendChild(style);
        }

        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideIn 0.3s ease-out reverse';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.priority-clickable') && 
            !event.target.closest('.status-clickable') &&
            !event.target.closest('.priority-dropdown') &&
            !event.target.closest('.status-dropdown')) {
            document.querySelectorAll('.priority-dropdown, .status-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }
    });

    // Open request modal (for assigning/updating)
    window.openRequestModal = function(requestId) {
        const request = allRequests.find(r => r.id === requestId);
        if (!request) return;

        // Simple modal for now - you can enhance this later
        const action = confirm(`Request: ${request.title || request.description}\n\nWhat would you like to do?\n\nOK = View Details\nCancel = Close`);
        
        if (action) {
            // Open a detailed view or modal
            // For now, just show an alert with request details
            alert(`Request Details:\n\nResident: ${request.user_name}\nIssue: ${request.title || request.description}\nStatus: ${request.status}\nPriority: ${request.priority || 'medium'}\nAssigned To: ${request.assigned_official ? request.assigned_official.name : 'Unassigned'}`);
        }
    };

    // Event listeners
    if (statusFilter) {
        statusFilter.addEventListener('change', filterAndDisplayRequests);
    }

    if (priorityFilter) {
        priorityFilter.addEventListener('change', filterAndDisplayRequests);
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterAndDisplayRequests);
    }

    // Initial load
    loadRequests();
});

