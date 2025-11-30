// Authentication helper functions
const AUTH_TOKEN_KEY = 'auth_token';
const USER_DATA_KEY = 'user_data';

// Get stored token
export function getAuthToken() {
  return localStorage.getItem(AUTH_TOKEN_KEY);
}

// Get stored user data
export function getUserData() {
  const userData = localStorage.getItem(USER_DATA_KEY);
  return userData ? JSON.parse(userData) : null;
}

// Set authentication token and user data
export function setAuth(token, user) {
  localStorage.setItem(AUTH_TOKEN_KEY, token);
  localStorage.setItem(USER_DATA_KEY, JSON.stringify(user));
}

// Clear authentication
export function clearAuth() {
  localStorage.removeItem(AUTH_TOKEN_KEY);
  localStorage.removeItem(USER_DATA_KEY);
}

// Check if user is authenticated
export function isAuthenticated() {
  return !!getAuthToken();
}

// Check if user is official
export function isOfficial() {
  const user = getUserData();
  return user && user.isOfficial === true;
}

// Make authenticated API request
export async function apiRequest(url, options = {}) {
  const token = getAuthToken();
  
  const headers = {
    'Content-Type': 'application/json',
    ...options.headers
  };

  if (token) {
    headers['Authorization'] = `Bearer ${token}`;
  }

  const response = await fetch(url, {
    ...options,
    headers
  });

  if (response.status === 401) {
    // Token expired or invalid
    clearAuth();
    window.location.href = '/login';
    return null;
  }

  return response;
}

// Redirect if not authenticated
export function requireAuth(redirectTo = '/login') {
  if (!isAuthenticated()) {
    window.location.href = redirectTo;
    return false;
  }
  return true;
}

// Redirect if not official
export function requireOfficial(redirectTo = '/dashboard') {
  if (!isOfficial()) {
    window.location.href = redirectTo;
    return false;
  }
  return true;
}

