# Quick Database Environment Variables Setup
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Database Environment Variables Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "This script will help you set up your database environment variables." -ForegroundColor Yellow
Write-Host ""

# Check if logged in
$status = netlify status 2>&1
if ($status -match "Not logged in") {
    Write-Host "You need to log in to Netlify first!" -ForegroundColor Red
    Write-Host "Run: netlify login" -ForegroundColor Yellow
    exit 1
}

Write-Host "Enter your database configuration:" -ForegroundColor Cyan
Write-Host ""

# Get database host
$dbHost = Read-Host "DB_HOST (e.g., your-db-host.com or IP address)"
if (-not $dbHost) {
    Write-Host "DB_HOST is required!" -ForegroundColor Red
    exit 1
}
netlify env:set DB_HOST "$dbHost" 2>&1 | Out-Null
Write-Host "✓ DB_HOST set" -ForegroundColor Green

# Get database user
$dbUser = Read-Host "DB_USER (database username)"
if (-not $dbUser) {
    Write-Host "DB_USER is required!" -ForegroundColor Red
    exit 1
}
netlify env:set DB_USER "$dbUser" 2>&1 | Out-Null
Write-Host "✓ DB_USER set" -ForegroundColor Green

# Get database password
$dbPassword = Read-Host "DB_PASSWORD (database password)" -AsSecureString
if (-not $dbPassword) {
    Write-Host "DB_PASSWORD is required!" -ForegroundColor Red
    exit 1
}
$BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($dbPassword)
$plainPassword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)
netlify env:set DB_PASSWORD "$plainPassword" 2>&1 | Out-Null
Write-Host "✓ DB_PASSWORD set" -ForegroundColor Green

# Get database name
$dbName = Read-Host "DB_NAME (database name)"
if (-not $dbName) {
    Write-Host "DB_NAME is required!" -ForegroundColor Red
    exit 1
}
netlify env:set DB_NAME "$dbName" 2>&1 | Out-Null
Write-Host "✓ DB_NAME set" -ForegroundColor Green

# Get SSL setting
Write-Host ""
Write-Host "Is this a cloud database (PlanetScale, AWS RDS, DigitalOcean, etc.)?" -ForegroundColor Yellow
Write-Host "Type 'y' for yes (SSL required) or 'n' for no (local database)" -ForegroundColor Gray
$isCloud = Read-Host "Use SSL? (y/n)"
if ($isCloud -eq 'y' -or $isCloud -eq 'Y') {
    $dbSsl = "true"
} else {
    $dbSsl = "false"
}
netlify env:set DB_SSL "$dbSsl" 2>&1 | Out-Null
Write-Host "✓ DB_SSL set to $dbSsl" -ForegroundColor Green

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "All database variables set!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next step: Redeploy your site" -ForegroundColor Yellow
Write-Host "Run: netlify deploy --prod" -ForegroundColor White
Write-Host ""


