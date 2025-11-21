# Netlify Deployment Guide

This guide will help you deploy your Smart Neighborhood Maintenance System to Netlify.

## Prerequisites

1. A Netlify account (sign up at https://netlify.com)
2. A MySQL database (you can use services like PlanetScale, AWS RDS, DigitalOcean, etc.)
3. Git repository (GitHub, GitLab, or Bitbucket)

## Step 1: Set Up MySQL Database

1. Create a MySQL database using your preferred provider
2. Run the following SQL to create the necessary tables:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    address TEXT,
    is_official TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE maintenance_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT 'general',
    status ENUM('pending', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX idx_user_id ON maintenance_requests(user_id);
CREATE INDEX idx_status ON maintenance_requests(status);
```

## Step 2: Build the Project

1. Install dependencies:
```bash
npm install
```

2. Build the project:
```bash
npm run build:netlify
```

This will:
- Copy all assets (CSS, JS, images) to the `dist` folder
- Convert Blade templates to static HTML files

## Step 3: Deploy to Netlify

### Option A: Deploy via Netlify Dashboard

1. Go to [Netlify Dashboard](https://app.netlify.com)
2. Click "Add new site" → "Import an existing project"
3. Connect your Git repository
4. Configure build settings:
   - **Build command:** `npm run build:netlify`
   - **Publish directory:** `dist`
   - **Node version:** 18

### Option B: Deploy via Netlify CLI

1. Install Netlify CLI:
```bash
npm install -g netlify-cli
```

2. Login to Netlify:
```bash
netlify login
```

3. Initialize and deploy:
```bash
netlify init
netlify deploy --prod
```

## Step 4: Configure Environment Variables

1. Go to your site settings in Netlify Dashboard
2. Navigate to "Environment variables"
3. Add the following variables:

```
DB_HOST=your-mysql-host.com
DB_USER=your-database-user
DB_PASSWORD=your-database-password
DB_NAME=your-database-name
DB_SSL=true
JWT_SECRET=your-super-secret-jwt-key
APP_URL=https://your-site.netlify.app
```

**Important:** Generate a strong JWT_SECRET. You can use:
```bash
node -e "console.log(require('crypto').randomBytes(32).toString('hex'))"
```

## Step 5: Install Netlify Functions Dependencies

Netlify Functions need their dependencies installed. Create a `netlify/functions/package.json`:

```json
{
  "name": "netlify-functions",
  "version": "1.0.0",
  "dependencies": {
    "bcryptjs": "^2.4.3",
    "jsonwebtoken": "^9.0.2",
    "mysql2": "^3.6.5"
  }
}
```

Then update your root `package.json` to install these in the functions directory during build, or use a build script.

## Step 6: Verify Deployment

1. Visit your Netlify site URL
2. Test the registration flow
3. Test the login flow
4. Verify dashboard access

## Troubleshooting

### Functions Not Working

- Check Netlify Functions logs in the dashboard
- Verify environment variables are set correctly
- Ensure MySQL database is accessible from Netlify's servers
- Check that your database allows connections from Netlify's IP ranges

### Build Errors

- Ensure Node.js version is set to 18 in Netlify settings
- Check that all dependencies are listed in `package.json`
- Verify build scripts are correct

### Database Connection Issues

- Ensure your MySQL host allows external connections
- Check SSL settings (set `DB_SSL=true` if your database requires SSL)
- Verify database credentials are correct
- Some providers require IP whitelisting - check Netlify's IP ranges

## File Structure

```
your-project/
├── dist/                    # Built static files (deployed to Netlify)
│   ├── index.html
│   ├── login.html
│   ├── register.html
│   ├── dashboard.html
│   ├── css/
│   ├── js/
│   └── images/
├── netlify/
│   └── functions/          # Serverless functions
│       ├── login.js
│       ├── register.js
│       └── api.js
├── netlify.toml            # Netlify configuration
├── package.json
└── .env.example            # Environment variables template
```

## Additional Notes

- The authentication system uses JWT tokens stored in localStorage
- All API calls go through Netlify Functions
- Static assets are served directly from the `dist` folder
- Make sure to update your database schema if you add new features

## Support

If you encounter issues:
1. Check Netlify Function logs in the dashboard
2. Check browser console for JavaScript errors
3. Verify all environment variables are set correctly
4. Test database connectivity separately

