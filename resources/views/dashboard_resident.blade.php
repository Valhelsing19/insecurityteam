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
    <link rel="stylesheet" href="{{ asset('css/dashboard-resident.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <div class="logo-circle">
                        <img src="{{ asset('images/smart-neighborhood-logo.png') }}" alt="Smart Neighborhood Logo" onerror="this.style.display='none'">
                    </div>
                    <div class="logo-text">
                        <h2>Smart Neighborhood</h2>
                        <p>resident Portal</p>
                    </div>
                </div>
            </div>

            <nav class="navigation">
                <a href="/dashboard/resident" class="nav-button active">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M2.5 1.67L10 6.67L17.5 1.67M10 6.67V18.33M2.5 1.67V18.33L10 13.33M17.5 1.67V18.33L10 13.33" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Home</span>
                </a>
                <a href="/submit-request" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M1.67 1.67H6.67V6.67H1.67V1.67Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.67 10H13.33M6.67 13.33H13.33M6.67 16.67H13.33" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                        <path d="M10 6.67H18.33V18.33H10V6.67Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Submit Request</span>
                </a>
                <a href="/my-requests" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M3.33 1.67H13.33V16.67H3.33V1.67Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.67 6.67H10M6.67 10H10M6.67 13.33H10" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                        <path d="M11.67 1.67H16.67V5M11.67 5H16.67" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.67 7.5H16.67V10.83M11.67 10.83H16.67" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.67 12.5H16.67V14.17M11.67 14.17H16.67" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
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
            <!-- Hero Banner -->
            <div class="hero-banner">
                <div class="hero-content">
                    <div class="hero-badges">
                        <span class="hero-badge">Welcome Back</span>
                        <span class="hero-badge">resident</span>
                    </div>
                    <h1 class="hero-title">Smart Neighborhood System</h1>
                    <p class="hero-description">Manage your maintenance requests and stay updated with neighborhood activities</p>
                    <div class="hero-actions">
                        <button class="hero-button primary">
                            <span>Submit Request</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 3.33V12.67M3.33 8H12.67" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button class="hero-button secondary">Learn More</button>
                    </div>
                </div>
            </div>

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
                        <div class="action-icon blue-gradient">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 8V12M12 16H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Submit New Request</h3>
                            <p class="action-description">Report a maintenance issue</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-icon purple-gradient">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 8H22" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M8 16H14" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">View My Requests</h3>
                            <p class="action-description">Track your submissions</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-icon green-gradient">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M3 3V21H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 16L12 11L16 15L21 10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 10V3H14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Dashboard</h3>
                            <p class="action-description">View statistics & insights</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Bottom Row -->
            <div class="content-bottom">
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
                        <div class="activity-item">
                            <div class="activity-avatar green-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#00A63E"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">Plumbing Issue Resolved</h4>
                                <p class="activity-description">Basement leak has been fixed</p>
                                <div class="activity-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <path d="M6 6C6.82843 6 7.5 5.32843 7.5 4.5C7.5 3.67157 6.82843 3 6 3C5.17157 3 4.5 3.67157 4.5 4.5C4.5 5.32843 5.17157 6 6 6Z" fill="#717182"/>
                                            <path d="M6 7.5C4.5075 7.5 1.5 8.2575 1.5 9.75V10.5H10.5V9.75C10.5 8.2575 7.4925 7.5 6 7.5Z" fill="#717182"/>
                                        </svg>
                                        <span>Building A, Unit 204</span>
                                    </div>
                                    <div class="meta-item">
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.5"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.5" stroke-linecap="round"/>
                                        </svg>
                                        <span>2 hours ago</span>
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
                                <h4 class="activity-title">Electrical Inspection</h4>
                                <p class="activity-description">Request is under review</p>
                                <div class="activity-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <path d="M6 6C6.82843 6 7.5 5.32843 7.5 4.5C7.5 3.67157 6.82843 3 6 3C5.17157 3 4.5 3.67157 4.5 4.5C4.5 5.32843 5.17157 6 6 6Z" fill="#717182"/>
                                            <path d="M6 7.5C4.5075 7.5 1.5 8.2575 1.5 9.75V10.5H10.5V9.75C10.5 8.2575 7.4925 7.5 6 7.5Z" fill="#717182"/>
                                        </svg>
                                        <span>Building B, Unit 102</span>
                                    </div>
                                    <div class="meta-item">
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.5"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.5" stroke-linecap="round"/>
                                        </svg>
                                        <span>5 hours ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-avatar orange-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 2L2 7V12C2 16.97 5.61 21.19 12 22C18.39 21.19 22 16.97 22 12V7L12 2Z" fill="#E17100"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">New Request Submitted</h4>
                                <p class="activity-description">Street light maintenance</p>
                                <div class="activity-meta">
                                    <div class="meta-item">
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <path d="M6 6C6.82843 6 7.5 5.32843 7.5 4.5C7.5 3.67157 6.82843 3 6 3C5.17157 3 4.5 3.67157 4.5 4.5C4.5 5.32843 5.17157 6 6 6Z" fill="#717182"/>
                                            <path d="M6 7.5C4.5075 7.5 1.5 8.2575 1.5 9.75V10.5H10.5V9.75C10.5 8.2575 7.4925 7.5 6 7.5Z" fill="#717182"/>
                                        </svg>
                                        <span>Park Avenue</span>
                                    </div>
                                    <div class="meta-item">
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.5"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.5" stroke-linecap="round"/>
                                        </svg>
                                        <span>1 day ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <!-- Announcements -->
                    <div class="announcements">
                        <div class="announcements-header">
                            <svg class="announcements-icon" viewBox="0 0 20 20" fill="none">
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
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.5"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.5" stroke-linecap="round"/>
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
                                        <svg class="meta-icon" viewBox="0 0 12 12" fill="none">
                                            <circle cx="6" cy="6" r="5" stroke="#717182" stroke-width="0.5"/>
                                            <path d="M6 3V6L8 7" stroke="#717182" stroke-width="0.5" stroke-linecap="round"/>
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
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/dashboard-resident.js') }}" defer></script>
</body>
</html>

