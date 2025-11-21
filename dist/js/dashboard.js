import { requireAuth, apiRequest, clearAuth } from './auth.js';

// Check authentication
if (!requireAuth()) {
  // Redirect will happen in requireAuth
  exit;
}

// Logout functionality
const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    clearAuth();
    window.location.href = '/login.html';
  });
}

// Load dashboard data
async function loadDashboardData() {
  try {
    const response = await apiRequest('/.netlify/functions/api/dashboard');
    
    if (!response) return;
    
    const data = await response.json();
    
    if (data.stats) {
      document.getElementById('activeRequests').textContent = data.stats.active || 0;
      document.getElementById('completedRequests').textContent = data.stats.completed || 0;
      document.getElementById('pendingRequests').textContent = data.stats.pending || 0;
    }
    
    if (data.requests && data.requests.length > 0) {
      renderActivityList(data.requests);
    }
  } catch (error) {
    console.error('Error loading dashboard data:', error);
  }
}

function renderActivityList(requests) {
  const activityList = document.getElementById('activityList');
  if (!activityList) return;
  
  activityList.innerHTML = requests.slice(0, 3).map(request => {
    const statusClass = request.status === 'completed' ? 'active' : 
                       request.status === 'pending' ? 'review' : '';
    const statusIcon = request.status === 'completed' ? '#00A63E' : '#155DFC';
    
    const date = new Date(request.created_at);
    const timeAgo = getTimeAgo(date);
    
    return `
      <div class="activity-item ${statusClass}">
        <div class="activity-avatar blue-bg">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="${statusIcon}"/>
          </svg>
        </div>
        <div class="activity-content">
          <h4 class="activity-title">${escapeHtml(request.title)}</h4>
          <p class="activity-description">${escapeHtml(request.description)}</p>
          <div class="activity-meta">
            <div class="meta-item">
              <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                <path d="M8 8C9.1 8 10 7.1 10 6C10 4.9 9.1 4 8 4C6.9 4 6 4.9 6 6C6 7.1 6.9 8 8 8ZM8 10C6.67 10 2 10.67 2 12V14H14V12C14 10.67 9.33 10 8 10Z" fill="#717182"/>
              </svg>
              <span>${escapeHtml(request.location)}</span>
            </div>
            <div class="meta-item">
              <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                <path d="M8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2ZM8 13C5.24 13 3 10.76 3 8C3 5.24 5.24 3 8 3C10.76 3 13 5.24 13 8C13 10.76 10.76 13 8 13Z" fill="#717182"/>
                <path d="M8.5 5V8.25L11 9.5L10.25 10.75L7 9V5H8.5Z" fill="#717182"/>
              </svg>
              <span>${timeAgo}</span>
            </div>
          </div>
        </div>
      </div>
    `;
  }).join('');
}

function getTimeAgo(date) {
  const seconds = Math.floor((new Date() - date) / 1000);
  
  if (seconds < 60) return 'just now';
  if (seconds < 3600) return `${Math.floor(seconds / 60)} minutes ago`;
  if (seconds < 86400) return `${Math.floor(seconds / 3600)} hours ago`;
  if (seconds < 604800) return `${Math.floor(seconds / 86400)} days ago`;
  return date.toLocaleDateString();
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Load dashboard data on page load
loadDashboardData();

