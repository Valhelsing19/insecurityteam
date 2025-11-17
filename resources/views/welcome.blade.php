<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Smart Neighborhood Maintenance Request and Response System - Empowering residents and local authorities">
  <title>Smart Neighborhood Maintenance System</title>

  <link rel="icon" href="/images/favicon.png" sizes="32x32">
  <meta name="theme-color" content="#155DFC">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --primary-blue: #155DFC;
      --primary-purple: #4F39F6;
      --primary-purple-dark: #9810FA;
      --light-blue: #DBEAFE;
      --light-purple: #E0E7FF;
      --text-dark: #0A0A0A;
      --text-gray: #717182;
      --white: #FFFFFF;
      --white-80: rgba(255, 255, 255, 0.8);
      --white-50: rgba(255, 255, 255, 0.5);
      --gradient-primary: linear-gradient(90deg, #155DFC 0%, #4F39F6 50%, #9810FA 100%);
      --gradient-primary-short: linear-gradient(90deg, #155DFC 0%, #4F39F6 100%);
      --gradient-bg: linear-gradient(135deg, rgba(239, 246, 255, 1) 0%, rgba(238, 242, 255, 1) 50%, rgba(250, 245, 255, 1) 100%);
      --gradient-overlay: linear-gradient(135deg, rgba(43, 127, 255, 0.1) 0%, rgba(97, 95, 255, 0.1) 50%, rgba(173, 70, 255, 0.1) 100%);
      --shadow-sm: 0px 4px 6px -4px rgba(0, 0, 0, 0.1), 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
      --shadow-md: 0px 8px 10px -6px rgba(0, 0, 0, 0.1), 0px 20px 25px -5px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
      --shadow-blue: 0px 8px 10px -6px rgba(43, 127, 255, 0.3), 0px 20px 25px -5px rgba(43, 127, 255, 0.3);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Arimo', Arial, sans-serif;
      background: var(--gradient-bg);
      color: var(--text-dark);
      overflow-x: hidden;
      min-height: 100vh;
      line-height: 1.5;
    }

    .skip-link{
      position: absolute;
      left: -9999px;
      top: 0;
      background: #fff;
      color: #000;
      padding: .5rem .75rem;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    .skip-link:focus{
      left: 1rem;
      top: 1rem;
      z-index: 9999;
      outline: 3px solid #000;
      outline-offset: 4px;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 16px;
    }

    /* Header */
    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background: var(--white-80);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0px 1px 2px -1px rgba(0, 0, 0, 0.1), 0px 1px 3px 0px rgba(0, 0, 0, 0.1);
    }

    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 16px;
      height: 73px;
    }

    .logo-section {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo-circle {
      width: 66px;
      height: 66px;
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

    .logo-text h1 {
      font-size: 16px;
      font-weight: 400;
      color: var(--text-dark);
      line-height: 1.5;
      margin: 0;
    }

    .logo-text p {
      font-size: 12px;
      font-weight: 400;
      color: var(--text-gray);
      line-height: 1.33;
      margin: 0;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-login {
      padding: 8px 16px;
      background: transparent;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 400;
      color: var(--text-dark);
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .btn-get-started {
      padding: 8px 16px;
      background: var(--gradient-primary-short);
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 400;
      color: var(--white);
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      box-shadow: var(--shadow-blue);
    }

    /* Background Hero Section */
    .hero-background {
      position: relative;
      width: 100%;
      height: 857px;
      margin-top: 73px;
    }

    .hero-bg-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.2;
    }

    .hero-gradient {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--gradient-overlay);
    }

    /* Main Content */
    .landing-page {
      position: relative;
      z-index: 10;
    }

    /* Hero Section */
    .hero-section {
      padding: 96px 16px 0;
      max-width: 1280px;
      margin: 0 auto;
    }

    .hero-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 64px;
      padding-bottom: 64px;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 16px;
      padding: 8px 16px;
      background: var(--light-blue);
      border-radius: 999px;
      font-size: 14px;
      color: #1447E6;
    }

    .badge-icon {
      width: 16px;
      height: 16px;
    }

    .hero-heading {
      text-align: center;
      max-width: 1248px;
    }

    .hero-title {
      font-size: 60px;
      font-weight: 400;
      line-height: 1;
      text-align: center;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 0;
    }

    .hero-description {
      font-size: 18px;
      line-height: 1.56;
      color: var(--text-gray);
      text-align: center;
      max-width: 672px;
      margin: 28px auto 0;
    }

    .hero-buttons {
      display: flex;
      gap: 16px;
      justify-content: center;
      margin-top: 40px;
    }

    .btn-primary-gradient {
      padding: 8px 16px;
      background: var(--gradient-primary-short);
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 400;
      color: var(--white);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: var(--shadow-blue);
    }

    .btn-outline {
      padding: 8px 24px;
      background: var(--white);
      border: 1.82px solid rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      font-size: 14px;
      font-weight: 400;
      color: var(--text-dark);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
    }

    /* Feature Cards Section */
    .feature-cards {
      display: flex;
      gap: 12px;
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 16px;
    }

    .feature-card {
      flex: 1;
      background: var(--white-80);
      border-radius: 14px;
      padding: 24px 0 0 24px;
      box-shadow: var(--shadow-md);
      display: flex;
      gap: 16px;
    }

    .feature-icon {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      flex-shrink: 0;
    }

    .feature-icon.blue {
      background: var(--light-blue);
    }

    .feature-icon.purple {
      background: var(--light-purple);
    }

    .feature-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .feature-title {
      font-size: 20px;
      font-weight: 400;
      line-height: 1.4;
      color: var(--text-dark);
      margin: 0;
    }

    .feature-description {
      font-size: 16px;
      line-height: 1.5;
      color: var(--text-gray);
      margin: 0;
    }

    .feature-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-top: 8px;
    }

    .feature-list-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: var(--text-dark);
    }

    .check-icon {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
    }

    /* Everything You Need Section */
    .features-section {
      padding: 48px 16px;
      background: var(--white-50);
      margin-top: 48px;
    }

    .section-header {
      text-align: center;
      max-width: 1280px;
      margin: 0 auto 48px;
    }

    .section-title {
      font-size: 36px;
      font-weight: 400;
      line-height: 1.11;
      background: var(--gradient-primary-short);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 0 0 24px;
    }

    .section-subtitle {
      font-size: 16px;
      line-height: 1.5;
      color: var(--text-gray);
      margin: 0;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      max-width: 1280px;
      margin: 0 auto;
    }

    .feature-box {
      background: var(--white-80);
      border-radius: 14px;
      padding: 24px 0 0 24px;
      box-shadow: var(--shadow-sm);
      display: flex;
      flex-direction: column;
      gap: 40px;
    }

    .feature-box-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .feature-box-icon.tracking {
      background: linear-gradient(135deg, #51A2FF 0%, #155DFC 100%);
    }

    .feature-box-icon.analytics {
      background: linear-gradient(135deg, #7C86FF 0%, #4F39F6 100%);
    }

    .feature-box-icon.collaboration {
      background: linear-gradient(135deg, #C27AFF 0%, #9810FA 100%);
    }

    .feature-box-title {
      font-size: 18px;
      font-weight: 400;
      line-height: 1.56;
      color: var(--text-dark);
      margin: 0;
    }

    .feature-box-description {
      font-size: 14px;
      line-height: 1.43;
      color: var(--text-gray);
      margin: 0;
    }

    /* Community in Action Section */
    .community-section {
      padding: 64px 16px;
      max-width: 1280px;
      margin: 0 auto;
    }

    .community-card {
      position: relative;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
      margin-top: 32px;
    }

    .community-image {
      width: 100%;
      height: 500px;
      object-fit: cover;
    }

    .community-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 50%;
      background: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0) 100%);
    }

    .community-content {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 32px;
    }

    .community-title {
      font-size: 24px;
      font-weight: 400;
      line-height: 1.33;
      color: var(--white);
      margin: 0 0 16px;
    }

    .carousel-dots {
      display: flex;
      gap: 8px;
      justify-content: center;
      margin-top: 16px;
    }

    .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--white-50);
      border: none;
      cursor: pointer;
    }

    .dot.active {
      width: 32px;
      background: var(--white);
    }

    .carousel-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--white-80);
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-sm);
    }

    .carousel-nav.prev {
      left: 16px;
    }

    .carousel-nav.next {
      right: 16px;
    }

    /* CTA Section */
    .cta-section {
      padding: 48px;
      background: var(--gradient-primary);
      border-radius: 14px;
      max-width: 1248px;
      margin: 48px auto;
      text-align: center;
      box-shadow: var(--shadow-md);
    }

    .cta-title {
      font-size: 36px;
      font-weight: 400;
      line-height: 1.11;
      color: var(--white);
      margin: 0 0 24px;
    }

    .cta-description {
      font-size: 16px;
      line-height: 1.5;
      color: var(--light-blue);
      max-width: 672px;
      margin: 0 auto 40px;
    }

    .cta-buttons {
      display: flex;
      gap: 16px;
      justify-content: center;
    }

    .btn-cta-primary {
      padding: 8px 16px;
      background: var(--white);
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 400;
      color: var(--primary-blue);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: var(--shadow-md);
    }

    .btn-cta-outline {
      padding: 8px 24px;
      background: transparent;
      border: 1.82px solid var(--white);
      border-radius: 8px;
      font-size: 14px;
      font-weight: 400;
      color: var(--white);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
    }

    /* Footer */
    footer {
      padding: 33px 91px 0;
      background: var(--white-50);
      border-top: 1px solid #E5E7EB;
    }

    .footer-content {
      text-align: center;
      padding-bottom: 20px;
    }

    .footer-text {
      font-size: 14px;
      line-height: 1.43;
      color: var(--text-gray);
      margin: 0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .features-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .hero-title {
        font-size: 36px;
      }

      .feature-cards {
        flex-direction: column;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }

      .hero-buttons,
      .cta-buttons {
        flex-direction: column;
        width: 100%;
      }

      .btn-primary-gradient,
      .btn-outline,
      .btn-cta-primary,
      .btn-cta-outline {
        width: 100%;
        justify-content: center;
      }

      .header-actions {
        gap: 8px;
      }

      .btn-login,
      .btn-get-started {
        padding: 6px 12px;
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <a href="#main" class="skip-link">Skip to main content</a>

  <!-- Header -->
  <header>
    <div class="header-content">
      <div class="logo-section">
        <div class="logo-circle">
          <img src="/images/logo.png" alt="Smart Neighborhood Logo">
        </div>
        <div class="logo-text">
          <h1>Smart Neighborhood</h1>
          <p>Maintenance System</p>
        </div>
      </div>
      <div class="header-actions">
        <a href="/login" class="btn-login">Login</a>
        <a href="/register" class="btn-get-started">Get Started</a>
      </div>
    </div>
  </header>

  <!-- Hero Background -->
  <div class="hero-background">
    <img src="/images/background-hero.png" alt="" class="hero-bg-image" loading="lazy">
    <div class="hero-gradient"></div>
  </div>

  <!-- Main Content -->
  <main id="main" class="landing-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-content">
        <div class="badge">
          <svg class="badge-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.33 1.33H13.33V13.33H1.33V1.33Z" stroke="#155DFC" stroke-width="1.33"/>
            <path d="M12 2.67H13.33V4H12V2.67Z" stroke="#155DFC" stroke-width="1.33"/>
            <path d="M1.33 12H2.67V13.33H1.33V12Z" stroke="#155DFC" stroke-width="1.33"/>
          </svg>
          <span>Modern Community Management</span>
        </div>

        <div class="hero-heading">
          <h1 class="hero-title">Simplify Your Neighborhood<br>Maintenance Requests</h1>
          <p class="hero-description">
            A comprehensive platform connecting residents with officials to streamline maintenance requests, track progress, and build a better community together.
          </p>
          <div class="hero-buttons">
            <a href="/register" class="btn-primary-gradient">
              Get Started Free
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M3.33 8L12 8M12 8L8 3.33M12 8L8 12.67" stroke="white" stroke-width="1.33" stroke-linecap="round"/>
              </svg>
            </a>
            <a href="/login" class="btn-outline">Sign In to Your Account</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Feature Cards -->
    <section class="container">
      <div class="feature-cards">
        <div class="feature-card">
          <div class="feature-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="margin: 12px;">
              <path d="M9 12L12 15L21 6" stroke="#155DFC" stroke-width="2" stroke-linecap="round"/>
              <path d="M3 12L6 15L15 6" stroke="#155DFC" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">For Residents</h3>
            <p class="feature-description">
              Submit maintenance requests easily, track their status in real-time, and stay informed about your neighborhood issues.
            </p>
            <div class="feature-list">
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.33" stroke-linecap="round"/>
                </svg>
                <span>Quick request submission</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.33" stroke-linecap="round"/>
                </svg>
                <span>Real-time status updates</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.33" stroke-linecap="round"/>
                </svg>
                <span>Request history tracking</span>
              </div>
            </div>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon purple">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" style="margin: 14px;">
              <path d="M4 2H16V18H4V2Z" stroke="#4F39F6" stroke-width="2"/>
              <path d="M21 10.5H16V9.5H21V10.5Z" stroke="#4F39F6" stroke-width="2"/>
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">For Officials</h3>
            <p class="feature-description">
              Manage all maintenance requests efficiently, assign tasks to teams, and generate comprehensive reports.
            </p>
            <div class="feature-list">
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.33" stroke-linecap="round"/>
                </svg>
                <span>Centralized dashboard</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.33" stroke-linecap="round"/>
                </svg>
                <span>Team assignment tools</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.33" stroke-linecap="round"/>
                </svg>
                <span>Analytics & reporting</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Everything You Need Section -->
    <section class="features-section">
      <div class="section-header">
        <h2 class="section-title">Everything You Need</h2>
        <p class="section-subtitle">
          Powerful features designed to make neighborhood maintenance seamless and efficient
        </p>
      </div>
      <div class="features-grid">
        <div class="feature-box">
          <div class="feature-box-icon tracking">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
              <path d="M14 7V14L18 18" stroke="white" stroke-width="2.33" stroke-linecap="round"/>
              <circle cx="14" cy="14" r="11.67" stroke="white" stroke-width="2.33"/>
            </svg>
          </div>
          <div>
            <h3 class="feature-box-title">Real-Time Tracking</h3>
            <p class="feature-box-description">
              Monitor the status of all maintenance requests with live updates and notifications
            </p>
          </div>
        </div>

        <div class="feature-box">
          <div class="feature-box-icon analytics">
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none">
              <rect x="3.5" y="3.5" width="21" height="21" stroke="white" stroke-width="2"/>
              <path d="M21 10.5H16V9.5H21V10.5Z" stroke="white" stroke-width="2"/>
              <path d="M15.17 5.83H16.17V19.83H15.17V5.83Z" stroke="white" stroke-width="2"/>
              <path d="M9.33 16.33H10.33V19.83H9.33V16.33Z" stroke="white" stroke-width="2"/>
            </svg>
          </div>
          <div>
            <h3 class="feature-box-title">Analytics Dashboard</h3>
            <p class="feature-box-description">
              Visualize trends, track performance, and make data-driven decisions
            </p>
          </div>
        </div>

        <div class="feature-box">
          <div class="feature-box-icon collaboration">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
              <path d="M2.33 17.5L16.33 17.5" stroke="white" stroke-width="2.33"/>
              <path d="M18.66 3.65L22.16 3.65" stroke="white" stroke-width="2.33"/>
              <path d="M22.16 17.65L25.66 17.65" stroke="white" stroke-width="2.33"/>
              <rect x="5.83" y="3.5" width="9.33" height="9.33" stroke="white" stroke-width="2.33"/>
            </svg>
          </div>
          <div>
            <h3 class="feature-box-title">Team Collaboration</h3>
            <p class="feature-box-description">
              Assign tasks, coordinate with teams, and ensure nothing falls through the cracks
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Community in Action Section -->
    <section class="community-section">
      <div class="section-header">
        <h2 class="section-title">Community in Action</h2>
        <p class="section-subtitle">
          See how neighbors work together to create thriving, well-maintained communities
        </p>
      </div>
      <div class="community-card">
        <img src="/images/community-image.png" alt="Community collaboration" class="community-image" loading="lazy">
        <div class="community-overlay"></div>
        <div class="community-content">
          <h3 class="community-title">Collaboration Creates Better Neighborhoods</h3>
          <div class="carousel-dots">
            <button class="dot"></button>
            <button class="dot"></button>
            <button class="dot"></button>
            <button class="dot active"></button>
          </div>
        </div>
        <button class="carousel-nav prev" aria-label="Previous">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M7.5 5L12.5 10L7.5 15" stroke="#364153" stroke-width="1.67" stroke-linecap="round"/>
          </svg>
        </button>
        <button class="carousel-nav next" aria-label="Next">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M12.5 5L7.5 10L12.5 15" stroke="#364153" stroke-width="1.67" stroke-linecap="round"/>
          </svg>
        </button>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="container">
      <div class="cta-section">
        <h2 class="cta-title">Ready to Get Started?</h2>
        <p class="cta-description">
          Join hundreds of neighborhoods already using our platform to improve their community maintenance
        </p>
        <div class="cta-buttons">
          <a href="/register" class="btn-cta-primary">
            Create Your Account
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3.33 8L12 8M12 8L8 3.33M12 8L8 12.67" stroke="#155DFC" stroke-width="1.33" stroke-linecap="round"/>
            </svg>
          </a>
          <a href="/login" class="btn-cta-outline">Sign In</a>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <p class="footer-text">
        © 2025 Smart Neighborhood Maintenance System. All rights reserved.
      </p>
    </div>
  </footer>
</body>
</html>
