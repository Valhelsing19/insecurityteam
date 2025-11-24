import { setAuth } from './auth.js';

const togglePassword = document.getElementById('togglePassword');
  let passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');
  const loginForm = document.getElementById('loginForm');
  const emailField = document.getElementById('emailField');
  const passwordField = document.getElementById('passwordField');
  const emailInput = document.getElementById('email');
  const loginBtn = document.getElementById('loginBtn');
  const alertMessage = document.getElementById('alertMessage');
  const alertText = document.getElementById('alertText');

  // Password toggle functionality
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

  function showAlert(message) {
    if (alertMessage && alertText) {
      alertText.textContent = message;
      alertMessage.style.display = 'flex';
      setTimeout(() => {
        alertMessage.style.display = 'none';
      }, 5000);
    } else {
      alert(message);
    }
  }

  function setLoading(isLoading) {
    if (loginBtn) {
      loginBtn.disabled = isLoading;
      const spinner = loginBtn.querySelector('.spinner');
      const btnText = loginBtn.querySelector('.btn-text');
      if (spinner && btnText) {
        if (isLoading) {
          spinner.style.display = 'inline-block';
          btnText.textContent = 'Logging in...';
        } else {
          spinner.style.display = 'none';
          btnText.textContent = 'Login';
        }
      }
    }
  }

  function validateForm() {
    let isValid = true;

    // Validate email
    const emailValue = emailInput.value.trim();
    if (!emailValue) {
      showFieldError(emailField, 'Email is required');
      isValid = false;
    } else if (!validateEmail(emailValue)) {
      showFieldError(emailField, 'Please enter a valid email address');
      isValid = false;
    } else {
      clearFieldError(emailField);
    }

    // Validate password
    const passwordValue = passwordInput.value.trim();
    if (!passwordValue) {
      showFieldError(passwordField, 'Password is required');
      isValid = false;
    } else {
      clearFieldError(passwordField);
    }

    return isValid;
  }

  // Clear errors when user starts typing
  if (emailInput) {
    emailInput.addEventListener('input', function() {
      if (this.value.trim()) {
        clearFieldError(emailField);
      }
    });
  }

  if (passwordInput) {
    passwordInput.addEventListener('input', function() {
      if (this.value.trim()) {
        clearFieldError(passwordField);
      }
    });
  }

  // Form submission handler
  if (loginForm) {
    loginForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      if (!validateForm()) {
        return false;
      }

      setLoading(true);

      try {
        const response = await fetch('/.netlify/functions/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: emailInput.value.trim(),
            password: passwordInput.value,
            isOfficial: false
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          // Store authentication
          setAuth(data.token, data.user);

          // Redirect based on user type
          if (data.user.isOfficial) {
            window.location.href = '/dashboard/official';
          } else {
            window.location.href = '/dashboard';
          }
        } else {
          showAlert(data.error || 'Invalid email or password');
          setLoading(false);
        }
      } catch (error) {
        console.error('Login error:', error);
        showAlert('An error occurred. Please try again.');
        setLoading(false);
      }
    });
  }

  // Google Sign-In handler
  const googleSigninBtn = document.getElementById('googleSignin');
  if (googleSigninBtn) {
    // Load and initialize Google Sign-In on page load
    loadGoogleScript().then(() => {
      // Initialize Google Sign-In
      google.accounts.id.initialize({
        client_id: '490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com',
        callback: handleGoogleSignIn
      });

      // Render the Google Sign-In button (this handles clicks automatically)
      google.accounts.id.renderButton(googleSigninBtn, {
        theme: 'outline',
        size: 'large',
        width: '100%',
        text: 'signin_with',
        type: 'standard'
      });

      console.log('Google Sign-In initialized and button rendered');
    }).catch(error => {
      console.error('Failed to load Google script:', error);
      showAlert('Failed to load Google Sign-In. Please refresh the page.');
    });
  }

  // Load Google Identity Services script
  function loadGoogleScript() {
    return new Promise((resolve, reject) => {
      if (window.google && window.google.accounts) {
        resolve();
        return;
      }

      const script = document.createElement('script');
      script.src = 'https://accounts.google.com/gsi/client';
      script.async = true;
      script.defer = true;
      script.onload = resolve;
      script.onerror = reject;
      document.head.appendChild(script);
    });
  }

  // Handle Google Sign-In callback
  async function handleGoogleSignIn(response) {
    console.log('Google Sign-In callback received');
    try {
      setLoading(true);

      if (!response || !response.credential) {
        throw new Error('No credential received from Google');
      }

      // Send token to backend with timeout
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout

      let result;
      try {
        result = await fetch('/.netlify/functions/google-auth', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            token: response.credential,
            isOfficial: false
          }),
          signal: controller.signal
        });
        clearTimeout(timeoutId);
      } catch (fetchError) {
        clearTimeout(timeoutId);
        if (fetchError.name === 'AbortError') {
          throw new Error('Request timed out. Please check your internet connection and try again.');
        } else if (fetchError.message && fetchError.message.includes('Failed to fetch')) {
          throw new Error('Network error. Please check your internet connection and try again.');
        } else {
          throw new Error('Failed to connect to server. Please try again.');
        }
      }

      // Parse JSON response with error handling
      let data;
      try {
        const text = await result.text();
        if (!text) {
          throw new Error('Empty response from server');
        }
        data = JSON.parse(text);
      } catch (parseError) {
        console.error('JSON parse error:', parseError);
        throw new Error('Invalid response from server. Please try again.');
      }

      if (result.ok && data.success) {
        // Validate response data
        if (!data.token || !data.user) {
          throw new Error('Invalid response from server. Missing authentication data.');
        }

        // Store authentication
        try {
          setAuth(data.token, data.user);
        } catch (authError) {
          console.error('Auth storage error:', authError);
          throw new Error('Failed to save authentication. Please try again.');
        }

        // Redirect based on user type
        try {
          if (data.user.isOfficial) {
            window.location.href = '/dashboard/official';
          } else {
            window.location.href = '/dashboard';
          }
        } catch (redirectError) {
          console.error('Redirect error:', redirectError);
          showAlert('Sign-in successful, but redirect failed. Please navigate to the dashboard manually.');
          setLoading(false);
        }
      } else {
        // Handle error response
        const errorMessage = data.error || 'Google sign-in failed. Please try again.';
        showAlert(errorMessage);
        setLoading(false);
      }
    } catch (error) {
      console.error('Google sign-in error:', error);
      let errorMessage = 'An error occurred during sign-in.';

      if (error.message) {
        errorMessage = error.message;
      } else if (error.name === 'TypeError' && error.message.includes('fetch')) {
        errorMessage = 'Network error. Please check your internet connection and try again.';
      } else if (error.name === 'SyntaxError') {
        errorMessage = 'Invalid response from server. Please try again.';
      }

      showAlert(errorMessage);
      setLoading(false);
    }
  }
