# Script to set GOOGLE_CLIENT_ID environment variable in Netlify
# Run this script after logging in to Netlify CLI

Write-Host "Setting GOOGLE_CLIENT_ID environment variable in Netlify..." -ForegroundColor Cyan

# Check if logged in
$status = netlify status 2>&1
if ($status -match "Not logged in") {
    Write-Host "`nYou need to log in to Netlify first!" -ForegroundColor Yellow
    Write-Host "Run: netlify login" -ForegroundColor Yellow
    Write-Host "Then run this script again." -ForegroundColor Yellow
    exit 1
}

# Get site info
Write-Host "`nChecking site status..." -ForegroundColor Cyan
$siteInfo = netlify status 2>&1

# Set the environment variable
$clientId = "490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com"

Write-Host "`nSetting GOOGLE_CLIENT_ID environment variable..." -ForegroundColor Cyan
Write-Host "Value: $clientId" -ForegroundColor Gray

# Set for production
netlify env:set GOOGLE_CLIENT_ID "$clientId" --context production

# Set for all contexts (to be safe)
netlify env:set GOOGLE_CLIENT_ID "$clientId"

Write-Host "`n✅ Environment variable set successfully!" -ForegroundColor Green
Write-Host "`nNext steps:" -ForegroundColor Cyan
Write-Host "1. Trigger a new deployment in Netlify Dashboard" -ForegroundColor Yellow
Write-Host "2. Or run: netlify deploy --prod" -ForegroundColor Yellow
Write-Host "`nThe variable will be available after the next deployment." -ForegroundColor Gray

