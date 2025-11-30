# Comprehensive script to set all required Netlify environment variables
# Run this script after logging in to Netlify CLI

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Netlify Environment Variables Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if logged in
$status = netlify status 2>&1
if ($status -match "Not logged in") {
    Write-Host "You need to log in to Netlify first!" -ForegroundColor Yellow
    Write-Host "Run: netlify login" -ForegroundColor Yellow
    Write-Host "Then run this script again." -ForegroundColor Yellow
    exit 1
}

# Check if site is linked
$linkStatus = netlify status 2>&1
if ($linkStatus -match "not linked") {
    Write-Host "Site is not linked. Attempting to link..." -ForegroundColor Yellow
    Write-Host "Please select your site when prompted." -ForegroundColor Yellow
    netlify link
}

Write-Host "Setting environment variables..." -ForegroundColor Cyan
Write-Host ""

# Google Client ID (already set, but we'll verify)
$googleClientId = "490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com"
Write-Host "Setting GOOGLE_CLIENT_ID..." -ForegroundColor Gray
netlify env:set GOOGLE_CLIENT_ID "$googleClientId" 2>&1 | Out-Null
Write-Host "✓ GOOGLE_CLIENT_ID set" -ForegroundColor Green

# Generate and set JWT_SECRET
Write-Host "Generating JWT_SECRET..." -ForegroundColor Gray
$jwtSecret = node -e "console.log(require('crypto').randomBytes(32).toString('hex'))" 2>&1 | Select-Object -Last 1
if ($jwtSecret) {
    $jwtSecret = $jwtSecret.Trim()
    Write-Host "Setting JWT_SECRET..." -ForegroundColor Gray
    netlify env:set JWT_SECRET "$jwtSecret" 2>&1 | Out-Null
    Write-Host "✓ JWT_SECRET set (generated)" -ForegroundColor Green
} else {
    Write-Host "⚠ Could not generate JWT_SECRET automatically" -ForegroundColor Yellow
    Write-Host "Please set it manually: netlify env:set JWT_SECRET 'your-secret-here'" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Database Configuration Required" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "You need to set the following database environment variables:" -ForegroundColor Yellow
Write-Host "  - DB_HOST (your MySQL host)" -ForegroundColor Gray
Write-Host "  - DB_USER (your database username)" -ForegroundColor Gray
Write-Host "  - DB_PASSWORD (your database password)" -ForegroundColor Gray
Write-Host "  - DB_NAME (your database name)" -ForegroundColor Gray
Write-Host "  - DB_SSL (true or false, usually true for cloud databases)" -ForegroundColor Gray
Write-Host ""
Write-Host "To set them, run:" -ForegroundColor Cyan
Write-Host "  netlify env:set DB_HOST 'your-host'" -ForegroundColor White
Write-Host "  netlify env:set DB_USER 'your-user'" -ForegroundColor White
Write-Host "  netlify env:set DB_PASSWORD 'your-password'" -ForegroundColor White
Write-Host "  netlify env:set DB_NAME 'your-database'" -ForegroundColor White
Write-Host "  netlify env:set DB_SSL 'true'" -ForegroundColor White
Write-Host ""
Write-Host "Or set them interactively now? (y/n)" -ForegroundColor Cyan
$response = Read-Host

if ($response -eq 'y' -or $response -eq 'Y') {
    Write-Host ""
    Write-Host "Enter database configuration:" -ForegroundColor Cyan
    
    $dbHost = Read-Host "DB_HOST"
    if ($dbHost) {
        netlify env:set DB_HOST "$dbHost" 2>&1 | Out-Null
        Write-Host "✓ DB_HOST set" -ForegroundColor Green
    }
    
    $dbUser = Read-Host "DB_USER"
    if ($dbUser) {
        netlify env:set DB_USER "$dbUser" 2>&1 | Out-Null
        Write-Host "✓ DB_USER set" -ForegroundColor Green
    }
    
    $dbPassword = Read-Host "DB_PASSWORD" -AsSecureString
    if ($dbPassword) {
        $BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($dbPassword)
        $plainPassword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)
        netlify env:set DB_PASSWORD "$plainPassword" 2>&1 | Out-Null
        Write-Host "✓ DB_PASSWORD set" -ForegroundColor Green
    }
    
    $dbName = Read-Host "DB_NAME"
    if ($dbName) {
        netlify env:set DB_NAME "$dbName" 2>&1 | Out-Null
        Write-Host "✓ DB_NAME set" -ForegroundColor Green
    }
    
    $dbSsl = Read-Host "DB_SSL (true/false, default: true)"
    if (-not $dbSsl) { $dbSsl = "true" }
    netlify env:set DB_SSL "$dbSsl" 2>&1 | Out-Null
    Write-Host "✓ DB_SSL set to $dbSsl" -ForegroundColor Green
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Verify all environment variables are set:" -ForegroundColor White
Write-Host "   netlify env:list" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Redeploy your site to apply changes:" -ForegroundColor White
Write-Host "   netlify deploy --prod" -ForegroundColor Gray
Write-Host ""
Write-Host "3. Test Google Sign-In on your deployed site" -ForegroundColor White
Write-Host ""

