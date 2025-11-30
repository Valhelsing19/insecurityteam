const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 8888;
const DIST_DIR = path.join(__dirname, 'dist');

// MIME types
const mimeTypes = {
  '.html': 'text/html',
  '.js': 'text/javascript',
  '.css': 'text/css',
  '.json': 'application/json',
  '.png': 'image/png',
  '.jpg': 'image/jpg',
  '.gif': 'image/gif',
  '.svg': 'image/svg+xml',
  '.ico': 'image/x-icon',
  '.woff': 'application/font-woff',
  '.woff2': 'application/font-woff2',
  '.ttf': 'application/font-ttf',
  '.eot': 'application/vnd.ms-fontobject'
};

const server = http.createServer((req, res) => {
  console.log(`${req.method} ${req.url}`);

  // Handle Netlify Functions - proxy to localhost:8889
  if (req.url.startsWith('/.netlify/functions/')) {
    const proxyReq = http.request({
      hostname: 'localhost',
      port: 8889,
      path: req.url,
      method: req.method,
      headers: { ...req.headers, host: 'localhost:8889' }
    }, (proxyRes) => {
      res.writeHead(proxyRes.statusCode, proxyRes.headers);
      proxyRes.pipe(res);
    });

    proxyReq.on('error', (err) => {
      console.error('Proxy error:', err.message);
      res.writeHead(502, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify({ error: 'Function server not available. Make sure Netlify Functions are running on port 8889.' }));
    });

    req.pipe(proxyReq);
    return;
  }

  // Serve static files
  let filePath;
  const urlPath = req.url.split('?')[0]; // Remove query string
  
  if (urlPath === '/' || urlPath === '') {
    filePath = path.join(DIST_DIR, 'index.html');
  } else {
    // Remove leading slash and join with dist directory
    const cleanPath = urlPath.startsWith('/') ? urlPath.slice(1) : urlPath;
    filePath = path.join(DIST_DIR, cleanPath);
  }
  
  // Normalize the path (resolves .. and .)
  filePath = path.normalize(filePath);
  
  // Security: prevent directory traversal
  const resolvedPath = path.resolve(filePath);
  const resolvedDist = path.resolve(DIST_DIR);
  if (!resolvedPath.startsWith(resolvedDist)) {
    res.writeHead(403, { 'Content-Type': 'text/html' });
    res.end('<h1>403 - Forbidden</h1>');
    return;
  }

  // Check if file exists
  fs.stat(filePath, (err, stats) => {
    if (err) {
      // File doesn't exist
      // If URL ends with /, try index.html in that directory
      if (urlPath.endsWith('/')) {
        const dirIndex = path.join(filePath, 'index.html');
        fs.stat(dirIndex, (err2) => {
          if (err2) {
            res.writeHead(404, { 'Content-Type': 'text/html' });
            res.end(`<h1>404 - File Not Found</h1><p>Path: ${urlPath}</p>`);
            return;
          }
          serveFile(dirIndex, res);
        });
      } else {
        // Try adding .html extension if it doesn't have one
        const ext = path.extname(filePath);
        if (!ext) {
          const htmlPath = filePath + '.html';
          fs.stat(htmlPath, (err2) => {
            if (err2) {
              res.writeHead(404, { 'Content-Type': 'text/html' });
              res.end(`<h1>404 - File Not Found</h1><p>Path: ${urlPath}</p>`);
              return;
            }
            serveFile(htmlPath, res);
          });
        } else {
          res.writeHead(404, { 'Content-Type': 'text/html' });
          res.end(`<h1>404 - File Not Found</h1><p>Path: ${urlPath}</p><p>Resolved: ${resolvedPath}</p>`);
        }
      }
      return;
    }
    
    if (stats.isDirectory()) {
      // It's a directory, try index.html
      const dirIndex = path.join(filePath, 'index.html');
      fs.stat(dirIndex, (err2) => {
        if (err2) {
          res.writeHead(404, { 'Content-Type': 'text/html' });
          res.end(`<h1>404 - File Not Found</h1><p>Directory has no index.html</p><p>Path: ${urlPath}</p>`);
          return;
        }
        serveFile(dirIndex, res);
      });
    } else {
      // It's a file, serve it
      serveFile(filePath, res);
    }
  });
});

function serveFile(filePath, res) {
  const ext = path.extname(filePath).toLowerCase();
  const contentType = mimeTypes[ext] || 'application/octet-stream';

  fs.readFile(filePath, (err, content) => {
    if (err) {
      res.writeHead(500, { 'Content-Type': 'text/html' });
      res.end('<h1>500 - Server Error</h1>');
      return;
    }

    res.writeHead(200, { 
      'Content-Type': contentType,
      'Access-Control-Allow-Origin': '*'
    });
    res.end(content);
  });
}

// Start static file server
server.listen(PORT, () => {
  console.log(`\n✅ Server running at http://localhost:${PORT}`);
  console.log(`📁 Serving files from: ${DIST_DIR}`);
  console.log(`🔧 Netlify Functions: Proxy to http://localhost:8889/.netlify/functions/*`);
  console.log(`\n💡 To run Netlify Functions, open another terminal and run:`);
  console.log(`   netlify dev --functions netlify/functions --port 8889\n`);
  console.log(`Press Ctrl+C to stop\n`);
});

// Cleanup on exit
process.on('SIGINT', () => {
  console.log('\nShutting down...');
  server.close();
  process.exit(0);
});
