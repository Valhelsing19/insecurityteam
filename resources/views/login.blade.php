<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Smart Neighborhood Maintenance System</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand: #3396D3;
      --brand-dark: #2680B8;
      --ink: rgba(0, 0, 0, 0.78);
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
      background: linear-gradient(
        143deg,
        rgba(236,204,100,.5) 0%,
        rgba(151,151,151,.4) 36%,
        rgba(56,8,231,.3) 100%
      );
      z-index: 2;
    }

    /* Login card */
    .login-card {
      position: relative; z-index: 4;
      width: 90%; max-width: 340px;
      background: rgba(217,217,217,.56);
      border-radius: var(--radius-md);
      box-shadow: 0 8px 20px rgba(0,0,0,.12);
      padding: 1.25rem 1.25rem;
      backdrop-filter: blur(6px) saturate(110%);
      -webkit-backdrop-filter: blur(6px) saturate(110%);
      display: flex; flex-direction: column;
      align-items: center; gap: 1rem;
      text-align: center;
    }

    /* Logo */
    .main-logo {
      width: 160px;
      height: 160px;
      background-image: url('/images/smart-neighborhood-logo.png');
      background-size: cover;
      background-position: center;
      border-radius: 50%;
      margin: .25rem auto .5rem;
    }

    /* Form styling */
    form {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    .field {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 0.3rem;
    }

    label {
      font-size: 14px;
      font-weight: 500;
      color: var(--ink);
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      height: 46px;
      border-radius: 8px;
      border: 1px solid #E0E0E0;
      padding: 0 12px;
      background: #fff;
      font-size: 15px;
      color: #000;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    input::placeholder { color: rgba(146, 146, 146, 0.78); }

    input:focus {
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(51, 150, 211, 0.15);
      outline: none;
    }

    .forgot-password {
      width: 100%;
      text-align: right;
      font-size: 13px;
      color: var(--ink);
      text-decoration: none;
      margin-top: -0.5rem;
      transition: color 0.2s;
    }
    .forgot-password:hover { color: var(--brand-dark); }

    /* Buttons */
    .action-buttons {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 0.6rem;
      margin-top: 0.5rem;
    }

    .btn {
      height: 50px;
      border: none;
      border-radius: 50px;
      font-weight: 700;
      font-size: 18px;
      color: #EDE9E9;
      cursor: pointer;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,.2); }
    .btn:active { transform: translateY(0); box-shadow: none; }

    /* NEW: single login button uses brand color */
    .btn-login { background: var(--brand); }
    .btn-login:hover { background: var(--brand-dark); }

    .divider {
      margin: 0.5rem 0;
      font-size: 13px;
      color: var(--ink);
    }

    .google-signin {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      cursor: pointer;
    }

    .google-signin svg { width: 16px; height: 16px; }
    .google-signin-text { font-size: 13px; color: var(--ink); }

    .create-account-wrapper {
      font-size: 13px;
      color: var(--ink);
      text-align: center;
    }

    .create-account-wrapper a {
      color: var(--brand);
      font-weight: 700;
      text-decoration: underline;
      text-underline-offset: 2px;
      margin-left: 4px;
    }

    .create-account-wrapper a:hover { color: var(--brand-dark); }

    @media (max-width: 480px) {
      .login-card { max-width: 320px; padding: 1rem; border-radius: 24px; }
      .main-logo { width: 120px; height: 120px; }
      .btn { height: 46px; font-size: 17px; }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="background-image" aria-hidden="true"></div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <div class="login-card">
      <div class="main-logo" aria-label="Smart Neighborhood Logo"></div>

      <form action="#" method="POST" novalidate>
        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" placeholder="Enter your email" autocomplete="email" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="**************" autocomplete="current-password" required>
        </div>

        <a href="#" class="forgot-password">Forgot password?</a>

        <div class="action-buttons">
          <!-- SINGLE LOGIN BUTTON -->
          <button type="submit" class="btn btn-login">Login</button>
        </div>

        <div class="divider">— or —</div>

        <div class="google-signin" role="button" tabindex="0" aria-label="Sign in with Gmail">
          <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
            <path d="M9.003 18c2.43 0 4.467-.806 5.956-2.18L12.05 13.56c-.806.54-1.836.86-3.047.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9.003 18z" fill="#34A853"/>
            <path d="M3.964 10.712c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V4.96H.957C.347 6.175 0 7.55 0 9.002c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
            <path d="M9.003 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.464.891 11.426 0 9.003 0 5.482 0 2.438 2.017.957 4.958L3.964 7.29c.708-2.127 2.692-3.71 5.036-3.71z" fill="#EA4335"/>
          </svg>
          <span class="google-signin-text">Sign in with Gmail</span>
        </div>

        <div class="create-account-wrapper">
          <span>Are you new?</span>
          <a href="#">Create an Account</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
