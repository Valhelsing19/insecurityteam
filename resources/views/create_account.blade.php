<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account - Smart Neighborhood Maintenance System</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --error: #EF4444;
      --radius-md: 8px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Arimo', sans-serif;
      background: linear-gradient(135deg, rgba(239, 246, 255, 1) 0%, rgba(238, 242, 255, 1) 50%, rgba(250, 245, 255, 1) 100%);
      overflow-x: hidden;
      min-height: 100dvh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
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
      background: linear-gradient(135deg, rgba(239, 246, 255, 1) 0%, rgba(238, 242, 255, 1) 50%, rgba(250, 245, 255, 1) 100%);
      z-index: 1;
    }

    .gradient-overlay {
      display: none;
    }

    /* Card */
    .card {
      position: relative; z-index: 4;
      width: 90%; max-width: 608px;
      background: rgba(255, 255, 255, 0.8);
      border-radius: 14px;
      box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
      padding: 24px 24px 24px 24px;
      display: flex; flex-direction: column; gap: 32px;
    }

    /* Header Section */
    .header-section {
      display: flex; flex-direction: column; align-items: center; gap: 0;
      text-align: center;
    }

    .logo {
      width: 102px; height: 102px;
      background-image: url('/images/smart-neighborhood-logo.png');
      background-size: cover; background-position: center;
      border-radius: 216px;
      margin: 0 auto 0.25rem;
      box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }

    .title {
      font-size: 30px;
      font-weight: 400;
      font-family: 'Arimo', sans-serif;
      background: linear-gradient(90deg, rgba(21, 93, 252, 1) 0%, rgba(79, 57, 246, 1) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      line-height: 1.2em;
      text-align: center;
      margin-bottom: 0.25rem;
    }

    .subtitle {
      font-size: 16px;
      font-weight: 400;
      font-family: 'Arimo', sans-serif;
      color: #717182;
      line-height: 1.5em;
      text-align: center;
    }

    /* Form */
    .form-section {
      display: flex; flex-direction: column; gap: 16px;
    }

    .form-row {
      display: flex; gap: 12px; width: 100%;
    }

    .form-row .field {
      flex: 1;
    }

    .field {
      display: flex; flex-direction: column; gap: 8px;
      width: 100%;
    }

    .field.full-width {
      width: 100%;
    }

    label {
      font-size: 14px;
      font-weight: 400;
      font-family: 'Arimo', sans-serif;
      color: #0A0A0A;
      line-height: 1em;
    }

    .input-wrapper {
      position: relative;
      width: 100%;
    }

    .input-wrapper input {
      width: 100%;
      height: 36px;
      box-sizing: border-box;
      border-radius: 8px;
      border: 0.714286px solid rgba(0, 0, 0, 0);
      padding: 4px 12px 4px 40px;
      background: #FFFFFF;
      font-size: 14px;
      font-family: 'Arimo', sans-serif;
      font-weight: 400;
      line-height: 1.14990234375em;
      color: #000;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .input-wrapper input::placeholder {
      color: #717182;
      font-family: 'Arimo', sans-serif;
      font-size: 14px;
      font-weight: 400;
    }

    .input-wrapper input:focus {
      border-color: rgba(0, 0, 0, 0.1);
      box-shadow: 0 0 0 3px rgba(21, 93, 252, 0.15);
      outline: none;
      background: #fff;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      pointer-events: none;
      color: #717182;
    }

    .field.error input {
      border-color: var(--error);
      box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
    }

    .error-message {
      font-size: 12px;
      font-family: 'Arimo', sans-serif;
      color: var(--error);
      display: none;
      text-align: left;
      width: 100%;
      margin-top: 4px;
    }

    .field.error .error-message {
      display: block;
    }

    /* Address field - full width */
    .address-field {
      width: 100%;
    }

    .address-field .input-wrapper input {
      padding: 4px 12px 4px 40px;
    }

    /* Button */
    .btn-create {
      width: 100%;
      height: 36px;
      border: none;
      border-radius: 8px;
      font-weight: 400;
      font-size: 14px;
      font-family: 'Arimo', sans-serif;
      line-height: 1.4285714285714286em;
      color: #FFFFFF;
      cursor: pointer;
      transition: all 0.2s ease;
      background: linear-gradient(90deg, rgba(21, 93, 252, 1) 0%, rgba(79, 57, 246, 1) 100%);
      box-shadow: 0px 4px 6px -4px rgba(43, 127, 255, 0.3), 0px 10px 15px -3px rgba(43, 127, 255, 0.3);
    }

    .btn-create:hover:not(:disabled) {
      box-shadow: 0px 6px 8px -4px rgba(43, 127, 255, 0.4), 0px 12px 18px -3px rgba(43, 127, 255, 0.4);
      transform: translateY(-1px);
    }

    .btn-create:active:not(:disabled) {
      transform: translateY(0);
    }

    .btn-create:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    /* Google sign-in (match login page) */
    .google-signin {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.65rem 1rem;
      background: rgba(255,255,255,0.95);
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s;
      border: 0.714286px solid rgba(0, 0, 0, 0);
      width: 100%;
    }
    .google-signin:hover {
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,.1);
      transform: translateY(-1px);
    }
    .google-signin svg { width: 18px; height: 18px; }
    .google-signin-text {
      font-size: 14px;
      font-family: 'Arimo', sans-serif;
      color: #0A0A0A;
      font-weight: 400;
    }

    /* Footer */
    .footer-section {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 4px;
      font-size: 14px;
      font-family: 'Arimo', sans-serif;
      font-weight: 400;
      color: #717182;
    }

    .footer-section a {
      color: #155DFC;
      text-decoration: none;
      transition: color 0.2s;
    }

    .footer-section a:hover {
      color: rgba(21, 93, 252, 0.8);
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .card {
        max-width: 100%;
        padding: 1.5rem 1.5rem;
        gap: 32px;
      }
      .form-row {
        flex-direction: column;
        gap: 20px;
      }
      .title {
        font-size: 24px;
      }
      .subtitle {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="background-image" aria-hidden="true"></div>
    <div class="gradient-overlay" aria-hidden="true"></div>

    <div class="card" role="form" aria-labelledby="create-account-title">
      <!-- Header Section -->
      <div class="header-section">
        <div class="logo" aria-label="Smart Neighborhood Logo"></div>
        <h1 class="title" id="create-account-title">Create Your Account</h1>
        <p class="subtitle">Join the Smart Neighborhood community</p>
      </div>

      <!-- Form Section -->
      <form class="form-section" id="createAccountForm" novalidate>
        <!-- First Name and Last Name Row -->
        <div class="form-row">
          <div class="field" id="firstNameField">
            <label for="first_name">First Name *</label>
            <div class="input-wrapper">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
              </svg>
              <input id="first_name" name="first_name" type="text" placeholder="" autocomplete="given-name" required>
            </div>
            <span class="error-message">First name is required</span>
          </div>

          <div class="field" id="lastNameField">
            <label for="last_name">Last Name *</label>
            <div class="input-wrapper">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
              </svg>
              <input id="last_name" name="last_name" type="text" placeholder="" autocomplete="family-name" required>
            </div>
            <span class="error-message">Last name is required</span>
          </div>
        </div>

        <!-- Username and Email Row -->
        <div class="form-row">
          <div class="field" id="usernameField">
            <label for="username">Username *</label>
            <div class="input-wrapper">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
              </svg>
              <input id="username" name="username" type="text" placeholder="" autocomplete="username" required>
            </div>
            <span class="error-message">Username is required</span>
          </div>

          <div class="field" id="emailField">
            <label for="email">Email *</label>
            <div class="input-wrapper">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 4H4C2.9 4 2.01 4.9 2.01 6L2 18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 18H4V8L12 13L20 8V18ZM12 11L4 6H20L12 11Z" fill="currentColor"/>
              </svg>
              <input id="email" name="email" type="email" placeholder="" autocomplete="email" required>
            </div>
            <span class="error-message">Please enter a valid email address</span>
          </div>
        </div>

        <!-- Phone Number Row -->
        <div class="field full-width" id="phoneField">
          <label for="phone">Phone Number *</label>
          <div class="input-wrapper">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" fill="currentColor"/>
            </svg>
            <input id="phone" name="phone" type="tel" placeholder="09XXXXXXXXX" pattern="^09\d{9}$" autocomplete="tel" required>
          </div>
          <span class="error-message">Please enter a valid Philippine mobile number</span>
        </div>

        <!-- Password and Confirm Password Row -->
        <div class="form-row">
          <div class="field" id="passwordField">
            <label for="password">Password *</label>
            <div class="input-wrapper">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 8H17V6C17 3.24 14.76 1 12 1S7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM12 3C13.66 3 15 4.34 15 6V8H9V6C9 4.34 10.34 3 12 3ZM18 20H6V10H18V20Z" fill="currentColor"/>
              </svg>
              <input id="password" name="password" type="password" placeholder="••••••••" autocomplete="new-password" required>
            </div>
            <span class="error-message">Password is required</span>
          </div>

          <div class="field" id="confirmPasswordField">
            <label for="confirm_password">Confirm Password *</label>
            <div class="input-wrapper">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 8H17V6C17 3.24 14.76 1 12 1S7 3.24 7 6V8H6C4.9 8 4 8.9 4 10V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10C20 8.9 19.1 8 18 8ZM12 3C13.66 3 15 4.34 15 6V8H9V6C9 4.34 10.34 3 12 3ZM18 20H6V10H18V20Z" fill="currentColor"/>
              </svg>
              <input id="confirm_password" name="confirm_password" type="password" placeholder="••••••••" autocomplete="new-password" required>
            </div>
            <span class="error-message">Passwords do not match</span>
          </div>
        </div>

        <!-- Address Field - Full Width -->
        <div class="field address-field full-width" id="addressField">
          <label for="address">Address *</label>
          <div class="input-wrapper">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z" fill="currentColor"/>
            </svg>
            <input id="address" name="address" type="text" placeholder="123 Main Street" autocomplete="street-address" required>
          </div>
          <span class="error-message">Address is required</span>
        </div>

        <!-- Create Account Button -->
        <button type="submit" class="btn-create" id="createAccountBtn">
          Create Account
        </button>
      </form>

      <div class="google-signin" role="button" tabindex="0" aria-label="Sign up with Google" id="googleSignin">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
          <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
          <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
          <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
          <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        <span class="google-signin-text">Sign in with Gmail</span>
      </div>

      <!-- Footer Section -->
      <div class="footer-section">
        <span>Already have an account?</span>
        <a href="/login">Sign In</a>
      </div>
    </div>
  </div>

  <script>
    (function(){
      const form = document.getElementById('createAccountForm');
      const createAccountBtn = document.getElementById('createAccountBtn');
      const googleSignupBtn = document.getElementById('googleSignin');

      // Form validation
      function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
      }

      function showFieldError(field, message) {
        field.classList.add('error');
        const errorMessage = field.querySelector('.error-message');
        if (errorMessage) {
          errorMessage.textContent = message;
        }
      }

      function clearFieldError(field) {
        field.classList.remove('error');
      }

      function validateForm() {
        let isValid = true;

        // Validate first name
        const firstName = document.getElementById('first_name');
        if (!firstName.value.trim()) {
          showFieldError(document.getElementById('firstNameField'), 'First name is required');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('firstNameField'));
        }

        // Validate last name
        const lastName = document.getElementById('last_name');
        if (!lastName.value.trim()) {
          showFieldError(document.getElementById('lastNameField'), 'Last name is required');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('lastNameField'));
        }

        // Validate username
        const username = document.getElementById('username');
        if (!username.value.trim()) {
          showFieldError(document.getElementById('usernameField'), 'Username is required');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('usernameField'));
        }

        // Validate email
        const email = document.getElementById('email');
        const emailValue = email.value.trim();
        if (!emailValue) {
          showFieldError(document.getElementById('emailField'), 'Email is required');
          isValid = false;
        } else if (!validateEmail(emailValue)) {
          showFieldError(document.getElementById('emailField'), 'Please enter a valid email address');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('emailField'));
        }

        // Validate phone
        const phone = document.getElementById('phone');
        if (!phone.value.trim()) {
          showFieldError(document.getElementById('phoneField'), 'Phone number is required');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('phoneField'));
        }

        // Validate password
        const password = document.getElementById('password');
        if (!password.value.trim()) {
          showFieldError(document.getElementById('passwordField'), 'Password is required');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('passwordField'));
        }

        // Validate confirm password
        const confirmPassword = document.getElementById('confirm_password');
        if (!confirmPassword.value.trim()) {
          showFieldError(document.getElementById('confirmPasswordField'), 'Please confirm your password');
          isValid = false;
        } else if (password.value !== confirmPassword.value) {
          showFieldError(document.getElementById('confirmPasswordField'), 'Passwords do not match');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('confirmPasswordField'));
        }

        // Validate address
        const address = document.getElementById('address');
        if (!address.value.trim()) {
          showFieldError(document.getElementById('addressField'), 'Address is required');
          isValid = false;
        } else {
          clearFieldError(document.getElementById('addressField'));
        }

        return isValid;
      }

      // Clear errors when user starts typing
      const inputs = form.querySelectorAll('input');
      inputs.forEach(input => {
        input.addEventListener('input', function() {
          const field = this.closest('.field');
          if (field && this.value.trim()) {
            clearFieldError(field);
          }
        });
      });

      // Form submission handler
      if (form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();

          if (!validateForm()) {
            return false;
          }

          // If validation passes, you can proceed with the actual form submission
          // Uncomment the line below when you're ready to submit the form
          // this.submit();
        });
      }

      if (googleSignupBtn) {
        googleSignupBtn.addEventListener('click', function() {
          window.location.href = '/auth/google';
        });
      }
    })();
  </script>
</body>
</html>
