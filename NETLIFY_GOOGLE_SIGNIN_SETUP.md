# Netlify Configuration for Google Sign-In

This guide explains what you need to configure in Netlify for Google Sign-In to work properly.

## Required Environment Variables

You need to set the following environment variables in your Netlify dashboard:

### 1. **GOOGLE_CLIENT_ID**
- **Value**: `490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com`
- **Where to find it**: Google Cloud Console → APIs & Services → Credentials
- **Purpose**: Identifies your application to Google's authentication service

### 2. **JWT_SECRET**
- **Value**: A secure random string (at least 32 characters)
- **How to generate**: 
  ```bash
  node -e "console.log(require('crypto').randomBytes(32).toString('hex'))"
  ```
- **Purpose**: Used to sign and verify JWT tokens for user sessions

### 3. **SUPABASE_URL**
- **Value**: Your Supabase project URL
- **Format**: `https://xxxxx.supabase.co`
- **Where to find it**: Supabase Dashboard → Project Settings → API

### 4. **SUPABASE_SERVICE_ROLE_KEY**
- **Value**: Your Supabase service role key (NOT the anon key)
- **Where to find it**: Supabase Dashboard → Project Settings → API → service_role key
- **Purpose**: Allows server-side access to your Supabase database
- **⚠️ Important**: Keep this secret! Never expose it in client-side code.

## How to Set Environment Variables in Netlify

1. **Go to Netlify Dashboard**
   - Navigate to your site: `https://app.netlify.com/sites/YOUR_SITE_NAME`

2. **Open Site Settings**
   - Click on **Site configuration** → **Environment variables**

3. **Add Each Variable**
   - Click **Add variable**
   - Enter the variable name (e.g., `GOOGLE_CLIENT_ID`)
   - Enter the variable value
   - Select the scope:
     - **All scopes**: Available everywhere
     - **Builds only**: Only during build time
     - **Deploys only**: Only during deployment
   - For these variables, use **All scopes**

4. **Save and Redeploy**
   - After adding all variables, trigger a new deployment
   - Go to **Deploys** → Click **Trigger deploy** → **Deploy site**

## Google Cloud Console Configuration

You also need to configure your Google OAuth consent screen:

1. **Go to Google Cloud Console**
   - Navigate to: `https://console.cloud.google.com/apis/credentials`

2. **Configure OAuth Consent Screen**
   - Go to **APIs & Services** → **OAuth consent screen**
   - Fill in:
     - **App name**: Smart Neighborhood Maintenance System
     - **User support email**: Your email
     - **Developer contact information**: Your email
   - Add scopes:
     - `email`
     - `profile`
     - `openid`

3. **Add Authorized JavaScript Origins**
   - Go to **APIs & Services** → **Credentials**
   - Click on your OAuth 2.0 Client ID
   - Under **Authorized JavaScript origins**, add:
     - `https://smart-neighborhood.netlify.app`
     - `https://YOUR_SITE_NAME.netlify.app`
     - `http://localhost:8888` (for local development)

4. **Add Authorized Redirect URIs**
   - Under **Authorized redirect URIs**, add:
     - `https://smart-neighborhood.netlify.app`
     - `https://YOUR_SITE_NAME.netlify.app`
     - `http://localhost:8888` (for local development)

## Verify Configuration

After setting everything up:

1. **Check Environment Variables**
   - In Netlify, go to **Site configuration** → **Environment variables**
   - Verify all 4 variables are present

2. **Test Google Sign-In**
   - Visit your site: `https://smart-neighborhood.netlify.app/login`
   - Click "Sign in with Gmail"
   - A Google popup should appear
   - After signing in, you should be redirected to the dashboard

3. **Check Function Logs**
   - If there are errors, go to **Functions** → **google-auth**
   - Check the logs for any error messages

## Troubleshooting

### Google Sign-In button doesn't appear
- Check browser console for JavaScript errors
- Verify `GOOGLE_CLIENT_ID` is set correctly
- Make sure the Google script is loading: Check Network tab for `accounts.google.com/gsi/client`

### "Failed to verify Google token" error
- Verify `GOOGLE_CLIENT_ID` matches the one in Google Cloud Console
- Check that authorized origins include your Netlify domain
- Ensure the OAuth consent screen is published (not in testing mode for production)

### "JWT_SECRET environment variable is not set" error
- Add `JWT_SECRET` to Netlify environment variables
- Redeploy the site after adding it

### "SUPABASE_SERVICE_ROLE_KEY is not set" error
- Add `SUPABASE_SERVICE_ROLE_KEY` to Netlify environment variables
- Make sure you're using the **service_role** key, not the **anon** key

## Security Notes

- ⚠️ **Never commit** environment variables to Git
- ⚠️ **Never expose** `SUPABASE_SERVICE_ROLE_KEY` in client-side code
- ⚠️ **Never expose** `JWT_SECRET` in client-side code
- ✅ Use Netlify's environment variables for all secrets
- ✅ Keep your Google OAuth Client ID secure (though it's less sensitive)

## Summary Checklist

- [ ] `GOOGLE_CLIENT_ID` set in Netlify
- [ ] `JWT_SECRET` set in Netlify (32+ character random string)
- [ ] `SUPABASE_URL` set in Netlify
- [ ] `SUPABASE_SERVICE_ROLE_KEY` set in Netlify
- [ ] OAuth consent screen configured in Google Cloud Console
- [ ] Authorized JavaScript origins added in Google Cloud Console
- [ ] Authorized redirect URIs added in Google Cloud Console
- [ ] Site redeployed after adding environment variables
- [ ] Google Sign-In button appears and works

