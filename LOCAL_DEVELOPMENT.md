# Local Development with Netlify Dev

## Quick Start

### Option 1: Build and Serve (Recommended)
```bash
npm run dev:netlify
```
This will:
1. Build the project (copy assets, convert HTML, install function dependencies)
2. Start Netlify dev server

### Option 2: Just Serve (if already built)
```bash
npm run serve
# or
netlify dev
```

## Environment Variables

Make sure your `.env` file in the project root contains:

```env
# Google OAuth
GOOGLE_CLIENT_ID=490999705819-m00vphvg4c9s7fm6oh849dipon6ac6t8.apps.googleusercontent.com

# Database Configuration
DB_HOST=your-database-host
DB_USER=your-database-user
DB_PASSWORD=your-database-password
DB_NAME=your-database-name
DB_SSL=false

# JWT Secret (generate a random string)
JWT_SECRET=your-secret-key-here
```

## Access Your Application

After starting `netlify dev`, you'll see output like:
```
Local dev server ready: http://localhost:8888
```

Then access:
- Home: `http://localhost:8888`
- Login: `http://localhost:8888/login.html`
- Register: `http://localhost:8888/register.html`
- Dashboard: `http://localhost:8888/dashboard.html`

## Making Changes

1. **Edit source files** in:
   - `public/js/` - JavaScript files
   - `public/css/` - CSS files
   - `resources/views/` - HTML templates (Blade files)

2. **Rebuild the project**:
   ```bash
   npm run build:netlify
   ```

3. **Restart Netlify dev** (if needed):
   - Press `Ctrl+C` to stop
   - Run `netlify dev` again

## Troubleshooting

### Port Already in Use
If port 8888 is busy:
```bash
netlify dev --port 8889
```

### Environment Variables Not Loading
- Make sure `.env` file is in the project root
- Restart `netlify dev` after adding new variables
- Check that variables don't have quotes around values

### Functions Not Working
- Check terminal for error messages
- Verify all environment variables are set
- Check `netlify/functions/node_modules` exists

### Changes Not Reflecting
- Rebuild: `npm run build:netlify`
- Hard refresh browser: `Ctrl+Shift+R` or `Ctrl+F5`
- Clear browser cache

## Development Workflow

1. Make changes to source files
2. Run `npm run build:netlify` to rebuild
3. Test in browser (Netlify dev auto-reloads functions)
4. If needed, restart `netlify dev` for static file changes

