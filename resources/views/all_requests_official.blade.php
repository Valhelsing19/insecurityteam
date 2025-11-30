<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Neighborhood - All Requests</title>

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
            border-bottom: 0.71px solid var(--border);
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

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0;
            background: transparent;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--text-dark);
            margin-bottom: 16px;
        }

        .back-button:hover {
            opacity: 0.8;
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

        /* Statistics Cards */
        .stats-container {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            flex: 1;
            background: var(--white-80);
            border-radius: 14px;
            padding: 16px 0 0 16px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        .stat-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon-container {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon-container.pending {
            background: #FEF3C6;
        }

        .stat-icon-container.in-progress {
            background: #DBEAFE;
        }

        .stat-icon-container.completed {
            background: #DCFCE7;
        }

        .stat-icon {
            width: 20px;
            height: 20px;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 400;
            line-height: 1.33;
            color: var(--text-dark);
            margin: 0;
        }

        .stat-label {
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

        .filter-text {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-arrow {
            width: 16px;
            height: 16px;
            opacity: 0.5;
            color: var(--text-gray);
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
            padding: 8px;
            text-align: left;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            color: var(--text-dark);
        }

        .table-header th:first-child {
            padding-left: 8px;
            width: 224px;
        }

        .table-header th:nth-child(2) {
            width: 278px;
        }

        .table-header th:nth-child(3) {
            width: 128px;
        }

        .table-header th:nth-child(4) {
            width: 119px;
        }

        .table-header th:nth-child(5) {
            width: 169px;
        }

        .table-header th:last-child {
            width: 220px;
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
            padding: 8px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
        }

        .resident-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .resident-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(81, 162, 255, 1) 0%, rgba(97, 95, 255, 1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 14px;
            font-weight: 400;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .resident-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .resident-avatar-initials {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .resident-name {
            color: var(--text-dark);
        }

        .issue-cell {
            color: var(--text-dark);
        }

        .date-cell {
            color: var(--text-gray);
        }

        .priority-badge {
            display: inline-flex;
            align-items: center;
            padding: 1.9px 8.91px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.33;
            border: 0.91px solid transparent;
        }

        .priority-badge.high {
            background: #FFE2E2;
            color: #C10007;
        }

        .priority-badge.medium {
            background: #FEF3C6;
            color: #BB4D00;
        }

        .priority-badge.low {
            background: #DBEAFE;
            color: #1447E6;
        }

        .priority-badge.urgent {
            background: #FFE2E2;
            color: #C10007;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 1.9px 8.91px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.33;
            border: 0.91px solid transparent;
        }

        .status-badge.pending {
            background: #FEF3C6;
            color: #BB4D00;
        }

        .status-badge.active {
            background: #DBEAFE;
            color: #1447E6;
        }

        .status-badge.in-progress {
            background: #DBEAFE;
            color: #1447E6;
        }

        /* Dropdown styles for priority and status */
        .priority-dropdown-container, .status-dropdown-container {
            position: relative;
            display: inline-block;
        }

        .priority-clickable, .status-clickable {
            transition: all 0.2s ease;
        }

        .priority-clickable:hover, .status-clickable:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }

        .priority-dropdown, .status-dropdown {
            position: fixed !important;
            z-index: 10000 !important;
            background: white !important;
            border: 1px solid #ddd !important;
            border-radius: 4px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
            min-width: 120px !important;
        }

        .dropdown-item {
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            color: var(--text-dark);
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dropdown-item:first-child {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }

        .dropdown-item:last-child {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .status-badge.completed {
            background: #DCFCE7;
            color: #008236;
        }

        .status-badge.cancelled {
            background: #FEE2E2;
            color: #DC2626;
        }

        .status-icon {
            width: 12px;
            height: 12px;
        }

        .action-button {
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
            color: var(--text-gray);
        }

        .action-button:hover {
            border-color: var(--border);
        }

        .action-text {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-arrow {
            width: 16px;
            height: 16px;
            opacity: 0.5;
            color: var(--text-gray);
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

        /* Request Detail Modal */
        .request-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            position: relative;
            background: var(--white);
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            z-index: 10001;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 32px;
            color: var(--text-gray);
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .modal-close:hover {
            color: var(--text-dark);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-section {
            margin-bottom: 32px;
        }

        .modal-section:last-child {
            margin-bottom: 0;
        }

        .modal-section h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 16px 0;
        }

        .resident-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .modal-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(81, 162, 255, 1) 0%, rgba(97, 95, 255, 1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 24px;
            font-weight: 400;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .modal-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .modal-avatar-initials {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .resident-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .resident-name-large {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .resident-email {
            font-size: 14px;
            color: var(--text-gray);
            margin: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-item label {
            font-size: 12px;
            font-weight: 400;
            color: var(--text-gray);
        }

        .info-item span {
            font-size: 14px;
            font-weight: 400;
            color: var(--text-dark);
        }

        .description-text {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-dark);
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .media-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
        }

        .media-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            background: var(--border);
        }

        .media-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .media-image:hover {
            transform: scale(1.05);
        }

        .media-video {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .media-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            color: var(--blue);
            text-decoration: none;
            font-size: 14px;
        }

        .media-link:hover {
            text-decoration: underline;
        }

        /* Media Viewer */
        .media-viewer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10002;
            align-items: center;
            justify-content: center;
        }

        .viewer-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
        }

        .viewer-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            z-index: 10003;
        }

        .viewer-close {
            position: absolute;
            top: -40px;
            right: 0;
            background: none;
            border: none;
            font-size: 32px;
            color: var(--white);
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .viewer-image {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }

        .viewer-video {
            max-width: 100%;
            max-height: 90vh;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .media-gallery {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
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
                <a href="/dashboard/official" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="2.5" y="2.5" width="15" height="15" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M15 7.5H10.83L10 4.17L6.67 11.67H2.5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="/all-requests/official" class="nav-button active">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="6.67" y="1.67" width="6.67" height="3.33" stroke="currentColor" stroke-width="1.67"/>
                        <rect x="3.33" y="3.33" width="13.33" height="15" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M10 9.17V13.33" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">All Requests</span>
                </a>
                <a href="/reports" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                        <rect x="3.33" y="1.67" width="13.33" height="16.67" stroke="currentColor" stroke-width="1.67"/>
                        <path d="M6.67 9.17H6.67M6.67 13.33H6.67" stroke="currentColor" stroke-width="1.67" stroke-linecap="round"/>
                    </svg>
                    <span class="nav-text">Activity Log</span>
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
                <a href="/official/page" class="back-button">
                    ← Back to Dashboard
                </a>
                <div class="header-content">
                    <div class="header-text">
                        <h1 class="page-title">Request Management</h1>
                        <p class="page-description">Manage and assign maintenance requests</p>
                    </div>
                    <button class="export-button" id="exportBtn">
                        <svg class="export-icon" viewBox="0 0 16 16" fill="none">
                            <path d="M8 2V10" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                            <path d="M2 10H12" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                            <path d="M4.67 6.66L8 10L11.33 6.66" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        </svg>
                        <span class="export-text">Export Report</span>
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-icon-container pending">
                            <svg class="stat-icon" viewBox="0 0 20 20" fill="none">
                                <rect x="1.65" y="2.49" width="16.68" height="15.01" stroke="#E17100" stroke-width="1.67"/>
                                <path d="M10 7.5V14.17" stroke="#E17100" stroke-width="1.67" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <p class="stat-value" id="pendingCount">0</p>
                            <p class="stat-label">Pending Requests</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-icon-container in-progress">
                            <svg class="stat-icon" viewBox="0 0 20 20" fill="none">
                                <path d="M10 5V3.33" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/>
                                <path d="M1.67 1.67H16.67" stroke="#155DFC" stroke-width="1.67" stroke-linecap="round"/>
                                <rect x="1.67" y="1.67" width="16.67" height="16.67" stroke="#155DFC" stroke-width="1.67"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <p class="stat-value" id="inProgressCount">0</p>
                            <p class="stat-label">In Progress</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-icon-container completed">
                            <svg class="stat-icon" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 8.33L9.17 10L12.5 6.67" stroke="#00A63E" stroke-width="1.67" stroke-linecap="round"/>
                                <rect x="2.5" y="2.5" width="15" height="15" stroke="#00A63E" stroke-width="1.67"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <p class="stat-value" id="completedCount">0</p>
                            <p class="stat-label">Completed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <div class="filters-content">
                    <select class="filter-dropdown" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <select class="filter-dropdown" id="priorityFilter">
                        <option value="">All Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                    <div class="search-container">
                        <svg class="search-icon" viewBox="0 0 16 16" fill="none">
                            <circle cx="7.1" cy="7.1" r="2.89" stroke="currentColor" stroke-width="1.33"/>
                            <path d="M2 2L10.66 10.66" stroke="currentColor" stroke-width="1.33" stroke-linecap="round"/>
                        </svg>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search by resident or issue...">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-card">
                <table class="table-container">
                    <thead class="table-header">
                        <tr>
                            <th>Resident</th>
                            <th>Issue</th>
                            <th>Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-body" id="requestsTableBody">
                        <tr>
                            <td colspan="6" class="loading">Loading requests...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/all-requests-official.js') }}"></script>
</body>
</html>

