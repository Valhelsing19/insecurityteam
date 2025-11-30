<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activity Log - Smart Neighborhood</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --white: #FFFFFF;
            --text-dark: #0A0A0A;
            --text-gray: #717182;
            --nav-text: #364153;
            --red: #E7000B;
            --blue: #155DFC;
            --green: #00A63E;
            --orange: #E17100;
            --border: #E5E7EB;
            --white-80: rgba(255, 255, 255, 0.8);
            --gradient-primary: linear-gradient(90deg, rgba(43, 127, 255, 1) 0%, rgba(79, 57, 246, 1) 100%);
            --gradient-bg: linear-gradient(135deg, rgba(239, 246, 255, 1) 0%, rgba(255, 255, 255, 1) 50%, rgba(238, 242, 255, 1) 100%);
            --gradient-title: linear-gradient(90deg, rgba(21, 93, 252, 1) 0%, rgba(79, 57, 246, 1) 100%);
            --shadow: 0px 4px 6px -4px rgba(0, 0, 0, 0.1), 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-blue: 0px 4px 6px -4px rgba(43, 127, 255, 0.3), 0px 10px 15px -3px rgba(43, 127, 255, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arimo', Arial, sans-serif;
            background: var(--white);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 256px;
            min-height: 100vh;
            background: var(--white);
            border-right: 0.91px solid var(--border);
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow);
        }

        .sidebar-header {
            padding: 24px 24px 0.71px;
            border-bottom: 0.91px solid var(--border);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .logo-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h2 {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--text-dark);
            margin: 0;
        }

        .logo-text p {
            font-size: 12px;
            font-weight: 400;
            line-height: 1.33;
            color: var(--text-dark);
            text-transform: uppercase;
            margin: 0;
        }

        .navigation {
            flex: 1;
            padding: 16px 0;
        }

        .nav-button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 0 0 16px;
            width: 223px;
            height: 44px;
            border-radius: 10px;
            margin-left: 16px;
            margin-bottom: 4px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-button.active {
            background: var(--gradient-primary);
            box-shadow: var(--shadow-blue);
        }

        .nav-button.active .nav-icon {
            color: var(--white);
        }

        .nav-button.active .nav-text {
            color: var(--white);
        }

        .nav-button:not(.active) {
            background: transparent;
        }

        .nav-button:not(.active) .nav-text {
            color: var(--nav-text);
        }

        .nav-button:not(.active) .nav-icon {
            color: var(--nav-text);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .nav-text {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
        }

        .sidebar-footer {
            padding: 16.9px 16px 0;
            border-top: 0.91px solid var(--border);
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0;
            width: 100%;
            height: 36px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-icon {
            width: 16px;
            height: 16px;
            color: var(--red);
        }

        .logout-text {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--red);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            background: var(--gradient-bg);
            min-height: 100vh;
            padding: 24px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 400;
            line-height: 1.2;
            background: var(--gradient-title);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .page-description {
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
            color: var(--text-gray);
            margin: 0;
        }

        .export-button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 12px;
            height: 36px;
            background: var(--gradient-primary);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: var(--shadow-blue);
        }

        .export-button:hover {
            opacity: 0.9;
        }

        .export-icon {
            width: 16px;
            height: 16px;
            color: var(--white);
        }

        .export-text {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--white);
        }

        /* Summary Cards */
        .summary-cards {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            flex: 1;
            background: var(--white-80);
            border-radius: 14px;
            padding: 16px 0 0 16px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        .summary-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-icon-container {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .summary-icon-container.blue {
            background: #DBEAFE;
        }

        .summary-icon-container.green {
            background: #DCFCE7;
        }

        .summary-icon-container.orange {
            background: #FEF3C6;
        }

        .summary-icon {
            width: 20px;
            height: 20px;
        }

        .summary-info {
            display: flex;
            flex-direction: column;
        }

        .summary-value {
            font-size: 24px;
            font-weight: 400;
            line-height: 1.33;
            color: var(--text-dark);
            margin: 0;
        }

        .summary-label {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--text-gray);
            margin: 0;
        }

        /* Filters */
        .filters-card {
            background: var(--white-80);
            border-radius: 14px;
            padding: 16px 0 0 16px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        .filters-content {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .filter-dropdown {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 0 12px;
            height: 36px;
            background: var(--white);
            border: 0.91px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--text-dark);
        }

        .filter-dropdown:hover {
            border-color: var(--border);
        }

        .search-container {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            height: 36px;
            padding: 4px 12px 4px 40px;
            background: var(--white);
            border: 0.91px solid transparent;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.15;
            color: var(--text-dark);
        }

        .search-input::placeholder {
            color: var(--text-gray);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--border);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #99A1AF;
        }

        /* Table */
        .table-card {
            background: var(--white-80);
            border-radius: 14px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .table-container {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header {
            background: linear-gradient(90deg, rgba(239, 246, 255, 1) 0%, rgba(238, 242, 255, 1) 100%);
            border-bottom: 0.91px solid rgba(0, 0, 0, 0.1);
        }

        .table-header th {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--text-dark);
        }

        .table-body {
            background: var(--white);
        }

        .table-body tr {
            border-bottom: 0.91px solid rgba(0, 0, 0, 0.1);
        }

        .table-body tr:last-child {
            border-bottom: none;
        }

        .table-body td {
            padding: 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
        }

        .action-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.33;
        }

        .action-badge.status {
            background: #DBEAFE;
            color: #1447E6;
        }

        .action-badge.priority {
            background: #FEF3C6;
            color: #BB4D00;
        }

        .action-badge.assigned {
            background: #DCFCE7;
            color: #008236;
        }

        .action-badge.unassigned {
            background: #FEE2E2;
            color: #DC2626;
        }

        .official-name {
            color: var(--text-dark);
            font-weight: 500;
        }

        .request-link {
            color: var(--blue);
            text-decoration: none;
            cursor: pointer;
        }

        .request-link:hover {
            text-decoration: underline;
        }

        .date-cell {
            color: var(--text-gray);
        }

        .change-value {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .change-arrow {
            width: 16px;
            height: 16px;
            opacity: 0.5;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: var(--text-gray);
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--text-gray);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <div class="logo-circle">
                        <img src="{{ asset('images/dashboard-logo.png') }}" alt="Logo">
                    </div>
                    <div class="logo-text">
                        <h2>Smart Neighborhood</h2>
                        <p>Official Portal</p>
                    </div>
                </div>
            </div>

            <nav class="navigation">
                <a href="/official/page" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="2.5" y="2.5" width="15" height="15" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M15 7.5H10.83L10 4.17L6.67 11.67H2.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="/all-requests/official" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="6.67" y="1.67" width="6.67" height="3.33" stroke="currentColor" stroke-width="1.67"/>
                        <rect x="3.33" y="3.33" width="13.33" height="15" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M10 9.17V13.33" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">All Requests</span>
                </a>
                <a href="/reports" class="nav-button active">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="3.33" y="1.67" width="13.33" height="16.67" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M6.67 9.17H6.67M6.67 13.33H6.67" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Activity Log</span>
                </a>
                <a href="/settings/official" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <path d="M2.54 1.68L17.47 1.68C17.47 1.68 17.47 1.68 17.47 1.68" stroke="currentColor" stroke-width="1.67"/>
                        <circle cx="7.5" cy="7.5" r="5" stroke="currentColor" stroke-width="1.67"/>
                    </svg>
                    <span class="nav-text">Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <button class="logout-button" id="logoutBtn">
                    <svg class="logout-icon" viewBox="0 0 16 16" fill="none">
                        <path d="M10.66 4.67L13.33 7.33L10.66 10" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        <path d="M6 8H13.33" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        <path d="M2 2V14" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                    </svg>
                    <span class="logout-text">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="page-title">Activity Log</h1>
                        <p class="page-description">Track all official actions and changes to maintenance requests</p>
                    </div>
                    <button class="export-button" id="exportBtn">
                        <svg class="export-icon" viewBox="0 0 16 16" fill="none">
                            <path d="M8 2V10" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                            <path d="M2 10H12" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                            <path d="M4.67 6.66L8 10L11.33 6.66" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        </svg>
                        <span class="export-text">Export Log</span>
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-content">
                        <div class="summary-icon-container blue">
                            <svg class="summary-icon" viewBox="0 0 20 20" fill="none">
                                <rect x="3.33" y="1.67" width="13.33" height="16.67" stroke="#155DFC" stroke-width="1.67"/>
                                <path d="M6.67 9.17H6.67M6.67 13.33H6.67" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="summary-info">
                            <p class="summary-value" id="totalActivities">0</p>
                            <p class="summary-label">Total Activities</p>
                        </div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-content">
                        <div class="summary-icon-container green">
                            <svg class="summary-icon" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 8.33L9.17 10L12.5 6.67" stroke="#00A63E" stroke-width="1.67" stroke-linecap="round"/>
                                <rect x="2.5" y="2.5" width="15" height="15" stroke="#00A63E" stroke-width="1.67"/>
                            </svg>
                        </div>
                        <div class="summary-info">
                            <p class="summary-value" id="statusChanges">0</p>
                            <p class="summary-label">Status Changes</p>
                        </div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-content">
                        <div class="summary-icon-container orange">
                            <svg class="summary-icon" viewBox="0 0 20 20" fill="none">
                                <rect x="1.65" y="2.49" width="16.68" height="15.01" stroke="#E17100" stroke-width="1.67"/>
                                <path d="M10 7.5V14.17" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="summary-info">
                            <p class="summary-value" id="assignments">0</p>
                            <p class="summary-label">Assignments</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <div class="filters-content">
                    <select class="filter-dropdown" id="actionFilter">
                        <option value="">All Actions</option>
                        <option value="status_changed">Status Changes</option>
                        <option value="priority_set">Priority Changes</option>
                        <option value="assigned">Assignments</option>
                        <option value="unassigned">Unassignments</option>
                    </select>
                    <div class="search-container">
                        <svg class="search-icon" viewBox="0 0 16 16" fill="none">
                            <circle cx="7.1" cy="7.1" r="2.89" stroke="currentColor" stroke-width="1.33"/>
                            <path d="M2 2L10.66 10.66" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        </svg>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search by official name or request...">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-card">
                <table class="table-container">
                    <thead class="table-header">
                        <tr>
                            <th>Date & Time</th>
                            <th>Official</th>
                            <th>Request</th>
                            <th>Action</th>
                            <th>Change</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody class="table-body" id="activityTableBody">
                        <tr>
                            <td colspan="6" class="loading">Loading activity log...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/reports.js') }}"></script>
</body>
</html>

