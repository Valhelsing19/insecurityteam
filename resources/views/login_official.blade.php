<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Official Login - Smart Neighborhood Maintenance System</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/login-official.css') }}">
</head>
<body>
  <div class="main-container">
    <div class="background-image" aria-hidden="true"></div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <div class="login-card">
      <div class="main-logo" aria-label="Smart Neighborhood Logo"></div>
      <h1 class="system-title">Smart Neighborhood</h1>
      <p class="system-tagline">Official Access Portal</p>
      <div class="security-badge">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L4 6v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V6l-8-4z" fill="currentColor"/>
          <path d="M10 14l-2-2-1.5 1.5L10 17l6-6-1.5-1.5L10 14z" fill="white"/>
        </svg>
        Authorized Personnel Only
      </div>

      <div class="alert alert-error" id="alertMessage" style="display: none;">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
          <path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <span id="alertText">Invalid username or password</span>
      </div>

      <form id="loginForm" novalidate>
        <div class="field" id="usernameField">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" placeholder="Enter your username" autocomplete="username" required>
          <span class="error-message">Please enter your username</span>
        </div>

        <div class="field" id="passwordField">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <input id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required>
            <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password" aria-pressed="false" title="Show password">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- initial: hidden state icon (eye-off) -->
                <path d="M2 4.27L3.28 3l17.5 17.5L20.5 22l-2.1-2.1c-1.9.83-4.02 1.35-6.4 1.35-5 0-9.27-3.11-11-7.5 1.03-2.62 2.94-4.78 5.3-6.16L2 4.27zM12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l1.7 1.7C20.2 13.9 21.27 12.35 22 10.5 20.27 6.11 16 3 11 3c-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zm-4.47 2.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2z" fill="currentColor"/>
              </svg>
            </button>
          </div>
          <span class="error-message">Password is required</span>
        </div>

        <div class="action-buttons">
          <button type="submit" class="btn btn-secure" id="loginBtn">
            <span class="spinner"></span>
            <span class="btn-text">Secure Login</span>
          </button>
        </div>

        <div class="back-resident">
          <span>Return to resident portal?</span>
          <a href="/login">Go to Resident Login</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/login-official.js') }}"></script>
</body>
</html>
