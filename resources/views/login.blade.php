<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Smart Neighborhood Maintenance System</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand: #3396D3;
      --brand-dark: #2680B8;
      --brand-light: #4DA8E0;
      --ink: rgba(0, 0, 0, 0.78);
      --ink-light: rgba(0, 0, 0, 0.60);
      --success: #10B981;
      --error: #EF4444;
      --radius-md: 32px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Archivo', sans-serif;
      background: #FFFFFF;
      overflow-x: hidden;
      min-height: 100dvh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .main-container {
      position: relative;
      width: 100%;
      min-height: 100dvh;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .background-image {
      position: absolute; inset: 0;
      background-image: url('/images/background-image.png');
      background-size: cover; background-position: center;
      z-index: 1;
    }

    .gradient-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(143deg, rgba(236,204,100,.5) 0%, rgba(151,151,151,.4) 36%, rgba(56,8,231,.3) 100%);
      z-index: 2;
    }

    /* Login Card */
    .login-card {
      position: relative; z-index: 4;
      width: 90%; max-width: 360px;
      background: rgba(217,217,217,.58);
      border-radius: var(--radius-md);
      box-shadow: 0 8px 20px rgba(0,0,0,.12);
      padding: 1.5rem 1.5rem 1.75rem;
      backdrop-filter: blur(8px) saturate(110%);
      -webkit-backdrop-filter: blur(8px) saturate(110%);
      display: flex; flex-direction: column;
      align-items: center; gap: 0.75rem;
      text-align: center;
    }

    /* Logo */
    .main-logo {
      width: 140px; height: 140px;
      background-image: url('/images/smart-neighborhood-logo.png');
      background-size: cover; background-position: center;
      border-radius: 50%;
      margin: 0 auto 0.25rem;
      box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }

    .system-title { font-size: 15px; font-weight: 600; color: var(--ink); margin-bottom: 0.25rem; text-shadow: 0 1px 2px rgba(255,255,255,.5); }
    .system-tagline { font-size: 12px; font-weight: 400; color: var(--ink-light); margin-bottom: 0.5rem; }

    .security-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.75rem; background: rgba(16,185,129,0.15); border-radius: 20px; font-size: 11px; font-weight: 500; color: #059669; margin-bottom: 0.5rem; }
    .security-badge svg { width: 12px; height: 12px; }

    /* Form */
    form { width: 100%; display: flex; flex-direction: column; align-items: center; gap: 1rem; }
    .field { width: 100%; display: flex; flex-direction: column; align-items: flex-start; gap: 0.35rem; }
    .field.error input { border-color: var(--error); }
    .error-message { font-size: 12px; color: var(--error); display: none; text-align: left; width: 100%; }
    .field.error .error-message { display: block; }
    label { font-size: 14px; font-weight: 500; color: var(--ink); }

    .input-wrapper { position: relative; width: 100%; }
    input[type="email"], input[type="password"] { width: 100%; height: 46px; border-radius: 8px; border: 1px solid #E0E0E0; padding: 0 12px; background: rgba(255,255,255,0.95); font-size: 15px; color: #000; transition: border-color 0.3s, box-shadow 0.3s; }
    input::placeholder { color: rgba(146,146,146,0.78); }
    input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(51,150,211,0.15); outline: none; background: #fff; }

    .password-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; display: flex; align-items: center; color: var(--ink-light); transition: color 0.2s; }
    .password-toggle:hover { color: var(--brand); }
    .password-toggle svg { width: 20px; height: 20px; }

    .options-row { width: 100%; display: flex; justify-content: space-between; align-items: center; margin-top: -0.5rem; }
    .remember-me { display: flex; align-items: center; gap: 0.4rem; cursor: pointer; }
    .remember-me input[type="checkbox"] { width: 16px; height: 16px; cursor: pointer; accent-color: var(--brand); }
    .remember-me label { font-size: 13px; cursor: pointer; user-select: none; }
    .forgot-password { font-size: 13px; color: var(--ink); text-decoration: none; transition: color 0.2s; font-weight: 500; }
    .forgot-password:hover { color: var(--brand-dark); }

    /* Buttons */
    .action-buttons { width: 100%; display: flex; flex-direction: column; gap: 0.6rem; margin-top: 0.5rem; }
    .btn { height: 50px; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; color: #EDE9E9; cursor: pointer; transition: all 0.2s ease; position: relative; overflow: hidden; }
    .btn:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.25); }
    .btn:active:not(:disabled) { transform: translateY(0); box-shadow: 0 2px 4px rgba(0,0,0,.2); }
    .btn:disabled { opacity: 0.7; cursor: not-allowed; }
    .btn-login { background: var(--brand); display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .btn-login:hover:not(:disabled) { background: var(--brand-dark); }
    .spinner { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; display: none; }
    .btn-login.loading .spinner { display: block; }
    .btn-login.loading .btn-text { display: none; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .divider { margin: 0.25rem 0; font-size: 13px; color: var(--ink-light); font-weight: 500; }
    .google-signin { display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1rem; background: rgba(255,255,255,0.95); border-radius: 25px; cursor: pointer; transition: all 0.2s; border: 1px solid rgba(0,0,0,0.1); }
    .google-signin:hover { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.1); transform: translateY(-1px); }
    .google-signin svg { width: 18px; height: 18px; }
    .google-signin-text { font-size: 14px; color: var(--ink); font-weight: 500; }

    .create-account-wrapper { font-size: 13px; color: var(--ink); text-align: center; margin-top: 0.25rem; }
    .create-account-wrapper a { color: var(--brand); font-weight: 700; text-decoration: none; margin-left: 4px; border-bottom: 2px solid var(--brand); padding-bottom: 1px; transition: all 0.2s; }
    .create-account-wrapper a:hover { color: var(--brand-dark); border-bottom-color: var(--brand-dark); }

    /* Alerts */
    .alert { width: 100%; padding: 0.75rem 1rem; border-radius: 8px; font-size: 13px; display: none; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; }
    .alert.show { display: flex; }
    .alert-error { background: rgba(239,68,68,0.15); color: #DC2626; border: 1px solid rgba(239,68,68,0.3); }
    .alert-success { background: rgba(16,185,129,0.15); color: #059669; border: 1px solid rgba(16,185,129,0.3); }
    .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

    @media (max-width: 480px) {
      .login-card { max-width: 340px; padding: 1.25rem 1.25rem 1.5rem; border-radius: 24px; }
      .main-logo { width: 120px; height: 120px; }
      .btn { height: 46px; font-size: 17px; }
      .system-title { font-size: 14px; }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="background-image" aria-hidden="true"></div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <div class="login-card">
      <div class="main-logo" aria-label="Smart Neighborhood Logo"></div>
      <h1 class="system-title">Smart Neighborhood</h1>
      <p class="system-tagline">Community maintenance made easy</p>
      <div class="security-badge">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L4 6v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V6l-8-4z" fill="currentColor"/>
          <path d="M10 14l-2-2-1.5 1.5L10 17l6-6-1.5-1.5L10 14z" fill="white"/>
        </svg>
        Secure Login
      </div>

      <div class="alert alert-error" id="alertMessage">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
          <path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <span id="alertText">Invalid email or password</span>
      </div>

      <form id="loginForm" novalidate>
        <div class="field" id="emailField">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="email" required>
          <span class="error-message">Please enter a valid email address</span>
        </div>

        <div class="field" id="passwordField">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <input id="password" name="password" type="password" placeholder="••••••••••••••" autocomplete="current-password" required>
            <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password" aria-pressed="false" title="Show password">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- initial: hidden state icon (eye-off) -->
                <path d="M2 4.27L3.28 3l17.5 17.5L20.5 22l-2.1-2.1c-1.9.83-4.02 1.35-6.4 1.35-5 0-9.27-3.11-11-7.5 1.03-2.62 2.94-4.78 5.3-6.16L2 4.27zM12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l1.7 1.7C20.2 13.9 21.27 12.35 22 10.5 20.27 6.11 16 3 11 3c-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zm-4.47 2.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2z" fill="currentColor"/>
              </svg>
            </button>
          </div>
          <span class="error-message">Password is required</span>
        </div>

        <div class="options-row">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
          </div>
          <a href="#" class="forgot-password">Forgot password?</a>
        </div>

        <div class="action-buttons">
          <button type="submit" class="btn btn-login" id="loginBtn">
            <span class="spinner"></span>
            <span class="btn-text">Login</span>
          </button>
        </div>

        <div class="divider">— or —</div>

        <div class="google-signin" role="button" tabindex="0" aria-label="Sign in with Gmail" id="googleSignin">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          <span class="google-signin-text">Sign in with Gmail</span>
        </div>

        <div class="create-account-wrapper">
          <span>Are you new?</span>
          <a href="/register">Create an Account</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    (function(){
      const togglePassword = document.getElementById('togglePassword');
      let passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      function setIcon(isVisible){
        if (!eyeIcon) return;
        eyeIcon.innerHTML = isVisible
          ? '<path d="M12 5c5 0 9.27 3.11 11 7.5-1.73 4.39-6 7.5-11 7.5S2.73 16.89 1 12.5C2.73 8.11 7 5 12 5zm0 12.5c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0-8c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3z" fill="currentColor"/>'
          : '<path d="M2 4.27L3.28 3l17.5 17.5L20.5 22l-2.1-2.1c-1.9.83-4.02 1.35-6.4 1.35-5 0-9.27-3.11-11-7.5 1.03-2.62 2.94-4.78 5.3-6.16L2 4.27zM12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l1.7 1.7C20.2 13.9 21.27 12.35 22 10.5 20.27 6.11 16 3 11 3c-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zm-4.47 2.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2z" fill="currentColor"/>';
      }

      function replaceInputWithType(newType){
        const newInput = passwordInput.cloneNode(true);
        newInput.type = newType;
        newInput.value = passwordInput.value;
        passwordInput.parentNode.replaceChild(newInput, passwordInput);
        passwordInput = newInput;
      }

      function toggleVisibility(){
        if (!passwordInput) return;
        const shouldShow = passwordInput.type === 'password';
        try {
          passwordInput.type = shouldShow ? 'text' : 'password';
        } catch (_) {
          replaceInputWithType(shouldShow ? 'text' : 'password');
        }
        setIcon(shouldShow);
        togglePassword.setAttribute('aria-pressed', shouldShow ? 'true' : 'false');
        togglePassword.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
        togglePassword.setAttribute('title', shouldShow ? 'Hide password' : 'Show password');
        passwordInput.focus();
        const end = passwordInput.value.length;
        passwordInput.setSelectionRange(end, end);
      }

      if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();
          toggleVisibility();
        });
      }
    })();
  </script>

</body>
</html>
