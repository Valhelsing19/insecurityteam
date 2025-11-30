// Import auth functions
import { setAuth } from './auth.js';

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
  if (!firstName || !firstName.value.trim()) {
    showFieldError(document.getElementById('firstNameField'), 'First name is required');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('firstNameField'));
  }

  // Validate last name
  const lastName = document.getElementById('last_name');
  if (!lastName || !lastName.value.trim()) {
    showFieldError(document.getElementById('lastNameField'), 'Last name is required');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('lastNameField'));
  }

  // Validate username
  const username = document.getElementById('username');
  if (!username || !username.value.trim()) {
    showFieldError(document.getElementById('usernameField'), 'Username is required');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('usernameField'));
  }

  // Validate email
  const email = document.getElementById('email');
  if (!email) {
    isValid = false;
  } else {
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
  }

  // Validate phone
  const phone = document.getElementById('phone');
  if (!phone || !phone.value.trim()) {
    showFieldError(document.getElementById('phoneField'), 'Phone number is required');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('phoneField'));
  }

  // Validate password
  const password = document.getElementById('password');
  if (!password || !password.value.trim()) {
    showFieldError(document.getElementById('passwordField'), 'Password is required');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('passwordField'));
  }

  // Validate confirm password
  const confirmPassword = document.getElementById('confirm_password');
  if (!confirmPassword || !confirmPassword.value.trim()) {
    showFieldError(document.getElementById('confirmPasswordField'), 'Please confirm your password');
    isValid = false;
  } else if (password && password.value !== confirmPassword.value) {
    showFieldError(document.getElementById('confirmPasswordField'), 'Passwords do not match');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('confirmPasswordField'));
  }

  // Validate address
  const address = document.getElementById('address');
  if (!address || !address.value.trim()) {
    showFieldError(document.getElementById('addressField'), 'Address is required');
    isValid = false;
  } else {
    clearFieldError(document.getElementById('addressField'));
  }

  return isValid;
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('createAccountForm');
  const createAccountBtn = document.getElementById('createAccountBtn');
  const googleSignupBtn = document.getElementById('googleSignin');

  if (!form) {
    console.error('Form element not found');
    return;
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

      // Disable button and show loading state
      if (createAccountBtn) {
        createAccountBtn.disabled = true;
        createAccountBtn.textContent = 'Signing up...';
      }

      // Get form data
      const formData = {
        first_name: document.getElementById('first_name').value.trim(),
        last_name: document.getElementById('last_name').value.trim(),
        username: document.getElementById('username').value.trim(),
        email: document.getElementById('email').value.trim(),
        phone: document.getElementById('phone').value.trim(),
        password: document.getElementById('password').value,
        address: document.getElementById('address').value.trim()
      };

      try {
        // Send registration request with timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout

        let result;
        try {
          result = await fetch('/.netlify/functions/register', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData),
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

          // Redirect to dashboard
          try {
            window.location.href = '/dashboard';
          } catch (redirectError) {
            console.error('Redirect error:', redirectError);
            alert('Account created successfully, but redirect failed. Please navigate to the dashboard manually.');
            if (createAccountBtn) {
              createAccountBtn.disabled = false;
              createAccountBtn.textContent = 'Create Account';
            }
          }
        } else {
          // Handle error response
          const errorMessage = data.error || 'Registration failed. Please try again.';
          alert(errorMessage);
          if (createAccountBtn) {
            createAccountBtn.disabled = false;
            createAccountBtn.textContent = 'Create Account';
          }
        }
      } catch (error) {
        console.error('Registration error:', error);
        let errorMessage = 'An error occurred during registration.';

        if (error.message) {
          errorMessage = error.message;
        } else if (error.name === 'TypeError' && error.message.includes('fetch')) {
          errorMessage = 'Network error. Please check your internet connection and try again.';
        } else if (error.name === 'SyntaxError') {
          errorMessage = 'Invalid response from server. Please try again.';
        }

        alert(errorMessage);
        if (createAccountBtn) {
          createAccountBtn.disabled = false;
          createAccountBtn.textContent = 'Create Account';
        }
      }
    });
  }

  // Google Sign-In handler
  if (googleSignupBtn) {
    // Load and initialize Google Sign-In on page load
    loadGoogleScript().then(() => {
      // Initialize Google Sign-In
      google.accounts.id.initialize({
        client_id: '490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com',
        callback: handleGoogleSignUp
      });

      // Render the Google Sign-In button (this handles clicks automatically)
      google.accounts.id.renderButton(googleSignupBtn, {
        theme: 'outline',
        size: 'large',
        width: '100%',
        text: 'signup_with',
        type: 'standard'
      });

      console.log('Google Sign-In initialized and button rendered');
    }).catch(error => {
      console.error('Failed to load Google script:', error);
      alert('Failed to load Google Sign-In. Please refresh the page.');
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

  // Handle Google Sign-Up callback
  async function handleGoogleSignUp(response) {
    console.log('Google Sign-Up callback received');
    try {
      if (createAccountBtn) {
        createAccountBtn.disabled = true;
        createAccountBtn.textContent = 'Signing up...';
      }

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

        // Redirect to dashboard
        try {
          window.location.href = '/dashboard';
        } catch (redirectError) {
          console.error('Redirect error:', redirectError);
          alert('Sign-up successful, but redirect failed. Please navigate to the dashboard manually.');
          if (createAccountBtn) {
            createAccountBtn.disabled = false;
            createAccountBtn.textContent = 'Create Account';
          }
        }
      } else {
        // Handle error response
        const errorMessage = data.error || 'Google sign-up failed. Please try again.';
        alert(errorMessage);
        if (createAccountBtn) {
          createAccountBtn.disabled = false;
          createAccountBtn.textContent = 'Create Account';
        }
      }
    } catch (error) {
      console.error('Google sign-up error:', error);
      let errorMessage = 'An error occurred during sign-up.';

      if (error.message) {
        errorMessage = error.message;
      } else if (error.name === 'TypeError' && error.message.includes('fetch')) {
        errorMessage = 'Network error. Please check your internet connection and try again.';
      } else if (error.name === 'SyntaxError') {
        errorMessage = 'Invalid response from server. Please try again.';
      }

      alert(errorMessage);
      if (createAccountBtn) {
        createAccountBtn.disabled = false;
        createAccountBtn.textContent = 'Create Account';
      }
    }
  }
});
