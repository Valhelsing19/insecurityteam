# Quick Fix: GOOGLE_CLIENT_ID Environment Variable

## Option 1: Using Netlify CLI (Recommended)

1. **Login to Netlify** (if not already logged in):
   ```powershell
   netlify login
   ```

2. **Run the setup script**:
   ```powershell
   .\set-netlify-env.ps1
   ```

   Or manually set it:
   ```powershell
   netlify env:set GOOGLE_CLIENT_ID "490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com"
   ```

3. **Redeploy your site**:
   - Go to Netlify Dashboard → Deploys → Trigger deploy
   - Or run: `netlify deploy --prod`

## Option 2: Using Netlify Dashboard (Easier)

1. Go to [Netlify Dashboard](https://app.netlify.com)
2. Select your site: **smart-neighborhood**
3. Go to: **Site Settings** → **Environment Variables**
4. Click **Add variable**
5. Set:
   - **Key**: `GOOGLE_CLIENT_ID`
   - **Value**: `490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com`
   - **Scope**: Select **All scopes** (or at least **Production**)
6. Click **Save**
7. **Trigger a new deployment**:
   - Go to **Deploys** tab
   - Click **Trigger deploy** → **Clear cache and deploy site**

## Verify It's Set

After deployment, check the function logs:
1. Go to Netlify Dashboard → Functions
2. Check the logs for `google-auth` function
3. The error should be gone

## Important Notes

- Environment variables are only available after a new deployment
- Make sure the variable scope includes **Production** (or **All scopes**)
- The variable name is case-sensitive: `GOOGLE_CLIENT_ID` (not `google_client_id`)

