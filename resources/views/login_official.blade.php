<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Official Login - Smart Neighborhood Maintenance System</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --official: #200DD1;        /* primary accent for officials */
      --official-600: #1508A8;    /* hover/darker */
      --ink: rgba(0, 0, 0, 0.78);
      --radius-md: 24px;          /* slightly sharper than resident */
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

    /* Background + gradient (same look as welcome) */
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

    /* Official login card */
    .login-card {
      position: relative; z-index: 4;
      width: 90%; max-width: 360px;            /* compact but comfortable */
      background: rgba(217,217,217,.56);
      border-radius: var(--radius-md);
      box-shadow: 0 16px 40px rgba(0,0,0,.22); /* stronger shadow */
      padding: 1.25rem 1.25rem 1.5rem;
      backdrop-filter: blur(6px) saturate(110%);
      -webkit-backdrop-filter: blur(6px) saturate(110%);
      display: flex; flex-direction: column;
      align-items: center; gap: 1rem;
      text-align: center;
    }

    /* Top security banner */
    .secure-banner {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem;
      background: rgba(32, 13, 209, 0.1);
      border: 1px solid rgba(32, 13, 209, 0.25);
      color: var(--official);
      font-weight: 700;
      font-size: 13px;
      padding: .5rem .75rem;
      border-radius: 10px;
    }

    /* Logo */
    .main-logo {
      width: 160px;
      height: 160px;
      background-image: url('/images/smart-neighborhood-logo.png');
      background-size: cover; background-position: center;
      border-radius: 50%;
      margin: .25rem auto .25rem;
    }

    /* Title (small, official tone) */
    .portal-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--ink);
      margin-top: .25rem;
    }

    /* Form */
    form {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    .field { width: 100%; display: flex; flex-direction: column; align-items: flex-start; gap: .3rem; }
    label { font-size: 14px; font-weight: 600; color: var(--ink); }

    input[type="email"], input[type="password"] {
      width: 100%; height: 46px;
      border-radius: 8px; border: 1px solid #E0E0E0;
      padding: 0 12px; background: #fff;
      font-size: 15px; color: #000;
      transition: border-color .3s, box-shadow .3s;
    }
    input::placeholder { color: rgba(146,146,146,.78); }
    input:focus { border-color: var(--official); box-shadow: 0 0 0 3px rgba(32,13,209,.15); outline: none; }

    .forgot-password {
      width: 100%;
      text-align: right;
      font-size: 13px;
      color: var(--ink);
      text-decoration: none;
      margin-top: -0.5rem;
      transition: color .2s;
    }
    .forgot-password:hover { color: var(--official-600); }

    /* Buttons */
    .action-buttons { width: 100%; display: flex; flex-direction: column; gap: .6rem; margin-top: .25rem; }

    .btn {
      height: 50px; border: none; border-radius: 50px;
      font-weight: 700; font-size: 18px; color: #fff; cursor: pointer;
      transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.22); }
    .btn:active { transform: translateY(0); box-shadow: none; }

    /* Secure login (violet) */
    .btn-secure { background: var(--official); }
    .btn-secure:hover { background: var(--official-600); }

    /* Optional alternate auth (Gov ID / SSO placeholder) */
    .divider { margin: .5rem 0; font-size: 13px; color: var(--ink); }
    .alt-auth {
      display: flex; align-items: center; justify-content: center; gap: .4rem;
      font-size: 13px; color: var(--ink);
    }
    .alt-auth a { color: var(--official); font-weight: 700; text-decoration: underline; text-underline-offset: 2px; }
    .alt-auth a:hover { color: var(--official-600); }

    /* Return to resident portal */
    .back-resident {
      margin-top: .75rem;
      font-size: 13px; color: var(--ink);
    }
    .back-resident a { color: var(--official); font-weight: 700; text-decoration: underline; text-underline-offset: 2px; }
    .back-resident a:hover { color: var(--official-600); }

    @media (max-width: 480px) {
      .login-card { max-width: 340px; padding: 1rem; border-radius: 20px; }
      .main-logo { width: 130px; height: 130px; }
      .btn { height: 46px; font-size: 17px; }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="background-image" aria-hidden="true"></div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <div class="login-card">
      <div class="secure-banner" role="status" aria-live="polite">
        🔒 Authorized Personnel Only
      </div>

      <div class="main-logo" aria-label="Smart Neighborhood Logo"></div>

      <div class="portal-title">Official Access Portal</div>

      <form action="#" method="POST" novalidate>
        <!-- @csrf -->

        <div class="field">
          <label for="email">Official Email</label>
          <input id="email" name="email" type="email" placeholder="name@city.gov" autocomplete="email" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="**************" autocomplete="current-password" required>
        </div>

        <a href="#" class="forgot-password">Forgot password?</a>

        <div class="action-buttons">
          <button type="submit" class="btn btn-secure">Secure Login</button>
        </div>

        <div class="divider">— or —</div>

        <!-- Optional alternate auth link (replace with your SSO/Gov ID route if needed) -->
        <div class="alt-auth">
          <span>Use alternate ID?</span>
          <a href="#">Sign in with Gov ID</a>
        </div>

        <div class="back-resident">
          <span>Return to resident portal?</span>
          <a href="/login">Go to Resident Login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
