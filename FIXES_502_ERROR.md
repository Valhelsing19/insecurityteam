# Fixes Applied for 502 Gateway Error

## Problem
The application was getting a 502 Gateway Error on Render because:
1. **Port Mismatch**: Render provides a `PORT` environment variable (usually 10000), but Nginx was hardcoded to listen on port 80
2. **Nginx Configuration**: The nginx config wasn't being generated dynamically with the PORT variable
3. **Service Startup**: PHP-FPM and Nginx needed better configuration for Render's environment

## Solutions Applied

### 1. Dynamic Port Configuration
- Created `docker/nginx.conf.template` that uses `${PORT}` variable
- Updated `docker/start.sh` to use `envsubst` to substitute PORT at runtime
- Nginx now listens on whatever port Render provides

### 2. Nginx Site Configuration
- Added proper symlink creation to enable nginx site
- Added nginx configuration test before starting
- Ensured sites-enabled directory is properly set up

### 3. PHP-FPM Configuration
- Fixed PHP-FPM command in supervisor config
- Ensured PHP-FPM starts before Nginx (priority settings)

### 4. Startup Script Improvements
- Removed `set -e` to prevent script from exiting on non-critical errors
- Added better error handling with `|| true` for non-critical operations
- Added logging to show which port is being used

## Files Changed

1. **Dockerfile**
   - Added `gettext-base` package for `envsubst` command
   - Created nginx sites-enabled directory
   - Updated to use nginx template instead of static config

2. **docker/nginx.conf.template** (NEW)
   - Template file with `${PORT}` placeholder
   - Will be processed by `envsubst` at runtime

3. **docker/start.sh**
   - Added PORT environment variable handling
   - Added nginx config generation from template
   - Added nginx site enabling
   - Improved error handling

4. **docker/supervisord.conf**
   - Fixed PHP-FPM command path
   - Added priority settings for proper startup order
   - Added unlimited log file sizes for debugging

## Testing

After deploying, check:
1. Render logs should show: "Starting services on port 10000" (or whatever PORT Render provides)
2. Health check endpoint `/up` should return 200
3. Application should be accessible via Render URL

## If Still Getting 502 Error

1. **Check Render Logs**: Look for errors in the service logs
2. **Verify Environment Variables**: Ensure `APP_KEY` is set
3. **Check PHP-FPM**: Verify PHP-FPM is running (check supervisor logs)
4. **Check Nginx**: Verify Nginx is running and listening on correct port
5. **Database Connection**: If using database, verify connection string is correct

## Debug Commands (via Render Shell)

```bash
# Check if services are running
ps aux | grep -E 'nginx|php-fpm'

# Check nginx config
cat /etc/nginx/sites-enabled/default

# Check supervisor status
supervisorctl status

# Check logs
tail -f /var/log/supervisor/nginx.out.log
tail -f /var/log/supervisor/php-fpm.out.log
```

