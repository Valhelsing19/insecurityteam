<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Neighborhood - Resident Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                        <img src="{{ asset('images/dashboard-logo.png') }}" alt="Smart Neighborhood Logo">
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
                        <rect x="2.5" y="2.5" width="15" height="15" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M7.5 10H12.5M7.5 7.5H12.5M7.5 12.5H12.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Home</span>
                </a>
                <a href="/submit-request" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="1.67" y="1.67" width="16.67" height="16.67" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M10 6.67V13.33M6.67 10H13.33" stroke="currentColor" stroke-width="1.67"/>
                    </svg>
                    <span class="nav-text">Submit Request</span>
                </a>
                <a href="/my-requests" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M3.33 6.67H6.67M3.33 10H6.67M3.33 13.33H6.67" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                        <path d="M6.67 1.67H13.33V18.33H6.67V1.67Z" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M10 6.67H13.33M10 10H13.33M10 13.33H13.33" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Dashboard Overview</h1>
                <p class="page-description">Monitor and track neighborhood maintenance requests</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Total Requests</div>
                        <div class="stat-number" id="totalRequests">0</div>
                    </div>
                    <div class="stat-icon blue">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="none">
                            <rect x="8" y="2" width="8" height="4" stroke="white" stroke-width="2"/>
                            <rect x="4" y="4" width="15.99" height="17.99" stroke="white" stroke-width="2"/>
                            <path d="M12 11H12.01M12 15H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Pending</div>
                        <div class="stat-number" id="pendingRequests">0</div>
                    </div>
                    <div class="stat-icon orange">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="none">
                            <path d="M12 6L12 2L12 6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <rect x="2" y="2" width="19.99" height="19.99" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">In Progress</div>
                        <div class="stat-number" id="inProgressRequests">0</div>
                    </div>
                    <div class="stat-icon purple">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="6" stroke="white" stroke-width="2"/>
                            <circle cx="10" cy="10" r="3" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number" id="completedRequests">0</div>
            </div>
                    <div class="stat-icon green">
                        <svg width="24" height="24" viewBox="0 0 20 20" fill="none">
                            <path d="M9 10L9 6L9 10" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <path d="M4 10L10 10L16 10" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        </div>
                    </div>

            <!-- Charts Section -->
            <div class="charts-container">
                <!-- Issues by Type Chart -->
                <div class="chart-card">
                    <h3 class="chart-title">Issues by Type</h3>
                    <div class="chart-container">
                        <canvas id="issuesChart"></canvas>
                        </div>
                    </div>
                <!-- Trend Over Time Chart -->
                <div class="chart-card">
                    <h3 class="chart-title">Trend Over Time</h3>
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>

                <!-- Recent Activity -->
            <div class="activity-card">
                <h3 class="activity-title">Recent Activity</h3>
                    <div class="activity-list" id="recentActivityList">
                        <!-- Activity items will be dynamically loaded here -->
                    </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/dashboard-resident.js') }}"></script>
</body>
</html>
