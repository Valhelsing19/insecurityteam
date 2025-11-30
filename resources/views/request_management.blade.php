<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Management - Smart Neighborhood</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/request-management.css') }}">
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
                <a href="/dashboard" class="nav-button">
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
                <a href="/my-requests" class="nav-button active">
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
                <a href="/dashboard" class="back-button">
                    <span>← Back to Dashboard</span>
                </a>
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="page-title">Request Management</h1>
                        <p class="page-description">Manage and assign maintenance requests</p>
                    </div>
                    <button class="export-button">
                        <svg class="export-icon" viewBox="0 0 16 16" fill="none">
                            <path d="M8 2V14M8 2L2 8M8 2L14 8" stroke="white" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 10H14" stroke="white" stroke-width="1.33" stroke-linecap="round"/>
                        </svg>
                        <span>Export Report</span>
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="8" stroke="#E17100" stroke-width="1.67"/>
                            <path d="M10 4V10L13 13" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="pendingCount">0</div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon in-progress">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 5V10L13 13" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/>
                            <circle cx="10" cy="10" r="8" stroke="#155DFC" stroke-width="1.67"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="inProgressCount">0</div>
                        <div class="stat-label">In Progress</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon completed">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M5 10L8 13L15 6" stroke="#00A63E" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="10" cy="10" r="8" stroke="#00A63E" stroke-width="1.67"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="completedCount">0</div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-card">
                <div class="filters-row">
                    <div class="filter-select">
                        <select id="status-filter">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                        </select>
                        <svg class="select-arrow" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="filter-select">
                        <select id="priority-filter">
                            <option>All Priority</option>
                            <option>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                        <svg class="select-arrow" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="search-wrapper">
                        <svg class="search-icon" viewBox="0 0 16 16" fill="none">
                            <circle cx="8" cy="8" r="5" stroke="currentColor" stroke-width="1.33"/>
                            <path d="M11 11L14 14" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        </svg>
                        <input type="text" id="search-input" class="search-input" placeholder="Search by resident or issue...">
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 152px;">Resident</th>
                                <th style="width: 191px;">Issue</th>
                                <th style="width: 90px;">Date</th>
                                <th style="width: 78px;">Priority</th>
                                <th style="width: 111px;">Status</th>
                                <th style="width: 146px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="requests-table-body">
                            <!-- Table rows will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/request-management.js') }}"></script>
</body>
</html>

