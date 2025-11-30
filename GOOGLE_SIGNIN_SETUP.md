# Google Sign-In Setup Instructions

## Environment Variables

Add the following environment variable in Netlify Dashboard:

**Key:** `GOOGLE_CLIENT_ID`  
**Value:** `490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com`

## Database Migration

Run the following SQL in your MySQL database:

```sql
ALTER TABLE users ADD COLUMN google_id VARCHAR(255) UNIQUE NULL;
ALTER TABLE users ADD COLUMN picture VARCHAR(500) NULL;
CREATE INDEX idx_google_id ON users(google_id);
```

Or use the migration file: `database/migrations/add_google_fields.sql`

## Installation Steps

1. **Install dependencies:**
   ```bash
   cd netlify/functions
   npm install
   ```

2. **Set environment variable in Netlify:**
   - Go to Netlify Dashboard → Site Settings → Environment Variables
   - Add `GOOGLE_CLIENT_ID` with your Client ID value

3. **Run database migration:**
   - Execute the SQL migration in your MySQL database

4. **Deploy:**
   - Commit and push changes to GitHub
   - Netlify will automatically rebuild

## Testing

1. Test locally:
   ```bash
   netlify dev
   ```

2. Visit `http://localhost:8888/login.html`
3. Click the "Sign in with Gmail" button
4. Complete Google authentication

## Notes

- The Google Client ID is embedded in the frontend JavaScript (this is safe and standard practice)
- The Client Secret is NOT needed for this implementation
- Make sure your Google OAuth redirect URIs are configured correctly in Google Cloud Console

