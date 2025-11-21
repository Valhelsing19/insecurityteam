# Deployment Guide for Render

This guide explains how to deploy this Laravel application to Render using Docker.

## Prerequisites

1. A Render account (sign up at https://render.com)
2. Your code pushed to a Git repository (GitHub, GitLab, or Bitbucket)
3. A database (PostgreSQL recommended for Render)

## Files Created

The following files have been created for Docker deployment:

- `Dockerfile` - Multi-stage Docker build for Laravel + Vite
- `.dockerignore` - Excludes unnecessary files from Docker build
- `render.yaml` - Render service configuration
- `docker/nginx.conf` - Nginx web server configuration
- `docker/supervisord.conf` - Process manager configuration
- `docker/start.sh` - Application startup script

## Deployment Steps

### 1. Prepare Your Repository

Ensure all files are committed and pushed to your Git repository:

```bash
git add .
git commit -m "Add Docker configuration for Render deployment"
git push
```

### 2. Create Database on Render

1. Go to your Render dashboard
2. Click "New +" → "PostgreSQL"
3. Choose a name (e.g., `insecurityteam-db`)
4. Select a plan (Starter is fine for development)
5. Note the connection details (you'll need these for environment variables)

### 3. Deploy Web Service

#### Option A: Using render.yaml (Recommended)

1. Go to Render dashboard
2. Click "New +" → "Blueprint"
3. Connect your repository
4. Render will automatically detect `render.yaml` and create the service

#### Option B: Manual Setup

1. Go to Render dashboard
2. Click "New +" → "Web Service"
3. Connect your Git repository
4. Configure:
   - **Name**: `insecurityteam`
   - **Environment**: `Docker`
   - **Dockerfile Path**: `./Dockerfile`
   - **Docker Context**: `.`
   - **Plan**: Starter (or your preferred plan)
   - **Region**: Choose closest to your users

### 4. Configure Environment Variables

In your Render service settings, add these environment variables:

#### Required Variables

```
APP_NAME=InsecurityTeam
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
```

#### Database Variables (if using PostgreSQL)

```
DB_CONNECTION=pgsql
DB_HOST=your-db-host.onrender.com
DB_PORT=5432
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

#### Optional Variables

```
LOG_CHANNEL=stderr
LOG_LEVEL=error
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

### 5. Generate Application Key

After deployment, you can generate the app key via Render's shell:

1. Go to your service → "Shell"
2. Run: `php artisan key:generate --show`
3. Copy the key and add it as `APP_KEY` environment variable

Or let the startup script handle it automatically (it will generate if not set).

### 6. Run Migrations

After the first deployment:

1. Go to your service → "Shell"
2. Run: `php artisan migrate --force`

Or uncomment the migration line in `docker/start.sh` to run automatically on startup.

## Important Notes

### Database Considerations

- **SQLite**: Not recommended for production on Render (file system is ephemeral)
- **PostgreSQL**: Recommended for Render (managed service available)
- **MySQL**: Can be used with external managed MySQL service

### Storage Considerations

- Render's file system is **ephemeral** - files are lost on redeploy
- Use cloud storage (S3, etc.) for user uploads
- Configure `FILESYSTEM_DISK=s3` in environment variables if using S3

### Performance Optimization

The Dockerfile includes:
- ✅ Production-optimized Composer install
- ✅ Laravel config/route/view caching
- ✅ Opcache enabled
- ✅ Gzip compression in Nginx
- ✅ Static asset caching

### Health Checks

Render will use `/up` endpoint (Laravel's health check) to verify your service is running.

## Troubleshooting

### Build Fails

- Check build logs in Render dashboard
- Ensure all files are committed to Git
- Verify Dockerfile syntax

### Application Won't Start

- Check service logs in Render dashboard
- Verify environment variables are set correctly
- Ensure database connection is working

### 500 Errors

- Check Laravel logs: `php artisan log:show` in Render shell
- Verify `APP_KEY` is set
- Check database connection
- Ensure storage directories have correct permissions

### Assets Not Loading

- Verify Vite build completed successfully
- Check that `public/build` directory exists
- Ensure `APP_URL` matches your Render URL

## Updating Your Application

1. Make changes to your code
2. Commit and push to Git
3. Render will automatically rebuild and redeploy
4. Check deployment logs for any issues

## Cost Considerations

- **Starter Plan**: Free tier available (spins down after inactivity)
- **Standard Plans**: Start at $7/month for always-on service
- **Database**: PostgreSQL Starter is free, scales as needed

## Support

For issues specific to:
- **Render**: Check Render documentation or support
- **Laravel**: Check Laravel documentation
- **Docker**: Check Docker documentation

