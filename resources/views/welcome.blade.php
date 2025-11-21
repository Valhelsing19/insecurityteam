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

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
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
        <a href="/login/official" class="btn-official-login">Official Login</a>
        <a href="/register" class="btn-get-started">Get Started</a>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main id="main" class="landing-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <!-- Hero Background -->
      <div class="hero-background">
        <img src="/images/background-hero.png" alt="" class="hero-bg-image" loading="lazy">
        <div class="hero-gradient"></div>
      </div>
      <div class="hero-content">
        <div class="badge">
          <svg class="badge-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 1.5L9.5 5.5L13.5 7L9.5 8.5L8 12.5L6.5 8.5L2.5 7L6.5 5.5L8 1.5Z" stroke="white" stroke-width="1.33" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
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
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M3 12L12 3L21 12V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V12Z" stroke="#155DFC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 22V12H15V22" stroke="#155DFC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">For Residents</h3>
            <p class="feature-description">
              Submit maintenance requests easily, track their status in real-time, and stay informed about your neighborhood issues.
            </p>
            <div class="feature-list">
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.3328598737716675" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Quick request submission</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.3328598737716675" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Real-time status updates</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.3328598737716675" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Request history tracking</span>
              </div>
            </div>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M12 2L3 7V12C3 16.55 6.36 20.74 12 22C17.64 20.74 21 16.55 21 12V7L12 2Z" stroke="#4F39F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M12 8V12" stroke="#4F39F6" stroke-width="2" stroke-linecap="round"/>
              <path d="M12 16H12.01" stroke="#4F39F6" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">For Officials</h3>
            <p class="feature-description">
              Manage all maintenance requests efficiently, assign tasks to teams, and generate comprehensive reports.
            </p>
            <div class="feature-list">
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.3328598737716675" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Centralized dashboard</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.3328598737716675" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Team assignment tools</span>
              </div>
              <div class="feature-list-item">
                <svg class="check-icon" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6 6.66L4 8.66L6.66 11.33L12 6" stroke="#00A63E" stroke-width="1.3328598737716675" stroke-linecap="round" stroke-linejoin="round"/>
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

  <!-- Scripts -->
  <script src="{{ asset('js/welcome.js') }}" defer></script>
</body>
</html>
