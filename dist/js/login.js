import { setAuth } from './auth.js';

(function(){
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
    alertText.textContent = message;
    alertMessage.style.display = 'flex';
    setTimeout(() => {
      alertMessage.style.display = 'none';
    }, 5000);
  }

  function setLoading(isLoading) {
    loginBtn.disabled = isLoading;
    if (isLoading) {
      loginBtn.querySelector('.spinner').style.display = 'inline-block';
      loginBtn.querySelector('.btn-text').textContent = 'Logging in...';
    } else {
      loginBtn.querySelector('.spinner').style.display = 'none';
      loginBtn.querySelector('.btn-text').textContent = 'Login';
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
            window.location.href = '/dashboard/official.html';
          } else {
            window.location.href = '/dashboard.html';
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

  // Also validate on button click (in case form submission is handled differently)
  if (loginBtn) {
    loginBtn.addEventListener('click', function(e) {
      if (!validateForm()) {
        e.preventDefault();
        return false;
      }
    });
  }
})();

