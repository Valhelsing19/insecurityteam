<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Smart Neighborhood Maintenance Request and Response System - Empowering residents and local authorities">
  <title>Smart Neighborhood Maintenance System</title>

  <link rel="icon" href="/images/favicon.png" sizes="32x32">
  <meta name="theme-color" content="#3396D3">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;800&family=Roboto+Condensed:wght@800&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand: #3396D3;
      --brand-600: #2680B8;
      --ink: #000000;
      --ink-inv: #ffffff;

      --surface-blur: rgba(217, 217, 217, 0.35);
      --header-bg: rgba(51, 150, 211, 0.6);
      --footer-bg: rgba(51, 150, 211, 0.6);

      --radius-pill: 999px;
      --radius-md: 12px;

      --shadow-md: 0 4px 10px rgba(0,0,0,.10);
      --shadow-lg: 0 10px 30px rgba(0,0,0,.15);

      --gap: clamp(16px, 2.5vw, 32px);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Roboto', Arial, sans-serif;
      background: #FFFFFF;
      color: var(--ink);
      overflow-x: hidden;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
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

    .main-container {
      position: relative;
      width: 100%;
      max-width: 1440px;
      min-height: 100dvh;
      background: #FFFFFF;
      overflow: hidden;
      box-shadow: var(--shadow-md);
      display: grid;
      grid-template-rows: 79px 1fr 79px;
    }

    /* Background layers */
    .background-layer {
      position: absolute;
      inset: 0;
      background-image: url('/images/background-image.png');
      background-image: image-set(
        url('/images/background-image.png') 1x,
        url('/images/background-image@2x.png') 2x
      );
      background-size: cover;
      background-position: center;
      pointer-events: none;
    }

    .background-layer img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      pointer-events: none;
      user-select: none;
    }

    .gradient-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        143deg,
        rgba(236, 204, 100, 0.5) 0%,
        rgba(151, 151, 151, 0.4) 36%,
        rgba(56, 8, 231, 0.3) 100%
      );
      pointer-events: none;
    }

    @media (prefers-contrast: more){
      .gradient-overlay{
        background: linear-gradient(143deg, rgba(0,0,0,.35), rgba(0,0,0,.45));
      }
    }

    header.header {
      height: 79px;
      background: var(--header-bg);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0,0,0,.08);
    }

    .header-logo {
      width: 107px;
      height: 107px;
      background-image: url('/images/smart-neighborhood-logo.png');
      background-image: image-set(
        url('/images/smart-neighborhood-logo.png') 1x,
        url('/images/smart-neighborhood-logo@2x.png') 2x
      );
      background-size: cover;
      background-position: center;
      border-radius: 50%;
      flex-shrink: 0;
      overflow: hidden;
    }
    .header-logo img{
      width: 100%; height: 100%; object-fit: cover; display: block;
      border-radius: 50%; user-select: none; pointer-events: none;
    }

    .nav-menu {
      display: flex;
      gap: 2rem;
      align-items: center;
      margin-right: 1rem;
    }

    .nav-item {
      font-weight: 700;
      font-size: 15px;
      color: var(--ink);
      text-decoration: none;
      transition: color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
      white-space: nowrap;
    }
    .nav-item:hover{ text-decoration: underline; text-underline-offset: 3px; }
    .nav-item:focus{
      color: var(--ink-inv);
      outline: 2px solid #000000;
      outline-offset: 4px;
    }

    /* NEW: a subtle pill for the Official login link */
    .nav-action {
      padding: .5rem 1rem;
      border: 2px solid var(--ink);
      border-radius: var(--radius-pill);
      background: rgba(255,255,255,.35);
      text-decoration: none;
      box-shadow: 0 2px 6px rgba(0,0,0,.08);
    }
    .nav-action:hover,
    .nav-action:focus {
      background: var(--brand);
      color: var(--ink);
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(0,0,0,.2);
      outline: 3px solid #000; /* visible focus */
      outline-offset: 3px;
    }

    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      min-height: 0;
      position: relative;
    }

    .content-backdrop {
      position: absolute;
      inset: 2rem;
      background: var(--surface-blur);
      border: 1px solid rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(6px) saturate(110%);
      -webkit-backdrop-filter: blur(6px) saturate(110%);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-lg);
    }

    .content-wrapper {
      position: relative;
      z-index: 10;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: var(--gap);
      max-width: 900px;
      text-align: center;
      width: 100%;
    }

    .main-title {
      font-size: clamp(18px, 3vw, 25px);
      font-weight: 400;
      color: var(--ink);
      line-height: 1.4;
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
    }

    .logo-container {
      width: 280px;
      height: 280px;
      background-image: url('/images/smart-neighborhood-logo.png');
      background-image: image-set(
        url('/images/smart-neighborhood-logo.png') 1x,
        url('/images/smart-neighborhood-logo@2x.png') 2x
      );
      background-size: cover;
      background-position: center;
      border-radius: 50%;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }
    .logo-container img{
      width: 100%; height: 100%; object-fit: cover; display:block;
      border-radius: 50%; user-select: none; pointer-events: none;
    }

    .subtitle {
      font-family: 'Roboto Condensed', sans-serif;
      font-weight: 800;
      font-size: clamp(28px, 4vw, 35px);
      color: var(--ink);
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
    }

    .description {
      font-size: clamp(16px, 2.5vw, 22px);
      font-weight: 400;
      color: var(--ink);
      line-height: 1.4;
      max-width: 755px;
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
    }

    .button-group {
      display: flex;
      gap: 2rem;
      margin-top: 1rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    .btn {
      padding: 1rem 2.5rem;
      font-family: 'Roboto', sans-serif;
      font-weight: 700;
      font-size: 22px;
      color: var(--ink);
      border: 2px solid var(--ink);
      border-radius: var(--radius-pill);
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
      text-decoration: none;
      display: inline-block;
      min-width: 200px;
      text-align: center;
      outline-offset: 3px;
    }
    .btn:active { transform: translateY(0); box-shadow: none; }

    .btn-primary {
      background: var(--brand);
      border-color: var(--ink);
    }
    .btn-primary:hover,
    .btn-primary:focus {
      background: var(--brand-600);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary {
      background: transparent;
    }
    .btn-secondary:hover,
    .btn-secondary:focus {
      background: rgba(51, 150, 211, 0.2);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn:focus { outline: 3px solid #000000; }

    footer.footer {
      height: 79px;
      background: var(--footer-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      z-index: 100;
      box-shadow: 0 -2px 10px rgba(0,0,0,.05);
    }

    .emergency-text {
      font-weight: 700;
      font-size: clamp(14px, 2vw, 18px);
      color: var(--ink);
      text-align: center;
      max-width: 700px;
    }

    .emergency-number {
      font-weight: 800;
      color: #FF0000;
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .nav-menu { gap: 1rem; }
      .nav-item { font-size: 13px; }
      .logo-container { width: 200px; height: 200px; }
      .button-group { flex-direction: column; gap: 1rem; }
      .btn { width: 100%; max-width: 300px; }
      .nav-action{ padding: .4rem .8rem; } /* compact on mobile */
    }

    @media (prefers-color-scheme: dark){
      body{ background:#0E0F11; }
      .main-title, .subtitle, .description, .nav-item, .emergency-text{ color:#f4f6f8; }
      .content-backdrop{ background: rgba(40,40,48,.35); border-color: rgba(255,255,255,.15); }
      .btn{ color:#101114; border-color:#e7e8ea; }
      .btn-secondary:hover{ background: rgba(51,150,211,.25); }
      .nav-action{ border-color:#e7e8ea; }
    }
  </style>
</head>
<body>
  <a href="#main" class="skip-link">Skip to main content</a>

  <div class="main-container">
    <div class="background-layer" aria-hidden="true">
      <img src="/images/background-image.png" alt="" loading="lazy" decoding="async">
    </div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <header class="header">
      <div class="header-logo" aria-label="Smart Neighborhood Logo">
        <img src="/images/smart-neighborhood-logo.png" alt="Smart Neighborhood Logo" decoding="async">
      </div>
      <nav class="nav-menu" aria-label="Main navigation">
        <a href="#about" class="nav-item" aria-current="page">About Us</a>
        <a href="#how-it-works" class="nav-item">How It Works</a>
        <a href="#faq" class="nav-item">FAQ</a>

        <!-- NEW: Login as Official (top-right) -->
        <a href="/login/official" class="nav-item nav-action" aria-label="Login as Official">Login as Official</a>
      </nav>
    </header>

    <main id="main">
      <div class="content-backdrop" aria-hidden="true"></div>
      <div class="content-wrapper">
        <h1 class="main-title">
          SMART NEIGHBORHOOD MAINTENANCE REQUEST AND RESPONSE SYSTEM
        </h1>

        <div class="logo-container" aria-label="Smart Neighborhood Main Logo">
          <img src="/images/smart-neighborhood-logo.png" alt="Smart Neighborhood Main Logo" loading="lazy" decoding="async">
        </div>

        <h2 class="subtitle">SMART RNS PORTAL</h2>

        <p class="description">
          Empowering residents and local authorities to build cleaner, safer, and smarter communities through connected maintenance solutions
        </p>

        <div class="button-group">
          <button class="btn btn-primary" onclick="handleRegister()">REGISTER</button>
          <a href="/login" class="btn btn-secondary">LOG IN</a>
        </div>
      </div>
    </main>

    <footer class="footer">
      <p class="emergency-text">
        Emergency Maintenance Issue? Call 24/7 Hotline:
        <a class="emergency-number" href="tel:+63321234567">(032) 123-4567</a>
      </p>
    </footer>
  </div>

  <script>
    function handleRegister() {
      console.log('Register clicked');
      alert('Registration page coming soon!');
    }
  </script>
</body>
</html>
