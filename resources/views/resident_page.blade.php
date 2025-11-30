<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Neighborhood - Resident Page</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/resident-page.css') }}">
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
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 17.5V10.8333C12.5 10.6123 12.4122 10.4004 12.2559 10.2441C12.0996 10.0878 11.8877 10 11.6667 10H8.33333C8.11232 10 7.90036 10.0878 7.74408 10.2441C7.5878 10.4004 7.5 10.6123 7.5 10.8333V17.5" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2.5 8.33333C2.49994 8.09088 2.55278 7.85135 2.65482 7.63142C2.75687 7.4115 2.90566 7.21649 3.09083 7.05999L8.92417 2.05999C9.22499 1.80575 9.60613 1.66626 10 1.66626C10.3939 1.66626 10.775 1.80575 11.0758 2.05999L16.9092 7.05999C17.0943 7.21649 17.2431 7.4115 17.3452 7.63142C17.4472 7.85135 17.5001 8.09088 17.5 8.33333V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Home</span>
                </a>
                <a href="/submit-request" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3_431)">
                            <path d="M9.99996 18.3333C14.6023 18.3333 18.3333 14.6023 18.3333 9.99996C18.3333 5.39759 14.6023 1.66663 9.99996 1.66663C5.39759 1.66663 1.66663 5.39759 1.66663 9.99996C1.66663 14.6023 5.39759 18.3333 9.99996 18.3333Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.66663 10H13.3333" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 6.66663V13.3333" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_3_431">
                                <rect width="20" height="20" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="nav-text">Submit Request</span>
                </a>
                <a href="/my-requests" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.00004 18.3333C4.55801 18.3333 4.13409 18.1577 3.82153 17.8451C3.50897 17.5326 3.33337 17.1087 3.33337 16.6666V3.3333C3.33337 2.89127 3.50897 2.46734 3.82153 2.15478C4.13409 1.84222 4.55801 1.66663 5.00004 1.66663H11.6667C11.9305 1.6662 12.1918 1.71796 12.4355 1.81894C12.6792 1.91991 12.9005 2.06809 13.0867 2.25496L16.0767 5.24496C16.2641 5.43122 16.4127 5.65275 16.514 5.89676C16.6152 6.14078 16.6667 6.40244 16.6667 6.66663V16.6666C16.6667 17.1087 16.4911 17.5326 16.1786 17.8451C15.866 18.1577 15.4421 18.3333 15 18.3333H5.00004Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.6666 1.66663V5.83329C11.6666 6.05431 11.7544 6.26627 11.9107 6.42255C12.067 6.57883 12.2789 6.66663 12.5 6.66663H16.6666" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.33329 7.5H6.66663" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.3333 10.8334H6.66663" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.3333 14.1666H6.66663" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">My Requests</span>
                </a>
                <a href="/settings" class="nav-button">
                    <svg class="nav-icon" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.05918 3.44663C8.10509 2.96358 8.32945 2.515 8.68843 2.18853C9.0474 1.86206 9.5152 1.68115 10.0004 1.68115C10.4857 1.68115 10.9535 1.86206 11.3124 2.18853C11.6714 2.515 11.8958 2.96358 11.9417 3.44663C11.9693 3.75868 12.0716 4.05948 12.2401 4.32358C12.4086 4.58768 12.6382 4.8073 12.9096 4.96386C13.1809 5.12042 13.486 5.2093 13.7989 5.22298C14.1119 5.23666 14.4235 5.17474 14.7075 5.04246C15.1484 4.84228 15.6481 4.81331 16.1092 4.9612C16.5703 5.10909 16.9599 5.42326 17.2021 5.84255C17.4443 6.26185 17.5219 6.75627 17.4197 7.22961C17.3175 7.70294 17.0428 8.12131 16.6492 8.4033C16.3928 8.58317 16.1836 8.82214 16.0391 9.09998C15.8946 9.37783 15.8192 9.68639 15.8192 9.99955C15.8192 10.3127 15.8946 10.6213 16.0391 10.8991C16.1836 11.177 16.3928 11.4159 16.6492 11.5958C17.0428 11.8778 17.3175 12.2962 17.4197 12.7695C17.5219 13.2428 17.4443 13.7372 17.2021 14.1565C16.9599 14.5758 16.5703 14.89 16.1092 15.0379C15.6481 15.1858 15.1484 15.1568 14.7075 14.9566C14.4235 14.8244 14.1119 14.7624 13.7989 14.7761C13.486 14.7898 13.1809 14.8787 12.9096 15.0352C12.6382 15.1918 12.4086 15.4114 12.2401 15.6755C12.0716 15.9396 11.9693 16.2404 11.9417 16.5525C11.8958 17.0355 11.6714 17.4841 11.3124 17.8106C10.9535 18.137 10.4857 18.3179 10.0004 18.3179C9.5152 18.3179 9.0474 18.137 8.68843 17.8106C8.32945 17.4841 8.10509 17.0355 8.05918 16.5525C8.03163 16.2403 7.92926 15.9394 7.76073 15.6752C7.5922 15.411 7.36249 15.1913 7.09104 15.0347C6.81959 14.8782 6.5144 14.7893 6.20133 14.7757C5.88825 14.7621 5.57651 14.8242 5.29251 14.9566C4.85158 15.1568 4.35195 15.1858 3.89084 15.0379C3.42974 14.89 3.04015 14.5758 2.79791 14.1565C2.55567 13.7372 2.47811 13.2428 2.58031 12.7695C2.68251 12.2962 2.95718 11.8778 3.35084 11.5958C3.60719 11.4159 3.81645 11.177 3.96092 10.8991C4.10538 10.6213 4.1808 10.3127 4.1808 9.99955C4.1808 9.68639 4.10538 9.37783 3.96092 9.09998C3.81645 8.82214 3.60719 8.58317 3.35084 8.4033C2.95773 8.12117 2.68355 7.70296 2.58159 7.22995C2.47964 6.75694 2.55718 6.26291 2.79916 5.84389C3.04114 5.42487 3.43027 5.11078 3.89092 4.96266C4.35157 4.81455 4.85083 4.84299 5.29168 5.04246C5.57564 5.17474 5.8873 5.23666 6.20026 5.22298C6.51322 5.2093 6.81829 5.12042 7.08962 4.96386C7.36096 4.8073 7.59059 4.58768 7.75906 4.32358C7.92754 4.05948 8.02991 3.75868 8.05751 3.44663" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <button class="logout-button">
                    <svg class="logout-icon" viewBox="0 0 16 16" fill="none">
                        <path d="M10.66 4.66L13.33 7.33L10.66 10" stroke="#E7000B" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.33 7.33H6" stroke="#E7000B" stroke-width="1.33" stroke-linecap="round"/>
                        <path d="M6 8H2" stroke="#E7000B" stroke-width="1.33" stroke-linecap="round"/>
                        <path d="M2 2V14" stroke="#E7000B" stroke-width="1.33" stroke-linecap="round"/>
                    </svg>
                    <span class="logout-text">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="welcome-badges">
                        <span class="welcome-badge">Welcome Back</span>
                        <span class="welcome-badge">resident</span>
                    </div>
                    <h1 class="welcome-title">Smart Neighborhood System</h1>
                    <p class="welcome-description">Manage your maintenance requests and stay updated with neighborhood activities</p>
                    <div class="welcome-actions">
                        <a href="/submit-request" class="welcome-button primary">
                            <span>Submit Request</span>
                            <svg class="welcome-icon" viewBox="0 0 16 16" fill="none">
                                <path d="M6 12L10 8L6 4" stroke="#155DFC" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Onboarding Message for New Users -->
            <div id="onboarding-message" class="onboarding-message" style="display: none;">
                <div class="onboarding-content">
                    <svg class="onboarding-icon" viewBox="0 0 20 20" fill="none">
                        <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="2"/>
                        <path d="M10 6V10M10 14H10.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <div class="onboarding-text">
                        <h3>Welcome to Smart Neighborhood!</h3>
                        <p>Get started by submitting your first maintenance request. Our team is here to help keep your neighborhood in great shape.</p>
                    </div>
                    <button class="onboarding-close" onclick="this.parentElement.parentElement.style.display='none'">
                        <svg viewBox="0 0 16 16" fill="none">
                            <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Active Requests</div>
                        <div class="stat-number" id="stat-active">0</div>
                    </div>
                    <div class="stat-icon blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9978 5.9989V11.9978L15.9971 13.9974" stroke="#155DFC" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.9977 21.9959C17.5195 21.9959 21.9958 17.5196 21.9958 11.9978C21.9958 6.47595 17.5195 1.99963 11.9977 1.99963C6.47583 1.99963 1.99951 6.47595 1.99951 11.9978C1.99951 17.5196 6.47583 21.9959 11.9977 21.9959Z" stroke="#155DFC" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number" id="stat-completed">0</div>
                    </div>
                    <div class="stat-icon green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.9977 21.9959C17.5195 21.9959 21.9958 17.5196 21.9958 11.9978C21.9958 6.47595 17.5195 1.99963 11.9977 1.99963C6.47583 1.99963 1.99951 6.47595 1.99951 11.9978C1.99951 17.5196 6.47583 21.9959 11.9977 21.9959Z" stroke="#00A63E" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.99829 11.9978L10.9979 13.9974L14.9972 9.99817" stroke="#00A63E" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Pending Review</div>
                        <div class="stat-number" id="stat-pending">0</div>
                    </div>
                    <div class="stat-icon orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.726 17.9967L13.7275 3.9993C13.5531 3.69157 13.3002 3.4356 12.9946 3.25751C12.6889 3.07942 12.3415 2.9856 11.9878 2.9856C11.6341 2.9856 11.2867 3.07942 10.9811 3.25751C10.6755 3.4356 10.4226 3.69157 10.2481 3.9993L2.24964 17.9967C2.07335 18.302 1.98091 18.6485 1.98169 19.001C1.98248 19.3536 2.07645 19.6996 2.25408 20.0042C2.43172 20.3087 2.6867 20.5608 2.99319 20.735C3.29968 20.9092 3.64678 20.9993 3.99931 20.9961H19.9963C20.3472 20.9958 20.6917 20.9031 20.9954 20.7275C21.2991 20.5518 21.5513 20.2994 21.7265 19.9954C21.9018 19.6915 21.994 19.3468 21.9939 18.996C21.9938 18.6452 21.9014 18.3005 21.726 17.9967Z" stroke="#E17100" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.9978 8.99829V12.9983" stroke="#E17100" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.9978 16.9968H12.0078" stroke="#E17100" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2 class="section-title">Quick Actions</h2>
                <div class="actions-grid">
                    <div class="action-card">
                        <div class="action-image" style="background: var(--gradient-blue);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9978 21.9959C17.5196 21.9959 21.9959 17.5196 21.9959 11.9978C21.9959 6.47595 17.5196 1.99963 11.9978 1.99963C6.47595 1.99963 1.99963 6.47595 1.99963 11.9978C1.99963 17.5196 6.47595 21.9959 11.9978 21.9959Z" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.99854 11.9978H15.997" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.9978 7.99854V15.997" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Submit New Request</h3>
                            <p class="action-description">Report a maintenance issue</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-image" style="background: var(--gradient-purple);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.9989 21.9959C5.46856 21.9959 4.95995 21.7852 4.58494 21.4102C4.20994 21.0352 3.99927 20.5266 3.99927 19.9963V3.99926C3.99927 3.46893 4.20994 2.96032 4.58494 2.58531C4.95995 2.21031 5.46856 1.99964 5.9989 1.99964H13.9974C14.3139 1.99912 14.6274 2.06123 14.9198 2.18237C15.2122 2.30352 15.4777 2.48131 15.7011 2.70551L19.2884 6.29284C19.5132 6.5163 19.6915 6.78209 19.813 7.07485C19.9345 7.36762 19.9968 7.68155 19.9963 7.99852V19.9963C19.9963 20.5266 19.7856 21.0352 19.4106 21.4102C19.0356 21.7852 18.527 21.9959 17.9967 21.9959H5.9989Z" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.9973 1.99963V6.9987C13.9973 7.26387 14.1027 7.51818 14.2902 7.70568C14.4777 7.89318 14.732 7.99852 14.9971 7.99852H19.9962" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.99854 8.99829H7.99854" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.997 12.9976H7.99854" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.997 16.9968H7.99854" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">View My Requests</h3>
                            <p class="action-description">Track your submissions</p>
                        </div>
                    </div>

                    <div class="action-card">
                        <div class="action-image" style="background: var(--gradient-green);">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.9971 6.99866H21.996V12.9975" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21.9958 6.99866L13.4974 15.4971L8.4983 10.498L1.99951 16.9968" stroke="white" stroke-width="1.99963" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Dashboard</h3>
                            <p class="action-description">View statistics & insights</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="bottom-section">
                <div class="left-column">
                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <div class="activity-header">
                            <h3 class="section-title">Recent Activity</h3>
                            <button class="view-all-button">
                                <span>View All</span>
                                <svg class="view-all-icon" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                        <div class="activity-list">
                            <!-- Activity items will be dynamically loaded here -->
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <!-- Announcements -->
                    <div class="announcements">
                        <div class="announcements-header">
                            <div style="display: flex; align-items: center; gap: 8px;">
                            <svg class="announcements-icon" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.05098 11.9384C0.942114 12.0577 0.870271 12.2061 0.844189 12.3655C0.818107 12.5249 0.838909 12.6884 0.904065 12.8362C0.969221 12.984 1.07592 13.1097 1.21119 13.1979C1.34646 13.2862 1.50446 13.3333 1.66598 13.3334H14.9993C15.1608 13.3334 15.3188 13.2866 15.4542 13.1985C15.5896 13.1104 15.6964 12.9848 15.7617 12.8371C15.827 12.6894 15.8481 12.5259 15.8222 12.3665C15.7963 12.2071 15.7247 12.0587 15.616 11.9392C14.5076 10.7967 13.3326 9.58254 13.3326 5.83337C13.3326 4.50729 12.8059 3.23552 11.8682 2.29784C10.9305 1.36016 9.65873 0.833374 8.33264 0.833374C7.00656 0.833374 5.73479 1.36016 4.79711 2.29784C3.85943 3.23552 3.33264 4.50729 3.33264 5.83337C3.33264 9.58254 2.15681 10.7967 1.05098 11.9384Z" stroke="#155DFC" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h2 class="section-title">Announcements</h2>
                        </div>
                            <button class="view-all-button" id="announcements-view-all">
                                <span>View All</span>
                                <svg class="view-all-icon" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                            </button>
                            </div>

                        <div class="announcements-list" id="announcements-list">
                            <!-- Announcements will be dynamically loaded here -->
                            <div class="announcement-loading">Loading announcements...</div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Announcement Modal -->
    <div id="announcement-modal" class="announcement-modal" style="display: none;">
        <div class="modal-overlay" onclick="closeAnnouncementModal()"></div>
        <div class="modal-content">
            <button class="modal-close" onclick="closeAnnouncementModal()">
                <svg viewBox="0 0 16 16" fill="none">
                    <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="modal-header">
                <div class="modal-badge" id="modal-badge"></div>
                <h2 class="modal-title" id="modal-title"></h2>
                <p class="modal-time" id="modal-time"></p>
            </div>
            <div class="modal-body">
                <div class="modal-section">
                    <h3 class="modal-section-title">Description</h3>
                    <p class="modal-description" id="modal-description"></p>
                </div>
                <div class="modal-details" id="modal-details"></div>
                <div id="modal-media" class="modal-media-section" style="display: none;"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/resident-page.js') }}"></script>
</body>
</html>


