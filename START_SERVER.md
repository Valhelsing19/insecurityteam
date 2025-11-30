# How to Start Local Development Server

## ✅ FIXED - Simple Solution

I've created a custom Node.js server that works reliably. Here's how to use it:

### Option 1: Full Setup (Static Files + Functions)

**Terminal 1 - Start Static File Server:**
```powershell
npm run serve
```

**Terminal 2 - Start Netlify Functions (in a new terminal):**
```powershell
netlify dev --functions netlify/functions --port 8889
```

### Option 2: Just Static Files (for testing UI)

```powershell
npm run serve
```

Then access: `http://localhost:8888`

## What This Does

- ✅ Serves static files from `dist/` folder on port 8888
- ✅ Proxies Netlify Functions requests to port 8889
- ✅ No framework detection issues
- ✅ No port conflicts
- ✅ Simple and reliable

## Access Your Site

- Home: `http://localhost:8888`
- Login: `http://localhost:8888/login.html`
- Register: `http://localhost:8888/register.html`
- Dashboard: `http://localhost:8888/dashboard.html`

## Making Changes

1. Edit source files in `public/` or `resources/views/`
2. Rebuild: `npm run build:netlify`
3. Refresh browser (hard refresh: Ctrl+Shift+R)

## Troubleshooting

**Port 8888 already in use:**
```powershell
taskkill /F /IM node.exe
```

**Functions not working:**
- Make sure you started the Netlify Functions server on port 8889
- Check that your `.env` file has all required variables

**Files not updating:**
- Run `npm run build:netlify` to rebuild
- Hard refresh browser (Ctrl+Shift+R)

