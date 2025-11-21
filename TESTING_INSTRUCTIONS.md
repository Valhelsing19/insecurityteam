# Testing Google Sign-In - Important Instructions

## ⚠️ CRITICAL: Use Netlify Dev, NOT Laravel Server

You **MUST** use Netlify's development server, not the old Laravel server.

### ❌ WRONG (Don't use this):
```bash
php artisan serve
# Then accessing: http://127.0.0.1:8000
```

### ✅ CORRECT (Use this):
```bash
netlify dev
# Then accessing: http://localhost:8888
```

## Steps to Test

1. **Stop any Laravel server** (if running):
   - Press `Ctrl+C` in the terminal running `php artisan serve`

2. **Start Netlify Dev**:
   ```bash
   netlify dev
   ```

3. **Access the site**:
   - Open browser: `http://localhost:8888`
   - Navigate to: `http://localhost:8888/login.html`

4. **Test Google Sign-In**:
   - Click "Sign in with Gmail" button
   - A Google popup should appear
   - Sign in with your Google account
   - You should be redirected to the dashboard

## Troubleshooting

### If button doesn't do anything:

1. **Open browser console** (F12 → Console tab)
2. **Check for errors** - Look for:
   - CORS errors
   - Script loading errors
   - Network errors

3. **Verify Google Script is loading**:
   - In console, type: `window.google`
   - Should return an object, not `undefined`

4. **Check Network tab**:
   - Look for request to `/.netlify/functions/google-auth`
   - Check if it's returning 200 or an error

### Common Issues:

1. **"404 Not Found" on `/auth/google`**:
   - This route doesn't exist in Netlify
   - The correct endpoint is `/.netlify/functions/google-auth`
   - Make sure you're using `netlify dev`, not Laravel server

2. **Button click does nothing**:
   - Check browser console for JavaScript errors
   - Make sure you're accessing via `http://localhost:8888`, not `http://127.0.0.1:8000`
   - Verify the script tag in HTML is loading correctly

3. **Google popup doesn't appear**:
   - Check if popup is blocked by browser
   - Verify Google Client ID is correct
   - Check Google Cloud Console for authorized origins

## Environment Setup

Make sure you have:
- ✅ `GOOGLE_CLIENT_ID` set in Netlify environment variables
- ✅ Database migration run (google_id and picture columns)
- ✅ Dependencies installed: `cd netlify/functions && npm install`

## Testing on Production

After deploying to Netlify:
- Visit: `https://smart-neigborhood.netlify.app/login.html`
- Test Google Sign-In button
- Check Netlify Functions logs if there are errors

