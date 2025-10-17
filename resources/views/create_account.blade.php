<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account - Smart Neighborhood Maintenance System</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --ink: rgba(0, 0, 0, 0.78);
      --muted: rgba(146, 146, 146, 0.78);
      --card: rgba(217,217,217,0.56);
      --resident: #08D219;
      --official: #0C51FF;
      --link: #3027E3;
      --radius-lg: 50px;
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

    .background-image { position: absolute; inset: 0; z-index: 1; }
    .background-image::before {
      content: "";
      position: absolute; inset: 0;
      background-image: url('/images/figma-splash.png'), url('/images/background-image.png');
      background-size: cover; background-position: center;
    }

    .gradient-overlay {
      position: absolute; inset: 0; z-index: 2;
      background: linear-gradient(143deg, rgba(236,204,100,.5) 0%, rgba(151,151,151,.4) 36%, rgba(56,8,231,.3) 100%);
    }

    .card {
      position: relative; z-index: 4;
      width: 90%; max-width: 580px;
      background: var(--card);
      border-radius: var(--radius-lg);
      padding: 2rem 2rem;
      backdrop-filter: blur(6px) saturate(110%);
      -webkit-backdrop-filter: blur(6px) saturate(110%);
      box-shadow: 0 12px 28px rgba(0,0,0,.14);
      display: flex; flex-direction: column; gap: 1rem;
    }

    .logo {
      width: 165px; height: 173px; margin: 0 auto 0.5rem;
      background-image: url('/images/figma-logo.png'), url('/images/smart-neighborhood-logo.png');
      background-size: cover; background-position: center; border-radius: 16px;
    }

    .stack { display: flex; flex-direction: column; gap: 0.8rem; }

    label { font-size: 15px; color: var(--ink); }

    .input {
      width: 100%; height: 46px; border-radius: 8px; border: 1px solid #E0E0E0;
      padding: 0 12px; background: #fff; font-size: 16px; color: #000;
    }
    .input::placeholder { color: var(--muted); }

    .row { display: flex; gap: .75rem; align-items: center; }
    .row .btn { flex: 1 1 0; }

    .btn {
      height: 45px; border: none; border-radius: var(--radius-lg);
      color: #EDE9E9; font-weight: 700; font-size: 12px; cursor: pointer;
      transition: transform .15s ease, box-shadow .15s ease, opacity .2s;
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.18); }
    .btn:active { transform: translateY(0); box-shadow: none; }
    .btn-resident { background: var(--resident); }
    .btn-official { background: var(--official); }

    .helper { font-size: 14px; color: var(--ink); text-align: center; }
    .helper a { color: var(--link); text-decoration: none; font-weight: 400; }

    @media (max-width: 640px) {
      .card { padding: 1.25rem 1.25rem; border-radius: 32px; }
      .row { flex-direction: column; }
      .btn { width: 100%; }
      .logo { width: 148px; height: 156px; }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="background-image" aria-hidden="true"></div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <div class="card" role="form" aria-labelledby="create-account-title">
      <div class="logo" aria-label="Smart Neighborhood Logo"></div>

      <div class="stack">
        <label for="username">Username</label>
        <input id="username" class="input" name="username" type="text" placeholder="Enter your Username" autocomplete="username">
      </div>

      <div class="stack">
        <label for="email">Email Address</label>
        <input id="email" class="input" name="email" type="email" placeholder="Enter your email address" autocomplete="email">
      </div>

      <div class="stack">
        <label for="password">Password</label>
        <input id="password" class="input" name="password" type="password" placeholder="**************" autocomplete="new-password">
      </div>

      <div class="stack">
        <label for="confirm_password">Comfirm Password</label>
        <input id="confirm_password" class="input" name="confirm_password" type="password" placeholder="**************" autocomplete="new-password">
      </div>

      <div class="row" style="margin-top:.5rem">
        <button class="btn btn-resident" type="button">Create Resident Account</button>
        <button class="btn btn-official" type="button">Create Official Account</button>
      </div>

      <p class="helper">Already have an account? <a href="/login">Sign In</a></p>
    </div>
  </div>
</body>
</html>


