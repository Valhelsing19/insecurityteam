<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Resident Portal - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=roboto:300,400,500,600,700,800|archivo:600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-roboto">
    <div class="flex">
        <!-- Sidebar -->
        <div class="side-menu w-64 h-screen relative" style="background: #FFF0CE;">
            <!-- Smart Neighborhood Logo -->
            <div class="smart-logo absolute -left-3.5 -top-3 w-[107px] h-[107px] rounded-full">
                <img src="https://api.builder.io/api/v1/image/assets/TEMP/4a00650bb18ea53527b58cf2099a4393807a54cf?width=214"
                     alt="Smart Neighborhood Logo"
                     class="w-full h-full rounded-full object-cover">
            </div>

            <!-- Portal Title -->
            <div class="portal-title absolute left-[84px] top-[23px] text-black font-roboto text-xl font-bold">
                Smart Resident Portal
            </div>

            <!-- Dashboard Title -->
            <div class="dashboard-title absolute left-7 top-[117px] text-black font-roboto text-2xl font-extrabold">
                Dashboard
            </div>

            <!-- Menu Items -->
            <div class="menu-items absolute top-[180px] w-full">
                <!-- Profile -->
                <div class="profile-menu flex items-center px-7 py-3" style="background: #D7D7D7;">
                    <span class="text-black font-archivo text-base font-bold">Profile</span>
                    <svg class="ml-auto w-3 h-5 fill-black" viewBox="0 0 12 20">
                        <path d="M11.77 1.77L10 0L0 10L10 20L11.77 18.23L3.54 10L11.77 1.77Z"/>
                    </svg>
                </div>

                <!-- Submit Request -->
                <div class="submit-request-menu flex items-center px-7 py-2" style="background: #D7D7D7;">
                    <span class="text-black font-archivo text-base font-bold">Submit Request</span>
                    <svg class="ml-auto w-3 h-5 fill-black" viewBox="0 0 12 20">
                        <path d="M11.77 1.77L10 0L0 10L10 20L11.77 18.23L3.54 10L11.77 1.77Z"/>
                    </svg>
                </div>

                <!-- Request Management -->
                <div class="request-management-menu flex items-center px-7 py-2" style="background: #D7D7D7;">
                    <span class="text-black font-archivo text-base font-bold">Request Management</span>
                    <svg class="ml-auto w-3 h-5 fill-black" viewBox="0 0 12 20">
                        <path d="M11.77 1.77L10 0L0 10L10 20L11.77 18.23L3.54 10L11.77 1.77Z"/>
                    </svg>
                </div>

                <!-- Settings -->
                <div class="settings-menu flex items-center px-7 py-2" style="background: #D7D7D7;">
                    <span class="text-black font-archivo text-base font-bold">Settings</span>
                    <svg class="ml-auto w-3 h-5 fill-black" viewBox="0 0 12 20">
                        <path d="M11.77 1.77L10 0L0 10L10 20L11.77 18.23L3.54 10L11.77 1.77Z"/>
                    </svg>
                </div>
            </div>

            <!-- Logout Section -->
            <div class="logout-section absolute bottom-0 w-full h-[70px] shadow-inner flex items-center px-3" style="background: #EBCB90; border-top: 1px solid rgba(146, 146, 146, 0.78);">
                <svg class="logout-icon w-6 h-6" viewBox="0 0 24 24" fill="none">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke="#A50303" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="logout-text text-red-700 font-archivo text-sm font-semibold ml-4">Log out</span>
                <img src="https://api.builder.io/api/v1/image/assets/TEMP/5314336acc9c3daf32aecca2c2c33af25e59e85d?width=82"
                     alt="User Avatar"
                     class="user-avatar w-10 h-10 rounded-full ml-auto">
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content flex-1">
            <!-- Top Header Bar -->
            <div class="top-header h-[83px] shadow-lg flex items-center justify-end px-8" style="background: #EBCB90;">
                <!-- Admin Login Button -->
                <div class="admin-login flex items-center">
                    <svg class="admin-icon w-6 h-5" viewBox="0 0 24 21" fill="none">
                        <path d="M12 0.875L3 4.375V9.625C3 14.4812 6.84 19.0225 12 20.125C17.16 19.0225 21 14.4812 21 9.625V4.375L12 0.875ZM12 4.2875C12.5933 4.2875 13.1734 4.44145 13.6667 4.72989C14.1601 5.01833 14.5446 5.4283 14.7716 5.90796C14.9987 6.38761 15.0581 6.91541 14.9424 7.42461C14.8266 7.93381 14.5409 8.40154 14.1213 8.76866C13.7018 9.13577 13.1672 9.38577 12.5853 9.48706C12.0033 9.58835 11.4001 9.53636 10.8519 9.33768C10.3038 9.139 9.83524 8.80255 9.50559 8.37087C9.17595 7.93919 9 7.43168 9 6.9125C9 6.21631 9.31607 5.54863 9.87868 5.05634C10.4413 4.56406 11.2044 4.2875 12 4.2875ZM12 11.2C14 11.2 18 12.1538 18 13.895C17.3432 14.7614 16.4516 15.472 15.4047 15.9636C14.3578 16.4553 13.1881 16.7125 12 16.7125C10.8119 16.7125 9.64218 16.4553 8.59527 15.9636C7.54836 15.472 6.65677 14.7614 6 13.895C6 12.1538 10 11.2 12 11.2Z" fill="black"/>
                    </svg>
                    <span class="admin-text text-black font-roboto text-xs font-bold ml-2">Login as Official</span>
                </div>

                <!-- Notification Icon -->
                <svg class="notification-icon w-4 h-5 fill-black ml-8" viewBox="0 0 17 20">
                    <path d="M8 20C7.45 20 6.97917 19.8042 6.5875 19.4125C6.19583 19.0208 6 18.55 6 18H10C10 18.55 9.80417 19.0208 9.4125 19.4125C9.02083 19.8042 8.55 20 8 20ZM1 17C0.716667 17 0.479167 16.9042 0.2875 16.7125C0.0958333 16.5208 0 16.2833 0 16C0 15.7167 0.0958333 15.4792 0.2875 15.2875C0.479167 15.0958 0.716667 15 1 15H2V8C2 6.61667 2.41667 5.3875 3.25 4.3125C4.08333 3.2375 5.16667 2.53333 6.5 2.2V1.5C6.5 1.08333 6.64583 0.729167 6.9375 0.4375C7.22917 0.145833 7.58333 0 8 0C8.41667 0 8.77083 0.145833 9.0625 0.4375C9.35417 0.729167 9.5 1.08333 9.5 1.5V1.825C9.33333 2.15833 9.20833 2.50833 9.125 2.875C9.04167 3.24167 9 3.61667 9 4C9 5.38333 9.4875 6.5625 10.4625 7.5375C11.4375 8.5125 12.6167 9 14 9V15H15C15.2833 15 15.5208 15.0958 15.7125 15.2875C15.9042 15.4792 16 15.7167 16 16C16 16.2833 15.9042 16.5208 15.7125 16.7125C15.5208 16.9042 15.2833 17 15 17H1ZM14 7C13.1667 7 12.4583 6.70833 11.875 6.125C11.2917 5.54167 11 4.83333 11 4C11 3.16667 11.2917 2.45833 11.875 1.875C12.4583 1.29167 13.1667 1 14 1C14.8333 1 15.5417 1.29167 16.125 1.875C16.7083 2.45833 17 3.16667 17 4C17 4.83333 16.7083 5.54167 16.125 6.125C15.5417 6.70833 14.8333 7 14 7Z"/>
                </svg>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content p-8 min-h-screen" style="background: #EEE;">
                <!-- Welcome Section -->
                <div class="welcome-section mb-8">
                    <div class="welcome-title flex items-center text-black font-roboto text-3xl font-bold mb-2">
                        Welcome back, Lyndon!
                        <svg class="wave-icon w-6 h-6 ml-2" viewBox="0 0 22 22" fill="none">
                            <path d="M9.45726 4.2534C9.57435 4.1364 9.71337 4.04364 9.86636 3.98044C10.0193 3.91724 10.1833 3.88484 10.3488 3.8851C10.5144 3.88535 10.6782 3.91826 10.831 3.98193C10.9838 4.0456 11.1225 4.13879 11.2393 4.25615L16.0554 9.09799L15.6475 8.09424C15.1342 6.82924 16.5697 5.66507 17.7008 6.42682C17.875 6.54324 18.0189 6.69724 18.1234 6.87599L20.3051 10.6123C21.0393 11.87 21.3364 13.3354 21.1498 14.7797C20.9632 16.224 20.3036 17.5658 19.2738 18.5956L18.5002 19.3692C17.2642 20.6052 15.5878 21.2996 13.8398 21.2996C12.0919 21.2996 10.4155 20.6052 9.17951 19.3692L4.56501 14.7538C4.33119 14.517 4.20054 14.1973 4.20157 13.8644C4.2026 13.5316 4.33522 13.2127 4.5705 12.9773C4.80578 12.7419 5.12462 12.6091 5.45743 12.6079C5.79025 12.6067 6.11004 12.7372 6.34701 12.9709L7.81734 14.4412L8.30409 13.9545L4.92159 10.572C4.68777 10.3351 4.55712 10.0154 4.55815 9.6826C4.55918 9.34978 4.6918 9.03087 4.92708 8.79547C5.16236 8.56007 5.4812 8.42728 5.81402 8.42608C6.14684 8.42489 6.46662 8.55537 6.70359 8.78907L10.0861 12.1716L10.5719 11.6857L5.93726 7.05015C5.81388 6.93467 5.71499 6.79555 5.64646 6.64107C5.57793 6.48659 5.54117 6.31991 5.53836 6.15094C5.53554 5.98196 5.56674 5.81415 5.63009 5.65748C5.69344 5.50081 5.78765 5.35847 5.90712 5.23895C6.02659 5.11942 6.16887 5.02513 6.32551 4.9617C6.48215 4.89827 6.64995 4.86699 6.81892 4.86971C6.9879 4.87244 7.1546 4.90911 7.30911 4.97756C7.46362 5.04601 7.60279 5.14483 7.71834 5.26815L12.3539 9.90374L12.8398 9.4179L9.45634 6.03357C9.33943 5.91669 9.24669 5.77793 9.18342 5.62521C9.12015 5.47249 9.08758 5.3088 9.08758 5.14349C9.08758 4.97818 9.12015 4.81448 9.18342 4.66176C9.24669 4.50904 9.33943 4.37028 9.45634 4.2534M16.4817 1.41724L17.2361 1.93699C18.342 2.70058 19.2999 3.65879 20.0631 4.7649L20.5828 5.51932L19.074 6.55974L18.5533 5.8044C17.9166 4.88231 17.1178 4.08347 16.1957 3.44674L15.4403 2.92607L16.4817 1.41724ZM2.92509 15.4404L3.44576 16.1957C4.08277 17.1179 4.88192 17.9168 5.80434 18.5534L6.55876 19.0741L5.51834 20.5829L4.76393 20.0632C3.65781 19.2999 2.6996 18.342 1.93601 17.2362L1.41626 16.4808L2.92509 15.4404Z" fill="#FFCD29"/>
                        </svg>
                    </div>
                    <p class="welcome-subtitle text-black font-roboto text-xl font-normal">Here's what's happening with your maintenance requests</p>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid grid grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                    <!-- Active Requests -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-sm">
                        <div class="stat-icon w-12 h-12 bg-amber-700 rounded-lg mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8" viewBox="0 0 30 30" fill="none">
                                <path d="M26.9133 6.83672L23.1633 3.08672C23.0762 2.99956 22.9728 2.93041 22.859 2.88323C22.7452 2.83605 22.6232 2.81177 22.5 2.81177C22.3768 2.81177 22.2548 2.83605 22.141 2.88323C22.0272 2.93041 21.9238 2.99956 21.8367 3.08672L10.5867 14.3367C10.4997 14.4239 10.4307 14.5273 10.3836 14.6411C10.3366 14.7549 10.3124 14.8769 10.3125 15V18.75C10.3125 18.9986 10.4113 19.2371 10.5871 19.4129C10.7629 19.5887 11.0014 19.6875 11.25 19.6875H15C15.1232 19.6876 15.2451 19.6634 15.3589 19.6164C15.4727 19.5693 15.5762 19.5003 15.6633 19.4133L26.9133 8.16329C27.0004 8.07622 27.0696 7.97282 27.1168 7.85901C27.164 7.7452 27.1882 7.62321 27.1882 7.50001C27.1882 7.3768 27.164 7.25481 27.1168 7.141C27.0696 7.02719 27.0004 6.92379 26.9133 6.83672ZM14.6121 17.8125H12.1875V15.3879L19.6875 7.8879L22.1121 10.3125L14.6121 17.8125ZM23.4375 8.98711L21.0129 6.56251L22.5 5.0754L24.9246 7.50001L23.4375 8.98711ZM26.25 15V24.375C26.25 24.8723 26.0525 25.3492 25.7008 25.7008C25.3492 26.0525 24.8723 26.25 24.375 26.25H5.625C5.12772 26.25 4.65081 26.0525 4.29917 25.7008C3.94754 25.3492 3.75 24.8723 3.75 24.375V5.62501C3.75 5.12772 3.94754 4.65081 4.29917 4.29918C4.65081 3.94755 5.12772 3.75 5.625 3.75H15C15.2486 3.75 15.4871 3.84878 15.6629 4.02459C15.8387 4.20041 15.9375 4.43886 15.9375 4.68751C15.9375 4.93615 15.8387 5.1746 15.6629 5.35042C15.4871 5.52623 15.2486 5.62501 15 5.62501H5.625V24.375H24.375V15C24.375 14.7514 24.4738 14.5129 24.6496 14.3371C24.8254 14.1613 25.0639 14.0625 25.3125 14.0625C25.5611 14.0625 25.7996 14.1613 25.9754 14.3371C26.1512 14.5129 26.25 14.7514 26.25 15Z" fill="#FCD19C"/>
                            </svg>
                        </div>
                        <div class="stat-label text-black font-roboto text-xs font-light mb-2">Active Requests</div>
                        <div class="stat-number text-black font-roboto text-xl font-bold">3</div>
                    </div>

                    <!-- Resolved -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-sm">
                        <div class="stat-icon w-12 h-12 bg-green-400 rounded-lg mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8" viewBox="0 0 30 30" fill="none">
                                <path d="M25.3125 4.6875H4.6875C4.19022 4.6875 3.71331 4.88504 3.36167 5.23667C3.01004 5.58831 2.8125 6.06522 2.8125 6.5625V23.4375C2.8125 23.9348 3.01004 24.4117 3.36167 24.7633C3.71331 25.115 4.19022 25.3125 4.6875 25.3125H25.3125C25.8098 25.3125 26.2867 25.115 26.6383 24.7633C26.99 24.4117 27.1875 23.9348 27.1875 23.4375V6.5625C27.1875 6.06522 26.99 5.58831 26.6383 5.23667C26.2867 4.88504 25.8098 4.6875 25.3125 4.6875ZM24.1008 10.0383L12.8508 21.2883C12.7637 21.3754 12.6603 21.4446 12.5465 21.4918C12.4327 21.539 12.3107 21.5632 12.1875 21.5632C12.0643 21.5632 11.9423 21.539 11.8285 21.4918C11.7147 21.4446 11.6113 21.3754 11.5242 21.2883L6.83672 16.6008C6.66081 16.4249 6.56198 16.1863 6.56198 15.9375C6.56198 15.6887 6.66081 15.4501 6.83672 15.2742C7.01263 15.0983 7.25122 14.9995 7.5 14.9995C7.74878 14.9995 7.98737 15.0983 8.16328 15.2742L12.1875 19.2996L22.7742 8.71172C22.9501 8.53581 23.1887 8.43698 23.4375 8.43698C23.6863 8.43698 23.9249 8.53581 24.1008 8.71172C24.2767 8.88763 24.3755 9.12622 24.3755 9.375C24.3755 9.62378 24.2767 9.86237 24.1008 10.0383Z" fill="#14AE5C"/>
                            </svg>
                        </div>
                        <div class="stat-label text-black font-roboto text-xs font-light mb-2">Resolved</div>
                        <div class="stat-number text-black font-roboto text-xl font-bold">12</div>
                    </div>

                    <!-- In Progress -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-sm">
                        <div class="stat-icon w-12 h-12 bg-amber-500 rounded-lg mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8" viewBox="0 0 30 30" fill="none">
                                <path d="M7.5 5H5V2.5H25V5H22.5V7.5C22.5 9.51875 21.48 11.1438 20.195 12.4713C19.3162 13.3787 18.2475 14.215 17.1637 15C18.2475 15.785 19.3162 16.6213 20.195 17.5287C21.48 18.8562 22.5 20.4813 22.5 22.5V25H25V27.5H5V25H7.5V22.5C7.5 20.4813 8.52 18.8562 9.805 17.5287C10.6837 16.6213 11.7525 15.785 12.8363 15C11.7525 14.215 10.6837 13.3787 9.805 12.4713C8.52 11.1438 7.5 9.51875 7.5 7.5V5ZM10 5V7.5C10 8.35625 10.325 9.16875 10.9637 10H19.0363C19.6737 9.16875 20 8.35625 20 7.5V5H10ZM15 16.5275C13.6938 17.45 12.51 18.3287 11.6013 19.2675C11.3754 19.4997 11.1625 19.7442 10.9637 20H19.0363C18.8375 19.7442 18.6246 19.4997 18.3988 19.2675C17.49 18.3287 16.3062 17.45 15 16.5275Z" fill="#FFE8A3"/>
                            </svg>
                        </div>
                        <div class="stat-label text-black font-roboto text-xs font-light mb-2">In Progress</div>
                        <div class="stat-number text-black font-roboto text-xl font-bold">8</div>
                    </div>

                    <!-- Pending Feedback -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-sm">
                        <div class="stat-icon w-12 h-12 bg-blue-300 rounded-lg mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8" viewBox="0 0 30 30" fill="none">
                                <path d="M10.625 18.125H19.375M10.625 11.875H15" stroke="#E4CCFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.7125 26.1125C22.9425 25.7663 27.1075 21.5413 27.45 16.2375C27.5163 15.2 27.5163 14.125 27.45 13.0875C27.1075 7.78504 22.9425 3.56254 17.7125 3.21379C15.9062 3.09475 14.0939 3.09475 12.2875 3.21379C7.05753 3.56129 2.89253 7.78504 2.55003 13.0888C2.48381 14.1377 2.48381 15.1898 2.55003 16.2388C2.67503 18.17 3.52878 19.9588 4.53503 21.4688C5.11878 22.525 4.73378 23.8438 4.12503 24.9975C3.68753 25.8288 3.46753 26.2438 3.64378 26.5438C3.81878 26.8438 4.21253 26.8538 4.99878 26.8725C6.55503 26.91 7.60378 26.47 8.43628 25.8563C8.90753 25.5075 9.14378 25.3338 9.30628 25.3138C9.46878 25.2938 9.79003 25.4263 10.43 25.6888C11.005 25.9263 11.6738 26.0725 12.2863 26.1138C14.0675 26.2313 15.9288 26.2313 17.7138 26.1138L17.7125 26.1125Z" stroke="#E4CCFF" stroke-width="1.5" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="stat-label text-black font-roboto text-xs font-light mb-2">Pending Feedback</div>
                        <div class="stat-number text-black font-roboto text-xl font-bold">2</div>
                    </div>
                </div>

                <!-- Report New Issues Section -->
                <div class="report-section rounded-2xl p-8 mb-8 text-white relative" style="background: #3396D3;">
                    <h3 class="report-title font-roboto text-xl font-bold mb-2">Report a New Issues</h3>
                    <p class="report-subtitle font-roboto text-xs font-normal mb-6">Help us maintain our community by reporting issues in your neighborhood</p>

                    <button class="submit-btn bg-white text-blue-500 px-8 py-2 rounded-full font-roboto text-xs font-bold hover:bg-gray-100 transition-colors">
                        Submit Request
                    </button>

                    <!-- Arrow Icon -->
                    <svg class="submit-arrow absolute top-2 right-8 w-3 h-4 fill-blue-500 transform -rotate-12" viewBox="0 0 12 17">
                        <path d="M5.06319 16.0841L11.5634 0.812742L0.00430186 3.44642L1.96735 8.36534L8.98224 3.37182L3.09154 11.1737L5.06319 16.0841Z"/>
                    </svg>
                </div>

                <!-- My Recent Request Section -->
                <div class="recent-requests">
                    <div class="section-header flex items-center justify-between mb-6">
                        <h3 class="section-title text-black font-roboto text-xl font-medium">My Recent Request</h3>

                        <!-- Filter Tabs -->
                        <div class="filter-tabs flex gap-4">
                            <button class="tab-btn active bg-blue-500 text-white px-4 py-1 rounded-full font-roboto text-xl font-medium">All</button>
                            <button class="tab-btn text-black px-4 py-1 rounded-full font-roboto text-xl font-medium hover:bg-gray-200">In Progress</button>
                            <button class="tab-btn text-black px-4 py-1 rounded-full font-roboto text-xl font-medium hover:bg-gray-200">Completed</button>
                            <button class="tab-btn text-black px-4 py-1 rounded-full font-roboto text-xl font-medium hover:bg-gray-200">Pending</button>
                        </div>
                    </div>

                    <!-- Request Cards Grid -->
                    <div class="requests-grid grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Broken Streetlight Request -->
                        <div class="request-card bg-white rounded-2xl shadow-lg">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/4d5605873da8ba8ab703a520dfcf7b72bbc84f67?width=792"
                                 alt="Broken Streetlight"
                                 class="request-image w-full h-40 object-cover rounded-t-2xl">
                            <div class="request-content p-6">
                                <div class="request-header flex items-center justify-between mb-4">
                                    <h4 class="request-title text-black font-roboto text-xl font-bold">Broken Streetlight</h4>
                                    <span class="status-badge in-progress bg-blue-500 text-white px-4 py-1 rounded-full font-roboto text-xl font-medium">In Progress</span>
                                </div>
                                <p class="request-description text-black font-roboto text-xl font-normal mb-6 text-center">Streetlight near corner of Main St. and 5th Ave has been out for 3 days. Safety concern at night.</p>

                                <hr class="border-black mb-4">

                                <div class="request-footer flex items-center justify-between">
                                    <div class="location flex items-center">
                                        <svg class="location-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M15.75 4.49995C15.7499 3.79041 15.5486 3.09544 15.1693 2.49577C14.79 1.8961 14.2484 1.41633 13.6074 1.1122C12.9663 0.808068 12.2521 0.692047 11.5478 0.777615C10.8434 0.863182 10.1778 1.14683 9.62818 1.5956C9.07859 2.04438 8.66759 2.63987 8.44293 3.31291C8.21828 3.98594 8.18917 4.70891 8.359 5.39782C8.52884 6.08674 8.89063 6.71334 9.40237 7.20484C9.91411 7.69634 10.5548 8.03257 11.25 8.17448V21.4481C11.2501 21.6473 11.2898 21.8446 11.3667 22.0284L11.8388 23.1534C11.8546 23.1823 11.8779 23.2065 11.9063 23.2233C11.9346 23.2402 11.967 23.249 12 23.249C12.033 23.249 12.0654 23.2402 12.0937 23.2233C12.1221 23.2065 12.1454 23.1823 12.1613 23.1534L12.6333 22.0284C12.7102 21.8446 12.7499 21.6473 12.75 21.4481V8.17448C13.5964 8.00054 14.357 7.54008 14.9035 6.87072C15.4499 6.20136 15.7489 5.36406 15.75 4.49995ZM13.125 4.49995C12.9025 4.49995 12.685 4.43397 12.5 4.31035C12.315 4.18674 12.1708 4.01104 12.0856 3.80547C12.0005 3.5999 11.9782 3.3737 12.0216 3.15547C12.065 2.93724 12.1722 2.73679 12.3295 2.57945C12.4868 2.42212 12.6873 2.31497 12.9055 2.27157C13.1238 2.22816 13.35 2.25044 13.5555 2.33559C13.7611 2.42073 13.9368 2.56493 14.0604 2.74993C14.184 2.93494 14.25 3.15245 14.25 3.37495C14.25 3.67332 14.1315 3.95947 13.9205 4.17044C13.7095 4.38142 13.4234 4.49995 13.125 4.49995Z" fill="black"/>
                                        </svg>
                                        <span class="location-text text-black font-roboto text-sm font-light">Main St. & 5th Ave</span>
                                    </div>
                                    <div class="time flex items-center">
                                        <svg class="time-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 20C14.1217 20 16.1566 19.1571 17.6569 17.6569C19.1571 16.1566 20 14.1217 20 12C20 9.87827 19.1571 7.84344 17.6569 6.34315C16.1566 4.84285 14.1217 4 12 4C9.87827 4 7.84344 4.84285 6.34315 6.34315C4.84285 7.84344 4 9.87827 4 12C4 14.1217 4.84285 16.1566 6.34315 17.6569C7.84344 19.1571 9.87827 20 12 20ZM12 2C13.3132 2 14.6136 2.25866 15.8268 2.7612C17.0401 3.26375 18.1425 4.00035 19.0711 4.92893C19.9997 5.85752 20.7362 6.95991 21.2388 8.17317C21.7413 9.38642 22 10.6868 22 12C22 14.6522 20.9464 17.1957 19.0711 19.0711C17.1957 20.9464 14.6522 22 12 22C6.47 22 2 17.5 2 12C2 9.34784 3.05357 6.8043 4.92893 4.92893C6.8043 3.05357 9.34784 2 12 2ZM12.5 7V12.25L17 14.92L16.25 16.15L11 13V7H12.5Z" fill="black"/>
                                        </svg>
                                        <span class="time-text text-black font-roboto text-sm font-light">2 days ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pot Hole Request -->
                        <div class="request-card bg-white rounded-2xl shadow-lg">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/4d5605873da8ba8ab703a520dfcf7b72bbc84f67?width=792"
                                 alt="Pot Hole"
                                 class="request-image w-full h-40 object-cover rounded-t-2xl">
                            <div class="request-content p-6">
                                <div class="request-header flex items-center justify-between mb-4">
                                    <h4 class="request-title text-black font-roboto text-xl font-bold">Pot Hole</h4>
                                    <span class="status-badge pending bg-lime-400 text-black px-4 py-1 rounded-full font-roboto text-xl font-medium">Pending</span>
                                </div>
                                <p class="request-description text-black font-roboto text-xl font-normal mb-6 text-center">Streetlight near corner of Main St. and 5th Ave has been out for 3 days. Safety concern at night.</p>

                                <hr class="border-black mb-4">

                                <div class="request-footer flex items-center justify-between">
                                    <div class="location flex items-center">
                                        <svg class="location-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M15.75 4.49995C15.7499 3.79041 15.5486 3.09544 15.1693 2.49577C14.79 1.8961 14.2484 1.41633 13.6074 1.1122C12.9663 0.808068 12.2521 0.692047 11.5478 0.777615C10.8434 0.863182 10.1778 1.14683 9.62818 1.5956C9.07859 2.04438 8.66759 2.63987 8.44293 3.31291C8.21828 3.98594 8.18917 4.70891 8.359 5.39782C8.52884 6.08674 8.89063 6.71334 9.40237 7.20484C9.91411 7.69634 10.5548 8.03257 11.25 8.17448V21.4481C11.2501 21.6473 11.2898 21.8446 11.3667 22.0284L11.8388 23.1534C11.8546 23.1823 11.8779 23.2065 11.9063 23.2233C11.9346 23.2402 11.967 23.249 12 23.249C12.033 23.249 12.0654 23.2402 12.0937 23.2233C12.1221 23.2065 12.1454 23.1823 12.1613 23.1534L12.6333 22.0284C12.7102 21.8446 12.7499 21.6473 12.75 21.4481V8.17448C13.5964 8.00054 14.357 7.54008 14.9035 6.87072C15.4499 6.20136 15.7489 5.36406 15.75 4.49995ZM13.125 4.49995C12.9025 4.49995 12.685 4.43397 12.5 4.31035C12.315 4.18674 12.1708 4.01104 12.0856 3.80547C12.0005 3.5999 11.9782 3.3737 12.0216 3.15547C12.065 2.93724 12.1722 2.73679 12.3295 2.57945C12.4868 2.42212 12.6873 2.31497 12.9055 2.27157C13.1238 2.22816 13.35 2.25044 13.5555 2.33559C13.7611 2.42073 13.9368 2.56493 14.0604 2.74993C14.184 2.93494 14.25 3.15245 14.25 3.37495C14.25 3.67332 14.1315 3.95947 13.9205 4.17044C13.7095 4.38142 13.4234 4.49995 13.125 4.49995Z" fill="black"/>
                                        </svg>
                                        <span class="location-text text-black font-roboto text-sm font-light">Main St. & 5th Ave</span>
                                    </div>
                                    <div class="time flex items-center">
                                        <svg class="time-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 20C14.1217 20 16.1566 19.1571 17.6569 17.6569C19.1571 16.1566 20 14.1217 20 12C20 9.87827 19.1571 7.84344 17.6569 6.34315C16.1566 4.84285 14.1217 4 12 4C9.87827 4 7.84344 4.84285 6.34315 6.34315C4.84285 7.84344 4 9.87827 4 12C4 14.1217 4.84285 16.1566 6.34315 17.6569C7.84344 19.1571 9.87827 20 12 20ZM12 2C13.3132 2 14.6136 2.25866 15.8268 2.7612C17.0401 3.26375 18.1425 4.00035 19.0711 4.92893C19.9997 5.85752 20.7362 6.95991 21.2388 8.17317C21.7413 9.38642 22 10.6868 22 12C22 14.6522 20.9464 17.1957 19.0711 19.0711C17.1957 20.9464 14.6522 22 12 22C6.47 22 2 17.5 2 12C2 9.34784 3.05357 6.8043 4.92893 4.92893C6.8043 3.05357 9.34784 2 12 2ZM12.5 7V12.25L17 14.92L16.25 16.15L11 13V7H12.5Z" fill="black"/>
                                        </svg>
                                        <span class="time-text text-black font-roboto text-sm font-light">5 days ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Clogged Drainage Request -->
                        <div class="request-card bg-white rounded-2xl shadow-lg">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/4d5605873da8ba8ab703a520dfcf7b72bbc84f67?width=792"
                                 alt="Clogged Drainage"
                                 class="request-image w-full h-40 object-cover rounded-t-2xl">
                            <div class="request-content p-6">
                                <div class="request-header flex items-center justify-between mb-4">
                                    <h4 class="request-title text-black font-roboto text-xl font-bold">Clogged Drainage</h4>
                                    <span class="status-badge completed bg-green-400 text-black px-4 py-1 rounded-full font-roboto text-xl font-medium">Completed</span>
                                </div>
                                <p class="request-description text-black font-roboto text-xl font-normal mb-6 text-center">Streetlight near corner of Main St. and 5th Ave has been out for 3 days. Safety concern at night.</p>

                                <hr class="border-black mb-4">

                                <div class="request-footer flex items-center justify-between">
                                    <div class="location flex items-center">
                                        <svg class="location-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M15.75 4.49995C15.7499 3.79041 15.5486 3.09544 15.1693 2.49577C14.79 1.8961 14.2484 1.41633 13.6074 1.1122C12.9663 0.808068 12.2521 0.692047 11.5478 0.777615C10.8434 0.863182 10.1778 1.14683 9.62818 1.5956C9.07859 2.04438 8.66759 2.63987 8.44293 3.31291C8.21828 3.98594 8.18917 4.70891 8.359 5.39782C8.52884 6.08674 8.89063 6.71334 9.40237 7.20484C9.91411 7.69634 10.5548 8.03257 11.25 8.17448V21.4481C11.2501 21.6473 11.2898 21.8446 11.3667 22.0284L11.8388 23.1534C11.8546 23.1823 11.8779 23.2065 11.9063 23.2233C11.9346 23.2402 11.967 23.249 12 23.249C12.033 23.249 12.0654 23.2402 12.0937 23.2233C12.1221 23.2065 12.1454 23.1823 12.1613 23.1534L12.6333 22.0284C12.7102 21.8446 12.7499 21.6473 12.75 21.4481V8.17448C13.5964 8.00054 14.357 7.54008 14.9035 6.87072C15.4499 6.20136 15.7489 5.36406 15.75 4.49995ZM13.125 4.49995C12.9025 4.49995 12.685 4.43397 12.5 4.31035C12.315 4.18674 12.1708 4.01104 12.0856 3.80547C12.0005 3.5999 11.9782 3.3737 12.0216 3.15547C12.065 2.93724 12.1722 2.73679 12.3295 2.57945C12.4868 2.42212 12.6873 2.31497 12.9055 2.27157C13.1238 2.22816 13.35 2.25044 13.5555 2.33559C13.7611 2.42073 13.9368 2.56493 14.0604 2.74993C14.184 2.93494 14.25 3.15245 14.25 3.37495C14.25 3.67332 14.1315 3.95947 13.9205 4.17044C13.7095 4.38142 13.4234 4.49995 13.125 4.49995Z" fill="black"/>
                                        </svg>
                                        <span class="location-text text-black font-roboto text-sm font-light">Main St. & 5th Ave</span>
                                    </div>
                                    <div class="time flex items-center">
                                        <svg class="time-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 20C14.1217 20 16.1566 19.1571 17.6569 17.6569C19.1571 16.1566 20 14.1217 20 12C20 9.87827 19.1571 7.84344 17.6569 6.34315C16.1566 4.84285 14.1217 4 12 4C9.87827 4 7.84344 4.84285 6.34315 6.34315C4.84285 7.84344 4 9.87827 4 12C4 14.1217 4.84285 16.1566 6.34315 17.6569C7.84344 19.1571 9.87827 20 12 20ZM12 2C13.3132 2 14.6136 2.25866 15.8268 2.7612C17.0401 3.26375 18.1425 4.00035 19.0711 4.92893C19.9997 5.85752 20.7362 6.95991 21.2388 8.17317C21.7413 9.38642 22 10.6868 22 12C22 14.6522 20.9464 17.1957 19.0711 19.0711C17.1957 20.9464 14.6522 22 12 22C6.47 22 2 17.5 2 12C2 9.34784 3.05357 6.8043 4.92893 4.92893C6.8043 3.05357 9.34784 2 12 2ZM12.5 7V12.25L17 14.92L16.25 16.15L11 13V7H12.5Z" fill="black"/>
                                        </svg>
                                        <span class="time-text text-black font-roboto text-sm font-light">1 week ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Water Leakage Request -->
                        <div class="request-card bg-white rounded-2xl shadow-lg">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/4d5605873da8ba8ab703a520dfcf7b72bbc84f67?width=792"
                                 alt="Water Leakage"
                                 class="request-image w-full h-40 object-cover rounded-t-2xl">
                            <div class="request-content p-6">
                                <div class="request-header flex items-center justify-between mb-4">
                                    <h4 class="request-title text-black font-roboto text-xl font-bold">Water Leakage</h4>
                                    <span class="status-badge completed bg-green-400 text-black px-4 py-1 rounded-full font-roboto text-xl font-medium">Completed</span>
                                </div>
                                <p class="request-description text-black font-roboto text-xl font-normal mb-6 text-center">Streetlight near corner of Main St. and 5th Ave has been out for 3 days. Safety concern at night.</p>

                                <hr class="border-black mb-4">

                                <div class="request-footer flex items-center justify-between">
                                    <div class="location flex items-center">
                                        <svg class="location-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M15.75 4.49995C15.7499 3.79041 15.5486 3.09544 15.1693 2.49577C14.79 1.8961 14.2484 1.41633 13.6074 1.1122C12.9663 0.808068 12.2521 0.692047 11.5478 0.777615C10.8434 0.863182 10.1778 1.14683 9.62818 1.5956C9.07859 2.04438 8.66759 2.63987 8.44293 3.31291C8.21828 3.98594 8.18917 4.70891 8.359 5.39782C8.52884 6.08674 8.89063 6.71334 9.40237 7.20484C9.91411 7.69634 10.5548 8.03257 11.25 8.17448V21.4481C11.2501 21.6473 11.2898 21.8446 11.3667 22.0284L11.8388 23.1534C11.8546 23.1823 11.8779 23.2065 11.9063 23.2233C11.9346 23.2402 11.967 23.249 12 23.249C12.033 23.249 12.0654 23.2402 12.0937 23.2233C12.1221 23.2065 12.1454 23.1823 12.1613 23.1534L12.6333 22.0284C12.7102 21.8446 12.7499 21.6473 12.75 21.4481V8.17448C13.5964 8.00054 14.357 7.54008 14.9035 6.87072C15.4499 6.20136 15.7489 5.36406 15.75 4.49995ZM13.125 4.49995C12.9025 4.49995 12.685 4.43397 12.5 4.31035C12.315 4.18674 12.1708 4.01104 12.0856 3.80547C12.0005 3.5999 11.9782 3.3737 12.0216 3.15547C12.065 2.93724 12.1722 2.73679 12.3295 2.57945C12.4868 2.42212 12.6873 2.31497 12.9055 2.27157C13.1238 2.22816 13.35 2.25044 13.5555 2.33559C13.7611 2.42073 13.9368 2.56493 14.0604 2.74993C14.184 2.93494 14.25 3.15245 14.25 3.37495C14.25 3.67332 14.1315 3.95947 13.9205 4.17044C13.7095 4.38142 13.4234 4.49995 13.125 4.49995Z" fill="black"/>
                                        </svg>
                                        <span class="location-text text-black font-roboto text-sm font-light">Main St. & 5th Ave</span>
                                    </div>
                                    <div class="time flex items-center">
                                        <svg class="time-icon w-6 h-6 mr-1" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 20C14.1217 20 16.1566 19.1571 17.6569 17.6569C19.1571 16.1566 20 14.1217 20 12C20 9.87827 19.1571 7.84344 17.6569 6.34315C16.1566 4.84285 14.1217 4 12 4C9.87827 4 7.84344 4.84285 6.34315 6.34315C4.84285 7.84344 4 9.87827 4 12C4 14.1217 4.84285 16.1566 6.34315 17.6569C7.84344 19.1571 9.87827 20 12 20ZM12 2C13.3132 2 14.6136 2.25866 15.8268 2.7612C17.0401 3.26375 18.1425 4.00035 19.0711 4.92893C19.9997 5.85752 20.7362 6.95991 21.2388 8.17317C21.7413 9.38642 22 10.6868 22 12C22 14.6522 20.9464 17.1957 19.0711 19.0711C17.1957 20.9464 14.6522 22 12 22C6.47 22 2 17.5 2 12C2 9.34784 3.05357 6.8043 4.92893 4.92893C6.8043 3.05357 9.34784 2 12 2ZM12.5 7V12.25L17 14.92L16.25 16.15L11 13V7H12.5Z" fill="black"/>
                                        </svg>
                                        <span class="time-text text-black font-roboto text-sm font-light">2 weeks ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
