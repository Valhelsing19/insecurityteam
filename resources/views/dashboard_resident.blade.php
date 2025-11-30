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
                        <svg width="24" height="24" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_dd_12_6021)">
                                <path d="M12 16C12 8.26801 18.268 2 26 2H45.9688C53.7007 2 59.9688 8.26801 59.9688 16V35.9688C59.9688 43.7007 53.7007 49.9688 45.9688 49.9688H26C18.268 49.9688 12 43.7007 12 35.9688V16Z" fill="url(#paint0_linear_12_6021)" shape-rendering="crispEdges"/>
                                <path d="M38.9834 15.9878H32.9855C32.4334 15.9878 31.9858 16.4353 31.9858 16.9874V18.9867C31.9858 19.5388 32.4334 19.9864 32.9855 19.9864H38.9834C39.5354 19.9864 39.983 19.5388 39.983 18.9867V16.9874C39.983 16.4353 39.5354 15.9878 38.9834 15.9878Z" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M39.983 17.9871H41.9823C42.5126 17.9871 43.0211 18.1977 43.396 18.5726C43.771 18.9476 43.9816 19.4561 43.9816 19.9864V33.9814C43.9816 34.5116 43.771 35.0201 43.396 35.3951C43.0211 35.77 42.5126 35.9807 41.9823 35.9807H29.9866C29.4563 35.9807 28.9478 35.77 28.5729 35.3951C28.1979 35.0201 27.9873 34.5116 27.9873 33.9814V19.9864C27.9873 19.4561 28.1979 18.9476 28.5729 18.5726C28.9478 18.1977 29.4563 17.9871 29.9866 17.9871H31.9859" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M35.9846 24.9846H39.9832" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M35.9846 29.9829H39.9832" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M31.9858 24.9846H31.9958" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M31.9858 29.9829H31.9958" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <filter id="filter0_dd_12_6021" x="0" y="0" width="71.9688" height="71.9688" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_12_6021"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="3"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_12_6021"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="3" operator="erode" in="SourceAlpha" result="effect2_dropShadow_12_6021"/>
                                    <feOffset dy="10"/>
                                    <feGaussianBlur stdDeviation="7.5"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="effect1_dropShadow_12_6021" result="effect2_dropShadow_12_6021"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_12_6021" result="shape"/>
                                </filter>
                                <linearGradient id="paint0_linear_12_6021" x1="12" y1="2" x2="59.9688" y2="49.9688" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#2B7FFF"/>
                                    <stop offset="1" stop-color="#155DFC"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Pending</div>
                        <div class="stat-number" id="pendingRequests">0</div>
                    </div>
                    <div class="stat-icon orange">
                        <svg width="24" height="24" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_dd_12_6036)">
                                <path d="M12 16C12 8.26801 18.268 2 26 2H45.9688C53.7007 2 59.9688 8.26801 59.9688 16V35.9688C59.9688 43.7007 53.7007 49.9688 45.9688 49.9688H26C18.268 49.9688 12 43.7007 12 35.9688V16Z" fill="url(#paint0_linear_12_6036)" shape-rendering="crispEdges"/>
                                <path d="M35.9846 19.9863V25.9842L39.9832 27.9835" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M35.9845 35.9807C41.5054 35.9807 45.9809 31.5051 45.9809 25.9842C45.9809 20.4634 41.5054 15.9878 35.9845 15.9878C30.4636 15.9878 25.988 20.4634 25.988 25.9842C25.988 31.5051 30.4636 35.9807 35.9845 35.9807Z" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <filter id="filter0_dd_12_6036" x="0" y="0" width="71.9688" height="71.9688" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_12_6036"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="3"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_12_6036"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="3" operator="erode" in="SourceAlpha" result="effect2_dropShadow_12_6036"/>
                                    <feOffset dy="10"/>
                                    <feGaussianBlur stdDeviation="7.5"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="effect1_dropShadow_12_6036" result="effect2_dropShadow_12_6036"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_12_6036" result="shape"/>
                                </filter>
                                <linearGradient id="paint0_linear_12_6036" x1="12" y1="2" x2="59.9688" y2="49.9688" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FE9A00"/>
                                    <stop offset="1" stop-color="#E17100"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">In Progress</div>
                        <div class="stat-number" id="inProgressRequests">0</div>
                    </div>
                    <div class="stat-icon purple">
                        <svg width="24" height="24" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_dd_12_6047)">
                                <path d="M12 16C12 8.26801 18.268 2 26 2H45.9688C53.7007 2 59.9688 8.26801 59.9688 16V35.9688C59.9688 43.7007 53.7007 49.9688 45.9688 49.9688H26C18.268 49.9688 12 43.7007 12 35.9688V16Z" fill="url(#paint0_linear_12_6047)" shape-rendering="crispEdges"/>
                                <path d="M39.9829 20.9861H45.9808V26.984" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M45.9812 20.9861L37.4842 29.4831L32.486 24.4848L25.9883 30.9825" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <filter id="filter0_dd_12_6047" x="0" y="0" width="71.9688" height="71.9688" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_12_6047"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="3"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_12_6047"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="3" operator="erode" in="SourceAlpha" result="effect2_dropShadow_12_6047"/>
                                    <feOffset dy="10"/>
                                    <feGaussianBlur stdDeviation="7.5"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="effect1_dropShadow_12_6047" result="effect2_dropShadow_12_6047"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_12_6047" result="shape"/>
                                </filter>
                                <linearGradient id="paint0_linear_12_6047" x1="12" y1="2" x2="59.9688" y2="49.9688" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#615FFF"/>
                                    <stop offset="1" stop-color="#4F39F6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number" id="completedRequests">0</div>
            </div>
                    <div class="stat-icon green">
                        <svg width="24" height="24" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_dd_12_6058)">
                                <path d="M12 16C12 8.26801 18.268 2 26 2H45.9688C53.7007 2 59.9688 8.26801 59.9688 16V35.9688C59.9688 43.7007 53.7007 49.9688 45.9688 49.9688H26C18.268 49.9688 12 43.7007 12 35.9688V16Z" fill="url(#paint0_linear_12_6058)" shape-rendering="crispEdges"/>
                                <path d="M35.9847 35.9807C41.5056 35.9807 45.9812 31.5051 45.9812 25.9842C45.9812 20.4634 41.5056 15.9878 35.9847 15.9878C30.4638 15.9878 25.9883 20.4634 25.9883 25.9842C25.9883 31.5051 30.4638 35.9807 35.9847 35.9807Z" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M32.9854 25.9842L34.9846 27.9834L38.9832 23.9849" stroke="white" stroke-width="1.99929" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <filter id="filter0_dd_12_6058" x="0" y="0" width="71.9688" height="71.9688" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="4" operator="erode" in="SourceAlpha" result="effect1_dropShadow_12_6058"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="3"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_12_6058"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feMorphology radius="3" operator="erode" in="SourceAlpha" result="effect2_dropShadow_12_6058"/>
                                    <feOffset dy="10"/>
                                    <feGaussianBlur stdDeviation="7.5"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                    <feBlend mode="normal" in2="effect1_dropShadow_12_6058" result="effect2_dropShadow_12_6058"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_12_6058" result="shape"/>
                                </filter>
                                <linearGradient id="paint0_linear_12_6058" x1="12" y1="2" x2="59.9688" y2="49.9688" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#00C950"/>
                                    <stop offset="1" stop-color="#00A63E"/>
                                </linearGradient>
                            </defs>
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
