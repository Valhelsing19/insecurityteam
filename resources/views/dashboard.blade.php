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
                        <img src="{{ asset('images/smart-neighborhood-logo.png') }}" alt="Smart Neighborhood Logo" onerror="this.onerror=null; this.src='{{ asset('images/dashboard-logo.png') }}';">
                    </div>
                    <div class="logo-text">
                        <h2>Smart Neighborhood</h2>
                        <p>resident Portal</p>
                    </div>
                </div>
            </div>

            <nav class="navigation">
                <a href="/dashboard" class="nav-button active">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 10L10 7.5L12.5 10" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2.5 1.67L10 7.5L17.5 1.67" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2.5 1.67V18.33H17.5V1.67" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Home</span>
                </a>
                <a href="/submit-request" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.67 1.67H18.33V18.33H1.67V1.67Z" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.67 10H13.33" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round"/>
                        <path d="M10 6.67V13.33" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Submit Request</span>
                </a>
                <a href="/my-requests" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3.33" y="1.67" width="13.33" height="16.67" stroke="currentColor" stroke-width="1.6666666269302368"/>
                        <path d="M11.67 1.67V6.67H16.67" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.67 7.5H13.33M6.67 10.83H13.33M6.67 14.17H13.33" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">My Requests</span>
                </a>
                <a href="/settings" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.54 1.68L14.93 16.64" stroke="currentColor" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10" cy="10" r="5" stroke="currentColor" stroke-width="1.6666666269302368"/>
                        <circle cx="7.5" cy="7.5" r="2.5" fill="currentColor"/>
                    </svg>
                    <span class="nav-text">Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <button class="logout-button">
                    <svg class="logout-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.66 4.66L13.33 7.33L10.66 10M13.33 7.33H6M6 2H3.33C2.6 2 2 2.6 2 3.33V12.67C2 13.4 2.6 14 3.33 14H6" stroke="#E7000B" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="logout-text">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Hero Banner -->
            <div class="hero-banner">
                <div class="hero-badges">
                    <div class="hero-badge">Welcome Back</div>
                    <div class="hero-badge">resident</div>
                </div>
                <h1 class="hero-title">Smart Neighborhood System</h1>
                <p class="hero-description">Manage your maintenance requests and stay updated with neighborhood activities</p>
                <div class="hero-actions">
                        <button class="hero-button primary btn-primary">
                        <span>Submit Request</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="hero-button secondary btn-secondary">
                        <span>Learn More</span>
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Active Requests</div>
                        <div class="stat-number">12</div>
                    </div>
                    <div class="stat-icon stat-icon-active">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2ZM12 4.23L19.5 7.5C19.5 8.5 19.5 9.5 19.5 10.5C19.5 15.5 16.5 19.5 12 20.5C7.5 19.5 4.5 15.5 4.5 10.5C4.5 9.5 4.5 8.5 4.5 7.5L12 4.23Z" fill="#155DFC"/>
                            <path d="M12 6V12L16 14" stroke="#155DFC" stroke-width="1.9996280670166016" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number">48</div>
                    </div>
                    <div class="stat-icon stat-icon-completed">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 10L11 12L15 8M20 6L9 17L4 12" stroke="#00A63E" stroke-width="1.9996280670166016" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Pending Review</div>
                        <div class="stat-number">5</div>
                    </div>
                    <div class="stat-icon stat-icon-pending">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.98 2.99L20.01 18.01" stroke="#E17100" stroke-width="1.9996280670166016" stroke-linecap="round"/>
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
                        <div class="action-icon action-icon-blue blue-gradient">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" stroke="white" stroke-width="1.9996280670166016" fill="none"/>
                                <path d="M12 6V12L16 14" stroke="white" stroke-width="1.9996280670166016" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Submit New Request</h3>
                            <p class="action-description">Report a maintenance issue</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-icon action-icon-purple purple-gradient">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="2" width="16" height="20" stroke="white" stroke-width="1.9996280670166016" fill="none"/>
                                <path d="M14 2L20 2L20 8" stroke="white" stroke-width="1.9996280670166016" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 9H14M8 13H14M8 17H14" stroke="white" stroke-width="1.9996280670166016" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">View My Requests</h3>
                            <p class="action-description">Track your submissions</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-icon action-icon-green green-gradient">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="7" width="20" height="10" rx="2" stroke="white" stroke-width="1.9996280670166016" fill="none"/>
                                <circle cx="16" cy="10" r="3" stroke="white" stroke-width="1.9996280670166016" fill="none"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Dashboard</h3>
                            <p class="action-description">View statistics & insights</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Announcements Container -->
            <div class="content-bottom">
                <div class="content-row">
                    <!-- Recent Activity -->
                    <div class="recent-activity">
                    <div class="activity-header">
                        <h2 class="section-title">Recent Activity</h2>
                        <button class="view-all-button">
                            <span>View All</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-avatar avatar-green green-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 8.33L9 10L12.5 6.67" stroke="#00A63E" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">Plumbing Issue Resolved</h4>
                                <p class="activity-description">Basement leak has been fixed</p>
                                <div class="activity-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 6C6.83 6 7.5 5.33 7.5 4.5C7.5 3.67 6.83 3 6 3C5.17 3 4.5 3.67 4.5 4.5C4.5 5.33 5.17 6 6 6ZM6 7.5C5 7.5 2 8 2 9V10.5H10V9C10 8 7 7.5 6 7.5Z" fill="#717182"/>
                                        </svg>
                                        <span>Building A, Unit 204</span>
                                    </div>
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.9998140335083008"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.9998140335083008" stroke-linecap="round"/>
                                        </svg>
                                        <span>2 hours ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-avatar avatar-blue blue-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 3.33L3.33 6.67V10C3.33 12.76 5.57 15 8.33 15.67C11.09 15 13.33 12.76 13.33 10V6.67L10 3.33Z" fill="#155DFC"/>
                                    <path d="M10 3.33V10L13.33 11.67" stroke="#155DFC" stroke-width="1.6666666269302368" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">Electrical Inspection</h4>
                                <p class="activity-description">Request is under review</p>
                                <div class="activity-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 6C6.83 6 7.5 5.33 7.5 4.5C7.5 3.67 6.83 3 6 3C5.17 3 4.5 3.67 4.5 4.5C4.5 5.33 5.17 6 6 6ZM6 7.5C5 7.5 2 8 2 9V10.5H10V9C10 8 7 7.5 6 7.5Z" fill="#717182"/>
                                        </svg>
                                        <span>Building B, Unit 102</span>
                                    </div>
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.9998140335083008"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.9998140335083008" stroke-linecap="round"/>
                                        </svg>
                                        <span>5 hours ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-avatar avatar-yellow orange-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.65 2.49L16.68 15.01" stroke="#E17100" stroke-width="1.6666666269302368" stroke-linecap="round"/>
                                    <path d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10.83 14.17H9.17V12.5H10.83V14.17ZM10.83 10.83H9.17V5.83H10.83V10.83Z" fill="#E17100"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">New Request Submitted</h4>
                                <p class="activity-description">Street light maintenance</p>
                                <div class="activity-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 6C6.83 6 7.5 5.33 7.5 4.5C7.5 3.67 6.83 3 6 3C5.17 3 4.5 3.67 4.5 4.5C4.5 5.33 5.17 6 6 6ZM6 7.5C5 7.5 2 8 2 9V10.5H10V9C10 8 7 7.5 6 7.5Z" fill="#717182"/>
                                        </svg>
                                        <span>Park Avenue</span>
                                    </div>
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.9998140335083008"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.9998140335083008" stroke-linecap="round"/>
                                        </svg>
                                        <span>1 day ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Announcements & Help -->
                    <div class="right-column">
                    <!-- Announcements -->
                    <div class="announcements">
                        <div class="announcements-header">
                            <svg class="announcements-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 1.67L10 7.5L17.5 1.67" stroke="#364153" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.5 10V17.5H12.5V10" stroke="#364153" stroke-width="1.6666666269302368" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 2.5V7.5" stroke="#364153" stroke-width="1.6666666269302368" stroke-linecap="round"/>
                            </svg>
                            <h2 class="section-title">Announcements</h2>
                        </div>

                        <div class="announcements-list">
                            <div class="announcement-item announcement-orange orange-bg">
                                <h4 class="announcement-title">Scheduled Maintenance</h4>
                                <p class="announcement-description">Water supply will be interrupted on Oct 15 from 9 AM to 12 PM</p>
                                <div class="announcement-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="1"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="1" stroke-linecap="round"/>
                                        </svg>
                                        <span>Oct 15, 2025</span>
                                    </div>
                                </div>
                            </div>

                            <div class="announcement-item announcement-blue blue-bg">
                                <h4 class="announcement-title">New Feature Available</h4>
                                <p class="announcement-description">You can now track your requests in real-time</p>
                                <div class="announcement-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="1"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="1" stroke-linecap="round"/>
                                        </svg>
                                        <span>Oct 10, 2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Need Help Card -->
                    <div class="help-card">
                        <h3 class="help-title">Need Help?</h3>
                        <p class="help-description">Our support team is here to assist you 24/7</p>
                        <button class="help-button">Contact Support</button>
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
