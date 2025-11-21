<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Neighborhood - Resident Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <div class="logo-circle">
                        <img src="/images/dashboard-logo.png" alt="Smart Neighborhood Logo">
                    </div>
                    <div class="logo-text">
                        <h2>Smart Neighborhood</h2>
                        <p>resident Portal</p>
                    </div>
                </div>
            </div>

            <nav class="navigation">
                <a href="/dashboard" class="nav-button active">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M7.5 10L12.5 15L17.5 10M12.5 5V15" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Home</span>
                </a>
                <a href="/submit-request" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M1.67 1.67H18.33V18.33H1.67V1.67Z" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M10 6.67V13.33M6.67 10H13.33" stroke="currentColor" stroke-width="1.67"/>
                    </svg>
                    <span class="nav-text">Submit Request</span>
                </a>
                <a href="/my-requests" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M3.33 1.67H16.67V18.33H3.33V1.67Z" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M6.67 6.67H13.33M6.67 10H13.33M6.67 13.33H10" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">My Requests</span>
                </a>
                <a href="/settings" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <circle cx="10" cy="10" r="5" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M10 2.54V5M10 15V17.46M17.46 10H15M5 10H2.54" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <button class="logout-button">
                    <svg class="logout-icon" viewBox="0 0 16 16" fill="none">
                        <path d="M10.66 4.66L13.33 7.33L10.66 10M13.33 7.33H6M6 2H3.33C2.6 2 2 2.6 2 3.33V12.67C2 13.4 2.6 14 3.33 14H6" stroke="#E7000B" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="logout-text">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Statistics Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Active Requests</div>
                        <div class="stat-number">12</div>
                    </div>
                    <div class="stat-icon active">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2ZM12 4.23L19.5 7.5C19.5 8.5 19.5 9.5 19.5 10.5C19.5 15.5 16.5 19.5 12 20.5C7.5 19.5 4.5 15.5 4.5 10.5C4.5 9.5 4.5 8.5 4.5 7.5L12 4.23Z" fill="#155DFC"/>
                            <path d="M12 7V12L16 14" stroke="#155DFC" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number">48</div>
                    </div>
                    <div class="stat-icon completed">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 6L9 17L4 12" stroke="#00A63E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 6H9L4 12" stroke="#00A63E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Pending Review</div>
                        <div class="stat-number">5</div>
                    </div>
                    <div class="stat-icon pending">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z" fill="#E17100"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2 class="section-title">Quick Actions</h2>
                <div class="actions-grid">
                    <div class="action-card">
                        <div class="action-header blue-gradient"></div>
                        <div class="action-content">
                            <h3 class="action-title">Submit New Request</h3>
                            <p class="action-description">Report a maintenance issue</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-header green-gradient"></div>
                        <div class="action-content">
                            <h3 class="action-title">View My Requests</h3>
                            <p class="action-description">Track your submissions</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-header purple-gradient"></div>
                        <div class="action-content">
                            <h3 class="action-title">Dashboard</h3>
                            <p class="action-description">View statistics & insights</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity">
                <div class="activity-header">
                    <h2 class="section-title">Recent Activity</h2>
                    <button class="view-all-button">
                        <span>View All</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div class="activity-list">
                    <div class="activity-item active">
                        <div class="activity-avatar blue-bg">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#155DFC"/>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title">Plumbing Issue Resolved</h4>
                            <p class="activity-description">Basement leak has been fixed</p>
                            <div class="activity-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 8C9.1 8 10 7.1 10 6C10 4.9 9.1 4 8 4C6.9 4 6 4.9 6 6C6 7.1 6.9 8 8 8ZM8 10C6.67 10 2 10.67 2 12V14H14V12C14 10.67 9.33 10 8 10Z" fill="#717182"/>
                                    </svg>
                                    <span>Building A, Unit 204</span>
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2ZM8 13C5.24 13 3 10.76 3 8C3 5.24 5.24 3 8 3C10.76 3 13 5.24 13 8C13 10.76 10.76 13 8 13Z" fill="#717182"/>
                                        <path d="M8.5 5V8.25L11 9.5L10.25 10.75L7 9V5H8.5Z" fill="#717182"/>
                                    </svg>
                                    <span>2 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item review">
                        <div class="activity-avatar green-bg">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#00A63E"/>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title">Electrical Inspection</h4>
                            <p class="activity-description">Request is under review</p>
                            <div class="activity-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 8C9.1 8 10 7.1 10 6C10 4.9 9.1 4 8 4C6.9 4 6 4.9 6 6C6 7.1 6.9 8 8 8ZM8 10C6.67 10 2 10.67 2 12V14H14V12C14 10.67 9.33 10 8 10Z" fill="#717182"/>
                                    </svg>
                                    <span>Building B, Unit 102</span>
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2ZM8 13C5.24 13 3 10.76 3 8C3 5.24 5.24 3 8 3C10.76 3 13 5.24 13 8C13 10.76 10.76 13 8 13Z" fill="#717182"/>
                                        <path d="M8.5 5V8.25L11 9.5L10.25 10.75L7 9V5H8.5Z" fill="#717182"/>
                                    </svg>
                                    <span>5 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-avatar blue-bg">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#155DFC"/>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title">New Request Submitted</h4>
                            <p class="activity-description">Street light maintenance</p>
                            <div class="activity-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 8C9.1 8 10 7.1 10 6C10 4.9 9.1 4 8 4C6.9 4 6 4.9 6 6C6 7.1 6.9 8 8 8ZM8 10C6.67 10 2 10.67 2 12V14H14V12C14 10.67 9.33 10 8 10Z" fill="#717182"/>
                                    </svg>
                                    <span>Park Avenue</span>
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2ZM8 13C5.24 13 3 10.76 3 8C3 5.24 5.24 3 8 3C10.76 3 13 5.24 13 8C13 10.76 10.76 13 8 13Z" fill="#717182"/>
                                        <path d="M8.5 5V8.25L11 9.5L10.25 10.75L7 9V5H8.5Z" fill="#717182"/>
                                    </svg>
                                    <span>1 day ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcements -->
            <div class="announcements">
                <div class="announcements-header">
                    <svg class="announcements-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" stroke="#364153" stroke-width="1.67"/>
                    </svg>
                    <h2 class="section-title">Announcements</h2>
                </div>

                <div class="announcements-list">
                    <div class="announcement-item orange-bg">
                        <h4 class="announcement-title">Scheduled Maintenance</h4>
                        <p class="announcement-description">Water supply will be interrupted on Oct 15 from 9 AM to 12 PM</p>
                        <div class="announcement-meta">
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2ZM8 13C5.24 13 3 10.76 3 8C3 5.24 5.24 3 8 3C10.76 3 13 5.24 13 8C13 10.76 10.76 13 8 13Z" fill="#717182"/>
                                    <path d="M8.5 5V8.25L11 9.5L10.25 10.75L7 9V5H8.5Z" fill="#717182"/>
                                </svg>
                                <span>Oct 15, 2025</span>
                            </div>
                        </div>
                    </div>

                    <div class="announcement-item blue-bg">
                        <h4 class="announcement-title">New Feature Available</h4>
                        <p class="announcement-description">You can now track your requests in real-time</p>
                        <div class="announcement-meta">
                            <div class="meta-item">
                                <svg class="meta-icon" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2ZM8 13C5.24 13 3 10.76 3 8C3 5.24 5.24 3 8 3C10.76 3 13 5.24 13 8C13 10.76 10.76 13 8 13Z" fill="#717182"/>
                                    <path d="M8.5 5V8.25L11 9.5L10.25 10.75L7 9V5H8.5Z" fill="#717182"/>
                                </svg>
                                <span>Oct 10, 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
</body>
</html>
