# Database Environment Variables Setup

## Required Variables

Your Netlify Functions need the following database environment variables to work:

1. **DB_HOST** - Your MySQL database host (e.g., `your-db-host.com` or `123.456.789.0`)
2. **DB_USER** - Your database username
3. **DB_PASSWORD** - Your database password
4. **DB_NAME** - Your database name
5. **DB_SSL** - Set to `true` for cloud databases (PlanetScale, AWS RDS, etc.) or `false` for local databases

## Quick Setup

### Option 1: Using Netlify CLI (Recommended)

Run these commands after logging in to Netlify:

```powershell
netlify env:set DB_HOST "your-database-host.com"
netlify env:set DB_USER "your-username"
netlify env:set DB_PASSWORD "your-password"
netlify env:set DB_NAME "your-database-name"
netlify env:set DB_SSL "true"
```

### Option 2: Using Netlify Dashboard

1. Go to [Netlify Dashboard](https://app.netlify.com)
2. Select your site: **smart-neigborhood**
3. Go to: **Site Settings** → **Environment Variables**
4. Add each variable:
   - Click **Add variable**
   - Enter the key (e.g., `DB_HOST`)
   - Enter the value
   - Select scope: **All scopes** (or at least **Production**)
   - Click **Save**
5. Repeat for all 5 variables

### Option 3: Using the Setup Script

Run the interactive setup script:

```powershell
.\setup-netlify-env.ps1
```

This will guide you through setting all environment variables.

## Database Providers

### PlanetScale
- **DB_HOST**: Found in your PlanetScale dashboard (e.g., `aws.connect.psdb.cloud`)
- **DB_USER**: Your PlanetScale username
- **DB_PASSWORD**: Your PlanetScale password
- **DB_NAME**: Your database name
- **DB_SSL**: `true`

### AWS RDS
- **DB_HOST**: Your RDS endpoint (e.g., `your-db.123456789.us-east-1.rds.amazonaws.com`)
- **DB_USER**: Your RDS master username
- **DB_PASSWORD**: Your RDS master password
- **DB_NAME**: Your database name
- **DB_SSL**: `true`

### DigitalOcean Managed Database
- **DB_HOST**: Your database host (found in DigitalOcean dashboard)
- **DB_USER**: Your database user
- **DB_PASSWORD**: Your database password
- **DB_NAME**: Your database name
- **DB_SSL**: `true`

### Local MySQL (for testing only)
- **DB_HOST**: `localhost` or your local IP
- **DB_USER**: Usually `root`
- **DB_PASSWORD**: Your MySQL root password
- **DB_NAME**: Your database name
- **DB_SSL**: `false`

**Note**: Local databases won't work with Netlify Functions unless you use a tunneling service like ngrok.

## Verify Setup

After setting all variables, verify them:

```powershell
netlify env:list
```

You should see all 5 database variables listed.

## Redeploy

After setting environment variables, you must redeploy:

1. **Via CLI**:
   ```powershell
   netlify deploy --prod
   ```

2. **Via Dashboard**:
   - Go to **Deploys** tab
   - Click **Trigger deploy** → **Clear cache and deploy site**

## Database Schema

Make sure your database has the `users` table with the following structure:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NULL,
    password VARCHAR(255) NULL,
    address TEXT NULL,
    google_id VARCHAR(255) UNIQUE NULL,
    picture VARCHAR(500) NULL,
    is_official TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_google_id ON users(google_id);
CREATE INDEX idx_email ON users(email);
```

**Note:** For the officials system, you also need to create the `officials`, enhanced `maintenance_requests`, and `request_activity_log` tables. See `database/schema/officials_system.sql` or `OFFICIAL_ACCOUNT_SETUP.md` for details.

If you need to add the Google fields to an existing table:

```sql
ALTER TABLE users ADD COLUMN google_id VARCHAR(255) UNIQUE NULL;
ALTER TABLE users ADD COLUMN picture VARCHAR(500) NULL;
CREATE INDEX idx_google_id ON users(google_id);
```

## Troubleshooting

### "Database configuration is incomplete"
- Make sure all 5 variables are set (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_SSL)
- Check that variables are set for the correct scope (Production or All scopes)
- Redeploy after setting variables

### "Database connection failed"
- Verify your DB_HOST is correct
- Check that your database allows connections from Netlify's IP ranges
- For cloud databases, ensure your firewall/security groups allow external connections
- Verify DB_SSL is set correctly (`true` for cloud, `false` for local)

### "Database access denied"
- Double-check your DB_USER and DB_PASSWORD
- Ensure the user has proper permissions on the database
- Verify the user exists in your database

### "Database does not exist"
- Check your DB_NAME matches exactly (case-sensitive)
- Ensure the database has been created

## Security Notes

- Never commit database credentials to Git
- Use strong, unique passwords
- Rotate passwords regularly
- Consider using database connection pooling for production
- Enable SSL for all cloud databases (DB_SSL=true)

