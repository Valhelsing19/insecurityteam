import { setAuth } from './auth.js';

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

  function setLoading(isLoading) {
    if (createAccountBtn) {
      createAccountBtn.disabled = isLoading;
      if (isLoading) {
        createAccountBtn.textContent = 'Creating Account...';
      } else {
        createAccountBtn.textContent = 'Create Account';
      }
    }
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
    form.addEventListener('submit', async function(e) {
      e.preventDefault();

      if (!validateForm()) {
        return false;
      }

      setLoading(true);

      try {
        const response = await fetch('/.netlify/functions/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            first_name: document.getElementById('first_name').value.trim(),
            last_name: document.getElementById('last_name').value.trim(),
            username: document.getElementById('username').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            password: document.getElementById('password').value,
            address: document.getElementById('address').value.trim()
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          // Store authentication
          setAuth(data.token, data.user);
          
          // Redirect to dashboard
          window.location.href = '/dashboard.html';
        } else {
          alert(data.error || 'Registration failed. Please try again.');
          setLoading(false);
        }
      } catch (error) {
        console.error('Registration error:', error);
        alert('An error occurred. Please try again.');
        setLoading(false);
      }
    });
  }

  // Google Sign-In handler
  if (googleSignupBtn) {
    googleSignupBtn.addEventListener('click', async function() {
      try {
        await loadGoogleScript();
        
        google.accounts.id.initialize({
          client_id: '490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com',
          callback: handleGoogleSignUp
        });

        google.accounts.id.prompt();
      } catch (error) {
        console.error('Google Sign-Up error:', error);
        alert('Failed to initialize Google Sign-Up. Please try again.');
      }
    });
  }

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

  async function handleGoogleSignUp(response) {
    try {
      setLoading(true);

      const result = await fetch('/.netlify/functions/google-auth', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          token: response.credential,
          isOfficial: false
        })
      });

      const data = await result.json();

      if (result.ok && data.success) {
        setAuth(data.token, data.user);
        window.location.href = '/dashboard.html';
      } else {
        alert(data.error || 'Google sign-up failed. Please try again.');
        setLoading(false);
      }
    } catch (error) {
      console.error('Google sign-up error:', error);
      alert('An error occurred during sign-up. Please try again.');
      setLoading(false);
    }
  }
})();
